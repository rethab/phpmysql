<?php

switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
                if (isset($_GET['id'])) {
                        listOne($_GET['id']);
                } else {
                        listAll();
                }
                break;
        case 'PUT':
                insertNew();
                break;
        case 'POST':
                update($_GET['id']);
                break;
        case 'DELETE':
                delete($_GET['id']);
                break;
        default:
                fail('invalid request method');
}

function fail($msg) {
        header(' ', true, 400);
        die($msg);
}

function db() {
        return new PDO('mysql:host=localhost;dbname=taskdb;charset=utf8',
                       'taskuser',
                       'taskpass');
}

function listAll() {
        try {
                $stmt = db()->query('SELECT * FROM tasks');
                return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
                var_dump($e);
                fail('failed to fetch');
        }
}
