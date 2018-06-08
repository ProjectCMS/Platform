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
         * @var User
         */
        private $user;

        public function __construct (User $user)
        {
            $this->user = $user;
        }


        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            dd($this->user);
            $paginate = $this->user->with('roles')->paginate($this->perPages);

            return view('users::index', compact('paginate'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create ()
        {
            return view('users::create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function store (CreateRequest $request)
        {
            $insert = $this->user->create($request->all());

            return redirect(route('admin.users.edit', $insert->id))->with('status-success', 'Tag criada com sucesso');
        }

        /**
         * Show the specified resource.
         * @return Response
         */
        public function show ()
        {
            return view('users::show');
        }

        /**
         * Show the form for editing the specified resource.
         * @return Response
         */
        public function edit ($id)
        {
            $data = $this->user->findOrFail($id);
            if (!$data) {
                return redirect()->route('admin.users');
            }

            return view('users::edit', compact('data'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function update (UpdateRequest $request, $id)
        {
            $data = $this->user->findOrFail($id);

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
