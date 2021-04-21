<?php 
require_once ('db.php');
$error=[];
$comments=[];
$result = $db_conn->query('SELECT comments.id as comment_id,comments.comment,comments.image,comments.rating,product.product_name,user.username FROM comments LEFT JOIN product ON product.product_id=comments.product_id LEFT JOIN user ON user.user_id=comments.user_id where comments.product_id='.$_GET['product_id'].' ORDER BY comments.id');
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($comments, $row);
    }
}
if(empty($result)){ 
    array_push($error,'No Comments avilable!');
    $res=[
        'success'=>200,
        'data'=>'',
        'error'=>$error
    ];
}else{
    $res=[
        'success'=>200,
        'data'=>$comments,
        'error'=>''
    ];
}
echo json_encode($res);