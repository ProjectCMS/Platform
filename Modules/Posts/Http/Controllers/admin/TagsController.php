<?php

    namespace Modules\Posts\Http\Controllers\admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Posts\Entities\Tag;
    use Modules\Posts\Http\Requests\Tags\CreateRequest;
    use Modules\Posts\Http\Requests\Tags\UpdateRequest;

    class TagsController extends Controller {
        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index (Tag $tag, Request $request)
        {
            $paginate = $tag->search($request->all())->paginate(10);

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
        public function store (Tag $tag, CreateRequest $request)
        {
            $insert = $tag->create($request->all());

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
        public function edit (Tag $tag, $id)
        {
            $data = $tag->find($id);
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
        public function update (Tag $tag, UpdateRequest $request, $id)
        {
            $data = $tag->findOrFail($id);

            $data->update($request->all());

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy (Tag $tag, Request $request)
        {
            $data = $tag->find($request->id);

            if ($data->posts()->count() == 0) {
                $data->forceDelete();
            } else {
                back()->with('status-danger', 'Não foi possivel deletar a tag <b>' . $data->name . '</b>');
            }
        }

    }
