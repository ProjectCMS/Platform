<?php

    namespace Modules\Subscribes\Http\Controllers\Web;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Payments\Entities\PaymentLogs;
    use Modules\Subscribes\Entities\Subscribe;
    use Modules\Subscribes\Entities\SubscribeCicles;
    use Modules\Subscribes\Entities\subscribeKeyLogs;
    use Modules\Subscribes\Entities\subscribeKeys;
    use Modules\Subscribes\Entities\SubscribeLogs;
    use Modules\Subscribes\Http\Requests\KeysRequest;
    use Carbon\Carbon;

    class SubscribesController extends Controller {
        /**
         * @var Subscribe
         */
        private $subscribe;
        /**
         * @var SubscribeCicles
         */
        private $cicles;
        /**
         * @var subscribeKeys
         */
        private $subscribeKeys;
        /**
         * @var subscribeKeyLogs
         */
        private $subscribeKeyLogs;
        /**
         * @var SubscribeLogs
         */
        private $subscribeLogs;
        /**
         * @var PaymentLogs
         */
        private $paymentLogs;

        public function __construct (Subscribe $subscribe, SubscribeCicles $cicles, SubscribeLogs $subscribeLogs, subscribeKeys $subscribeKeys, subscribeKeyLogs $subscribeKeyLogs, PaymentLogs $paymentLogs)
        {
            $this->subscribe        = $subscribe;
            $this->cicles           = $cicles;
            $this->subscribeKeys    = $subscribeKeys;
            $this->subscribeKeyLogs = $subscribeKeyLogs;
            $this->subscribeLogs    = $subscribeLogs;
            $this->paymentLogs      = $paymentLogs;
        }

        public function plan (Request $request, $id)
        {
            $request->session()->forget('subscribe_cicle');

            if ($id && $this->cicles->find($id)) {
                $request->session()->put('subscribe_cicle', $request->id);
            } else {
                return redirect()->back();
            }

            return redirect(route('web.payment'));
        }

        public function key (KeysRequest $request)
        {
            $client = auth('client')->user();
            $key    = $this->subscribeKeys->with(['cicle'])
                                          ->where('key', $request->key)
                                          ->whereColumn('use_general', '>', 'used')
                                          ->whereStatus(1)
                                          ->whereDate('validate_at', '>=', \Carbon\Carbon::now()->format('Y-m-d'))
                                          ->first();
            // Verifica se a chave pode ser usada
            if ($key) {

                // Verifica se existe algum log da chave
                $keyLogin = $this->subscribeKeyLogs->where([
                    'key_id'    => $key->id,
                    'client_id' => $client->id
                ]);

                // Verifica se o cliente pode usar essa chave
                if ($keyLogin->count() < $key->use_client) {

                    $subscribe      = $this->subscribe->whereClientId($client->id)->first();
                    $renovationDate = Carbon::now()->addDay($key->cicle->period->days);

                    // Verifica se o cliente já tem uma assinatura
                    $insertSubscribe = $this->subscribe->updateOrCreate([
                        'client_id' => $client->id,
                    ], [
                        'cicle_id'      => $key->cicle_id,
                        'status'        => 1,
                        'renovation_at' => $renovationDate,
                    ]);

                    // Verifica se é um update de assinatura
                    if (!$insertSubscribe->wasRecentlyCreated) {

                        $currentDate    = Carbon::now();
                        $renovationDate = Carbon::parse($subscribe->renovation_at);
                        $diffDate       = $currentDate->diffInDays($renovationDate);

                        if ($diffDate >= 1) {
                            $renovationDate = $renovationDate->addDay($diffDate);
                        }

                        $renovationDate = $renovationDate;

                        $insertSubscribe->update(['renovation_at' => $renovationDate]);
                    }

                    // Insere dados de log da assinatura
                    $this->subscribeLogs->create([
                        'subscribe_id' => $insertSubscribe->id,
                        'cicle_id'     => $key->cicle_id,
                        'validate_at'  => $renovationDate
                    ]);

                    // Insere dados de log da chave
                    $this->subscribeKeyLogs->create([
                        'key_id'    => $key->id,
                        'client_id' => $client->id
                    ]);

                    // Modifica a quantidade de uso da chave
                    $key->increment('used');

                    // Insere dados de pagamento
                    $options = [
                        'period'      => $key->cicle->title,
                        'period_days' => $key->cicle->period->days,
                        'amount'      => $key->cicle->amount
                    ];

                    $this->paymentLogs->create([
                        'model_type'    => $this->subscribe->getMorphClass(),
                        'model_id'      => $insertSubscribe->id,
                        'method_id'     => 2,
                        'client_id'     => $client->id,
                        'token_request' => bcrypt(date('Y-m-d H:i:s')),
                        'options'       => json_encode($options),
                        'message'       => 'Chave de assinatura',
                        'status'        => 'Aprovado',
                    ]);

                    return back()->with('status-success', 'Chave ativada com sucesso!');
                }

                return back()->with('status-danger', 'Chave inválida ou indisponível!');

            }

            return back()->with('status-danger', 'Chave inválida ou indisponível!');
        }

    }
