<?php
$url ="http://localhost/kantone/resolver.php?service=kantone&methode=single&id=zh";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
$body = curl_exec($ch);
curl_close($ch);

// Via json
$json = json_decode($body);
?>
