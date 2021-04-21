<?php 
require_once ('db.php');
$error=[];

$is_result = $db_conn->query("SELECT * FROM user WHERE email like '%".$_POST['email']."%' ");
if ( $is_result->num_rows >0) {
    array_push($error,'Email id is already exist');
}
if (empty($_POST["email"])) {
    array_push($error,'Email is required');
}else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    array_push($error,'Enter valid Email Id');
}
if (empty($_POST["password"])) {
    array_push($error,'Password is required');
}
if (empty($_POST["username"])) {
    array_push($error,'User Name is required');
}
if(empty($error)){
    $password=md5($_POST['password']);
    $sql = "UPDATE user SET 
    email='".$_POST['email']."',
    password='".$password."',
    username='".$_POST['username']."',
    shipping_address='".$_POST['shipping_address']."'
    where user_id=".$_POST['user_id'];   
    $db_conn->query($sql);
    $result = $db_conn->query('SELECT * FROM user where user_id='.$_POST['user_id'])->fetch_assoc();
    $res=[
        'success'=>200,
        'data'=>$result,
        'error'=>''
    ];
}else{
    $res=[
        'success'=>401,
        'data'=>NULL,
        'error'=>$error 
    ];
}
echo json_encode($res);
