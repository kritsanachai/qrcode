<!-- <head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head> -->

<?php

// include("../frontend/header_admin.php");

function checkCheff()
{
    if (!isset($_SESSION['cheff_login'])) {
        echo '<script>
        $(document).ready(function(){
            Swal.fire({
                icon: "error",
                title: "กรุณาเข้าสู่ระบบ",
                showConfirmButton: false,
                timer: 900
            }).then(() => {
                window.location.href = "../index.php"
            })
        });
            </script>';
        // echo"<script>alert('กรุณาเข้าสู่ระบบ'); window.location = '../index.php'</script>";
        exit();
    }
}

function checkAdmin()
{
    if (!isset($_SESSION['admin_login'])) {
        echo '<script>
        $(document).ready(function(){
            Swal.fire({
                icon: "error",
                title: "กรุณาเข้าสู่ระบบ",
                showConfirmButton: false,
                timer: 900
            }).then(() => {
                window.location.href = "../../index.php"
            })
        });
            </script>';
        // echo"<script>alert('กรุณาเข้าสู่ระบบ'); window.location = '../frontend/index.php'</script>";
        exit();
    }
}

// function checkMenu(){
//     echo"<script>alert('กรุณาเข้าสู่ระบบก่อนสั่งซื้อ'); window.location = '../index.php'</script>";
//     exit();
// }
?>