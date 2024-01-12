<?php 
    include('connect_db.php');
    include('phpqrcode/qrlib.php');
    $path = 'images/';
    $qrcode = $path.time().".png";
    $qrimage = time().".png";
    // $idTable = $_GET['id'];


   
        $idTable = $_GET['id'];
        // $orderRe = $conn->query("SELECT * FROM orders WHERE id_table = '$idTable'");
        // $order = $orderRe->fetch_assoc();
        // $idOrder = $order['id_order'];
        $http = "http://localhost/frontend_user/customer.php?tableId=".$idTable;

        
        $query = $conn->query("INSERT INTO qrcode (`qrtext`, `qrimage`,id_table) VALUES ('$http','$qrimage','$idTable')");
        if($query){
            echo "<script>alert('Data save successfully');</script>";
        }
        
        QRcode :: png($http, $qrcode, 'H',4 , 4);
        echo "<img src='".$qrcode."'>";
    
    // include('config.php');

    // how to save PNG codes to server
    
    

?>