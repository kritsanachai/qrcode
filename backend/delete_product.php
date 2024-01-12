<?php 
    include("connect_db.php");
    if(!empty($_POST['id'])){
        $id = $_POST['id'];
        $query_pro = $conn->query("SELECT * FROM product WHERE id = '$id'");
        $pro = $query_pro->fetch_array();
        @unlink('../frontend/frontend_user/image/' . $pro['img']);
        // // echo $pro['img'];
        // echo json_encode(1);
        $result = $conn->query("DELETE FROM product WHERE id = $id");
        if($result){
            echo json_encode(1);
            // echo "<script>alert('ลบรายการแล้วเรียบร้อย'); window.location = '../all_product.php'</script>";
        }else{
            echo json_encode(0);
            // echo $conn->error;
        }
    }

    
?>