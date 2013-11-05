<?php

require_once '../common/Request.php';

interface CommandResolver {
    public function getCommand(Request $request);
}