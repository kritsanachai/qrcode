<?php
include("../backend_user/connect_db.php");
session_start();
if (isset($_GET['tableId']) && isset($_GET['orderId'])) {
    $idTable = $_GET['tableId'];
    $orderId = $_GET['orderId'];
    $_SESSION['orderId'] = $orderId;
    $_SESSION['tableId'] = $idTable;
    $sqlCheckPage = "SELECT * FROM orders WHERE id_order='$orderId' AND id_table='$idTable'";
    $qCheckPage = $conn->query($sqlCheckPage);
    $rCheckPage = $qCheckPage->num_rows;
    if($rCheckPage != 1){
        header("Location:https://google.com");
    }
}else{
    header("Location:https://google.com");
}


$sqlTable = "SELECT * FROM tables WHERE id_table = '$idTable'";
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
<style>
        @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300&display=swap');
*{
    font-family: 'Prompt', sans-serif;
}
    html,
    body {
        height: 100vh;
    }

    .cart {
        background-color: #3F4FAD;
    }
</style>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Option 1: Include in HTML -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

<body>
    <nav>
        <div class="d-flex justifu-content-between bg-dark text-light">
            <div class="logo fix-top my-2 ms-4">จิ่มจุ่มรั้วหลากสี</div>
            <div class="ms-auto my-auto me-3">
                <?php echo $nameTable->name ?>
            </div>
        </div>
    </nav>
    <?php
    $sqlproduct = "SELECT * FROM product";
    $qProduct = $conn->query($sqlproduct);
    while ($data = $qProduct->fetch_object()) {
        ?>

        <div class="card my-2 shadow">
            <div class="card-body">
                <div class="d-flex justifu-content-between">
                    <img src="image/<?php echo $data->image ?>" class=" my-auto" width="80px" height="80px" alt="">
                    <div class="ms-3 me-5">
                        <p class="my-0">
                            <?php echo $data->name ?>
                        </p>
                        <p class="my-0">
                            <?php echo $data->description ?>
                        </p>
                        <p class="my-0">
                            ราคา :
                            <?php echo $data->price ?>
                        </p>
                    </div>
                    <div class="ms-auto my-auto d-flex">
                        <button class="ms-1 btn btn-success px-3 py-2" id="addcart"
                            data-id="<?php echo $data->id ?>">สั่ง</button>
                    </div>

                </div>
            </div>
        </div>
        <?php
    }
    ?>


    <div class="fixed-bottom my-3 ">
        <div class="d-flex justify-content-end me-3">
            <a href="cart.php">
                <button class="cart rounded-circle " id="pageCart"><i class="bi bi-cart-fill "
                        style="color: azure; font-size: 20px;"></i></button>
            </a>
        </div>
    </div>


    <script>
        $(document).on("click", "#addcart", function () {
            var productId = $(this).data("id")
            var formdata = new FormData();
            formdata.append("productId", productId)
            $.ajax({
                url: "add.cart.php",
                type: "POST",
                data: formdata,
                dataType: "html",
                contentType: false,
                processData: false,
                success: function (data) {
                    Swal.fire({
                        title: "ระบุจำนวน",
                        showConfirmButton: false,
                        html: data
                    })
                }
            })
        })

        $(document).on('click', '#btnSubmitOrder', function () {
            var qty = $('#qtyOrder').val()
            var productId = $(this).data("productid")
            var formdata = new FormData()
            formdata.append("qty", qty)
            formdata.append("productId", productId)

            $.ajax({
                url: "../backend_user/add.cart.php",
                type: "POST",
                data: formdata,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 1) {
                        Swal.fire({
                            position: "top-end",
                            title: "เพิ่มรายการสำเร็จ",
                            showConfirmButton: false,
                            icon: "success",
                            timer: 900
                        })
                    } else {
                        Swal.fire({
                            position: "top-end",
                            title: "เกิดข้อผิดพลาด",
                            showConfirmButton: false,
                            icon: "error",
                            timer: 900
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