<?php

    namespace Modules\Users\Entities\Acl;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;
    use Modules\Core\Traits\FormatDates;
    use Modules\Users\Traits\Acl\RoutePermissions;

    class Permission extends \Spatie\Permission\Models\Permission {

        use FormatDates;
        use Cachable;
        use RoutePermissions;

        protected $fillable = ['name', 'label', 'description', 'guard_name'];

    }
