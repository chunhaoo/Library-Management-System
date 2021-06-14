<?php
session_start();

date_default_timezone_set('Asia/Kuala_Lumpur');
$checkoutTime = date('Y-m-d H:i:s');

require_once "components.php";
require_once "config.php";

if(isset($_POST['remove'])){
    if($_GET['action'] == 'remove'){
        foreach($_SESSION['cart'] as $key => $value)
        {
            if($value["book_id"] == $_GET['id']){
                unset($_SESSION['cart'][$key]);
                echo "<script>window.location = 'cart.php'</script>";
            }
        }
    }
}
?>


<?php
//Checkout
if(isset($_SESSION['cart'])){

    if(isset($_POST['checkout'])){
        $userid = $_SESSION["id"];
        $count = count($_SESSION['cart']);
        $bookID = array_column($_SESSION['cart'], 'book_id');
        $x = 0;
        while($x != $count)
        {
            foreach($bookID as $id)
            {
                $sql = "INSERT INTO borrow (bookID, studentID, duration) VALUES ('$id', '$userid', '$checkoutTime')";

                //Update Amount of books left
                $tmp = "SELECT amount FROM books WHERE id = '$id'";
                $tmpResult = mysqli_query($link, $tmp);
                $row = mysqli_fetch_assoc($tmpResult);

                //Checks if book has been borrowed
                $check = "SELECT * FROM borrow WHERE bookID = '$id'";
                $checkResult = mysqli_query($link, $check);
                $checkRow = mysqli_fetch_assoc($checkResult);

                //Checks if there is any book left
                if($row['amount'] == 0)
                {
                    unset($_SESSION['cart'][$x]);
                    echo"<script>alert('There are no books left')</script>";
                }else{
                    //Checks for borrowed book
                    if($checkRow['bookID'] == $id)
                    {
                        unset($_SESSION['cart'][$x]);
                        echo"<script>alert('Book has already been borrowed')</script>";
                    }else
                    {
                        $left = $row['amount'] - 1;
                        $update = "UPDATE books SET amount= '$left' WHERE id = '$id'";
                        mysqli_query($link, $update);
                        if(mysqli_query($link, $sql))
                        {
                            echo"<script>window.location = 'welcome.php'</script>";
                        }else{
                            echo"error";
                        }
                        unset($_SESSION['cart'][$x]);
                    }

                }
                $x++;
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style type="text/css">
        body{   background-image: url("background.png");
                background-repeat: no-repeat;
                background-size: 100%;}

        .align{ margin-top:50px;
                text-align: center; 
                background-color: white;
                color: black; }

        .align2 { margin-top:30px; }

        .max-width {    text-align: center;
                        color: white;
                        letter-spacing: 3px;
                        left:50%;
                        width:100%;
                        height:40%;
                        padding:50px 40px;
                        box-sizing: border-box;
                        background: rgba(0,0,0,0.7); }  

        .button {   text-align:center;
                    margin-right: 85%;
                    background-color: #008000;
                    border: #008000 1px solid;
                    border-radius:10px; }  

        .button:hover { background-color:red; 
                        cursor: pointer; }

    </style>
    <title>Cart</title>
    

<!--Font-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<!--Bootstrap-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body class="bg-light">

<!--Header Class-->
<div class="page-header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a href="welcome.php" class="navbar-brand">
            <h3 class="px-5">
                Library System
            </h3>
        </a>
        <!--Cart Button-->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
        arial-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarAltMarkup">
            <div class="mr-auto"></div>
                <div class="navbar-nav">
                    <a href="cart.php" class="nav-item nav-link active">
                        <h5 class="px-5 cart">
                            <!--Cart Icon-->
                            Cart
                            <?php
                            //How many items is in the cart
                                if(isset($_SESSION['cart']))
                                {
                                    $count = count($_SESSION['cart']);
                                    echo "<span id=\"cart_count\">$count</span>";
                                }else
                                {
                                    echo "<span id=\"cart_count\">0</span>";
                                }
                            ?>
                        </h5>
                    </a>
                </div>
        </div>
    </nav>
</div>

<!--Cart Container-->
<div class="container-fluid">
    <div class="row px-5">
        <div class="col-md-6">
            <div class="shopping-cart">
                <div class="align">
                    <h5>My Cart</h5>
                    <hr>
                </div>

            <div class="button">
                <?php
                    //Go back button
                    echo '<a href="./welcome.php"><font color="white"> Go Back </font></a>';
                ?>
            </div>
<br>                
            <div class="max-width">
                <?php
                    if(isset($_SESSION['cart']))
                    {
                        $sql = "SELECT * FROM books";
                        $link = mysqli_connect('localhost', 'root', '', 'library');
                        $result = mysqli_query($link, $sql);

                        $book_id = array_column($_SESSION['cart'], 'book_id');
                        while($row = mysqli_fetch_assoc($result))
                        {
                            foreach($book_id as $id){
                                if($row['id'] == $id){
                                    cartItems($row['id'], "./upload/".$row['name']."/1.png", $row['name'], $row['description']);
                                }
                            }
                        }
                    }else{
                        echo "<h5> Cart is Empty </h5>";
                    }
                ?>
            </div>
        </div>
    </div>

        <div class="col-md-5">
            <div class="pt-4">
                <div class="align2">
                    <form method="post">
                        <button type="submit" class="btn btn-success" name="checkout">Checkout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Bootstrap-->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>
</html>


<?php


?>
