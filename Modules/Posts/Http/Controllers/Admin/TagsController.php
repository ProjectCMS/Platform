<?php

    namespace Modules\Posts\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Posts\Entities\Tag;
    use Modules\Posts\Http\Requests\TagRequest;

    class TagsController extends Controller {

        /**
         * @var Tag
         */
        private $tag;

        public function __construct (Tag $tag)
        {
            $this->tag = $tag;
        }

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index (Request $request)
        {
            $paginate = $this->tag->search($request->all())->paginate(10);

            return view('posts::admin.tags.index', compact('paginate'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create ()
        {
            return view('posts::admin.tags.create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function store (TagRequest $request)
        {
            $insert = $this->tag->create($request->all());

            return redirect(route('admin.tags.edit', $insert->id))->with('status-success', 'Tag criada com sucesso');
        }

        /**
         * Show the specified resource.
         * @return Response
         */
        public function show ()
        {
            return view('posts::show');
        }

        /**
         * Show the form for editing the specified resource.
         * @return Response
         */
        public function edit ($id)
        {
            $data = $this->tag->find($id);
            if (!$data) {
                return redirect()->route('admin.tags');
            }

            return view('posts::admin.tags.edit', compact('data'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function update (TagRequest $request, $id)
        {
            $data = $this->tag->findOrFail($id);

            $data->update($request->all());

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy (Request $request)
        {
            $data = $this->tag->findOrFail($request->id);

            if ($data->posts()->count() == 0) {
                $data->forceDelete();
            } else {
                back()->with('status-danger', 'Não foi possivel deletar a tag <b>' . $data->title . '</b>');
            }
        }

    }
