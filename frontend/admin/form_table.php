<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Database Connection Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;600&family=Prompt&display=swap');

        * {
            font-family: 'Prompt', sans-serif;
        }
    </style>

    </style>

</head>

<body>
    <?php
    include("../../backend/connect_db.php");
    $idTable = $_GET['id'];
    date_default_timezone_set("Asia/bangkok");
    $date = date("d/m/Y");
    // $time = date("h:i");
    ?>
    <div class="row me-0">
        <?php
        include("nav.php");
        ?>


        <div class="col-9">
            <div class="container mt-5">
                <div class="d-flex justify-content-between">
                    <h2>รายละเอียดโต๊ะ</h2><a href="table.php"><button class="btn btn-primary">ย้อนกลับ</button></a>
                </div>
                <h5 class="mt-3">วันที่
                    <?php echo $date; ?>
                </h5>
                <h5>สถานะโต๊ะ :
                    <?php
                    $tableRe = $conn->query("SELECT * FROM tables WHERE id_table = '$idTable'");
                    $table = $tableRe->fetch_assoc();
                    echo $table['status'];
                    ?>
                </h5>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>โต๊ะที่ : </label>
                            <input type="text" class="form-control" id="idTable" readonly
                                value="<?php echo $idTable ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>จำนวนลูกค้า : </label>
                            <input type="text" class="form-control" id="numCustomer">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>เวลาเริ่ม : </label>
                            <input type="time" class="form-control" id="timeStart">
                        </div>
                    </div>
                    <!-- <div class="col-md-6">
                        <div class="form-group">
                            <label>เวลาสิ้นสุด : </label>
                            <input type="time" class="form-control" id="timeEnd">
                        </div>
                    </div> -->
                </div>
                <button type="submit" class="btn btn-success form-control" id="submitTable">ยืนยัน</button>

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script>
        $(document).on("click", "#submitTable", () => {
            var idTable = $('#idTable').val();
            var numCustomer = $('#numCustomer').val();
            var timeStart = $('#timeStart').val();
            // var timeEnd = $('#timeEnd').val();

            if (numCustomer == '' || timeStart == '') {
                Swal.fire({
                    title: "กรุณากรอกข้อมูลให้ครบถ้วน!!",
                    icon: 'error',
                    timer: 800,
                    showConfirmButton: false
                });
                // alert("hi");
            } else {
                var formdata = new FormData();
                formdata.append("idTable", idTable);
                formdata.append("numCustomer", numCustomer);
                formdata.append("timeStart", timeStart);
                // formdata.append("timeEnd", timeEnd);

                $.ajax({
                    url: "insert_table.php",
                    type: "POST",
                    data: formdata,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        console.log(data)
                        if (data == 1) {
                            Swal.fire({
                                title: "เพิ่มเสร็จสิ้น",
                                showConfirmButton: false,
                                icon: "success",
                                timer: 800,
                            })
                            .then((result) => {
                                window.location.href="report_table.php?id=" + idTable;
                            });
                        } else {
                            Swal.fire({
                                title: "เกิดข้อผิดพลาด",
                                showConfirmButton: false,
                                icon: "error",
                                timer: 800,
                            });
                        }
                    },
                });
            }
        });
    </script>

</body>

</html>