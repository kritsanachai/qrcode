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
    $orderRe = $conn->query("SELECT * FROM orders WHERE id_table = '$idTable'");
    $order = $orderRe->fetch_assoc();
    ?>
    <div class="row me-0">
        <?php
        include("nav.php");
        ?>


        <!-- <h1>Hi</h1> -->
        <div class="col-9">
            <div class="container mt-5">

                <div class="d-flex justify-content-between">
                    <h2>รายละเอียดโต๊ะ</h2><a href="table.php"><button class="btn btn-primary">ย้อนกลับ</button></a>
                </div>
                <h5 class="mt-3">วันที่
                    <?php echo $order['date']; ?>
                </h5>
                <h5 class="text-danger">สถานะโต๊ะ :
                    <?php
                    $tableRe = $conn->query("SELECT * FROM tables WHERE id_table = '$idTable'");
                    $table = $tableRe->fetch_assoc(); ?>
                    <?php echo $table['status']; ?>
                </h5>
                <h5>
                    <?php echo $table['name'] ?>
                </h5>
                <h5>เวลาเปิดโต๊ะ :
                    <?php echo $order['time'] ?> น.
                </h5>
                <h5>จำนวนลูกค้า :
                    <?php echo $order['numCustomer'] ?>
                </h5>

                <!-- <a href="MyReport.pdf"><button type="submit" class="btn btn-primary form-control mt-3"
                        id="submitTable">ปริ้น</button></a> -->
             
                    <a href="pdf.php?idTable=<?php echo $idTable?>" target="_back"><button class="btn btn-primary form-control mt-3">ปริ้น</button></a>
                    
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

    </script>

</body>

</html>
