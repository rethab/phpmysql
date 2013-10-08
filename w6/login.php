<?php

require_once('blog.php');

if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if (!login($username, $password)) {
                add_message('Password is wrong :(');
        }
}

if (is_logged_in()) {
        redirect('index.php');
}

head('Login');
?>


<form method="post">
<label for="username">Username:</label>
<input name="username" id="username" required /><br />

<label for="password">Password:</label>
<input type="password" name="password" id="password" required /><br />
<input type="submit" value="Login" name="login"/>
</form>
<?= foot() ?>
