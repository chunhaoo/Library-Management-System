<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header('Location: login.php?login=false');
}
$conn = mysqli_connect('localhost','root','','library');

if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $page = $_POST['page'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];

    $fileExt = explode('.', $fileName);
    $fileActExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');
    $sql = "insert into books values(".$id.",'".$name."','".$description."',".$amount.",".$page.");";
    $updatePageSQL = "update books set page = ".$page." where name = '".$name."';";

        if (in_array($fileActExt, $allowed)) {
            if ($fileError == 0) {
                if ($fileSize <= 100000000) {
                  if(!file_exists("./upload/".$name)){
                    $exec = mysqli_query($conn, $sql);
                    mkdir('./upload/'.$name);
                  } else{
                    $updatePage = mysqli_query($conn, $updatePageSQL);
                  }
                  $fileDestination = './upload/'.$name.'/'.$page.'.'. $fileActExt;
                  move_uploaded_file($fileTmpName, $fileDestination);
                  header('Location: ./admin_upload.php?submit=true');
                } else {
                    header('Location: ./admin_upload.php?submit=xsize');
                }
            } else {
                header('Location: ./admin_upload.php?submit=false');
            }
        } else {
            header('Location: ./admin_upload.php?submit=xtype');
        }
    }
?>
