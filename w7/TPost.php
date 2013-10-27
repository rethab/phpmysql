<?php

require_once('settings.php');

class PostGateway {

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname='.
                         DB_NAME.';charset=utf8',
                         DB_USER, DB_PASS);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    
    public function __call($name, $args) {
        if (strpos($name, 'findBy', 0) === 0) {
            return $this->find(lcfirst(substr($name, 6)), $args[0]);      
        } else {
            trigger_error('Method ' . $name . ' does not exist!', E_USER_ERROR);    
        }
    }

    public function insert(TPost $post) {
        $sql = 'INSERT INTO tbl_person (`author`, `title`, `content`)' . 
                ' VALUES (:author, :title, :content)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':author', $post->author);
        $stmt->bindParam(':title', $post->title);
        $stmt->bindParam(':content', $post->content);
        $success = $stmt->execute();
        $post->id = $this->db->lastInsertId();
        return $success;
    }

    public function update(TPost $post) {
        $sql = 'UPDATE tbl_person SET' .
                ' `author` = :author,' . 
                ' `title` = :title,' .
                ' `content` = :content' . 
                ' WHERE `id` = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $post->id, PDO::PARAM_INT);
        $stmt->bindParam(':author', $post->author);
        $stmt->bindParam(':title', $post->title);
        $stmt->bindParam(':content', $post->content);
        return $stmt->execute();
    }

    public function delete(TPost $post) {
        $sql = 'DELETE FROM tbl_person WHERE `id` = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $post->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Finds a post. If val is empty, then the field is
     * assumed to hold the value of the primary key to
     * be searched.
     */
    public function find($field, $val = NULL) {
        if (is_null($val)) {
            $val = $field;
            $field = 'id';
        }
        $field = "`".str_replace("`","``",$field)."`";
        $stmt = $this->db->prepare("SELECT * FROM tbl_person WHERE $field = :val");
        $stmt->execute(array(':val' => $val));
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'TPost');
        return $stmt->fetch();
    }

    public function findAll() {
        $stmt = $this->db->prepare("SELECT * FROM tbl_person");
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'TPost');
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
}

class TPost {
    public $id;
    public $author;
    public $created;
    public $title;
    public $content;
}
