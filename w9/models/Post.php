<?php


require_once 'config.php';


// Model Class representing a Post
public class Post {

    private $id;
    private $created;
    private $title;
    private $content;

    private $gateway;

    function __construct() {
        $this -> gateway = new PostRowGateway();
        $this -> gateway -> connect();
    }

    public function set_title($title) {
        $this -> title = $title;
    }

    public function set_content($content) {
        $this -> content = $content;
    }

    public function set_id($id) {
        $this -> id = $id;
    }

    public function set_created($created) {
        $this -> created = $created;
    }

    public function get_title() {
        return $this -> title;
    }

    public function get_content() {
        return $this -> content;
    }

    public function get_id() {
        return $this -> id;
    }

    public function get_created() {
        return $this -> created;
    }

    public function findAll() {
        return $this -> gateway -> findAll();
    }

    public function findById() {
        return $this -> gateway -> findByID($this -> id);
    }

    public function insert() {
        $this -> gateway -> insert($this -> title, $this -> content);
    }

    public function update() {
        $this -> gateway -> update($this -> id, $this -> title, $this -> content);
    }

    public function delete() {
        $this -> gateway -> delete($this -> id);
    }
}


class PostRowGateway {
    private $pdo;

    function __construct() {

    }

    function connect() {

        $hostname = DATABASE_HOST;
        $dbname = DATABASE_NAME;
        $username = DATABASE_USER;
        $password = DATABASE_PASSWORD;

        try {

            $this -> pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password, array(PDO::ATTR_PERSISTENT => true));
            $this -> pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            die("Could not connect to database!  " . $e -> getMessage());
        }
    }

    function findAll() {
        try {

            $sth = $this -> pdo -> query('SELECT * FROM tbl_person ORDER BY created, id');
            $sth -> setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Post');

            return $sth -> fetchAll();
        } catch (PDOException $e) {
            die("Could not get items from database: " . $e -> getMessage() . "<br/>");
        }

    }

    function findByID($postId) {

        $sth = $this -> pdo -> prepare('SELECT id, created, title, content FROM tbl_person WHERE id=:id');
        $sth -> bindParam(':id', $postId);
        $sth -> setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Post');
        $sth -> execute();

        $items = $sth -> fetchAll();
        return $items[0];
    }

    function insert($title, $content) {

        try {
            $sth = $this -> pdo -> prepare("INSERT INTO tbl_person (id, created, title, content) value (NULL, NULL, :title, :content)");
            $sth -> execute(array('title' => $title, 'content' => $content));
        } catch (PDOException $e) {
            die("Could not add new item [$title]: " . $e -> getMessage() . "<br/>");
        }

    }

    function delete($id) {
        try {
            $sth = $this -> pdo -> prepare('DELETE FROM tbl_person WHERE id=?');
            $sth -> execute(array($id));
        } catch (PDOException $e) {
            die("Could not delete item [$id]: " . $e -> getMessage() . "<br/>");
        }
    }

    function update($id, $title, $content) {
        try {
            $sth = $this -> pdo -> prepare("UPDATE tbl_person SET id=:id, title=:title, content=:content WHERE id=:id");
            $sth -> execute(array('id' => $id , 'title' => $title, 'content' => $content));

        } catch (PDOException $e) {
            die("Could not update item: " . $e -> getMessage() . "<br/>");
        }
    }
}

?>