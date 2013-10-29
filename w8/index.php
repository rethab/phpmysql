<?php

require_once("Post.php");

/*
 ****************************
 *  Optimistic Locking
 ****************************
 */
echoln("");
echoln("Optimistic Locking");
echoln("");

// Post erstellen und speichern
$post = new Post;
$post->author = "Bolt Thrower";
$post->title = "To Those Once Loyal";
$post->content = "Now wreathed in Crimson";
if($post->save()) {
    echoln("Post gespeichert");
} else {
    echoln("Post nicht gespeichert");
}

// Gleichen Post lesen
$post2 = Post::find($post->id);

// Ersten Post updaten (--> erhoeht version)
$post->content = "Forever sacrificed";
try {
    $post->save();
    echoln("Erwartet: Erste Speicherung ohne Probleme");
} catch (OutdatedVersionException $e) {
    echoln("Fehler: Erste Speicherung Fehlerhaft");
}

// Zweiten Post updaten (--> schlaegt fehl, weil Version zu alt ist)
$post2->content = "Solemn Reminder of silent sacrifice";
try {
    $post2->save();
    echoln("Fehler: Zweiter Speicherung ohne Probleme");
} catch (OutdatedVersionException $e) {
    echoln("Erwartet: Zeite Speicherung Fehlerhaft");
    echoln("Neu Lesen und nochmal versuchen:");
    $post2 = Post::find($post->id);
    $post2->content = "Solemn Reminder of silent sacrifice";
    try {
        $post2->save();
        echoln(" Erwartet: Speicherung nach erneutem Lesen Okay!");
    } catch (OutdatedVersionException $e) {
        echoln("Fehler: Trotz erneutem Lesen nicht okay");    
    }
}
