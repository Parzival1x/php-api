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
    $sql = "INSERT INTO user 
    (email,password,username,shipping_address)
    VALUES (
        '".$_POST['email']."',
        '".$password."',
        '".$_POST['username']."',
        '".$_POST['shipping_address']."'
    )";
    $db_conn->query($sql);
    $last_id = $db_conn->insert_id;
    $result = $db_conn->query('SELECT * FROM user where user_id='.$last_id)->fetch_assoc();
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
