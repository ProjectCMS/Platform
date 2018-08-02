<?php

    namespace Modules\Payments\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Payments\Entities\PaymentMethod;

    class PaymentsController extends Controller {
        /**
         * @var PaymentMethod
         */
        private $paymentMethod;

        public function __construct (PaymentMethod $paymentMethod)
        {
            $this->paymentMethod = $paymentMethod;
        }

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            $paginate = $this->paymentMethod->paginate(10);

            return view('payments::admin.index', compact('paginate'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create ()
        {
            return view('payments::create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function store (Request $request)
        {
        }

        /**
         * Show the specified resource.
         * @return Response
         */
        public function show ()
        {
            return view('payments::show');
        }

        /**
         * Show the form for editing the specified resource.
         * @return Response
         */
        public function edit ($id)
        {
            $data = $this->paymentMethod->with(['configs', 'group'])->find($id);

            return view('payments::admin.edit', compact('data'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function update (Request $request, $id)
        {
            $paymentMethod = $this->paymentMethod->find($id);
            $paymentConfig = $paymentMethod->configs()->first();

            $paymentMethod->update($request->all());

            if ($request->config) {
                foreach ($request->config as $name => $value) {
                    $paymentConfig->set($name, $value);
                }
            }

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy ()
        {
        }
    }
