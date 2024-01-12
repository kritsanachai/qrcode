<?php
include("../backend_user/connect_db.php");
session_start();
$tableId = $_SESSION['tableId'];
$orderId = $_SESSION['orderId'];

$sqlCheckPage = "SELECT * FROM orders WHERE id_order='$orderId' AND id_table='$tableId'";
$qCheckPage = $conn->query($sqlCheckPage);
$rCheckPage = $qCheckPage->num_rows;
if($rCheckPage != 1){
    header("Location:https://google.com");
}

$sqlTable = "SELECT * FROM tables WHERE id_table = '$tableId'";
$qTable = $conn->query($sqlTable);
$nameTable = $qTable->fetch_object();
?>
<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Option 1: Include in HTML -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300&display=swap');
*{
    font-family: 'Prompt', sans-serif;
}
</style>

<body>
    <nav>
        <div class="d-flex justifu-content-between bg-dark text-light">
            <div class="logo fix-top my-2 ms-4">จิ่มจุ่มรั้วหลากสี</div>
            <div class="ms-auto my-auto me-3">
                <?php echo $nameTable->name ?>
            </div>
        </div>
    </nav>
    <div class="container mt-4">

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">รายการ</th>
                    <th scope="col">ราคา</th>
                    <th scope="col">จำนวน</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $sqlCart = "SELECT * FROM cart WHERE tableId ='$tableId'";
                $qCart = $conn->query($sqlCart);

                while ($data = $qCart->fetch_object()) {
                    $sqlProduct = "SELECT * FROM product WHERE id = '$data->productId'";
                    $qProduct = $conn->query($sqlProduct);
                    $dataPro = $qProduct->fetch_object();
                    ?>
                    <tr class="">
                        <td scope="row">
                            <?php echo $i; ?>
                        </td>
                        <td>
                            <?php echo $dataPro->name; ?>
                        </td>
                        <td>
                            <?php echo $dataPro->price; ?>
                        </td>
                        <td><input type="number" value="<?php echo $data->qty; ?>" data-id="<?php echo $data->id ?>" style="width: 50px;" id="qty" class="form-control qtyClass"
                                min="0" max="10">
                            </td>
                        <td><button class="btn btn-danger" data-id="<?php echo $data->id ?>" id="btnDelCart">ลบ</button></td>
                    </tr>
                    <?php $i++;
                }
                ?>

            </tbody>
        </table>


        <div class="fixed-bottom d-flex">
            <button class="btn btn-warning form-control my-3 mx-2" id="btnBack">ย้อนกลับ</button>
            <button class=" btn btn-success shadow form-control my-3 mx-2" id="submitOrder">ยืนยันออร์เดอร์</button>
        </div>
    </div>

    <script>

        $(document).on("click","#btnDelCart",function(){
            var cartId = $(this).data("id");
            var formdata = new FormData()
            formdata.append("cartId",cartId);

            $.ajax({
                url:"../backend_user/del.cart.php",
                type:"POST",
                data:formdata,
                dataType:"json",
                contentType:false,
                processData:false,
                success:function(data){
                    if(data == 1){
                        Swal.fire({
                            title:"ลบเสร็จสิ้น",
                            showConfirmButton:false,
                            timer:900,
                            icon:"success"
                        }).then((result) => {
                            window.location.reload();
                        });
                    }else{
                        Swal.fire({
                            title:"เกิดข้อผิดพลาด",
                            showConfirmButton:false,
                            timer:900,
                            icon:"error"
                        })
                    }
                }
            })
        })

        $(document).on("input",".qtyClass",function(){
            var cartId = $(this).data("id");
            var qty = $(this).val();
            var formdata = new FormData()
            formdata.append("cartId",cartId);
            formdata.append("qty",qty);
            $.ajax({
                url : "../backend_user/change.qty.php",
                type:"POST",
                data:formdata,
                dataType:"json",
                contentType:false,
                processData:false,
                success:function(data){
                    console.log(data)
                    if(data == 0 ){
                        Swal.fire({
                            title:"เกิดข้อผิดพลาด",
                            text:"ไม่สามารถแก้ไขจำนวนได้",
                            icon:"error",
                            showConfirmButton:false,
                            timer:"900"
                        })
                    }
                }
            })
        });


        $(document).on("click","#btnBack",function(){
            window.history.back();
        })

        $(document).on("click", "#submitOrder", function () {
            $.ajax({
                url: "../backend_user/add.Order.php",
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 1) {
                        Swal.fire({
                            title: "เสร็จสิ้น",
                            showConfirmButton: false,
                            timer: 900,
                            icon: "success"
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด",
                            text: "โปรกสแกน QrCode เพื่อสั่งสินค้าใหม่ หรือแจ้งพนักงาน",
                            showConfirmButton: false,
                            timer: 900,
                            icon: "error"
                        })
                    }
                }
            })
        })
    </script>










    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>