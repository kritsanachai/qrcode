<?php
    include("../../backend/connect_db.php");
    $idOrder = $_POST['idOrder'];
    $resultOrder = $conn->query("SELECT * FROM orders WHERE id_order = '$idOrder'");
    $order = $resultOrder->fetch_assoc();
    $idTable = $order['id_table'];
    $resultTable = $conn->query("SELECT * FROM tables WHERE id_table = '$idTable'");
    $table = $resultTable->fetch_assoc();
?>

<h3 class="d-flex justify-content-center fw-bold mt-5">ออเดอร์ลูกค้า</h3>

<h5 class="d-flex justify-content-center fw-semibold mt-3">รายละเอียดข้อมูล</h5>

<div class="justify-content-center ">
    <div class="d-flex justify-content-around flex-sm-wrap mt-3">

    
            <p><?php echo $table['name'];?></p>
            <p>จำนวนลูกค้า : <span>
                    <?php echo  $order['numCustomer'];?>
                </span>คน</p>
       
    </div>

</div>


<table class="table table-hover" style="width: 900px;">
    <thead class="table-secondary">
        <tr>
            <th scope="col">#</th>
            <th scope="col">ชื่อสินค้า</th>
            <th scope="col">จำนวน</th>
            <th scope="col">ราคารวม</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $stu = $conn->query("SELECT * FROM order_detail WHERE id_order = '$idOrder'");
        $array = array(); //สร้าง array เพื่อเก็บข้อมูล

        while($row = $stu->fetch_object()){
            $dataArray = ["$row->id_product","$row->qty"]; //array นี้เก็บชุดข้อมูลของ order_detail
            $count = count($array); //นับ array มีข้อมูลไหม
            if($count == 0){ //ถ้าไม่มีข้อมูลใน array ให้มาทำการเพิ่มข้อมู,ใน array
                array_push($array,$dataArray);
            }else{ 
                for($i = 0;$i < count($array);$i++){
                    if($array[$i][0] == $row->id_product){
                        $oldQty = $array[$i][1];
                        $totalQty = $oldQty+$row->qty;
                        $array[$i][1] = $totalQty;
                    }else{
                        array_push($array,$dataArray);
                    }
                }
            } 
        }
        $total = 0;
        for($j=0;$j<count($array);$j++){
            $productId = $array[$j][0];
            $sumQty = $array[$j][1];
            $qPro = $conn->query("SELECT * FROM product WHERE id='$productId'");
            $dataPro = $qPro->fetch_object();
            $sumPro = $sumQty*$dataPro->price;
            $total = $total+$sumQty*$dataPro->price;
        ?>

            <tr>
                <td>
                    <?php echo $j+1; ?>
                </td>
                <td>
                    <?php echo $dataPro->name ?>
                </td>
                <td>
                    <?php echo $sumQty ?>
                </td>
                <td>
                    <?php echo $sumPro; ?>
                </td>
            </tr>

        <?php } ?>

    </tbody>
    <tfoot>
        <tr class="text-dark fw-bolder">
            <td colspan="3" class="text-center">ราคารวม</td>
            <td>
                <?php echo $total; ?>
            </td>
        </tr>
    </tfoot>
</table>


