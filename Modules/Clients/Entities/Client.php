<?php

    namespace Modules\Clients\Entities;

    use Modules\Clients\Notifications\ClientResetPassword;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Auth;
    use Modules\Core\Traits\FormatDates;

    class Client extends Authenticatable {
        use Notifiable;
        use FormatDates;

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

        /**
         * Send the password reset notification.
         *
         * @param  string $token
         *
         * @return void
         */
        public function sendPasswordResetNotification ($token)
        {
            $this->notify(new ClientResetPassword($token));
        }

        public function socialAccount ()
        {
            return $this->hasMany('Modules\Clients\Entities\SocialAccount');
        }

        public static function check ()
        {
            return Auth::guard('client')->check();
        }

        public static function user ()
        {
            return Auth::guard('client')->user();
        }

    }
