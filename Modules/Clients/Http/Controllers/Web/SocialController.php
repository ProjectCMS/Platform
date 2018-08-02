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
        /**
         * @var Request
         */
        private $request;

        public function __construct (SocialAccount $socialAccount, Request $request)
        {
            $this->socialAccount = $socialAccount;
            $this->request       = $request;
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

                    $redirect = $this->request->session()->get('url.intended');

                    return redirect()->to($redirect);
                }

            } catch (\Exception $e) {
                return redirect('/');
            }
        }

        public function setConfig ($provider)
        {
            config(['services.' . $provider . '.redirect' => route('web.clients.social.redirect', $provider)]);
        }

    }
