<?php

    namespace Modules\Admin\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Admin\Entities\Admin;

    class AdminController extends Controller {

        private $perPages = 15;

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            $paginate = Admin::with('roles')->paginate($this->perPages);

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
        public function store (Request $request)
        {
            $validation = $this->validation($request);
            $insert     = Admin::create($validation);

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
        public function edit ($id)
        {
            $data = Admin::find($id);
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
        public function update (Request $request, $id)
        {
            $data       = Admin::findOrFail($id);
            $validation = $this->validation($request, $id);

            $data->update($validation);

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy ()
        {
        }

        /**
         * Pages Validation
         * @return Response
         */
        public function validation ($request, $id = NULL)
        {
            $validation = $request->validate([
                'name'     => 'required',
                'email'    => 'required|string|email|max:255|unique:admins,email,' . $id,
                'password' => 'required|string|min:6|confirmed'
            ]);

            $validation["password"] = bcrypt($validation["password"]);

            return $validation;

        }
    }
