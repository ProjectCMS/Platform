<?php

namespace Modules\Pages\Http\Controllers\web;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Pages\Entities\Page;

class PagesController extends Controller
{

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show(Page $page)
    {
        dump($page->toArray());
    }


}
