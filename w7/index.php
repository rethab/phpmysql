<?php

require_once("RPost.php");
require_once("TPost.php");

/*
 ****************************
 *  Table Data Gateway Pattern
 ****************************
 */
echoln("TABLE DATA GATEWAY PATTERN");

// Post erstellen und speichern
$gateway = new PostGateway;
$post = new TPost;
$post->author = "Watain";
$post->title = "The Wild Hunt";
$post->content = "They Rode On";
if($gateway->insert($post)) {
    echoln("Post gespeichert");
} else {
    echoln("Post nicht gespeichert");
}

// Alle Posts finden
$posts = $gateway->findAll();
if (count($posts) > 0) {
    echoln("Mindestens einen Post mit findAll gefunden.");
} else {
    echoln("Keinen Post mit findAll gefunden.");
}

$post = $gateway->findByTitle("The Wild Hunt");
if ($post) {
    echoln("Post mit Titel 'The Wild Hunt' gefunden");
    $post->content = "Hurry on, Fellow Hunters!";
    $gateway->update($post);
    echoln("Post geaendert nach: 'Hurry on, Fellow Hunters!'");

    $gateway->delete($post);
    echoln("Post geloescht");
} else {
    echoln("Post mit Titel 'The Wild Hunt' nicht gefunden");
}

/*
 ****************************
 *  Row Data Gateway Pattern
 ****************************
 */
echoln("");
echoln("ROW DATA GATEWAY PATTERN");

// Post erstellen und speichern
$post = new RPost;
$post->author = "Bolt Thrower";
$post->title = "To Those Once Loyal";
$post->content = "Now wreathed in Crimson";
if($post->save()) {
    echoln("Post gespeichert");
} else {
    echoln("Post nicht gespeichert");
}

// Alle Posts finden
$posts = RPost::findAll();
if (count($posts) > 0) {
    echoln("Mindestens einen Post mit findAll gefunden.");
} else {
    echoln("Keinen Post mit findAll gefunden.");
}

$post = RPost::findByTitle("To Those Once Loyal");
if ($post) {
    echoln("Post mit Titel 'To Those Once Loyal' gefunden");
    $post->content = "Solemn Reminder of Silent Sacrifice";
    $post->save();
    echoln("Post geaendert nach: 'Solemn reminder of silent sacrifice'");

    $post->delete();
    echoln("Post geloescht");
} else {
    echoln("Post mit Titel 'To Those Once Loyal' nicht gefunden");
}
