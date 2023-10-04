<?php
session_start();

$host="localhost";
$dbname="toad";
$user="retro";
$mdp="owen1maeva2";

try{
    $db = new PDO ('mysql:host='.$host.'; dbname='.$dbname,$user,$mdp, array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'));
}
catch (PDOexception $e){
    die("Erreur");
}
?>