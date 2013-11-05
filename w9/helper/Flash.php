<?php 

class Flash {

    static function add_message($msg) {
            if (!isset($_SESSION['messages'])) {
                    $_SESSION['messages'] = array();
            }
            $_SESSION['messages'][] = $msg;
    }

    static function has_messages() {
            return isset($_SESSION['messages']) && !empty($_SESSION['messages']);
    }

    static function get_messages() {
            // essentially a clone
            $msgs = array_merge(array(), $_SESSION['messages']);
            $_SESSION['messages'] = array();
            return $msgs;
    }

}
