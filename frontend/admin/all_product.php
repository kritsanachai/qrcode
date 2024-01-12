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
    <div id="content-wrapper" class="d-flex flex-column">
    <div class="row me-0">
        <?php
        include("nav.php");
        ?>
        <div class="col-9">
            <div class="container mt-5">
                <div class="d-flex justify-content-between">
                        <h1 class="h3 mb-2 text-gray-800">รายการอาหารทั้งหมด</h1><button class="btn btn-primary" id="InsertProduct">เพิ่มรายการอาหาร</button>
                    </div>

                <div class="row text-center mt-3">
                <div class="card shadow mb-4">
                        
                <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>รูปภาพ</th>
                                            <th>ชื่อ</th>
                                            <th>รายละเอียด</th>
                                            <th>ราคา</th>
                                            <th style="text-align: center;">แก้ไขสินค้า</th>
                                            <th style="text-align: center;">ลบสินค้า</th>
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
                                        $result = $conn->query('SELECT * FROM product');
                                        while ($row = $result->fetch_assoc()){
                                            $x++;
                                    ?>
                                        <tr>
                                            <td><?php echo $x;?></td>
                                            <td><img style="width:150px; height:150px;" class="mx-auto d-block" src="../../frontend_user/image/<?php echo $row['image']; ?>" alt="" class="rounded"></td>
                                            
                                            <!-- <td><img src="upload/<?php echo $row['img'];?>" alt=""></td> -->
                                            <td><?php echo $row['name']?></td>
                                            <td><?php echo $row['description']?></td>
                                            <td><?php echo $row['price']?></td>
                                            <td><div class="text-center"><button class="btn btn-warning" id="EditProduct" data-id="<?php echo $row['id'];?>" data-num="<?php echo $x;?>">แก้ไข</button></div></td>
                                            <td><div class="text-center"><button class="btn btn-danger" id="DeleteProduct" data-id="<?php echo $row['id'];?>">ลบ</button></div></td>
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
        $(document).on("click", "#DeleteProduct", function () {
            var id = $(this).data("id");
            // alert(id);
            Swal.fire({
            title: "คุณต้องการลบใช่หรือไม่?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            }).then((result) => {
            if (result.isConfirmed) {
                var formdata = new FormData();
                formdata.append("id", id);
                // alert(id);

                $.ajax({
                    url:"../../backend/delete_product.php",
                    type:"POST",
                    data:formdata,
                    dataType:"json",
                    contentType:false,
                    processData:false,
                    success:function(data){
                        // console.log(data)
                        if(data == 1){
                            Swal.fire({
                            title:"เสร็จสิ้น",
                            showConfirmButton:false,
                            icon:"success",
                            timer:800
                        }).then((result) => {
                            window.location.reload();
                        });
                        }else{
                            Swal.fire({
                            title:"เกิดข้อผิดพลาด",
                            showConfirmButton:false,
                            icon:"error",
                            timer:800
                        });
                        }

                    }
                });
            }
            });
  });
  $(document).on("click", "#InsertProduct", function () {
    Swal.fire({
      title: "เพิ่มสินค้า",
      showConfirmButton: false,
      html:
        '<input type="text" class="form-control my-4" id="name" placeholder="ชื่อสินค้า" required>' +
        '<input type="text" class="form-control my-4" id="detail" placeholder="รายละเอียด" required>' +
        '<input type="text" class="form-control my-4" id="price" placeholder="ราคา" required>' +
        '<input type="file" accept="image/png, image/jpg, image/jpeg" class="form-control my-4" id="img" required>' +
        '<button class="btn btn-success form-control my-4" id="submitProduct">ยืนยัน</button>',
    });
  });

  $(document).on("click", "#submitProduct", function () {
    // alert('hi');
    var name = $("#name").val();
    var detail = $("#detail").val();
    var price = $("#price").val();
    var img = $('#img')[0].files[0];
    // console.log(name);
    // console.log(img);
    var formdata = new FormData();
    formdata.append("name", name);
    formdata.append("detail", detail);
    formdata.append("price", price);
    formdata.append("img", img);

    $.ajax({
      url: "../../backend/insert_product.php",
      type: "POST",
      data: formdata,
      dataType: "json",
      contentType: false,
      processData: false,
      success: function (data) {
        console.log(data)
        if (data == 1) {
          Swal.fire({
            title: "เสร็จสิ้น",
            showConfirmButton: false,
            icon: "success",
            timer: 800,
          }).then((result) => {
            window.location.reload();
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
  });
  //end insert
//start update
$(document).on("click", "#EditProduct", function () {
        var idProduct = $(this).data("id");
        var numProduct = $(this).data("num");
        var formdata = new FormData();
        formdata.append("id",idProduct);
        formdata.append("num",numProduct);
        $.ajax({
            url:"edit_product.php",
            type:"POST",
            data:formdata,
            dataType:"html",
            contentType:false,
            processData:false,
            success:function(data){
                Swal.fire({
                    title: "แก้ไขสินค้า",
                    showConfirmButton: false,
                    html:data 
                });
            }
        })
    
  });
  $(document).on("click", "#UpdateProduct", function () {
       // alert("hi");
        var id = $('#id').val();
        var name = $('#name').val();
        var detail = $('#detail').val();
        var price = $('#price').val();
        var img = $('#img')[0].files[0];
        // var img2 = $('#img2').val();
        // console.log(img2);

        var formdata = new FormData();
        formdata.append("id", id);
        formdata.append("name", name);
        formdata.append("detail", detail);
        formdata.append("price", price);
        formdata.append("img", img);
        // formdata.append("img2", img2);
        $.ajax({
            url: "../../backend/update_product.php",
            type: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (data) {
                console.log(data)
                if (data == 1) {
                Swal.fire({
                    title: "แก้ไขเสร็จสิ้น",
                    showConfirmButton: false,
                    icon: "success",
                    timer: 800,
                }).then((result) => {
                    window.location.reload();
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
});

    </script>
</body>

</html>