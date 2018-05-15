<?php

    namespace Modules\Users\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Users\Entities\User;
    use Modules\Users\Http\Requests\CreateRequest;
    use Modules\Users\Http\Requests\UpdateRequest;

    class UsersController extends Controller {

        private $perPages = 15;

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index (User $user)
        {
            dd($user->all()->toArray());
            $paginate = $user->with('roles')->paginate($this->perPages);

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
        public function store (User $user, CreateRequest $request)
        {
            $insert = $user->create($request->all());

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
        public function edit (User $user, $id)
        {
            $data = $user->find($id);
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
        public function update (User $user, UpdateRequest $request, $id)
        {
            $data = $user->findOrFail($id);

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
