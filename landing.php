<?php

session_start();
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>SDEV325!</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Acme" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="main.css">
    </head>
    <body background="images/layout/Code_presentation_background.png">
   <?php 
        $username = $_SESSION['appusername'];
        $password = $_SESSION['appPassword'];
        $badEncrypt = md5($password);
        $goodEncrypt = password_hash($password, PASSWORD_DEFAULT);

        echo "Welcome, ".$username. "! <br><br>";
        echo "This is your password: ".$password." <br><br>"; 
        echo "This is your password hashed with md5 (bad encryption): ".$badEncrypt."<br><br>";
        echo "This is your password hashed with bcrypt (good encryption): ".$goodEncrypt."<br><br>";
        
    ?>
    </body>
</html>
