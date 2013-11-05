<form method="post">
    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">

    <label for="title">Title</label>
    <input type="text" name="title" id="title" value="<?= $title ?>" required />
    <br />

    <label for="content">Content</label>
    <textarea name="content" id="content"><?= $content ?></textarea>
    <br />

    <input type="submit" value="<?= isset($_GET['id']) ? 'Update!' : 'Create' ?>" name="submit" />
</form>
