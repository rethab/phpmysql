<?php

require_once "./common/Request.php";
require_once "./common/Response.php";
require_once "./common/HttpRequestImpl.php";
require_once "./common/HttpResponseImpl.php";
require_once "./helper/Flash.php";

$request = new HttpRequestImpl();
$response = new HttpResponseImpl();

var_dump($request->getParameterNames());
