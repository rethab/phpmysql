<?php
require_once '../common/CommandResolver.php';
require_once '../common/Request.php';
require_once '../common/Response.php';

class BlogController{
    private $resolver;
    
    public function __construct(CommandResolver $resolver) {
        $this->resolver = $resolver;
    }
    
    public function handleRequest(Request $request, Response $response) {
        $command = $this->resolver->getCommand($request);
        $command->execute($request, $response);
        $response->flush();
    }
}
?>