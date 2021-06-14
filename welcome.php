<?php
// Initialize the session
session_start();
require_once "components.php";

if(isset($_SESSION["id"])){
  $studId = $_SESSION["id"];
} else{
  header("location: login.php");
}

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

if(isset($_POST['add'])){
    //If cart exist
    if(isset($_SESSION['cart'])){

        $item_array_id = array_column($_SESSION['cart'], "book_id");
        //print_r($item_array_id);

        //Checks if Item is in cart
        if(in_array($_POST['book_id'], $item_array_id)){
            echo "<script>alert('Book has been added to the cart')</script>";
            echo "<script>window.location = 'welcome.php'</script>";
        } else{
            //Adds Item to cart
            $count = count($_SESSION['cart']);
            $item_array = array('book_id' => $_POST['book_id']);
            $_SESSION['cart'][$count] = $item_array;
        }

    //Creates a cart for items to be added
    }else{
      //Set the countdown to 120 seconds.
      $_SESSION['countdown'] = 120;
      //Store the timestamp of when the countdown began.
      $_SESSION['time_started'] = time();
        $item_array = array('book_id' => $_POST['book_id']);

        $_SESSION['cart'][0] = $item_array;

    }
}


if(isset($_SESSION['countdown'])){
    //Get the current timestamp.
    $now = time();

    //Calculate how many seconds have passed since
    //the countdown began.
    $timeSince = $now - $_SESSION['time_started'];
    //How many seconds are remaining?
    $remainingSeconds = ($_SESSION['countdown'] - $timeSince);

    echo "There are $remainingSeconds seconds remaining.";
    //Check if the countdown has finished.
    if($remainingSeconds < 1){
        $count = count($_SESSION['cart']);
        $x = 0;
        while($x != $count)
        {
            unset($_SESSION['cart'][$x]);
        }
        echo"<script>alert('Books in cart has been removed due to a lack of activity by the user')</script>";
        unset($_SESSION['countdown']);
    }

    //Checks if there is anything in the cart
    if(count($_SESSION['cart'])==0){
        unset($_SESSION['countdown']);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>

    <!--Font-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!--Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style type="text/css">
        body{   font: 14px sans-serif; 
                color:white;
                background-image: url("background.png");
                background-repeat: no-repeat;
                background-size: 100%;}

        .align{    text-align: right; }

        .wrapper{   margin-right: 200px;
                    margin-left:  200px;
                    max-width: 960px;
                    padding-right: 10px;
                    padding-left:  10px;
                    padding-bottom: 150px; }

        .max-width {    position:absolute;
                        top:50%;
                        left:50%;
                        transform: translate(-50%,-50%);
                        width:100%;
                        height:60%;
                        padding:0px 40px;
                        box-sizing: border-box;
                        background: rgba(0,0,0,0.7); }
    </style>
</head>


<body>
    <!--Header-->
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
                        <a href="booksOwned.php" class="nav-item nav-link active">
                          <h5 class="px-5 cart">
                            Owned
                          </a>
                    </div>
            </div>
        </nav>
    </div>

    <div class="align">
        <p>
            <a href="logout.php" class="btn btn-danger text">Sign Out of Your Account</a>
        </p>
    </div>
<div class="max-width">
    <div class="container">
        <div class ="row text-center py-5">
        <?php
            $sql = "SELECT * FROM books";
            $link = mysqli_connect('localhost', 'root', '', 'library');
            $bookResult = mysqli_query($link, $sql);

            while($row = mysqli_fetch_assoc($bookResult))
            {
                book($row['id'], "./upload/".$row['name']."/1.png", $row['name'], $row['description'], $row['amount']);
            }

        ?>
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
//return books
  $conn = mysqli_connect('localhost', 'root', '', 'library');
  $checkDateSQL = "select bookID from borrow where DATEDIFF(now(), duration) > 7";
  $checkDate = mysqli_query($conn, $checkDateSQL);

  if ($checkDate->num_rows > 0) {
      while ($row = $checkDate->fetch_assoc()) {
        $bookID = $row['bookID'];
        $getAmtSQL = "select amount from books where id = $bookID;";
        $getAmt = mysqli_query($conn, $getAmtSQL);
          if($getAmt->num_rows > 0){
            while ($row = $getAmt->fetch_assoc()){
              $newAmt = $row['amount'] + 1;
              $addBookSql = "update books set amount = $newAmt where id = $bookID;";
              $deleteBorrowSql = "delete from borrow where studentID = $studId AND bookID = $bookID;";
              $addBook = mysqli_query($conn, $addBookSql);
              $deleteBorrow = mysqli_query($conn, $deleteBorrowSql);
            }
          }
      }
  }

 ?>
