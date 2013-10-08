<?php
require_once('blog.php');

logout();
add_message('Logged out!');
redirect('index.php');
