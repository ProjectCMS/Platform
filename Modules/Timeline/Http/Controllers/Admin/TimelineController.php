<?php

    namespace Modules\Timeline\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Posts\Entities\Post;
    use Modules\Timeline\Entities\Timeline;
    use Modules\Timeline\Http\Requests\TimelineRequest;

    class TimelineController extends Controller {
        /**
         * @var Timeline
         */
        private $timeline;
        /**
         * @var Post
         */
        private $post;

        public function __construct (Timeline $timeline, Post $post)
        {
            $this->timeline = $timeline;
            $this->post     = $post;

            $this->order = $this->timeline->orderBy('order', 'ASC')->pluck('title', 'id');
            $this->order = $this->order->map(function($item) {
                return 'Acima - ' . $item;
            });

        }

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index (Request $request)
        {
            $paginate = $this->timeline->paginate(10);

            return view('timeline::admin.index', compact('paginate'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create ()
        {
            $posts = $this->post->whereStatusId(4)->pluck('title', 'id');
            $order = $this->order;

            return view('timeline::admin.create', compact('posts', 'order'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function store (TimelineRequest $request)
        {
            $insert = $this->timeline->create($request->all());

            return redirect(route('admin.timeline.edit', $insert->id))->with('status-success', 'Timeline criada com sucesso');
        }

        /**
         * Show the specified resource.
         * @return Response
         */
        public function show ()
        {
            return view('timeline::show');
        }

        /**
         * Show the form for editing the specified resource.
         * @return Response
         */
        public function edit ($id)
        {
            $data  = $this->timeline->find($id);
            $posts = $this->post->whereStatusId(4)->where([["id", "!=", $id]])->pluck('title', 'id');
            $order = $this->order;

            if (!$data) {
                return redirect()->route('admin.timeline');
            }

            return view('timeline::admin.edit', compact('data', 'posts', 'order'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function update (TimelineRequest $request, $id)
        {
            $data = $this->timeline->findOrFail($id);
            $data->update($request->all());

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy (Request $request)
        {
            $data = $this->timeline->findOrFail($request->id);
            $data->forceDelete();
        }
    }
