<?php 
require_once ('db.php');
$error=[];

if (empty($_POST["user_id"])) {
    array_push($error,'user is required');
}
if (empty($_POST["product_id"])) {
    array_push($error,'product is required');
}
if(empty($error)){
   $result = $db_conn->query('SELECT * FROM cart where user_id='.$_POST['user_id'].' AND product_id='.$_POST['product_id']);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $quantity=$row['quantity']+1;
            $sql = 'UPDATE cart SET quantity='.$quantity.' where user_id='.$_POST['user_id'].' AND product_id='.$_POST['product_id'];
            $db_conn->query($sql);
        }
    }else{
        $sql = "INSERT INTO cart 
        (user_id,product_id,quantity)
        VALUES (
            '".$_POST['user_id']."',
            '".$_POST['product_id']."',
            '1'
        )";
        $db_conn->query($sql);
        $last_id = $db_conn->insert_id;
    }
    $cart=[];
    $result = $db_conn->query('SELECT * FROM cart where user_id='.$_POST['user_id']);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            array_push($cart, $row);
        }
    }
    $res=[
        'success'=>200,
        'data'=>$cart,
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