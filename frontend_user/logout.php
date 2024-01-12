<?php  
    session_start();
    session_destroy();

?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function(){
        Swal.fire({
            title:"ออกจากระบบเสร็จสิ้น",
            showConfirmButton:false,
            timer:900,
            icon:"success"
        }).then((result) => {
            window.location = "http://localhost/qr_code/index.php";
        });
    })
</script>