<?php

    namespace Modules\Emails\Emails;

    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Contracts\Queue\ShouldQueue;

    class ContactMail extends Mailable {
        use Queueable, SerializesModels;
        private $data;

        /**
         * Create a new message instance.
         *
         * @return void
         */
        public function __construct ($data)
        {
            //
            $this->data = $data;
        }

        /**
         * Build the message.
         *
         * @return $this
         */
        public function build ()
        {
            return $this->view('emails::templates.contact')->from([
                    'address' => $this->data->email,
                    'name'    => $this->data->name
                ])->subject(setting('site_name') . ' - ' . $this->data->subject)->with(['data' => $this->data]);
        }
    }
