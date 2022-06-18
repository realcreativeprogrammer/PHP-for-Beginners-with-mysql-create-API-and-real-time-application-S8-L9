<?php
try{
    $pdo=new PDO("mysql:host=localhost;dbname=dbname",'root','');
    // echo 'you are connected';
    }catch(PDOException $e){
        echo 'you hace error'.$e->getMessage();
    }

?>