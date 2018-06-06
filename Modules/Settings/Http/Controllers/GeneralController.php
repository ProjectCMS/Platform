<?php

    namespace Modules\Settings\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Settings\Entities\Setting;
    use DateTimeZone;

    class GeneralController extends Controller {
        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            $timezone  = $this->getTimeZone()->prepend('Selecione o Fuso horário', '');

            return view('settings::general.index', compact('timezone'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function update (Request $request)
        {
            $request = $request->except(['_method', '_token']);

            foreach ($request as $key => $value) {
                Setting::set($key, $value);
            }

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        public function getTimeZone ()
        {
            $return = [];
            foreach (timezone_identifiers_list() as $key => $zone) {

                $explode  = str_replace('_', ' ', explode('/', $zone));
                $timezone = new DateTimeZone($zone);
                $datetime = new \DateTime('now', $timezone);
                $hours    = floor($timezone->getOffset($datetime) / 3600);
                $mins     = floor(($timezone->getOffset($datetime) - ($hours * 3600)) / 60);
                $hours    = 'UTC/GMT ' . ($hours < 0 ? $hours : '+' . $hours);
                $mins     = ($mins > 0 ? $mins : '0' . $mins);

                $i = @$explode[1];
                if (isset($explode[2])) {
                    $i = $i . ' - ' . $explode[2];
                }

                $return[$explode[0]][$zone] = ' (' . $hours . ':' . $mins . ') ' . $i;

            }

            $return = collect($return);

            return $return;

        }
    }
