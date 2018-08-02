<?php

    namespace Modules\Clients\Http\Controllers\Web\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Hesto\MultiAuth\Traits\LogsoutGuard;
    use Modules\Seo\Libs\Manager;

    class LoginController extends Controller {
        /*
        |--------------------------------------------------------------------------
        | Login Controller
        |--------------------------------------------------------------------------
        |
        | This controller handles authenticating users for the application and
        | redirecting them to your home screen. The controller uses a trait
        | to conveniently provide its functionality to your applications.
        |
        */

        use AuthenticatesUsers, LogsoutGuard {
            LogsoutGuard::logout insteadof AuthenticatesUsers;
        }

        /**
         * Where to redirect users after login / registration.
         *
         * @var string
         */
        public $redirectTo = '/';
        /**
         * @var Manager
         */
        private $seo;
        /**
         * @var Request
         */
        private $request;

        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct (Manager $seo, Request $request)
        {
            $this->middleware('client.guest', ['except' => 'logout']);
            $this->seo     = $seo;
            $this->request = $request;
        }

        /**
         * Show the application's login form.
         *
         * @return \Illuminate\Http\Response
         */
        public function showLoginForm ()
        {
            $seo = $this->seo->setData('page', NULL, ['title' => 'Login']);

            return view('clients::web.auth.login', compact('seo'));
        }

        /**
         * Get the guard to be used during authentication.
         *
         * @return \Illuminate\Contracts\Auth\StatefulGuard
         */
        protected function guard ()
        {
            return Auth::guard('client');
        }

        protected function authenticated (Request $request, $user)
        {
            if ($request->ajax()) {
                return response()->json([
                    'auth'     => auth('client')->check(),
                    'user'     => $user->name,
                    'intended' => url($this->redirectPath()),
                ]);

            }
        }

        /**
         * @return string
         */
        public function redirectTo ()
        {
            $this->redirectTo = $this->request->session()->get('url.intended');
            return $this->redirectTo;
        }

    }
