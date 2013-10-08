<?php

require_once('blog.php');

if (!is_logged_in()) {
        add_message('Please login');
        redirect('login.php');
}

if(!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
        add_message('Id is missing');
        redirect('index.php');
}

$id = $_GET['id'];
$original = get_entry($id);
if ($original === false) {
        add_message('Entry does not exist');
        redirect('index.php');
} else {
        delete_entry($id);
        add_message('Entry deleted');
        redirect('index.php');
}
