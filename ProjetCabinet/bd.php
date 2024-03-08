<?php
    //Connection mysql
    try {
        $server = 'localhost';
        $login='userusager';
        $mdp = '';
        $db = 'cabinet';
        $linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
        }
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
?>

