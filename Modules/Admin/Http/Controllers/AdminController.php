<?php

    namespace Modules\Admin\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Admin\Entities\Admin;
    use Modules\Admin\Http\Requests\CreateRequest;
    use Modules\Admin\Http\Requests\UpdateRequest;

    class AdminController extends Controller {

        private $perPages = 15;

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index (Admin $admin)
        {
            $paginate = $admin->with('roles')->paginate($this->perPages);

            return view('admin::index', compact('paginate'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create ()
        {
            return view('admin::create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function store (Admin $admin, CreateRequest $request)
        {
            $insert = $admin->create($request->all());

            return redirect(route('admin.manager.edit', $insert->id))->with('status-success', 'Tag criada com sucesso');
        }

        /**
         * Show the specified resource.
         * @return Response
         */
        public function show ()
        {
            return view('admin::show');
        }

        /**
         * Show the form for editing the specified resource.
         * @return Response
         */
        public function edit (Admin $admin, $id)
        {
            $data = $admin->find($id);
            if (!$data) {
                return redirect()->route('admin.manager');
            }

            return view('admin::edit', compact('data'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function update (Admin $admin, UpdateRequest $request, $id)
        {
            $data       = $admin->findOrFail($id);

            $data->update($request->all());

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy ()
        {
        }
    }
