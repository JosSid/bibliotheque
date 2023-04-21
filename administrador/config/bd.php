<?php 
    $host="localhost";
    $bd="sitio";
    $usuario="root";
    $contraseña="";

    try {
        $connect=new PDO("mysql:host=$host;dbname=$bd",$usuario,$contraseña);
        //if($connect){echo "Connect to ".$bd." DB";}
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
?>