<?php 
require_once ('db.php');
$error=[];

if (empty($_POST["user_id"])) {
    array_push($error,'user is required');
}
if (empty($_POST["product_id"])) {
    array_push($error,'product is required');
}
if (empty($_POST["comment"])) {
    array_push($error,'comment is required');
}
if (empty($_POST["rating"])) {
    array_push($error,'Rating is required');
}
if (empty($_FILES["image"]["name"])) {
    array_push($error,'Image is required');
}
if(empty($error)){
    $fnm = $_FILES["image"]["name"];
    $upload="upload/comment/".$fnm;
    move_uploaded_file($_FILES["image"]["tmp_name"],$upload);
    $sql = "INSERT INTO comments 
    (user_id,product_id,comment,image,rating)
    VALUES (
        '".$_POST['user_id']."',
        '".$_POST['product_id']."',
        '".$_POST['comment']."',
        '$fnm',
        '".$_POST['rating']."'
    )";
    $db_conn->query($sql);
    $last_id = $db_conn->insert_id;
    $comment=[];
    $result = $db_conn->query('SELECT * FROM comments where id='.$last_id);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            array_push($comment, $row);
        }
    }
    $res=[
        'success'=>200,
        'data'=>$comment,
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