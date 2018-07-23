<?php

    namespace Modules\Users\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Users\Entities\Acl\Permission;
    use Modules\Users\Entities\Acl\Role;
    use Modules\Users\Entities\User;
    use Modules\Users\Http\Requests\UserRequest;

    class UsersController extends Controller {

        private $perPages = 15;
        /**
         * @var User
         */
        private $user;
        /**
         * @var Role
         */
        private $role;
        /**
         * @var Permission
         */
        private $permission;

        public function __construct (User $user, Role $role, Permission $permission)
        {
            $this->user       = $user;
            $this->role       = $role;
            $this->permission = $permission;
        }


        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            $paginate = $this->user->with(['roles', 'permissions'])->paginate($this->perPages);

            return view('users::index', compact('paginate'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create ()
        {
            $roles       = $this->role->all();
            $permissions = $this->permission->all();

            return view('users::create', compact('roles', 'permissions'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function store (UserRequest $request)
        {
            $insert = $this->user->create($request->all());
            $insert->syncRoles($request->roles ? $request->roles : []);
            $insert->syncPermissions($request->permissions ? $request->permissions : []);

            return redirect(route('admin.users.edit', $insert->id))->with('status-success', 'Usuário criado com sucesso');
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
            $data        = $this->user->with(['roles', 'permissions'])->find($id);
            $roles       = $this->role->all();
            $permissions = $this->permission->all();

            if (!$data) {
                return redirect()->route('admin.users');
            }

            return view('users::edit', compact('data', 'roles', 'permissions'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function update (UserRequest $request, $id)
        {
            $data = $this->user->findOrFail($id);

            $data->update($request->all());
            $data->syncRoles($request->roles ? $request->roles : []);
            $data->syncPermissions($request->permissions ? $request->permissions : []);

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy (Request $request)
        {
            $data = $this->user->findOrFail($request->id);
            $data->forceDelete();
        }
    }
