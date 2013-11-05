<?php

class HttpResponseImpl implements Response
{
    private $buffer;

    public function setStatus($status)
    {
        http_response_code($status);
    }

    public function addHeader($name, $value)
    {
    }

    public function write($data)
    {
        $this->buffer + $data;
    }

    public function flush()
    {
        echo $this->buffer;
        $this->buffer = null;
    }
}