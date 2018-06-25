<?php

    namespace Modules\Users\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;

    class User extends Authenticatable {
        use Notifiable;
        use Cachable;

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

    }
