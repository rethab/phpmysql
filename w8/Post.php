<?php

require_once('settings.php');

/**
 * Aufgabe 4: Siehe Code unten und index.php
 *
 * Aufgabe 5: Da man beim optimistischen Locking davon ausgeht, dass dieser
 *            Fall eher selten eintrifft, kann man die Daten einfach nochmal
 *            lesen. In meiner Lösung wird im Falle eines 'outdated' update
 *            eine Exception geworfen und dann wird in der Datei index.php
 *            der Datensatz neu geladen, wodurch sich die Version erneuert
 *            und ein Update durchgeführt werden kann.
 *
 * Aufgabe 6: Deadlock mit Autos erklärt: Zwei Autos mit sehr knappem Benzin-
 *            bzw. Dieseltank befahren jeweils am einen Ende einer Brücke.
 *            Dummerweise ist die Tankstelle für Benzin auf der Seite, von der
 *            das dieselbetriebene Fahrzeug herkommt und umgekehrt. Noch dazu
 *            kommt, dass man auf der Brücke nicht kreuzen kann und der Treib-
 *            stoff bei keinem der Fahrzeuge reicht, um wieder zurück zu
 *            fahren, wodruch beide blockiert sind.
 *
 *            Ähnlich ist das in der nebenläufigen Programmierung, wenn zwei
 *            Prozesse bzw. Threads Betriebsmittel exklusiv beanspruchen
 *            und ohne diese freizugeben noch mehr beanspruchen wollen (und
 *            und zwar genau die Resource, die vom anderen bereits
 *            beansprucht wird.
 *
 * Aufgabe 7: Lost Updates: Gibt es nicht mehr, da eine veraltete Version
 *                          eines Posts nicht gespeichert werden kann.
 *            Dirty Read: Es wird immer der aktuellste Stand gelesen.
 *            Non-Repeatable Read: Möglich, es wird immer der aktuellste Stand
 *                                 gelesen.
 *            Phantom Read: Möglich, es wird immer der aktuellste Stand gelesen
 *
 *            --> Der Hauptvorteil liegt, wie schon oben beschrieben, natürlich
 *                bei den Updates, da man grundsätzlich davon ausgeht, dass
 *                nicht schief geht, bzw. keine dazwischengefunkt hat. Wenn
 *                dies in den meisten Fällen der Fall ist, macht ein
 *                optimistisches Lock sinn und ist natürlich performanter
 *                anstatt einfach mal die ganze Tabelle oder gar Datenbank
 *                zu locken.
 *
 */

class Post {
    public $id;
    public $author;
    public $created;
    public $title;
    public $content;

    /**
     * Counter for optimistic locking
     */
    private $version;

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

            // manually set fields from db
            $this->id = $db->lastInsertId();
            $post = self::find($this->id);
            $this->created = $post->created;
            $this->version = $post->version;
            return $success;
        } else {
            // updated
            $sql = 'UPDATE tbl_person SET' .
                   ' `author` = :author,' .
                   ' `title` = :title,' .
                   ' `content` = :content,' . 
                   ' `version` = `version` + 1' .
                   ' WHERE `id` = :id' . 
                   '  AND `version` = :version';
            $stmt = self::db()->prepare($sql);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':content', $this->content);
            $stmt->bindParam(':version', $this->version);
            $success = $stmt->execute();
            if ($stmt->rowCount() !== 1) {
                throw new OutdatedVersionException();
            } else {
                return $success;
            }
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
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Post');
        return $stmt->fetch();
    }

    public static function findAll() {
            $db = self::db();
            $stmt = $db->prepare("SELECT * FROM tbl_person");
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Post');
            $stmt->execute();
            return $stmt->fetchAll();
    }

    public function __toString() {
        return "Post [id = $this->id, author = $this->author" .
               ", created = $this->created, title = $this->title" .
               ", content = $this->content, version = $this->version]";
    }
}

class OutdatedVersionException extends Exception {}
