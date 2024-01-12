<?php
session_start();
include("../backend_user/connect_db.php");

$sqlOrder = "SELECT * FROM order_detail WHERE status = '1' ORDER BY datetime ASC";
$qOrder = $conn->query($sqlOrder);
$array = array();
while ($data = $qOrder->fetch_object()) {
    $count = count($array);
    if ($count == 0) {
        $dataArray = ["$data->id_order", "$data->datetime"];
        array_push($array, $dataArray);
    } else {
        $dataArray = ["$data->id_order", "$data->datetime"];
        $oldData = $array[$count - 1];
        if ($oldData[0] == $data->id_order) {
            if ($oldData[1] != $data->datetime) {
                array_push($array, $dataArray);
            }
        } else {
            array_push($array, $dataArray);
        }
    }
}
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
<style>
    @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300&display=swap');
*{
    font-family: 'Prompt', sans-serif;
}
</style>
<?php 
    include("../backend/function.php");
    checkCheff();
?>
<body>

    <nav>
        <div class="d-flex justify-content-between bg-dark text-light px-4 py-2">
            <div class="">จิ้มจุ่มรั้วหลากสี</div>
            <div class=""><a href="logout.php">ออกจากระบบ</a></div>
        </div>
    </nav>

    <div class="container">


        <?php
        if (count($array) == 0) { ?>
            <div class="d-flex justify-content-center my-3">
                ไม่มีออเดอร์ตอนนี้
            </div>
        <?php }
        for ($i = 0; $i < count($array); $i++) {
            $orderId = $array[$i][0];
            $datetime = $array[$i][1];
            $sqlDataOrder = "SELECT * FROM order_detail WHERE id_order = '$orderId' AND datetime = '$datetime'";
            $qDataOrder = $conn->query($sqlDataOrder);
            $sqlOrder = "SELECT * FROM orders WHERE id_order = '$orderId'";
            $qOrderD = $conn->query($sqlOrder);
            $dataOrderD = $qOrderD->fetch_object();
            $idTable = $dataOrderD->id_table;
            $tableRe = $conn->query("SELECT * FROM tables WHERE id_table = '$idTable'");
            $table = $tableRe->fetch_assoc();

                ?>
            <div class="card my-2">
                <div class="card-header">
                    <div class="d-flex jhustify-content-start ps-3">
                        <?php echo $table['name']?>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ชื่อรายการ</th>
                                <th scope="col">จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $j = 1;
                            while ($dataOrder = $qDataOrder->fetch_object()) {
                                $sqlProduct = "SELECT * FROM product WHERE id = '$dataOrder->id_product'";
                                $qProduct = $conn->query($sqlProduct);
                                $dataProduct = $qProduct->fetch_object();
                                ?>
                                <tr class="">
                                    <td scope="row">
                                        <?php echo $j; ?>
                                    </td>
                                    <td>
                                        <?php echo $dataProduct->name ?>
                                    </td>
                                    <td>
                                        <?php echo $dataOrder->qty ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-success me-5 btnSuccessOrder" data-orderId="<?php echo $orderId ?>"
                            data-datetime="<?php echo $datetime ?>">จัดออร์เดอร์เสร็จสิ้น</button>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

    <script>
        setTimeout(function () {
            location.reload();
        }, 5000); // ระบุเวลาในหน่วยมิลลิวินาที
    </script>
    <script>

        $(document).on("click", ".btnSuccessOrder", function () {
            var orderId = $(this).data("orderid");
            var datetime = $(this).data("datetime");
            var formdata = new FormData();
            formdata.append("orderId", orderId);
            formdata.append("datetime", datetime);

            $.ajax({
                url: "../backend_user/update.order.php",
                type: "POST",
                data: formdata,
                dataType: "html",
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data)
                    if (data == 1) {
                        Swal.fire({
                            title: "เสร็จสิ้น",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 900
                        }).then((result) => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด",
                            icon: "error",
                            showConfirmButton: false,
                            timer: 900
                        });
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