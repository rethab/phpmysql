<?php

$task = params();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['remove']) && $_GET['remove']) {
        remove($_GET['id']);
    } else if (!empty($_GET['id'])) {
        listOne($_GET['id']);
    } else {
        listAll();
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($task->id === null) {
        insertNew($task);
    } else {
        update($task);
    }
} else {
    fail('invalid request method');
}

function fail($msg) {
    header(' ', true, 400);
    die($msg);
}

function params() {
    $entityBody = file_get_contents('php://input');
    return json_decode($entityBody);
}

function withDb($action) {
    try {
        $db = new PDO(
                'mysql:host=localhost;dbname=taskdb;charset=utf8',
                'taskuser',
                'taskpass');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $action($db);
    } catch (PDOException $e) {
        var_dump($e);
        fail('failed to run');
    }
}

function listAll() {
    withDb(function($db) {
            $stmt = $db->query('SELECT * FROM tasks');
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($res);
    });
}

function listOne($id) {
    $taskId = (int) $id;
    withDb(function ($db) use ($taskId) {
        $stmt = $db->prepare('SELECT * FROM tasks WHERE id = :id');
        $stmt->bindParam(':id', $taskId, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($res === false) {
            fail('Failed: retrieve Task');
        }
        echo json_encode($res);
    });
}

function insertNew($task) {
    withDb(function ($db) use ($task) {
        $sql = 'INSERT INTO tasks (`what`, `when`)
        VALUES (:what, :when)';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':what', $task->what);
        $stmt->bindParam(':when', $task->when);
        $success = $stmt->execute();
        if (!$success) {
            fail('Failed to save: ');
        }
    });
}

function update($task) {
    withDb(function ($db) use ($task) {
        $sql = 'UPDATE tasks SET `what` = :what, `when` = :when
        WHERE `id` = :id';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $task->id, PDO::PARAM_INT);
        $stmt->bindParam(':what', $task->what);
        $stmt->bindParam(':when', $task->when);
        $success = $stmt->execute();
        if (!$success) {
            fail('Failed to save: ');
        }
    });
}

function remove($taskId) {
    withDb(function ($db) use ($taskId) {
        $sql = 'DELETE FROM tasks WHERE `id` = :id';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $taskId, PDO::PARAM_INT);
        $success = $stmt->execute();
        if (!$success) {
            fail('Failed to save: ');
        }
    });
}
