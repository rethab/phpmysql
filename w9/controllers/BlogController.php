<?php

class BlogController{

    public function showPosts( Request $request, Response $response )
    {
        echo "show";
    }

    public function editPost( Request $request, Response $response )
    {
        echo "edit";
    }

    public function newPost( Request $request, Response $response )
    {
        echo "new";
    }

    public function deletePost( Request $request, Response $response )
    {
        echo "delete";
    }
}
