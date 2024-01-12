<?php  
    include("connect_db.php");

    $cartId = $_POST['cartId'];

    $sql = "DELETE FROM cart WHERE id = '$cartId'";
    $qSql = $conn->query($sql);

    if($qSql){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }
?>