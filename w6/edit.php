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
}

list($author, $created, $title, $content) = $original;

if (isset($_POST['create'])) {

        $title = $_POST['title'];
        $content = $_POST['content'];

        update_entry($id, $created, $author, $title, $content);

        add_message('Entry updated');
        redirect('index.php');
}

head('Edit ' . $id);
?>

<form method="post">

        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="<?= $title ?>" required />
        <br />

        <label for="content">Content</label>
        <textarea name="content" id="content"><?= $content ?></textarea>
        <br />

        <input type="submit" value="Update!" name="create" />
</form>

<?= foot() ?>
