<?php

if (isset($_POST['send'])) {
        $to = $_POST['to'];
        $from = $_POST['from'];
        $subject = $_POST['subject'];
        $text = $_POST['text'];
        $count = intval($_POST['count']);
        for ($i = 0; $i < $count; $i++) {
                if (mail($to, $subject, $text, 'From: ' . $from)) {
                        $msg = 'Nachricht gesendet';
                } else {
                        $msg = 'Nachricht konnte nicht gesendet werden';
                }
        }
}
?>

<!DOCTYPE html>
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Spam-Machine</title>
        <style>
                body {font-family: Verdana; font-size: larger;}
                input [type=submit] { margin: 2em;}
        </style>
</head>
<body>
        <h1>Spam-Machine</h1>
        <?php if (isset($msg)): ?>
                <p><?php echo $msg; ?></p>
        <?php endif; ?>
        
        <form method=post oninput="countOut.value=countIn.value">
                Empfänger: <input type=email name=to placeholder="name@email.com" autofocus required><br>
                Sender: <input type=email name=from placeholder="name@email.com" required><br>
                Anzahl (<output name=countOut for=countIn>3</output>): <input type=range name=count id=countIn min=1 max=10 value=3 step=1 required> <br>
                Betreff: <input name=subject placeholder="Betreff" required><br>
                Text: <textarea name=text placeholder="Na wie geht?" required></textarea><br>
                <input type=submit name=send value=Senden>
        </form>
</body>
</html>
