<?php  
    include("connect_db.php");

    $orderId = $_POST['orderId'];
    
    $datetime  = $_POST['datetime'];

    $sql = "UPDATE order_detail SET status='0' WHERE id_order='$orderId' AND datetime ='$datetime'";
    $qSql = $conn->query($sql);
    if($qSql){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }
?>