<?php
$host="localhost";
$dbname='Annuaire_de_podcasts';
$user='root';
$password='ayoub.fh2k52k5';

try{
    $pdo=new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$user,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  
}catch(PDOException $e)
{
    echo  $e->getMessage();
}

?>