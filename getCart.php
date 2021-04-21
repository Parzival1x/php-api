<?php 
require_once ('db.php');
$error=[];
$cart=[];
$result = $db_conn->query('SELECT cart.*,product.product_name,user.username FROM cart LEFT JOIN product ON product.product_id=cart.product_id LEFT JOIN user ON user.user_id=cart.user_id where cart.user_id='.$_GET['user_id'].' ORDER BY cart.id');
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($cart, $row);
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
        'data'=>$cart,
        'error'=>''
    ];
}
echo json_encode($res);