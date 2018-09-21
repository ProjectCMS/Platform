<?php

    namespace Modules\Contents\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Jenssegers\Date\Date;
    use Modules\Contents\Entities\Content;
    use Modules\Contents\Entities\ContentParticipants;
    use Modules\Contents\Entities\ContentStatus;
    use Modules\Contents\Entities\ContentCicles;
    use Modules\Contents\Http\Requests\Admin\ContentsRequest;
    use Modules\Contents\Http\Requests\Admin\CicleRequest;
    use Modules\Subscribes\Entities\SubscribeCicles;

    class ContentsController extends Controller {

        /**
         * @var Content
         */
        private $content;
        /**
         * @var ContentCicles
         */
        private $contentCicles;
        /**
         * @var ContentParticipants
         */
        private $contentParticipants;
        /**
         * @var ContentStatus
         */
        private $contentStatus;
        /**
         * @var SubscribeCicles
         */
        private $subscribeCicles;

        public function __construct (Content $content, ContentCicles $contentCicles, ContentParticipants $contentParticipants, ContentStatus $contentStatus, SubscribeCicles $subscribeCicles)
        {
            $this->content             = $content;
            $this->contentCicles       = $contentCicles;
            $this->contentParticipants = $contentParticipants;
            $this->contentStatus       = $contentStatus;
            $this->subscribeCicles     = $subscribeCicles;
        }

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            $paginate = $this->content->with(['participants'])->paginate(10);

            return view('contents::admin.index', compact('paginate'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create ()
        {
            $status = $this->contentStatus->pluck('title', 'id');
            $cicles = $this->subscribeCicles->pluck('title', 'id');

            return view('contents::admin.create', compact('status', 'cicles'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function store (ContentsRequest $request)
        {
            $insert = $this->content->create($request->all());
            $this->contentCicles->setCicles($insert->id, $request->cicle);

            return redirect(route('admin.contents.edit', $insert->id))->with('status-success', 'Concurso criado com sucesso');
        }

        /**
         * Show the specified resource.
         * @return Response
         */
        public function show ()
        {
            return view('contents::show');
        }

        /**
         * Show the form for editing the specified resource.
         * @return Response
         */
        public function edit ($id)
        {
            $data   = $this->content->find($id)->load(['cicles.cicle']);
            $status = $this->contentStatus->pluck('title', 'id');
            $cicles = $this->subscribeCicles->pluck('title', 'id');

            if (!$data) {
                return redirect()->route('admin.contents');
            }

            return view('contents::admin.edit', compact('data', 'status', 'cicles'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function update (ContentsRequest $request, $id)
        {
            $data = $this->content->findOrFail($id);
            $data->update($request->all());
            $this->contentCicles->setCicles($id, $request->cicle);

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy (Request $request)
        {
            $data = $this->content->findOrFail($request->id);
            $data->forceDelete();
        }

        public function cicle (CicleRequest $request)
        {
            $cicle = $this->subscribeCicles->find($request->cicle);

            return ['cicle_name' => $cicle->title, 'cicle_id' => $request->cicle, 'votes' => $request->votes];
        }
    }
