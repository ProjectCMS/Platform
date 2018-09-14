<?php

    namespace Modules\Clients\Http\Controllers\Web\Account;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Storage;
    use Modules\Clients\Http\Requests\Web\AvatarRequest;
    use Modules\Clients\Http\Requests\Web\ClientRequest;
    use Modules\Clients\Http\Requests\Web\PasswordRequest;
    use Modules\Seo\Libs\Manager;

    class AccountController extends Controller {

        /**
         * @var Manager
         */
        private $seo;

        public function __construct (Manager $seo)
        {
            $this->seo = $seo;
        }

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            $seo = $this->seo->setData('page', null, ['title' => 'Visão geral da conta']);
            return view('clients::web.account.home', compact('seo'));
        }

        public function profile ()
        {
            $seo = $this->seo->setData('page', null, ['title' => 'Editar perfil']);
            return view('clients::web.account.profile', compact('seo'));
        }

        public function password ()
        {
            $seo = $this->seo->setData('page', null, ['title' => 'Editar senha']);
            return view('clients::web.account.password', compact('seo'));
        }

        public function historic ()
        {
            $seo = $this->seo->setData('page', null, ['title' => 'Histórico de pagamentos']);
            return view('clients::web.account.historic', compact('seo'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function profileEdit (ClientRequest $request)
        {
            $client = auth('client')->user();
            $client->update($request->all());

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function passwordEdit (PasswordRequest $request)
        {
            $client = auth('client')->user();

            if (!(Hash::check($request->current_password, $client->password))) {
                return back()->with('status-danger', 'Sua senha atual não corresponde à senha que você forneceu. Por favor, tente novamente.');
            }

            if (strcmp($request->current_password, $request->new_password) == 0) {
                return back()->with('A nova senha não pode ser igual à sua senha atual. Por favor, escolha uma senha diferente.');
            }

            $client->update(['password' => bcrypt($request->new_password)]);

            return back()->with('status-success', 'Dados atualizado com sucesso');

        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function clientAvatar (AvatarRequest $request)
        {
            $client = auth('client')->user();
            $path   = 'public/clients/' . md5($client->id) . '/avatar';

            Storage::delete('public/' . $client->avatar);

            $upload = Storage::putFile($path, $request->file('avatar'));
            $upload = str_replace('public/', '', $upload);

            $client->avatar = $upload;
            $client->save();

            return back();
        }


    }
