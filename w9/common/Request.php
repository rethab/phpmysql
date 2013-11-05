<?php

interface Request
{
    public function getUri();
    public function getParameterNames();
    public function issetParameter($name);
    public function getParameter($name);
    public function getHeader($name);
}
