<?php 
    session_start();
    session_destroy();
    echo json_encode(1);
    // header("location: ../index.php");
    // echo "<script>alert('ออกจากระบบเรียบร้อย'); window.location = '../frontend/index.php'</script>";