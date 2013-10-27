<?php

require_once('settings.php');

class RPost {
    public $id;
    public $author;
    public $created;
    public $title;
    public $content;

    private static function db() {
        $db = new PDO('mysql:host=localhost;dbname='.
                         DB_NAME.';charset=utf8',
                         DB_USER, DB_PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        return $db;
    }

    public static function __callStatic($name, $args) {
        if (strpos($name, 'findBy', 0) === 0) {
            return self::find(lcfirst(substr($name, 6)), $args[0]);      
        } else {
            trigger_error('Method ' . $name . ' does not exist!', E_USER_ERROR);    
        }
    }
    
    public function save() {
        if ($this->id === null) {
            // insert
            $sql = 'INSERT INTO tbl_person (`author`, `title`, `content`)' . 
                   ' VALUES (:author, :title, :content)';
            $db = self::db();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':content', $this->content);
            $success = $stmt->execute();
            $this->id = $db->lastInsertId();
            return $success;
        } else {
            // updated
            $sql = 'UPDATE tbl_person SET' .
                   ' `author` = :author,' . 
                   ' `title` = :title,' .
                   ' `content` = :content' . 
                   ' WHERE `id` = :id';
            $stmt = self::db()->prepare($sql);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':content', $this->content);
            return $stmt->execute();
        }
    }

    public function delete() {
        $sql = 'DELETE FROM tbl_person WHERE `id` = :id';
        $stmt = self::db()->prepare($sql);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    /**
     * Finds a post. If val is empty, then the field is
     * assumed to hold the value of the primary key to
     * be searched.
     */
    public static function find($field, $val = NULL) {
        if (is_null($val)) {
            $val = $field;
            $field = 'id';
        }
        $field = "`".str_replace("`","``",$field)."`";
        $db = self::db();
        $stmt = $db->prepare("SELECT * FROM tbl_person WHERE $field = :val");
        $stmt->execute(array(':val' => $val));
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'RPost');
        return $stmt->fetch();
    }

    public static function findAll() {
            $db = self::db();
            $stmt = $db->prepare("SELECT * FROM tbl_person");
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'RPost');
            $stmt->execute();
            return $stmt->fetchAll();
    }
}
