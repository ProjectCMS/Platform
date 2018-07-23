<?php

    namespace Modules\Users\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Modules\Core\Traits\FormatDates;
    use Spatie\Permission\Traits\HasRoles;
    use Illuminate\Support\Facades\Auth;

    class User extends Authenticatable {
        use Notifiable;
        use Cachable;
        use HasRoles;
        use FormatDates;

        protected static $logAttributes = ['name', 'email'];
        protected static $logName       = 'Usuários';

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name',
            'email',
            'password',
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password',
            'remember_token',
        ];

        public function setPasswordAttribute ($value)
        {
            $this->attributes["password"] = bcrypt($value);
        }


        public static function acl ($route)
        {
            $tableNames = config('permission.table_names');
            $auth       = Auth::guard('user')->user();
            $users      = User::all()->count();
            $r          = $auth->roles();
            $p          = $auth->permissions();

            $roles        = collect([]);
            $permissions  = collect([]);
            $userAdmin    = FALSE;
            $exceptRoutes = [
                'admin.account',
                'admin.account.update'
            ];


            // Verifica o total de usuários cadastrados
            if (!($users == 1)) {
                // Verifica se o usuário logado é um admin
                if ($auth->hasRole('admin')) {
                    $userAdmin = TRUE;
                }
            } else {
                $userAdmin = TRUE;
            }

            if(in_array($route, $exceptRoutes)){

                $roles->push([1]);

            }else {
                if ($userAdmin == FALSE) {
                    $roles = $r->with(['routes', 'permissions'])
                               ->when($route, function($query) use ($route, $exceptRoutes, $tableNames) {
                                   $query->whereHas('routes', function($query) use ($route, $tableNames) {
                                       $query->where($tableNames['route_has_roles'] . '.route', $route);
                                   });
                                   $query->orWhereHas('permissions.routes', function($query) use ($route, $exceptRoutes, $tableNames) {
                                       $query->where($tableNames['route_has_permissions'] . '.route', $route);
                                   });

                                   return $query;
                               });

                    $permissions = $p->with('routes')
                                     ->when($route, function($query) use ($route, $exceptRoutes, $tableNames) {
                                         $query->whereHas('routes', function($query) use ($route, $exceptRoutes, $tableNames) {
                                             $query->where($tableNames['route_has_permissions'] . '.route', $route);
                                         });

                                         return $query;
                                     });
                }
            }

            return (object)compact('roles', 'permissions', 'userAdmin');
        }

    }
