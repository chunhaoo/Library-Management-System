<!doctype html>
<html>
<head>
    <title>Online LIBRARY</title>
    <link rel="stylesheet" type="text/css" href="login.css"/>
    <style type="text/css">
        body{   font: 14px sans-serif; 
                color:white;
                background-image: url("admin_background.png");
                background-repeat: no-repeat;
                background-size: 100%;}
        
        .align{     text-align: center;
                    text-shadow: 1px -3px 3px #F87217 }
        
        .align2{    text-align: center; }

        .border{    font-size: 45px;
                    font-weight: bold; 
                    margin-top:60px;
                    text-decoration: underline;
                    letter-spacing: 5px;
                    text-shadow: 5px 5px 10px red;
                    text-align: center; }

        .wrapper{   margin-right: 200px;
                    margin-left:  200px;
                    max-width: 960px;
                    padding-right: 10px;
                    padding-left:  10px;
                    padding-bottom: 150px; }

        .max-width {
                    position:absolute;
                    top:50%;
                    left:50%;
                    transform: translate(-50%,-50%);
                    width:800px;
                    height:420px;
                    padding:40px 40px;
                    box-sizing: border-box;
                    background: rgba(0,0,0,0.8); }
    </style>
</head>

<body>
<header>
<div class="border">
    <h2><strong>LIBRARY</strong></h2>
    </div>
</header>

<div class="max-width">
    <div class="wrapper">
        <div class="align">
            <h2>Login as Admin</h2>
        </div>
        <br>

        <div class="align2">
            <form action="admin_validation.php" method="POST">
                <label for="admin_id">ID:</label><br>
                <input type="text" name="admin_id" minlength="3" maxlength="7" title="e.g: 121" required><br><br><br>
                <label for="passwd">Password:</label><br>
                <input type="password" name="passwd" minlength="8" maxlength="8" required><br><br>
                <input type="submit" value="Login"><br><br>
                <a href="./login.php"><font color="red"> Go Back </font></a><br><br>
            </form>
        </div>

        <?php

            if(isset($_GET['submit']) && ($_GET['submit']) == 'true'){
                echo "Your file is submitted successfully!";
            }

            if(!isset($_GET['login'])){
                exit();
            } elseif($_GET['login'] == "false"){
                echo "You are logged out. Please log in again.";
            }
            ?>
        </body>
    </div>
</div>
</html>
