<?php 
    include("connect_db.php");
    $idOrder = $_POST['idOrder'];
    $approve = "ชำระเงินแล้ว";

    $upOrder = $conn->query("UPDATE orders SET status_order = '$approve' WHERE id_order = '$idOrder'");
    $reOrder = $conn->query("SELECT * FROM orders WHERE id_order = '$idOrder'");
    $order = $reOrder->fetch_assoc();
    $idTable = $order['id_table'];
    $reTable = $conn->query("UPDATE tables SET status = 'ว่าง' WHERE id_table = '$idTable'");
    echo json_encode(1);
?>