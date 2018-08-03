<?php

    namespace Modules\Media\Libs;


    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Pagination\LengthAwarePaginator;

    class FileManager {

        private $storagePath = 'storage/';
        private $publicPath  = 'public/';
        private $root        = '';

        public function __construct (Request $request)
        {
            $this->data = $request;
            $this->path = (isset($this->data->dir) && $this->data->dir != NULL ? base64_decode($this->data->dir) : NULL);
            $this->root = $this->root;

            $this->setRealPath();
        }

        /**
         * Set Real Path
         */
        public function setRealPath ()
        {
            if (isset($this->data->root) && $this->data->root != NULL) {
                $this->setRoot($this->data->root);
            }

            // Public Path
            $this->publicPath = $this->publicPath . $this->root;

            // Storage Path
            $this->storagePath = $this->storagePath . $this->root;

            // Check exists folder
            $this->checkFolder();
        }

        /**
         * Set Folder
         *
         * @param $folder
         */
        public function setRoot ($root)
        {
            $root       = base64_decode($root);
            $this->root = urldecode(trim(strip_tags($root), "/") . "/");
        }

        /**
         * Get Folder
         * @return string
         */
        public function getRoot ()
        {
            return $this->root;
        }

        public function getFilter ($perPages = 1)
        {
            $all     = $this->getFiles();
            $collect = collect($all)->sortByDesc('timestamp');
            if (isset($this->data->type) && $this->data->type != NULL) {
                $type    = $this->setTypeFile($this->data->type);
                $collect = $collect->where("type", $type);
            }
            if (isset($this->data->extension) && $this->data->extension != NULL) {
                $collect = $collect->where("ext", $this->data->extension);
            }
            $currentPage      = LengthAwarePaginator::resolveCurrentPage();
            $currentPageItems = $collect->slice(($currentPage * $perPages) - $perPages, $perPages)->all();
            $paginatedItems   = new LengthAwarePaginator($currentPageItems, count($collect), 20);
            $paginatedItems->setPath($this->data->url());

            return $collect;
        }

        /**
         * Get Directories
         * @return array
         */
        public function getDirectories ()
        {
            return $this->setItems('dir');
        }

        /**
         * Get Files
         * @return array
         */
        public function getFiles ()
        {
            return $this->setItems('file');
        }


        /**
         * Get Breadcrumb
         * @return array
         */
        public function getBreadcrumb ()
        {
            $bc         = explode("/", $this->subfolder);
            $tmp_path   = '';
            $breadcrumb = [];
            if (!empty($bc)) {
                foreach ($bc as $k => $b) {
                    if (!empty($b)) {
                        $tmp_path .= $b . "/";

                        $active = ($k == count($bc) - 2 ? TRUE : FALSE);
                        $link   = ($k == count($bc) - 2 ? NULL : $tmp_path);

                        $breadcrumb[$k] = ["folder" => $b, "link" => $this->setOptions($link), 'active' => $active];
                    }
                }

                return $breadcrumb;
            }
        }

        /**
         * Upload files
         */
        public function upload ()
        {
            $request = $this->data;

            if ($request->file) {
                foreach ($request->file as $key => $file) {
                    $filename = str_slug(preg_replace('/\..+$/', '', $file->getClientOriginalName())) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs($this->publicPath . @base64_decode($request->dir), $filename);
                }
            }
        }

        public function delete ()
        {
            $request = $this->data;
            $files   = $request->input('data');
            if ($files) {
                foreach ($files as $key => $file) {

                    $file       = base64_decode($file);
                    $publicPath = $this->publicPath . $file;
                    $infos      = Storage::disk('local')->getMetaData($publicPath);

                    // Verifica se é um diretório
                    if ($infos["type"] == "dir") {
                        $allFiles = Storage::allFiles($publicPath);

                        // Verifica se o diretório está vazio
                        if (empty($allFiles)) {
                            Storage::deleteDirectory($publicPath, TRUE);
                        }
                    } else {
                        Storage::delete($publicPath);
                    }
                }
            }
        }

        public function createFolder ()
        {
            $request = $this->data;
            if ($request->input('name') != NULL) {

                $dir        = base64_decode($request->input('dir'));
                $publicPath = $this->publicPath . $dir . '/' . $request->input('name');

                if (!Storage::exists($publicPath)) Storage::makeDirectory($publicPath, 0777, TRUE, TRUE);
            }
        }

        private function checkFolder ()
        {
            if (!Storage::exists($this->publicPath)) Storage::makeDirectory($this->publicPath, 0777, TRUE, TRUE);
        }

        private function setItems ($type)
        {

            $storagePath = public_path($this->storagePath);

            if (isset($this->path) && !empty($this->path) && strpos($this->path, '../') === FALSE && strpos($this->path, './') === FALSE) {
                $this->subfolder = urldecode(trim(strip_tags($this->path), "/") . "/");
            } else {
                $this->subfolder = '';
            }

            if ($this->subfolder == "/") {
                $this->subfolder = '';
            }


            if (!file_exists($storagePath . $this->subfolder)) {
                $this->subfolder = '';
            }

            $this->currentfolder = $this->subfolder;

            $folders = new \DirectoryIterator($storagePath . $this->subfolder);


            foreach ($folders as $key => $file) {

                switch ($type) {

                    case 'dir':
                        $condition = $file->isDir();
                        break;
                    case 'file':
                        $condition = $file->isFile();
                        break;
                    default:
                        $condition = $file->isFile() || $file->isDir();
                        break;
                }

                if ($condition) {

                    if ($file->getFilename() == '.' || ($file->getFilename() == '..' && $this->subfolder == '')) {
                        continue;
                    }

                    if ($file->getFilename() == '..' && trim($this->subfolder) != '') {

                        $src = explode("/", $this->subfolder);
                        unset($src[count($src) - 2]);

                        $src = implode("/", $src);
                        $src = ($src == '' ? "/" : $src);

                    } elseif ($file->getFilename() != '..') {

                        $src = $this->subfolder . $file->getFilename() . "";

                    }

                    $date = date('Y-m-d H:i:s', $file->getCTime());
                    $date = Carbon::parse($date)->diffForHumans();

                    $this->setOptions($src);

                    $default[$key] = [
                        'path_url'  => base64_encode($this->root . $src),
                        'path'      => '?' . $this->setOptions($src),
                        'storage'   => $this->root . $src,
                        'file'      => $file->getFilename(),
                        'timestamp' => $file->getCTime(),
                        'date'      => $date,
                        'size'      => $this->formatBytes($file->getSize()),
                        'size_ext'  => $file->getSize(),
                        'name'      => strtolower($file->getBasename()),
                    ];

                    if ($file->getFilename() == '.' or $file->getFilename() == '..') {

                        $list[$key] = [
                            'type'  => 'folder-up',
                            'group' => 0,
                            'file'  => '...',
                        ];

                    } elseif ($file->getType() == 'dir') {

                        $list[$key] = [
                            'type'  => 'folder',
                            'group' => 1,
                        ];

                    } else {

                        $types = $this->mimeTypes(mime_content_type($file->getPathname()));

                        $list[$key] = [
                            'type'     => $types[0],
                            'group'    => 2,
                            'path'     => asset($this->storagePath . $src),
                            'download' => route('admin.media.download', base64_encode($src)),
                            'name'     => strtolower($file->getBasename('.' . $file->getExtension())),
                            'ext'      => strtolower($file->getExtension()),
                            'mime'     => mime_content_type($file->getPathname()),
                        ];
                    }

                    $list[$key] = array_merge($default[$key], $list[$key]);
                }
            }

            if (!empty($list)) {
                return $list;
            }

            return [];


        }

        private function setTypeFile ($type)
        {
            switch ($type) {
                case 'file':
                case 'application':
                    $type = 'application';
                    break;

                case 'text':
                    $type = 'text';
                    break;

                case 'media':
                case 'video':
                    $type = 'video';
                    break;

                case 'audio':
                    $type = 'audio';
                    break;

                case 'image':
                case 'images':
                    $type = 'image';
                    break;
            }

            return $type;

        }

        private function setOptions ($src)
        {
            $return["dir"]       = base64_encode($src);
            $return["root"]      = (isset($this->data->root) ? $this->data->root : NULL);
            $return["multiple"]  = (isset($this->data->multiple) ? $this->data->multiple : 'false');
            $return["type"]      = (isset($this->data->type) ? $this->data->type : NULL);
            $return["extension"] = (isset($this->data->extension) ? $this->data->extension : NULL);
            $return["tools"]     = (isset($this->data->tools) ? $this->data->tools : 'false');

            return http_build_query($return);

        }

        private function formatBytes ($bytes)
        {
            if ($bytes >= 1073741824) {
                $bytes = number_format($bytes / 1073741824, 2) . ' GB';
            } elseif ($bytes >= 1048576) {
                $bytes = number_format($bytes / 1048576, 2) . ' MB';
            } elseif ($bytes >= 1024) {
                $bytes = number_format($bytes / 1024, 2) . ' KB';
            } elseif ($bytes > 1) {
                $bytes = $bytes . ' bytes';
            } elseif ($bytes == 1) {
                $bytes = $bytes . ' byte';
            } else {
                $bytes = '0 bytes';
            }

            return $bytes;
        }

        private function mimeTypes ($mime)
        {
            $array = explode('/', $mime);

            return $array;

        }

    }