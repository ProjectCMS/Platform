<?php

    namespace Modules\Subscribes\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Subscribes\Entities\Subscribe;
    use Modules\Subscribes\Entities\SubscribeCicles;
    use Modules\Subscribes\Entities\SubscribePeriods;
    use Modules\Subscribes\Http\Requests\CicleRequest;

    class CiclesController extends Controller {
        /**
         * @var Subscribe
         */
        private $subscribe;
        /**
         * @var SubscribeCicles
         */
        private $cicles;
        /**
         * @var SubscribePeriods
         */
        private $periods;

        public function __construct (Subscribe $subscribe, SubscribeCicles $cicles, SubscribePeriods $periods)
        {
            $this->subscribe = $subscribe;
            $this->cicles    = $cicles;
            $this->periods   = $periods;
        }

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            $paginate = $this->cicles->with(['period'])->paginate(10);

            return view('subscribes::admin.cicles.index', compact('paginate'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create ()
        {
            $periods = $this->periods->pluck('title', 'id');

            return view('subscribes::admin.cicles.create', compact('periods'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function store (CicleRequest $request)
        {
            $insert = $this->cicles->create($request->all());

            return redirect(route('admin.subscribes.cicles.edit', $insert->id))->with('status-success', 'Ciclo criado com sucesso');
        }

        /**
         * Show the specified resource.
         * @return Response
         */
        public function show ()
        {
            return view('subscribes::show');
        }

        /**
         * Show the form for editing the specified resource.
         * @return Response
         */
        public function edit ($id)
        {
            $data    = $this->cicles->find($id);
            $periods = $this->periods->pluck('title', 'id');

            return view('subscribes::admin.cicles.edit', compact('data', 'periods'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function update (CicleRequest $request, $id)
        {
            $data = $this->cicles->findOrFail($id);
            $data->update($request->all());

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy (Request $request)
        {
            $data = $this->cicles->findOrFail($request->id);
            $data->forceDelete();
        }
    }
