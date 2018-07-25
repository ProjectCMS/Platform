<?php
    Breadcrumbs::for ('post', function($trail) {
        $trail->push('Home', ('/'));
        $trail->push('Blog', route('web.posts'));
    });

    Breadcrumbs::for ('post.item', function($trail, $post) {
        $trail->parent('post');
        $trail->push($post->title, route('web.posts.' . $post->slug));
    });

    Breadcrumbs::for ('post.partial', function($trail, $partial) {
        $trail->parent('post');
        $trail->push($partial->title, ('/'));
    });
