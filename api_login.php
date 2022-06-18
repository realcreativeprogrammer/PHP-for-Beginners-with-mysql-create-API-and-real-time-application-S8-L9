<?php
require __DIR__.'/vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json; charset=UTF-8');
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Header: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods');
function input($value){
    $newvalue=trim($value);
    $newvalue=htmlspecialchars($newvalue);
    $newvalue=stripslashes($newvalue);
    return $newvalue;
}
$data=json_decode(file_get_contents('php://input'),true);
$email=input($data['email']);
$password=input($data['password']);

include './conn.php';
$sql='SELECT `id`, `email`, `password`, `date`, `role` FROM `user` WHERE email=? and password=?';
$exc=$pdo->prepare($sql);
$exc->execute(array($email,$password));
if($exc->rowCount()==1){
    $row=$exc->fetch();
    $key = 'fgdgfdgdfg';

    $payload = [
        'userid' => $row['id'],
        'email' => $row['email'],
        'role' => $row['role']

    ];
    
    $jwt = JWT::encode($payload, $key, 'HS256');
    http_response_code(200);
    echo json_encode($jwt);
}else{
    $jwt = 'sorry your email or password is incorrect';
    http_response_code(200);
    echo json_encode($jwt); 
}






?>