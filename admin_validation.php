<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "library");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['admin_id'];
$passwd = $_POST['passwd'];
//login time
date_default_timezone_set('Asia/Kuala_Lumpur');
$logintime = date('Y-m-d H:i:s');
mysqli_query($conn,"UPDATE stud_acc SET login_time = '$logintime' where stud_id = '$id';");
//login validation
$query = "Select * from admin where id = '$id' AND password = '$passwd';";
$result = mysqli_query($conn, $query);
$num = mysqli_num_rows($result);

if ($num==1){
    $_SESSION['admin_id'] = $id;
    header('Location:admin_main.php');
}
else{
    header('Location:login.php?login=false');
}
?>
