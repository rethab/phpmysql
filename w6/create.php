<?php

require_once('blog.php');

if (!is_logged_in()) {
        redirect('login.php');
}

if (isset($_POST['create'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $author = $_SESSION['username'];

        save_entry($author, $title, $content);

        add_message('Entry saved!');
        redirect('index.php?msg=created');
}

head('Create');
?>


<form method="post">

        <label for="title">Title</label>
        <input type="text" name="title" id="title" required />
        <br />

        <label for="content">Content</label>
        <textarea name="content" id="content"></textarea>
        <br />

        <input type="submit" value="Create!" name="create" />
</form>

<?= foot() ?>
