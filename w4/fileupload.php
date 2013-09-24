<?php

$types = array(1 => 'Crash',
               2 => 'Laaaaaaag',
               3 => 'Bluescreen');

if (isset($_POST['send'])) {

        $tmp_name = $_FILES['pictures']['tmp_name']['screenshot'];
        $name = $_FILES['pictures']['name']['screenshot'];
        if (!move_uploaded_file($tmp_name, 'images/'.$name)) {
                die('Failed to upload file :(');               
        }
        
        $name  = trim($_POST['name']);
        $type  = trim($_POST['type']);
        $tel   = trim($_POST['tel']);
        $cb    = trim($_POST['callback']) == 'on';
        $email = trim($_POST['email']);
        $web   = trim($_POST['web']);
        $date  = trim($_POST['datum']);
        $prio  = trim($_POST['prio']);
        $text  = trim($_POST['text']);
        $pass  = trim($_POST['password']);

        if (empty($name) ||
            !array_key_exists($type, $types) ||
            ($cb && empty($tel)) || 
            !filter_var($email, FILTER_VALIDATE_EMAIL) ||
            !filter_var($web, FILTER_VALIDATE_URL) ||
            empty($date) ||
            !ctype_digit($prio) ||
            empty($text) ||
            $pass !== 'S3CR3T') {
                die('Faaaaalsch, alles faaaalsch!!');
        }

        require('class.phpmailer.php');
 
        $mail = new PHPMailer();
         
        $mail->From     = 'bugreporting@bugrepots.net';
        $mail->AddAddress($email);
        $mail->Subject  = 'New Bug Report';
        $mail->AddEmbeddedImage('images/'.$name, 'screenshot', 'screenshot');
        $mail->Body     = 'Es gibt einen neuen Bug-Report: \n\n' . 
                          'Name: ' . $name . '\n\n' .
                          'Type: ' . $types[$type] . '\n\n' .
                          $cb ? ('Rückruf: ' . $tel) : 'Kein Rückruf' . '\n\n' .
                          'EMail: ' . $mail . '\n\n' .
                          'Web: ' . $web . '\n\n' .
                          'Date: ' . $date . '\n\n' .
                          'Prio: ' . $prio . '\n\n' .
                          'Text: ' . $text;
                          
        if(!$mail->Send()) {
                die('Failed to send Email :(');
        } else {
                $msg = 'Success!';
        }

}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Submit us your Bug!</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="style.css" type="text/css" media="all" />
</head>
<body>

	<h2>Bitte melde deinen Bug mit diesem Formular</h2>
	
	<form class="form" method="POST">
		
		<p class="name">
			<input type="text" name="name" id="name" placeholder="John Doe" required>
			<label for="name">Name</label>
		</p>
		
		<p class="email">
			<input type="email" name="email" id="email" placeholder="mail@example.com" required>
			<label for="email">Email</label>
		</p>

		<p class="tel">
			<input type="tel" name="tel" id="tel" placeholder="mail@example.com" required>
			<label for="tel">Telefon</label>
                        <input type="checkbox" name="callback"> Rückruf erforderlich?
		</p>

		<p class="type">
			<label for="type">Bugtype</label>
			<select name="type" id="type" >
                                <option value=1>Crash</option>
                                <option value=2>Laaaaaaag</option>
                                <option value=3>Bluescreen</option>
                        </select>
		</p>		
		
		<p class="web">
			<input type="url" name="web" id="web" placeholder="www.example.com" required>
			<label for="web">Betreffende Website</label>
		</p>		
	
		<p class="screenshot">
			<input type="file" name="screenshot" id="screenshot" />
			<label for="screenshot">Screenshot</label>
		</p>

		<p class="datum">
			<input type="datetime" name="datum" id="datum" />
			<label for="datum">Datum</label>
		</p>

		<p class="prio">
			<label for="prio">Priorität</label>
			<select name="prio" id="prio" >
                                <option value=1>Hoch</option>
                                <option value=2>Mittel</option>
                                <option value=3>Tief</option>
                        </select>
		</p>		
	
		<p class="text">
			<textarea name="text" placeholder="Fehlerreport" required></textarea>
		</p>
		
		<p class="password">
			<input type="password" name="password" id="password" required />
			<label for="password">Passwort</label>
		</p>
		
		<p class="submit">
			<input type="submit" value="Senden" />
		</p>
	</form>

</body>
</html>
