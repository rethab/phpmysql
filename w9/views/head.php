<!DOCTYPE html>
<html>
    <head>
        <title><?= $this->_['title'] ?></title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
    </head>
    <body>
    <?php if (Flash::has_messages()): ?>
        <p class="messages">
            <ul>
            <?php foreach (Flash::get_messages() as $message): ?>
                <li><?= $message ?>
            <?php endforeach; ?>
            </ul>
        </p>
    <?php endif; ?>
