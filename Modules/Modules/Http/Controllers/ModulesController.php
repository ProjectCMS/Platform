<?php

    namespace Modules\Modules\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Nwidart\Modules\Facades\Module;

    class ModulesController extends Controller {
        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            $modules = Module::all();

            return view('modules::admin.index', compact('modules'));
        }

        public function switch (Request $request)
        {
            $module = Module::findOrFail($request->module);
            $check  = core_module($module);
            $return = [];

            if ($check == TRUE) {
                $return = ["status" => FALSE, "msg" => "Este é um módulo central, não pode ser desabilitado."];
            } else {

                if ($request->status == 'true') {

                    $module->enable();
                    $return = ["status" => TRUE, "msg" => "Módulo habilitado com sucesso."];

                } else {

                    $module->disable();
                    $return = ["status" => TRUE, "msg" => "Módulo desabilitado com sucesso."];
                }
            }

            return $return;

        }

    }
