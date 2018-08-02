<?php

    namespace Modules\Emails\Http\Controllers\Web;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Illuminate\Support\Facades\Mail;
    use Modules\Emails\Emails\ContactMail;
    use Modules\Emails\Http\Requests\ContactRequest;

    class ContactController extends Controller {
        public function __construct ()
        {
        }

        public function sendMailContact (ContactRequest $request)
        {
            $email = Mail::to('michelvieira@outlook.com')->send(new ContactMail($request));

            if (Mail::failures()) {
                return back()->with('status-danger', 'Sua mensagem não pode ser enviada, tente novamente!');
            }

            return back()->with('status-success', 'Mensagem enviada com sucesso. Em breve entraremos em contato!');
        }
    }
