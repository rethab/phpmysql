<?php

class View {

    private $_ = array();

    public function assign($name, $value) {
        $this->_[$name] = $value;   
    }

    public function render($templateName) {
        require('templates/head.php');
        require('templates/'.$templateName.'.php');   
        require('templates/foot.php');
    }

}
