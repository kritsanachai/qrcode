<?php
session_start();
include("connect_db.php");

$codeuser = $_POST['username'];
$password = $_POST['password'];
$newpassword = md5($password);


$result = $conn->query("SELECT * FROM users WHERE code_user = '$codeuser'");
$row = $result->fetch_array();
// echo $row;
if ($result->num_rows > 0) {
    if ($codeuser == $row['code_user']) {
        if ($newpassword == $row['password']) {
            if ($row['status'] == 'admin') {
                $_SESSION['admin_login'] = $row['user_id'];
                echo json_encode(1);
            } else {
                $_SESSION['cheff_login'] = $row['user_id'];
                echo json_encode(2);
            }
        } else {
            echo json_encode(5);
        }
    } else {
        echo json_encode(4);
    }
} else {
    echo json_encode(3);
}


?>