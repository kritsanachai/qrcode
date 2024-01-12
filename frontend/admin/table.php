<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Table Selection</title>
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
    ?>
    <div class="row me-0">
        <?php
        include("nav.php");
        ?>
        <div class="col-9 mt-4">
            <div class="container mt-4 text-center">
                <h2>โต๊ะอาหาร</h2>

                <div class="row">
                    <!-- Card 1 -->
                    <?php
                    $tableRe = $conn->query("SELECT * FROM tables");
                    while ($table = $tableRe->fetch_assoc()) {

                        if ($table['status'] == "ว่าง") {
                            ?>
                            <div class="col-md-3  mt-4">
                                <div class="card text-white bg-success shadow" style="height: 11rem;">
                                    <div class="card-header mb-0">
                                        <h5>
                                            <?php echo $table['name']; ?>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- <h5 class="card-title"><?php echo $table['name']; ?></h5> -->
                                        <p class="card-text">สถานะ :
                                            <?php echo $table['status']; ?>
                                        </p>
                                        <a href="form_table.php?id=<?php echo $table['id_table']; ?>"
                                            class="btn btn-primary">เลือกโต๊ะนี้</a>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-3  mt-4">
                                <div class="card text-white bg-danger shadow" style="height: 11rem;">
                                    <div class="card-header">
                                        <h5>
                                            <?php echo $table['name']; ?>
                                        </h5>
                                    </div>
                                    <div class="card-body ">
                                        <!-- <h5 class="card-title"><?php echo $table['name']; ?></h5> -->
                                        <p class="card-text">สถานะ :
                                            <?php echo $table['status']; ?>
                                        </p>
                                        <a href="report_table.php?id=<?php echo $table['id_table']; ?>" class="btn btn-warning">รายละเอียด</a>
                                    </div>
                                </div>
                            </div>
                        <?php }

                    } ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>