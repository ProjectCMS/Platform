<?php

    namespace Modules\Posts\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Posts\Entities\Category;
    use Modules\Posts\Http\Requests\Categories\CreateRequest;
    use Modules\Posts\Http\Requests\Categories\UpdateRequest;

    class CategoriesController extends Controller {

        /**
         * @var Category
         */
        private $category;

        public function __construct (Category $category)
        {
            $this->category = $category;
        }

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index (Request $request)
        {
            $paginate = $this->category->search($request->all())->paginate(10);

            return view('posts::admin.categories.index', compact('paginate'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create ()
        {
            $parent = $this->category->where([["parent_id", "=", 0]])
                               ->pluck('title', 'id')
                               ->prepend('# Categoria Principal', 0);

            return view('posts::admin.categories.create', compact('parent'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function store (CreateRequest $request)
        {
            $insert = $this->category->create($request->all());

            return redirect(route('admin.categories.edit', $insert->id))->with('status-success', 'Categoria criada com sucesso');
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
            $data   = $this->category->find($id);
            $parent = $this->category->where([["id", "!=", $id], ["parent_id", "=", 0]])
                               ->pluck('title', 'id')
                               ->prepend('# Categoria Principal', 0);
            if (!$data) {
                return redirect()->route('admin.categories');
            }

            return view('posts::admin.categories.edit', compact('data', 'parent'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function update (UpdateRequest $request, $id)
        {
            $data = $this->category->findOrFail($id);

            $data->update($request->all());

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy (Request $request)
        {
            $data = $this->category->findOrFail($request->id);

            if ($data->posts()->count() == 0) {
                $data->menuItem()->forceDelete();
                $data->forceDelete();
            } else {
                back()->with('status-danger', 'Não foi possivel deletar a categoria <b>' . $data->title . '</b>');
            }
        }

    }
