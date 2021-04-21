<?php 
require_once ('db.php');
$error=[];
if (empty($_POST["product_name"])) {
    array_push($error,'Product name is required');
}
if (empty($_POST["description"])) {
    array_push($error,'description is required');
}
if (empty($_FILES["image"]["name"])) {
    array_push($error,'Image is required');
}
if (empty($_POST["price"])) {
    array_push($error,'price is required');
}
if (empty($_POST["shipping_cost"])) {
    array_push($error,'Shipping is required');
}
if(empty($error)){
    $fnm = $_FILES["image"]["name"];
    $upload="upload/product/".$fnm;
    move_uploaded_file($_FILES["image"]["tmp_name"],$upload);
    $sql = "INSERT INTO product 
    (product_name,description,image,price,shipping_cost)
    VALUES (
        '".$_POST['product_name']."',
        '".$_POST['description']."',
        '".$fnm."',
        '".$_POST['price']."',
        '".$_POST['shipping_cost']."'
    )";
    $db_conn->query($sql);
    $last_id = $db_conn->insert_id;
    $product=[];
    $result = $db_conn->query('SELECT * FROM product where product_id='.$last_id);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            array_push($product, $row);
        }
    }
    $res=[
        'success'=>200,
        'data'=>$product,
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