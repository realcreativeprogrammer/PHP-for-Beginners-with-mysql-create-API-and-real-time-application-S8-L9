<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
require __DIR__.'/vendor/autoload.php';
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json; charset=UTF-8');

include './conn.php';

$headers=apache_request_headers();
$authheader=false;
foreach($headers as $header => $value){
    if($header == 'auth'){
        $authheader=$value;
    }
}
if($authheader){
    try{
        $key='fgdgfdgdfg';
        $toekn=$authheader;
        $decoded = JWT::decode($toekn, new Key($key, 'HS256'));
        $decoded=(array)$decoded;
        if($decoded['role'] =='admin'){
            $sql='SELECT `id`, `email`, `password`, `date` FROM `user`';
            $exc=$pdo->prepare($sql);
            $exc->execute(array());
            $res=array();
            $res['data']=array();
    
            while($row =$exc->fetch()){
                $single_row=array('id'=>$row['id'],'useremail'=>$row['email'],'password'=>$row['password'],'date'=>$row['date']);
                array_push($res['data'],$single_row);
            }
            $res['message']=array('msg'=>'successfuly return date');
    
            http_response_code(200);
            echo json_encode($res);
            // print_r($decoded);
            

        }else{
            $res=array();
            $res['message']=array('msg'=>'sorry you are not admin');
            http_response_code(401);
            echo json_encode($res);  
        }
      
    }catch(\Exception $err){
        // echo $err;
        // echo 'sorry your token is invalid';
        $res=array();
        $res['message']=array('msg'=>'soory you cant access this path');
        http_response_code(401);
        echo json_encode($res);
    
    } 
}else{
    $res=array();
    $res['message']=array('msg'=>'sorry please send auth header',"data"=>$authheader);
    http_response_code(401);
    echo json_encode($res); 
}


?>