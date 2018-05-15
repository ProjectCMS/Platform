<?php

    namespace Modules\Pages\Http\Controllers\admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;

    use Modules\Core\Entities\Status;
    use Modules\Pages\Entities\Page;
    use Modules\Pages\Http\Requests\CreateRequest;
    use Modules\Pages\Http\Requests\UpdateRequest;
    use Modules\Seo\Entities\Seo;

    class PagesController extends Controller {

        private $perPages = 10;

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index (Page $page, Request $request)
        {
            $data     = $page->search($request->all());
            $paginate = $data->paginate($this->perPages);

            return view('pages::admin.index', compact('paginate'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create (Page $page, Status $status)
        {
            $parent = $page->where([["parent_id", "=", 0]])->pluck('title', 'id')->prepend('# Página Principal', 0);
            $status = $status->pluck('name', 'id');

            return view('pages::admin.create', compact('parent', 'status'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function store (Page $page, Seo $seo, CreateRequest $request)
        {
            $request->request->add(['seo_token' => bcrypt(date('Y-m-d H:i:s'))]);
            $request->request->add(['order' => $page->max('order') + 1]);

            $insert = $page->create($request->all());
            $seo    = $seo->create([
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
        public function edit (Page $page, Status $status, $id)
        {
            $data   = $page->withTrashed()->find($id);
            $parent = $page->where([["id", "!=", $id], ["parent_id", "=", 0]])
                           ->pluck('title', 'id')
                           ->prepend('Página Principal', 0);
            $status = $status->pluck('name', 'id');

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
        public function update (Page $page, Seo $seo, UpdateRequest $request, $id)
        {
            $data = $page->withTrashed()->findOrFail($id);

            $data->update($request->all());

            $seo->updateOrCreate([
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
        public function destroy (Page $page, Request $request)
        {
            $data = $page->find($request->id);
            $data->children()->forceDelete();
            $data->seo()->forceDelete();
            $data->forceDelete();

            back()->with('status-info', 'Página deletada com sucesso');

        }

        /**
         * @return Response
         */
        public function trash (Page $page, Request $request)
        {
            $data = $page->find($request->id);
            $data->delete();
        }

        /**
         * @return Response
         */
        public function restore (Page $page, Request $request)
        {
            $data = $page->withTrashed()->findOrFail($request->id);
            $data->restore();
        }

        /**
         * @return Response
         */
        public function order (Page $page, Request $request)
        {

            $source          = (int)$request->source;
            $destination     = (int)$request->destination != NULL ? $request->destination : 0;
            $item            = $page->withTrashed()->find($source);
            $item->parent_id = $destination;
            $item->save();

            $ordering     = json_decode($request->order);
            $rootOrdering = json_decode($request->rootOrder);

            if ($ordering) {
                foreach ($ordering as $order => $item_id) {
                    if ($itemToOrder = $page->find($item_id)) {
                        $itemToOrder->order = $order;
                        $itemToOrder->save();
                    }
                }
            } else {
                foreach ($rootOrdering as $order => $item_id) {
                    if ($itemToOrder = $page->find($item_id)) {
                        $itemToOrder->order = $order;
                        $itemToOrder->save();
                    }
                }
            }
        }
    }
