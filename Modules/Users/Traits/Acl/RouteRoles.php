<?php

    namespace Modules\Users\Traits\Acl;

    use Illuminate\Database\Eloquent\Relations\BelongsToMany;

    trait RouteRoles {

        public function routes (): BelongsToMany
        {
            return $this->belongsToMany(config('permission.models.role'), config('permission.table_names.route_has_roles'))
                        ->withPivot('route');
        }

        public function syncRoutes (...$routes)
        {
            $this->routes()->detach();

            return $this->giveRouteTo($routes);
        }

        public function giveRouteTo (...$routes)
        {
            $routes = collect($routes)->flatten()->all();
            foreach ($routes as $key => $route) {
                $this->routes()->attach($key, ["route" => $route]);
            }
        }

    }