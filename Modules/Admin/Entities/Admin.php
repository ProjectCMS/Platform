<?php

    namespace Modules\Admin\Entities;

    use App\Notifications\AdminResetPassword;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;

    class Admin extends Authenticatable {
        use Notifiable;

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

        /**
         * Send the password reset notification.
         *
         * @param  string $token
         *
         * @return void
         */
        public function sendPasswordResetNotification ($token)
        {
            $this->notify(new AdminResetPassword($token));
        }

        public function roles ()
        {
            return $this->belongsToMany('Modules\Admin\Entities\Role', 'role_admins');
        }

    }
