<?php

require_once "./models/Post.php";

class BlogController{

    private $view;

    public function __construct() {
        $this->view = new View();   
    }

    public function showPosts( Request $request, Response $response )
    {
        $this->view->assign('posts', Post::findAll());       
        $this->view->render('index');
    }

    public function editPost( Request $request, Response $response )
    {
        $post = new Post();
        $post->id = $request->getParameter('id');
        $this->view->assign('post', $post->findById());
        $this->view->render('edit');
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
