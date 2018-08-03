<?php

    namespace Modules\Publishers\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Core\Entities\Status;
    use Modules\Publishers\Entities\Publisher;
    use Modules\Publishers\Entities\PublisherOrientation;
    use Modules\Publishers\Http\Requests\PublisherRequest;

    class PublishersController extends Controller {

        /**
         * @var Publisher
         */
        private $publisher;
        /**
         * @var PublisherOrientation
         */
        private $orientation;
        /**
         * @var Status
         */
        private $status;

        public function __construct (Publisher $publisher, PublisherOrientation $orientation, Status $status)
        {

            $this->publisher   = $publisher;
            $this->orientation = $orientation;
            $this->status      = $status;
        }

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            $paginate = $this->publisher->with(['orientation'])->paginate(10);

            return view('publishers::admin.index', compact('paginate'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create ()
        {
            $status      = $this->status->pluck('title', 'id');
            $orientation = $this->orientation->pluck('title', 'id');

            return view('publishers::admin.create', compact('status', 'orientation'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function store (PublisherRequest $request)
        {
            $insert = $this->publisher->create($request->all());

            return redirect(route('admin.settings.publishers.edit', $insert->id))->with('status-success', 'Publicidade criada com sucesso');
        }

        /**
         * Show the specified resource.
         * @return Response
         */
        public function show ()
        {
            return view('publishers::show');
        }

        /**
         * Show the form for editing the specified resource.
         * @return Response
         */
        public function edit ($id)
        {
            $data        = $this->publisher->with(['orientation', 'status'])->find($id);
            $status      = $this->status->pluck('title', 'id');
            $orientation = $this->orientation->pluck('title', 'id');

            if (!$data) {
                return redirect()->route('admin.settings.publishers');
            }

            return view('publishers::admin.edit', compact('data', 'status', 'orientation'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function update (PublisherRequest $request, $id)
        {
            $data = $this->publisher->findOrFail($id);

            $data->update($request->all());

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy (Request $request)
        {
            $data = $this->publisher->findOrFail($request->id);
            $data->forceDelete();
        }
    }
