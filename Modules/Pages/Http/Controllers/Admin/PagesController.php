<?php

    namespace Modules\Pages\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;

    use Modules\Core\Entities\Status;
    use Modules\Pages\Entities\Page;
    use Modules\Pages\Entities\PageTemplate;
    use Modules\Pages\Http\Requests\PageRequest;
    use Modules\Seo\Entities\Seo;

    class PagesController extends Controller {

        /**
         * @var Page
         */
        private $page;
        /**
         * @var Status
         */
        private $status;
        /**
         * @var Seo
         */
        private $seo;
        /**
         * @var PageTemplate
         */
        private $pageTemplate;

        public function __construct (Page $page, Status $status, Seo $seo, PageTemplate $pageTemplate)
        {
            $this->page         = $page;
            $this->status       = $status;
            $this->seo          = $seo;
            $this->pageTemplate = $pageTemplate;
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
            $parent   = $this->page->where('parent_id', 0)->pluck('title', 'id')->prepend('# Página Principal', 0);
            $status   = $this->status->pluck('title', 'id');
            $template = $this->pageTemplate->pluck('title', 'id')->prepend('Todos os templates', '');

            return view('pages::admin.create', compact('parent', 'status', 'template'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function store (PageRequest $request)
        {
            $request->request->add(['order' => $this->page->max('order') + 1]);

            $insert = $this->page->create($request->all());

            // Cria ou Edita a tabela SEO
            $this->seo->createPolymorphic($request, $insert->getMorphClass(), $insert->id);

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
            $data     = $this->page->with(['seo'])->find($id);
            $parent   = $this->page->where([["id", "!=", $id], ["parent_id", "=", 0]])
                                   ->pluck('title', 'id')
                                   ->prepend('Página Principal', 0);
            $status   = $this->status->pluck('title', 'id');
            $template = $this->pageTemplate->pluck('title', 'id')->prepend('Todos os templates', '');

            if (!$data) {
                return redirect()->route('admin.pages');
            }

            return view('pages::admin.edit', compact('data', 'parent', 'status', 'template'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function update (PageRequest $request, $id)
        {
            $data = $this->page->findOrFail($id);
            $data->update($request->all());

            // Cria ou Edita a tabela SEO
            $this->seo->createPolymorphic($request, $data->getMorphClass(), $id);

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
            $data->menuItem()->forceDelete();
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
