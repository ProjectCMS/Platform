<?php

    namespace Modules\Emails\Http\Controllers\Web;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Illuminate\Support\Facades\Mail;
    use Modules\Emails\Emails\ContactMail;

    class ContactController extends Controller {
        public function __construct ()
        {
        }

        public function sendMailContact ()
        {
            Mail::to('mrvieira19@gmail.com')->send(new ContactMail());
        }
    }
