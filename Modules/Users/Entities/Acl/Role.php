<?php

    namespace Modules\Users\Entities\Acl;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;
    use Modules\Core\Traits\FormatDates;
    use Modules\Users\Traits\Acl\RouteRoles;

    class Role extends \Spatie\Permission\Models\Role {
        use FormatDates;
        use Cachable;
        use RouteRoles;

        protected $fillable = ['name', 'label', 'guard_name'];

    }
