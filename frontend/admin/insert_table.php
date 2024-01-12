<?php
include('../../backend/connect_db.php');
include('../../backend/phpqrcode/qrlib.php');
$path = 'images/';
$qrcode = $path . time() . ".png";
$qrimage = time() . ".png";

date_default_timezone_set("Asia/bangkok");
$date = date("d/m/Y");
$status = "ไม่ว่าง";
$statusOrder = "รอชำระเงิน";
$idTable = $_POST['idTable'];
$timeStart = $_POST['timeStart'];
$numCustomer = $_POST['numCustomer'];


// echo $http ;



$query = $conn->query("UPDATE tables SET status = '$status' WHERE id_table = '$idTable'");
$query1 = $conn->query("INSERT INTO orders (date, time, numCustomer, id_table, status_order) VALUES ('$date','$timeStart','$numCustomer','$idTable', '$statusOrder')");
if($query1){
    $idOrder = mysqli_insert_id($conn);
    $http = "http://localhost/qr_code/frontend_user/customer.php?tableId=" . $idTable . "&orderId=" . $idOrder;
    $query2 = $conn->query("INSERT INTO qrcode (`qrtext`, `qrimage`,id_table) VALUES ('$http','$qrimage','$idTable')");
    echo json_encode(1);
}



QRcode::png($http, $qrcode, 'H', 4, 4);
// echo "<img src='".$qrcode."'>";




?>