<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Table Selection</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;600&family=Prompt&display=swap');

    * {
        font-family: 'Prompt', sans-serif;
    }
</style>

<body>
    <?php
    include("../../backend/connect_db.php");
    $x = 0;
    ?>
    <div class="row me-0">
        <?php
        include("nav.php");
        ?>
        <div class="col-9">
            <div class="container mt-5">
                <h2>ชำระเงิน</h2>

                <div class="row text-center mt-3">
                <div class="card shadow mb-4">
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                                    <thead >
                                        <tr >
                                            <th style="text-align: center;">#</th>
                                            <th style="text-align: center;">วันที่</th>
                                            <th style="text-align: center;">เวลา</th>
                                            <th style="text-align: center;">จำนวนลูกค้า</th>
                                            <th style="text-align: center;">โต๊ะ</th>
                                            <th style="text-align: center;">สถานะ</th>
                                            <th style="text-align: center;">ดูรายการ</th>
                                            <!-- <th style="text-align: center;">แก้ไขรายละเอียดวัสดุ</th>
                                            <th style="text-align: center;">ลบวัสดุ</th> -->
                                        </tr>
                                    </thead>
                                    <!-- <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Salary</th>
                                        </tr>
                                    </tfoot> -->
                                    
                                    <tbody>
                                    <?php 
                                        $result = $conn->query("SELECT * FROM orders WHERE status_order = 'รอชำระเงิน'");
                                        while ($row = $result->fetch_assoc()){
                                            $x++;
                                    ?>
                                        <tr>
                                            <td><?php echo $x;?></td>
                                            <td><?php echo $row['date']?></td>
                                            <td><?php echo $row['time']?></td>
                                            <td><?php echo $row['numCustomer']?></td>
                                            <td><?php
                                            $idTable = $row['id_table'];
                                                $tableRe = $conn->query("SELECT * FROM tables WHERE id_table = '$idTable'");
                                                $table = $tableRe->fetch_assoc();
                                                echo $table['name'];
                                            ?></td>
                                            <td><?php 
                                                if($row['status_order'] == "รอชำระเงิน"){ ?>
                                                    <p class="text-warning"><?php echo $row['status_order']; ?></p>
                                                <?php } ?>
                                            </td>
                                            <td><div class="text-center"><button class="btn btn-primary" id="openOrder" data-id="<?php echo $row['id_order'];?>">ดู</button></div></td>
                                            <!-- <td><div class="text-center"><button class="btn btn-warning" id="EditProduct" data-id="<?php echo $row['id_product'];?>" data-num="<?php echo $x;?>">แก้ไข</button></div></td>
                                            <td><div class="text-center"><button class="btn btn-danger" id="DeleteProduct" data-id="<?php echo $row['id_product'];?>">ลบ</button></div></td> -->
                                        </tr>
                                       <?php } ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });

        $(document).on("click", "#openOrder", function () {
            var idOrder = $(this).data("id");
            var formdata = new FormData();
            formdata.append("idOrder", idOrder);
            $.ajax({
                url: "modalOrderPay.php",
                type: "POST",
                data: formdata,
                dataType: "html",
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data)
                    Swal.fire({
                        width: '1000px',
                        showConfirmButton: false,
                        html: data
                    });
                }
            })
        });
        $(document).on("click", "#confirmOrder", function () {
            // console.log("hi")
            var idOrder = $(this).data("id");
            // alert(id);
            Swal.fire({
                title: "ต้องการอนุมัติชำระเงินใช่หรือไม่?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    var formdata = new FormData();
                    formdata.append("idOrder", idOrder);
                    // alert(id);

                    $.ajax({
                        url: "../../backend/payment_order.php",
                        type: "POST",
                        data: formdata,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            if (data == 1) {
                                Swal.fire({
                                    title: "อนุมัติเสร็จสิ้น",
                                    showConfirmButton: false,
                                    icon: "success",
                                    timer: 800
                                }).then((result) => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: "เกิดข้อผิดพลาด",
                                    showConfirmButton: false,
                                    icon: "error",
                                    timer: 800
                                });
                            }

                        }
                    });
                }
            });
        });
    </script>
</body>

</html>