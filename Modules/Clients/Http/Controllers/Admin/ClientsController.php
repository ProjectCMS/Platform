<?php

    namespace Modules\Clients\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Clients\Entities\Client;
    use Modules\Clients\Http\Requests\Admin\ClientRequest;

    class ClientsController extends Controller {
        /**
         * @var Client
         */
        private $client;

        public function __construct (Client $client)
        {
            $this->client = $client;
        }

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            $paginate = $this->client->paginate(10);

            return view('clients::admin.index', compact('paginate'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create ()
        {
            return view('clients::admin.create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function store (ClientRequest $request)
        {
            $insert = $this->client->create($request->all());

            return redirect(route('admin.clients.edit', $insert->id))->with('status-success', 'Usuário criado com sucesso');
        }

        /**
         * Show the specified resource.
         * @return Response
         */
        public function show ()
        {
            return view('clients::show');
        }

        /**
         * Show the form for editing the specified resource.
         * @return Response
         */
        public function edit ($id)
        {
            $data  = $this->client->find($id);

            if (!$data) {
                return redirect()->route('admin.clients');
            }

            return view('clients::admin.edit', compact('data'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function update (ClientRequest $request, $id)
        {
            $data = $this->client->findOrFail($id);

            $data->update($request->all());

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy (Request $request)
        {
            $data = $this->client->findOrFail($request->id);
            $data->forceDelete();
        }
    }
