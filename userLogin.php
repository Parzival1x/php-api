<?php 
require_once ('db.php');
$error=[];
if (empty($_POST["email"])) {
    array_push($error,'Email is required');
}else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    array_push($error,'Enter valid Email Id');
}
if (empty($_POST["password"])) {
    array_push($error,'Password is required');
}
if(empty($error)){
    $user_email=$_POST['email'];
    $user_pass=md5($_POST['password']);
    $result=$db_conn->query("select * from user where email='$user_email' AND password='$user_pass'"); 
    if ($result->num_rows > 0) {
        $user_data=[];
        while($row = $result->fetch_assoc()) {
            array_push($user_data, $row);
        }
        $res=[
            'success'=>401,
            'data'=>$user_data,
            'error'=>'' 
        ];
    }else{
        array_push($error,'email and password not match!');
        $res=[
            'success'=>401,
            'data'=>NULL,
            'error'=>$error 
        ];
    }
   
}else{
    $res=[
        'success'=>401,
        'data'=>NULL,
        'error'=>$error 
    ];
}
echo json_encode($res);
