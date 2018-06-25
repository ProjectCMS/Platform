<?php

    namespace Modules\Clients\Http\Controllers\Web;

    use Modules\Clients\Entities\SocialAccount;
    use Socialite;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;

    class SocialController extends Controller {

        /**
         * @var SocialAccount
         */
        private $socialAccount;

        public function __construct (SocialAccount $socialAccount)
        {
            $this->socialAccount = $socialAccount;
        }

        public function login ($provider)
        {
            $this->setConfig($provider);
            return Socialite::driver($provider)->redirect();
        }

        public function redirect ($provider)
        {
            $this->setConfig($provider);
            try {
                $user = $this->socialAccount->login(Socialite::driver($provider)->user(), $provider);

                if ($user) {
                    auth('client')->login($user);

                    return redirect()->to('/');
                }

            } catch (\Exception $e) {
                return redirect('/teste');
            }
        }

        public function setConfig ($provider)
        {
            config(['services.' . $provider . '.redirect' => route('web.clients.social.redirect', $provider)]);
        }

    }
