<?php

use App\Post;

function getPages()
{
    $pages = Post::orderBy('id', 'DESC')->where('post_type', 'page')->where('is_published', '1')->limit(6)->get();
    return $pages;
}