<?php

    namespace Modules\Pages\Http\Controllers\admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;

    use Modules\Core\Entities\Status;
    use Modules\Pages\Entities\Page;
    use Modules\Seo\Entities\Seo;

    class PagesController extends Controller {

        private $perPages = 10;

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index (Request $request, Page $page)
        {
            $dataForm = $request->all();
            $data     = $page->search($dataForm)->with('children');
            $paginate = $data->paginate($this->perPages);

            return view('pages::admin.index', compact('paginate', 'dataForm'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create ()
        {
            $parent = Page::where([["parent_id", "=", 0]])->pluck('title', 'id')->prepend('# Página Principal', 0);
            $status = Status::pluck('name', 'id');

            return view('pages::admin.create', compact('parent', 'status'));
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
            $validation              = $this->validation($request);
            $validation["seo_token"] = bcrypt(date('Y-m-d H:i:s'));
            $validation["order"]     = Page::max('order') + 1;

            $insert = Page::create($validation);
            $seo    = Seo::create([
                'seo_token'    => $validation["seo_token"],
                'seo_title'    => $request->seo_title ? $request->seo_title : $validation["title"],
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
            $data   = Page::withTrashed()->find($id);
            $parent = Page::where([["id", "!=", $id], ["parent_id", "=", 0]])
                          ->pluck('title', 'id')
                          ->prepend('Página Principal', 0);
            $status = Status::pluck('name', 'id');

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
        public function update (Request $request, $id)
        {
            $data       = Page::withTrashed()->findOrFail($id);
            $validation = $this->validation($request);

            $data->update($validation);

            Seo::updateOrCreate([
                'seo_token' => $data->seo_token,
            ], [
                'seo_title'    => $request->seo_title ? $request->seo_title : $validation["title"],
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
            $data = Page::find($request->id);
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
            $data = Page::find($request->id);
            $data->delete();
        }

        /**
         * @return Response
         */
        public function restore (Request $request)
        {
            $data = Page::withTrashed()->findOrFail($request->id);
            $data->restore();
        }

        /**
         * Pages Validation
         * @return Response
         */
        public function validation ($request)
        {
            $validation = $request->validate([
                'status_id' => 'required',
                'parent_id' => 'required',
                'title'     => 'required',
                'content'   => 'required|min:1'
            ]);

            $content = preg_replace("/<p[^>]*?>/", "", $request->input('content'));
            $content = str_replace("</p>", "\r\n", $content);

            $validation["slug"]    = str_slug($validation["title"], '-');
            $validation["content"] = trim(html_entity_decode($content));

            return $validation;

        }


        /**
         * @return Response
         */
        public function order (Request $request)
        {

            $source          = (int)$request->source;
            $destination     = (int)$request->destination != NULL ? $request->destination : 0;
            $item            = Page::withTrashed()->find($source);
            $item->parent_id = $destination;
            $item->save();

            $ordering     = json_decode($request->order);
            $rootOrdering = json_decode($request->rootOrder);

            if ($ordering) {
                foreach ($ordering as $order => $item_id) {
                    if ($itemToOrder = Page::find($item_id)) {
                        $itemToOrder->order = $order;
                        $itemToOrder->save();
                    }
                }
            } else {
                foreach ($rootOrdering as $order => $item_id) {
                    if ($itemToOrder = Page::find($item_id)) {
                        $itemToOrder->order = $order;
                        $itemToOrder->save();
                    }
                }
            }
        }
    }
