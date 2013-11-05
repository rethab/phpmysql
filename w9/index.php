<?php

require_once "./common/Request.php";
require_once "./common/Response.php";
require_once "./common/HttpRequestImpl.php";
require_once "./common/HttpResponseImpl.php";
require_once "./helper/Flash.php";
require_once "./controllers/BlogController.php";

$request = new HttpRequestImpl();
$response = new HttpResponseImpl();

$blog = new BlogController();

switch( $request->getUri() )
{
    case '/edit':
            $blog->editPost( $request, $response );
        break;
    case '/delete':
        $blog->deletePost( $request, $response );
        break;
    case '/new':
        $blog->newPost( $request, $response );
        break;
    default:
        $blog->showPosts( $request, $response );
        break;
}
