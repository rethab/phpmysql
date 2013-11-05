<?php

class HttpResponseImpl implements Response
{
    public function setStatus($status)
    {
        http_response_code($status);
    }

    public function addHeader($name, $value)
    {
    }

    public function write($data)
    {
        echo $data;
    }

    public function flush()
    {
    }
}