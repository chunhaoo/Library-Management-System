<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header('Location: login.php?login=false');
}
?>

<!doctype html>
<html>
<head>
    <title>Online LIBRARY</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{   font: 14px sans-serif; 
                color:black;
                background-image: url("admin_background.png");
                background-repeat: no-repeat;
                background-size: 100%;
                }

        .border {   font-size: 45px;
                    font-weight: bold; 
                    margin-top:60px;
                    text-decoration: underline;
                    letter-spacing: 5px;
                    text-shadow: 2px 2px 10px red;
                    text-align: center; }

        .button {   font-size: 15px;
                    font-weight: bold; 
                    background-color: #cae8ca;
                    margin-left: 500px;
                    margin-right: 500px;
                    text-align: center;
                    border: blue 2px solid;
                    padding: 10px 25px;
                    border-radius:20px; }

        .button:hover { background:#00FF00; }
        
    </style>
</head>

<body>
    <div class="border">
        <header>
            <h1><strong>LIBRARY SYSTEM</strong></h1>
        </header>
    </div>   
<br>

    <div class="button">
        <a href="./admin_upload.php">Upload Book</a><br>
    </div>
<br>    
    <div class="button">
        <a href="logout.php">Logout</a><br>
            <?php
                if(!isset($_GET['login'])){
                    exit();
                } elseif($_GET['login'] == "false"){
                    echo "You are logged out. Please log in again.";
                }
            ?>
    </div>
</body>
</html>
