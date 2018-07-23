<?php

    namespace Modules\Users\Http\Controllers\Acl;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Users\Entities\Acl\Permission;
    use Modules\Users\Entities\Acl\Role;
    use Modules\Users\Entities\User;
    use Modules\Users\Http\Requests\Acl\RoleRequest;


    class RolesController extends Controller {

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

        /**
         * RolesController constructor.
         *
         * @param User       $user
         * @param Role       $role
         * @param Permission $permission
         */
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
            $paginate = $this->role->with(['permissions', 'users', 'routes'])->paginate(10);

            return view('users::acl.roles.index', compact('paginate'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create ()
        {
            $permissions = $this->permission->all();
            $routes      = routes_group();

            return view('users::acl.roles.create', compact('permissions', 'routes'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function store (RoleRequest $request)
        {
            $insert = Role::create($request->all());
            $insert->syncPermissions($request->permissions ? $request->permissions : []);
            $insert->syncRoutes($request->routes ? $request->routes : []);

            return redirect(route('admin.roles.edit', $insert->id))->with('status-success', 'Regra criada com sucesso');
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
            $data        = $this->role->with(['permissions', 'routes'])->find($id);
            $permissions = $this->permission->all();
            $routes      = routes_group();

            if (!$data) {
                return redirect()->route('admin.roles');
            }

            return view('users::acl.roles.edit', compact('data', 'permissions', 'routes'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function update (RoleRequest $request, $id)
        {
            $data = $this->role->findOrFail($id);
            $data->update($request->all());

            $data->syncPermissions($request->permissions ? $request->permissions : []);
            $data->syncRoutes($request->routes ? $request->routes : []);

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy (Request $request)
        {
            $data = $this->role->findOrFail($request->id);
            $data->forceDelete();
        }
    }
