<?php

    namespace Modules\Users\Http\Controllers\Acl;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Users\Entities\Acl\Permission;
    use Modules\Users\Entities\Acl\Role;
    use Modules\Users\Entities\User;
    use Modules\Users\Http\Requests\Acl\PermissionRequest;

    class PermissionsController extends Controller {
        /**
         * @var User
         */
        private $user;
        /**
         * @var Permission
         */
        private $permission;
        /**
         * @var Role
         */
        private $role;

        /**
         * PermissionsController constructor.
         *
         * @param User       $user
         * @param Permission $permission
         * @param Role       $role
         */
        public function __construct (User $user, Permission $permission, Role $role)
        {
            $this->user       = $user;
            $this->permission = $permission;
            $this->role       = $role;
        }

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            $paginate = $this->permission->with(['roles', 'routes'])->paginate(10);

            return view('users::acl.permissions.index', compact('paginate'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create ()
        {
            $roles  = $this->role->all();
            $routes = routes_group();

            return view('users::acl.permissions.create', compact('roles', 'routes'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function store (PermissionRequest $request)
        {
            $insert = $this->permission->create($request->all());
            $insert->syncRoles($request->roles ? $request->roles : []);
            $insert->syncRoutes($request->routes ? $request->routes : []);

            return redirect(route('admin.permissions.edit', $insert->id))->with('status-success', 'Regra criada com sucesso');
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
            $data   = $this->permission->with(['roles', 'routes'])->find($id);
            $roles  = $this->role->all();
            $routes = routes_group();

            if (!$data) {
                return redirect()->route('admin.permissions');
            }

            return view('users::acl.permissions.edit', compact('data', 'roles', 'routes'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function update (PermissionRequest $request, $id)
        {
            $data = $this->permission->findOrFail($id);
            $data->update($request->all());

            $data->syncRoles($request->roles ? $request->roles : []);
            $data->syncRoutes($request->routes ? $request->routes : []);

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy (Request $request)
        {
            $data = $this->permission->findOrFail($request->id);
            $data->forceDelete();
        }
    }
