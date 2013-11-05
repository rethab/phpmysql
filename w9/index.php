<?php

require_once "./common/Request.php";
require_once "./common/Response.php";
require_once "./common/HttpRequestImpl.php";
require_once "./common/HttpResponseImpl.php";

$request = new HttpRequestImpl();
$response = new HttpResponseImpl();

echo $request->getParameters();
