<?php

session_start();

if (!isset($_SESSION['personen'])) {
        $_SESSION['personen'] = array();
}

if (isset($_POST['send'])) {
        $name = trim($_POST['name']);
        $age = intval($_POST['age']);
        $_SESSION['personen'][] = array('name' => $name,
                                      'age' => $age);
        $msg = 'Gespeichert';
} else if (isset($_POST['reset'])) {
        session_unset();
}

?>
<!DOCTYPE html>
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Personenverzeichnis</title>
        <style>
                body {font-family: Verdana; font-size: larger;}
                input[type=submit] { margin: 2em;}
                p.success { color: green; }
        </style>
</head>
<body>
        <h1>Personenverzeichnis</h1>
        <?php if (!empty($_SESSION['personen'])): ?>
                <ul>
                        <?php foreach ($_SESSION['personen'] as $person): ?>
                                <li><?php echo htmlspecialchars($person['name']); ?> ist <?php echo $person['age']; ?> Jahre alt</li>
                        <?php endforeach; ?>
                </ul>
        <?php endif; ?>
        <?php if (isset($msg)): ?>
                <p class=success><?php echo $msg; ?></p>
        <?php endif; ?>

        <form method=post>
                Name: <input name=name autofocus required><br>
                Alter: <input name=age type=number required><br>
                <input type=submit name=send value=Eintragen>
        </form>

        <br >
        <form method=post>
                <input type=submit name=reset value="Personen-Liste leeren">
        </form>
</body>
</html>
