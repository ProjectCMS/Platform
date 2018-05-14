<?php

    namespace Modules\Posts\Http\Controllers\admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Posts\Entities\Category;

    class CategoriesController extends Controller {
        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index (Request $request, Category $category)
        {
            $paginate = $category->search($request->all())->paginate(10);

            return view('posts::admin.categories.index', compact('paginate'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create ()
        {
            $parent = Category::where([["parent_id", "=", 0]])
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
        public function store (Request $request)
        {
            $validation = $this->validation($request);
            $insert     = Category::create($validation);

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
            $data   = Category::find($id);
            $parent = Category::where([["id", "!=", $id], ["parent_id", "=", 0]])
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
        public function update (Request $request, $id)
        {
            $data       = Category::findOrFail($id);
            $validation = $this->validation($request, $id);

            $data->update($validation);

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy (Request $request)
        {
            $data = Category::find($request->id);

            if ($data->posts()->count() == 0) {
                $data->forceDelete();
            } else {
                back()->with('status-danger', 'Não foi possivel deletar a categoria <b>' . $data->name . '</b>');
            }
        }

        /**
         * Categories Validation
         * @return Response
         */
        public function validation ($request, $id = NULL)
        {
            $validation = $request->validate([
                'name'      => 'required|unique:categories,name,' . $id,
                'parent_id' => 'required'
            ]);

            $validation["slug"] = str_slug($validation["name"], '-');

            return $validation;
        }
    }
