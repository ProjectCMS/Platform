<?php

    namespace Modules\Media\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Illuminate\Support\Facades\Storage;
    use Modules\Media\Libs\FileManager;

    class MediaController extends Controller {

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            return view('media::index');
        }

        public function __construct (FileManager $fileManager)
        {
            $this->fileMananger = $fileManager;
            $this->directories  = $this->fileMananger->getDirectories();
            $this->breadcrumb   = $this->fileMananger->getBreadcrumb();
        }

        public function iframe ()
        {
            $directories = $this->directories;
            $breadcrumb  = $this->breadcrumb;

            return view('media::iframe', compact('directories', 'breadcrumb'));
        }

        public function modal ()
        {
            $directories = $this->directories;
            $breadcrumb  = $this->breadcrumb;

            return view('media::modal', compact('directories', 'breadcrumb'));
        }

        public function items ()
        {
            $directories = $this->directories;
            $items       = $this->fileMananger->getFilter();

            return view('media::partials.items', compact('items', 'directories'));
        }

        public function upload ()
        {
            $this->fileMananger->upload();
        }

        public function download ($file)
        {
            if ($file) {
                $file    = base64_decode($file);
                $storage = public_path('storage' . DIRECTORY_SEPARATOR . $file);

                return response()->download($storage);
            }
        }

        public function downloads (Request $request)
        {
            $zipper = new \Chumper\Zipper\Zipper;
            $files  = $request->input('data');

            if ($files) {
                foreach ($files as $key => $file) {
                    $file        = base64_decode($file);
                    $storage     = public_path('storage' . DIRECTORY_SEPARATOR . $file);
                    $files[$key] = $storage;
                }

                $name = 'arquivos-' . date('Y-m-d') . '.zip';
                $path = 'downloads' . DIRECTORY_SEPARATOR . $name;
                $zipper->zip($path)->add($files)->close();

                $storage = public_path($path);

                return response()->download($storage, $name);
            }

        }

        public function delete ()
        {
            $this->fileMananger->delete();
        }

        public function create_folder ()
        {
            $this->fileMananger->createFolder();
        }


    }
