<?php

    namespace Modules\Clients\Http\Controllers\Web\Auth;

    use Modules\Seo\Libs\Manager;
    use Validator;
    use Modules\Clients\Entities\Client;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Foundation\Auth\RegistersUsers;
    use Illuminate\Support\Facades\Auth;

    class RegisterController extends Controller {
        /*
        |--------------------------------------------------------------------------
        | Register Controller
        |--------------------------------------------------------------------------
        |
        | This controller handles the registration of new users as well as their
        | validation and creation. By default this controller uses a trait to
        | provide this functionality without requiring any additional code.
        |
        */

        use RegistersUsers;

        /**
         * Where to redirect users after login / registration.
         *
         * @var string
         */
        protected $redirectTo = '/client/home';
        /**
         * @var Manager
         */
        private $seo;

        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct (Manager $seo)
        {
            $this->middleware('client.guest');
            $this->seo = $seo;
        }

        /**
         * Get a validator for an incoming registration request.
         *
         * @param  array $data
         *
         * @return \Illuminate\Contracts\Validation\Validator
         */
        protected function validator (array $data)
        {
            return Validator::make($data, [
                'name'     => 'required|max:255',
                'email'    => 'required|email|max:255|unique:clients',
                'password' => 'required|min:6',
            ]);
        }

        /**
         * Create a new user instance after a valid registration.
         *
         * @param  array $data
         *
         * @return Client
         */
        protected function create (array $data)
        {
            return Client::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
        }

        /**
         * Show the application registration form.
         *
         * @return \Illuminate\Http\Response
         */
        public function showRegistrationForm ()
        {
            $seo  = $this->seo->setData('page', null, ['title' => 'Novo registro']);
            return view('clients::web.auth.register', compact('seo'));
        }

        /**
         * Get the guard to be used during registration.
         *
         * @return \Illuminate\Contracts\Auth\StatefulGuard
         */
        protected function guard ()
        {
            return Auth::guard('client');
        }

        protected function registered (Request $request, $user)
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
