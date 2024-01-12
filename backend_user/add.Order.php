<?php  
    include("connect_db.php");
    session_start();
    date_default_timezone_set("Asia/Bangkok");
    $date = date("Y-m-d H:i:s");
    $tableId = $_SESSION['tableId'];
    $orderId = $_SESSION['orderId'];

    $sql = "SELECT * FROM cart WHERE tableId = '$tableId'";
    $qSql = $conn->query($sql);
    $rCart = $qSql->num_rows;
    $logId = array();
    while($data = $qSql->fetch_object()){
        $sqlInsert = "INSERT INTO order_detail (id_order,id_product,qty,status,datetime) VALUES ('$orderId','$data->productId','$data->qty','1','$date')";
        $qInsert = $conn->query($sqlInsert);
        $lastId = mysqli_insert_id($conn);
        array_push($logId,$lastId);
        if(!$qInsert){
            foreach($logId as $data){
                $sqlDel = "DELETE FROM order_detail WHERE id = '$data'";
                $qDel = $conn->query($sqlDel);
            }
            echo json_encode(0);
            exit();
        }
    }
    $rOrder = count($logId);
    if($rCart == $rOrder){
        $DelCartU = "DELETE FROM cart WHERE tableId = '$tableId'";
        $qDelCartU = $conn->query($DelCartU);
        echo json_encode(1);
    }else{

    }
    
?>