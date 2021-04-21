<?php 
require_once ('db.php');
$error=[];
$products=[];
$result = $db_conn->query('SELECT * FROM product');
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($products, $row);
    }
}
if(empty($result)){ 
    array_push($error,'No Products avilable!');
    $res=[
        'success'=>200,
        'data'=>'',
        'error'=>$error
    ];
}else{
    $res=[
        'success'=>200,
        'data'=>$products,
        'error'=>''
    ];
}
echo json_encode($res);