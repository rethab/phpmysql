<?php

// start session for login
session_start();

// where all the blog entries are saved, one file is one entry
define('DATA_DIR', 'data/');

// separator for values in file
define('VAL_SEP', '##%%$$##');

// global password for login
define('SECRET_PASSWORD', 'secret');

// title for entire page
define('PAGE_TITLE', 'Reto Blog');

if (!is_writable(DATA_DIR)) {
        exit('Make sure ' . DATA_DIR . ' exists and is writable');
}
