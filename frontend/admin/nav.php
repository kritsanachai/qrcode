<!-- <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bulma@4/bulma.css" rel="stylesheet"> -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.0.0/mdb.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    include("../../backend/function.php");
    session_start();
    checkAdmin();
?>
<div class="col-3" style=" height: 100vh;">
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px; height: 100vh;">
        <!-- <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none"> -->
            <span class="fs-4 text-center">Admin</span>
        <!-- </a> -->
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="payment_order.php" class="nav-link active" aria-current="page">
                    ชำระเงิน
                </a>
            </li>
            <li>
                <a href="table.php" class="nav-link text-white">
                    เลือกโต๊ะ
                </a>
            </li>
            <li>
                <a href="order_table.php" class="nav-link text-white">
                    รายละเอียดโต๊ะ
                </a>
            </li>
            <li>
                <a href="all_product.php" class="nav-link text-white">
                    สินค้า
                </a>
            </li>
        </ul>
        <hr>
        <ul class="nav nav-pills flex-column ">
            
            <li>
                <button class="nav-link text-white" id="logout">
                   ออกจากระบบ
                </button>
            </li>

        </ul>
        <!-- <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong>mdo</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="#">New project...</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
            </ul>
        </div> -->
    </div>
</div>

<script>
        $(document).on("click", "#logout", function () {
            // alert(id);
            Swal.fire({
            title: "คุณต้องการออกจากระบบใช่หรือไม่?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "ยืนยัน",
            cancelButtonText: "ยกเลิก",
            }).then((result) => {
            if (result.isConfirmed) {
                // var formdata = new FormData();
                // formdata.append("id", id);
                // alert(id);
                $.ajax({
                    url:"../../backend/logout.php",
                    dataType:"json",
                    contentType:false,
                    processData:false,
                    success:function(data){
                        if(data == 1){
                            Swal.fire({
                            title:"ออกจากระบบเรียบร้อย",
                            showConfirmButton:false,
                            icon:"success",
                            timer:800
                        }).then((result) => {
                            window.location.href = "../../index.php";
                        });
                    }

                    }
                });
            }
            });
  });
    </script>