<?php

    namespace Modules\Users\Traits\Acl;

    use Illuminate\Database\Eloquent\Relations\BelongsToMany;

    trait RoutePermissions {

        public function routes (): BelongsToMany
        {
            return $this->belongsToMany(config('permission.models.permission'), config('permission.table_names.route_has_permissions'))->withPivot('route');
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