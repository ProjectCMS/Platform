<?php

    namespace Modules\Clients\Entities;

    use Illuminate\Database\Eloquent\Model;
    use Laravel\Socialite\Contracts\User as ProviderUser;
    use Modules\Clients\Entities\Client;

    class SocialAccount extends Model {
        protected $fillable = ['user_id', 'provider_id', 'provider'];

        public function user ()
        {
            return $this->belongsTo('Modules\Clients\Entities\Client');
        }

        public function login (ProviderUser $providerUser, $provider)
        {
            $account = $this->whereProvider($provider)->whereProviderId($providerUser->getId())->first();
            if ($account) {
                return $account->user;
            } else {

                $account = new SocialAccount([
                    'provider_id' => $providerUser->getId(),
                    'provider'    => $provider
                ]);

                return $this->checkUser($providerUser, $account);

            }
        }

        public function checkUser ($providerUser, $account)
        {
            $user = Client::whereEmail($providerUser->getEmail())->first();

            if (!$user) {

                $user = Client::create([
                    'email'    => $providerUser->getEmail(),
                    'name'     => $providerUser->getName(),
                    'password' => md5(rand(1, 10000)),
                ]);
            }
            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
