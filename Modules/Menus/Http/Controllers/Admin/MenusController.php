<?php

    namespace Modules\Menus\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Menus\Entities\Menu;
    use Modules\Menus\Entities\MenuItem;
    use Modules\Menus\Entities\MenuLocation;
    use Modules\Menus\Http\Requests\MenusRequest;

    class MenusController extends Controller {

        /**
         * @var Menu
         */
        private $menu;
        /**
         * @var MenuItem
         */
        private $menuItem;
        /**
         * @var MenuLocation
         */
        private $menuLocation;

        public function __construct (Menu $menu, MenuItem $menuItem, MenuLocation $menuLocation)
        {
            $this->menu         = $menu;
            $this->menuItem     = $menuItem;
            $this->menuLocation = $menuLocation;
        }


        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ($id = NULL)
        {
            if ($this->menu->count() == 0) {
                return redirect(route('admin.settings.menus.create'));
            } else {
                return redirect(route('admin.settings.menus.edit', $this->menu->first()->id));
            }
        }

        public function add_item_menu (Request $request)
        {
            $data = $this->menuItem->addItem($request);
            $new  = TRUE;

            return view('menus::partials.items.item', compact('data', 'new'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create ()
        {
            return view('menus::create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function store (MenusRequest $request)
        {
            $insert = $this->menu->create($request->all());
            $items  = $this->menuItem->managerItems($insert->id, $request->menu_items);

            return redirect(route('admin.settings.menus.edit', $insert->id))->with('status-success', 'Menu criado com sucesso');
        }

        /**
         * Show the specified resource.
         * @return Response
         */
        public function show ()
        {
            return view('menus::show');
        }

        /**
         * Show the form for editing the specified resource.
         * @return Response
         */
        public function edit ($id)
        {
            $data = $this->menu->with(['items', 'items.children'])->find($id);

            if (!$data) {
                return redirect()->route('admin.settings.menus.create');
            }

            return view('menus::edit', compact('data'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function update (MenusRequest $request, $id)
        {
            $update = $this->menu->findOrFail($id);
            $update = $update->update($request->all());
            $items  = $this->menuItem->managerItems($id, $request->menu_items);

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy (Request $request)
        {
            $data = $this->menu->find($request->id);
            $data->forceDelete();
        }

        public function locations ()
        {
            $locations = $this->menuLocation->locations();
            $menu      = $this->menu->all();

            return view('menus::locations', compact('menu', 'locations'));
        }

        public function locations_update (Request $request)
        {
            $this->menuLocation->query()->truncate();
            foreach ($request->location as $key => $location) {
                if ($location != NULL) {
                    $this->menuLocation->create(['menu_id' => $location, 'location' => $key]);
                }
            }

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }
    }
