<?php

require_once('settings.php');

function get_all_entries() {
        $entries = array();
        foreach (scandir(DATA_DIR) as $entry) {

                if (in_array($entry, array('.', '..'))) {
                        continue;
                }

                list($author, $created, $title, $content) = get_entry($entry);
                $entries[] = array(
                        'id' => basename($entry),
                        'author' => $author,
                        'created' => $created,
                        'title' => $title,
                        'content' => $content
                );
        }
        return $entries;
}

function get_entry($id) {
        $filename = DATA_DIR.$id;
        if (!file_exists($filename)) {
                return false;
        }
        $contents = file_get_contents($filename);
        return explode(VAL_SEP, $contents);
}

function save_entry($author, $title, $content) {
        $created = date('Y-m-d');
        $id = rand(1, 10000);
        $values = array($author, $created, $title, $content);
        $contents = implode(VAL_SEP, $values);
        $filename = DATA_DIR.$id;
        file_put_contents($filename, $contents);
        chmod($filename, 0777);
}

function update_entry($id, $created, $author, $title, $content) {
        $values = array($author, $created, $title, $content);
        $contents = implode(VAL_SEP, $values);
        $filename = DATA_DIR.$id;
        if (false === file_put_contents($filename, $contents)) {
                add_message('Failed to save');
        }
}

function delete_entry($id) {
        $filename = DATA_DIR.$id;
        return unlink($filename);
}

function is_logged_in() {
        return isset($_SESSION['username']);
}

function get_name() {
        return $_SESSION['username'];

}

function redirect($site) {
        header('Location: ' . $site);
        exit;
}

function logout() {
        unset($_SESSION['username']);
}

function login($username, $password) {
        if ($password === SECRET_PASSWORD) {
                $_SESSION['username'] = $username;
                return true;
        } else {
                return false;
        }
}

function add_message($msg) {
        if (!isset($_SESSION['messages'])) {
                $_SESSION['messages'] = array();
        }
        $_SESSION['messages'][] = $msg;
}

function has_messages() {
        return isset($_SESSION['messages']) && !empty($_SESSION['messages']);
}

function get_messages() {
        // essentially a clone
        $msgs = array_merge(array(), $_SESSION['messages']);
        $_SESSION['messages'] = array();
        return $msgs;
}

function head($page) {
        echo '<!doctype html><head><meta charset=utf-8>';
        echo '<title>'.PAGE_TITLE.'</title></head>';
        echo '<body>';
        echo '<h1>' . $page . '</h1>';
        if (has_messages()) {
                echo '<p class="messages">';
                echo '<ul>';
                foreach (get_messages() as $message) {
                        echo '<li>' . $message . '</li>';
                }
                echo '</ul>';
        }
}

function foot() {
        echo '</body></html>';
}
