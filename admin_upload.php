<!doctype html>
<html>
<head>
    <title>Online LIBRARY</title>
    <link rel="stylesheet" type="text/css" href="login.css"/>
    <style type="text/css">
        body{   font: 14px sans-serif; 
                color:black;
                background-image: url("admin_background.png");
                background-repeat: no-repeat;
                background-size: 100%;}

        .border{    font-size: 35px;
                    font-weight: bold; 
                    margin-top:60px;
                    text-decoration: underline;
                    letter-spacing: 5px;
                    text-shadow: 5px 5px 10px red;
                    text-align: center; }

        .wrapper{   position: absolute;
                    color: white;
                    left: 40%;
                    padding:20px 40px;
                    box-sizing: border-box;
                    background: rgba(0,0,0,0.7); }            
    </style>
</head>

<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header('Location: login.php?login=false');
}
?>

<header>
<div class="border">
    <h2><strong>LIBRARY</strong></h2>
    </div>
</header>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Template</title>
</head>

<div class="wrapper">
    <body>
        <form action="./upload.php" method="POST" enctype="multipart/form-data">
            <label for="id">ID:</label><br>
            <input type="number" name="id" required><br><br>
            <label for="name">Book Name:</label><br>
            <input type="text" name="name" required><br><br>
            <label for="amount">Amount:</label><br>
            <input type="number" name="amount" step=1 min=1 required><br><br>
            <label for="description">Description:</label><br>
            <input type="text" name="description" required maxlength=50><br><br>
            <label for="page" =>Page:</label><br>
            <input type="number" name="page" required step=1 min=1><br><br>
            <input type="file" name="file" accept=".png, .jpg, .jpeg" required><br><br>
            <button type="submit" name="submit">Confirm</button><br><br>
            <a href="./admin_main.php"><font color="red"> Go Back </font></a><br><br>
        </form>

        <?php
        if(!isset($_GET['submit'])){
            exit();
        } elseif($_GET['submit'] == 'true'){
            echo "The file is successfully uploaded!";
        } elseif($_GET['submit'] == 'false'){
            echo "Oops! Something went wrong, please try again.";
        } elseif($_GET['submit'] == 'xsize'){
        echo "your file size should not be over 100MB";
        } elseif($_GET['submit'] == 'xtype'){
        echo "only .png, .jpeg, .jpg are allowed";
        }
        ?>
    </body>
</div>
</html>
