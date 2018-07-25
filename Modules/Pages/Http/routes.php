<?php
    Breadcrumbs::for ('page', function($trail, $page) {
        $trail->push('Home', ('/'));
        $trail->push($page->title, route('web.pages.' . $page->slug));
    });

