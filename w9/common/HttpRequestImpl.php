<?php

require_once "Request.php";

class HttpRequestImpl implements Request
{
    public function getParameterNames()
    {
    }

    public function issetParameter($name)
    {
        return isset( $_GET[ $name ] );
    }

    public function getParameter($name)
    {
        return $_GET[$name];
    }

    public function getHeader($name)
    {
    }
}