<?php  
    include("connect_db.php");
    session_start();
    $idTable = $_SESSION['tableId'];
    $qty = $_POST['qty'];
    $productId = $_POST['productId'];

    $sqlCart = "SELECT * FROM cart WHERE tableId='$idTable' AND productId = '$productId'";
    $qCart = $conn->query($sqlCart);
    $rCart = $qCart->num_rows;

    if($rCart > 0 ){
        $dataCart = $qCart->fetch_object();
        $totalqty = $qty + $dataCart->qty;
        $id = $dataCart->id;
        $sqlOrderDetail = "UPDATE cart SET qty = '$totalqty ' WHERE id = '$id'";
        $qOrderDetail = $conn->query($sqlOrderDetail);
    }else{
        $sqlOrderDetail = "INSERT INTO cart (productId,qty,tableId) VALUES ('$productId','$qty','$idTable')";
        $qOrderDetail = $conn->query($sqlOrderDetail);
    
    }
    if($qOrderDetail){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }
    ?>