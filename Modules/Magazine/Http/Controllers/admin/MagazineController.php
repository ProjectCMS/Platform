<?php

    namespace Modules\Magazine\Http\Controllers\admin;

    use Chumper\Zipper\Zipper;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Illuminate\Support\Facades\Storage;
    use Ilovepdf\Ilovepdf;
    use Modules\Core\Entities\Status;
    use Modules\Magazine\Entities\Magazine;
    use Modules\Magazine\Http\Requests\CreateRequest;
    use Modules\Magazine\Http\Requests\UpdateRequest;

    class MagazineController extends Controller {
        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            return view('magazine::admin.index');
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create (Status $status)
        {
            $status = $status->pluck('name', 'id');

            return view('magazine::admin.create', compact('status'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function store (Magazine $magazine, CreateRequest $request)
        {
            $insert = $magazine->create($request->all());

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
        public function edit (Magazine $magazine, Status $status, $id)
        {
            $data   = $magazine->find($id);
            $status = $status->pluck('name', 'id');

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
        public function update (Magazine $magazine, UpdateRequest $request, $id)
        {
            $data = $magazine->findOrFail($id);

            $data->update($request->all());

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy (Magazine $magazine, Request $request)
        {
            $data = $magazine->find($request->id);
            $data->forceDelete();
        }

        public function manager (Request $request, Ilovepdf $ilovepdf, Zipper $zipper)
        {
            $ilovepdf->setApiKeys('project_public_bfaf4c0b037ed5fa7428e2063be25633_GrB3ibc71a8554e2763a588cbf68016d131ad', 'secret_key_a362a093f609f4462135cebd8bdfbfdd_G5BBmb05c526c09b616698aaf5ab2c693dfc1');

            //                                    $storage = storage_path('app/public/' . $request->storage);
            //                                    $pdf     = $ilovepdf->newTask('split');
            //                                    $pdf->addFile($storage);
            //                                    $pdf->setFixedRange(1);
            //                                    $pdf->setOutputFilename('pagina');
            //                                    $pdf->execute();
            //                                    $pdf->download('storage/tmp/');
            //
            //                                    dd("teste");

            $output = public_path('storage/tmp/output.zip');
            $path   = 'revistas/revista-' . date('Y-m-d');
            $zip    = $zipper->make($output)->extractTo('storage/' . $path);
            $files  = Storage::files('public/' . $path);


            $files  = str_replace('public/', '', $files);
            $return = [];

            foreach ($files as $key => $file) {

                $info = pathinfo(storage_path('public/' . $file));
                $key  = (int)str_replace('pagina-', '', $info["filename"]);

                $return[$key]["key"]     = $key;
                $return[$key]["storage"] = $file;
                $return[$key]["url"]     = asset('storage/' . $file);
            }

            $return = collect($return)->sortBy('key');

            return $return;
        }
    }
