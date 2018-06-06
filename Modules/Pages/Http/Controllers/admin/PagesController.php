<?php

    namespace Modules\Pages\Http\Controllers\admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;

    use Modules\Core\Entities\Status;
    use Modules\Pages\Entities\Page;
    use Modules\Seo\Entities\Seo;
    use Modules\Pages\Http\Requests\CreateRequest;
    use Modules\Pages\Http\Requests\UpdateRequest;

    class PagesController extends Controller {

        public function __construct (Page $page, Status $status, Seo $seo)
        {
            $this->page   = $page;
            $this->status = $status;
            $this->seo    = $seo;
        }

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index (Request $request)
        {
            $data     = $this->page->search($request->all());
            $paginate = $data->paginate(10);

            return view('pages::admin.index', compact('paginate'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create ()
        {
            $parent = $this->page->where('parent_id', 0)
                                 ->pluck('title', 'id')
                                 ->prepend('# Página Principal', 0);
            $status = $this->status->pluck('title', 'id');

            return view('pages::admin.create', compact('parent', 'status'));
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
            $request->request->add(['seo_token' => bcrypt(date('Y-m-d H:i:s'))]);
            $request->request->add(['order' => $this->page->max('order') + 1]);

            $insert = $this->page->create($request->all());
            $this->seo->create([
                'seo_token'    => $request->seo_token,
                'seo_title'    => $request->seo_title ? $request->seo_title : $request->title,
                'seo_keywords' => $request->seo_keywords,
                'seo_content'  => $request->seo_content,
            ]);

            return redirect(route('admin.pages.edit', $insert->id))->with('status-success', 'Página criada com sucesso');

        }

        /**
         * Show the specified resource.
         * @return Response
         */
        public function show ()
        {
            return view('Pages::show');
        }

        /**
         * Show the form for editing the specified resource.
         * @return Response
         */
        public function edit ($id)
        {
            $data   = $this->page->with(['seo'])->findOrFail($id);
            $parent = $this->page->where([["id", "!=", $id], ["parent_id", "=", 0]])
                                  ->pluck('title', 'id')
                                  ->prepend('Página Principal', 0);
            $status = $this->status->pluck('title', 'id');

            if (!$data) {
                return redirect()->route('admin.pages');
            }

            return view('pages::admin.edit', compact('data', 'parent', 'status'));
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
            $data = $this->page->findOrFail($id);
            $data->update($request->all());

            $this->seo->updateOrCreate([
                'seo_token' => $data->seo_token,
            ], [
                'seo_title'    => $request->seo_title ? $request->seo_title : $request->title,
                'seo_keywords' => $request->seo_keywords,
                'seo_content'  => $request->seo_content,
            ]);

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy (Request $request)
        {
            $data = $this->page->withTrashed()->findOrFail($request->id);
            $data->children()->forceDelete();
            $data->seo()->forceDelete();
            $data->forceDelete();

            back()->with('status-info', 'Página deletada com sucesso');

        }

        /**
         * @return Response
         */
        public function trash (Request $request)
        {
            $data = $this->page->findOrFail($request->id);
            $data->delete();
        }

        /**
         * @return Response
         */
        public function restore (Request $request)
        {
            $data = $this->page->withTrashed()->findOrFail($request->id);
            $data->restore();
        }

    }
