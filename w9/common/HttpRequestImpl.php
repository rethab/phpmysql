<?php

require_once "Request.php";

class HttpRequestImpl implements Request
{
    public function getUri()
    {
        return $_GET['uri'];
    }

    public function getParameterNames()
    {
        return array_filter(array_keys($_GET), function ($v) { return $v != 'uri'; } );
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