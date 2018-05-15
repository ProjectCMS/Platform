<?php

    namespace Modules\Posts\Http\Controllers\admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Posts\Entities\Category;
    use Modules\Posts\Http\Requests\Categories\CreateRequest;
    use Modules\Posts\Http\Requests\Categories\UpdateRequest;

    class CategoriesController extends Controller {
        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index (Category $category, Request $request)
        {
            $paginate = $category->search($request->all())->paginate(10);

            return view('posts::admin.categories.index', compact('paginate'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create (Category $category)
        {
            $parent = $category->where([["parent_id", "=", 0]])
                               ->pluck('name', 'id')
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
        public function store (Category $category, CreateRequest $request)
        {
            $insert = $category->create($request->all());

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
        public function edit (Category $category, $id)
        {
            $data   = $category->find($id);
            $parent = $category->where([["id", "!=", $id], ["parent_id", "=", 0]])
                               ->pluck('name', 'id')
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
        public function update (Category $category, UpdateRequest $request, $id)
        {
            $data = $category->findOrFail($id);

            $data->update($request->all());

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy (Category $category, Request $request)
        {
            $data = $category->find($request->id);

            if ($data->posts()->count() == 0) {
                $data->forceDelete();
            } else {
                back()->with('status-danger', 'Não foi possivel deletar a categoria <b>' . $data->name . '</b>');
            }
        }

    }
