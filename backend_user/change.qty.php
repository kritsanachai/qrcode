<?php  
    include("connect_db.php");

    $cartId = $_POST['cartId'];
    $qty = $_POST['qty'];

    $sqlChange = "UPDATE cart SET qty = '$qty' WHERE id = '$cartId'";
    $qChange = $conn->query($sqlChange);

    if($qChange){
        echo json_encode("แก้ไขจำนวนเสร็จสิ้น"); 
    }else{
        echo json_encode(0);
    }

?>