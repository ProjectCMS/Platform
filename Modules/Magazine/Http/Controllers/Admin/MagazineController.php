<?php

    namespace Modules\Magazine\Http\Controllers\Admin;

    use Chumper\Zipper\Zipper;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Illuminate\Support\Facades\Storage;
    use Ilovepdf\Ilovepdf;
    use Modules\Core\Entities\Status;
    use Modules\Magazine\Entities\Magazine;
    use Modules\Magazine\Entities\MagazineFile;
    use Modules\Magazine\Http\Requests\MagazineRequest;

    class MagazineController extends Controller {

        /**
         * @var Magazine
         */
        private $magazine;
        /**
         * @var MagazineFile
         */
        private $magazineFile;
        /**
         * @var Status
         */
        private $status;
        /**
         * @var Ilovepdf
         */
        private $ilovepdf;
        /**
         * @var Zipper
         */
        private $zipper;

        public function __construct (Magazine $magazine, MagazineFile $magazineFile, Status $status, Ilovepdf $ilovepdf, Zipper $zipper)
        {
            $this->magazine     = $magazine;
            $this->magazineFile = $magazineFile;
            $this->status       = $status;
            $this->ilovepdf     = $ilovepdf;
            $this->zipper       = $zipper;
        }

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            $paginate = $this->magazine->with(['files'])->paginate(10);

            return view('magazine::admin.index', compact('paginate'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create ()
        {
            $status = $this->status->pluck('title', 'id');

            return view('magazine::admin.create', compact('status'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function store (MagazineRequest $request)
        {
            $insert = $this->magazine->create($request->all());
            $this->magazineFile->managerItems($insert->id, $request->files_items);

            return redirect(route('admin.magazine.edit', $insert->id))->with('status-success', 'Revista criada com sucesso');

        }

        /**
         * Show the specified resource.
         * @return Response
         */
        public function show ()
        {
            return view('magazine::show');
        }

        /**
         * Show the form for editing the specified resource.
         * @return Response
         */
        public function edit ($id)
        {
            $data   = $this->magazine->with(['files'])->find($id);
            $status = $this->status->pluck('title', 'id');

            if (!$data) {
                return redirect()->route('admin.magazine');
            }

            return view('magazine::admin.edit', compact('data', 'status'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function update (MagazineRequest $request, $id)
        {
            $data = $this->magazine->findOrFail($id);
            $data->update($request->all());
            $this->magazineFile->managerItems($id, $request->files_items);

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy (Request $request)
        {
            $data = $this->magazine->findOrFail($request->id);
            $data->forceDelete();
        }

        public function manager (Request $request)
        {
            $this->ilovepdf->setApiKeys('project_public_bfaf4c0b037ed5fa7428e2063be25633_GrB3ibc71a8554e2763a588cbf68016d131ad', 'secret_key_a362a093f609f4462135cebd8bdfbfdd_G5BBmb05c526c09b616698aaf5ab2c693dfc1');

            $storage = storage_path('app/public/' . $request->storage);
            $pdf     = $this->ilovepdf->newTask('split');

            $pdf->addFile($storage);
            $pdf->setFixedRange(1);
            $pdf->setOutputFilename('pagina');
            $pdf->execute();
            $pdf->download('storage/tmp/');

            $output = public_path('storage/tmp/output.zip');
            $path   = 'revistas/revista-' . date('Y-m-d');
            $zip    = $this->zipper->make($output)->extractTo('storage/' . $path);
            $files  = Storage::files('public/' . $path);


            $files  = str_replace('public/', '', $files);
            $return = [];

            foreach ($files as $key => $file) {

                $info = pathinfo(storage_path('public/' . $file));
                $key  = (int)str_replace('pagina-', '', $info["filename"]);

                $return[$key]["id"]         = rand();
                $return[$key]["key"]        = $key;
                $return[$key]["path"]       = $file;
                $return[$key]["url"]        = asset('storage/' . $file);
                $return[$key]["subscriber"] = 0;
            }

            $return = collect($return)->sortBy('key');

            return $return;
        }
    }
