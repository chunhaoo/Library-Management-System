<!doctype html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <style type="text/css">
          body{   background-image: url("background.png");
                  background-repeat: no-repeat;
                  background-size: 100%;}

          .border{  font-size: 45px;
                    font-weight: bold; 
                    margin-top:60px;
                    color: white;
                    text-decoration: underline;
                    letter-spacing: 5px;
                    text-shadow: 2px 2px 10px blue;
                    text-align: center; }
          
          .button { font-size: 18px;
                    text-decoration:none;
                    margin-left: 600px;
                    margin-right: 600px;
                    text-align: center;
                    background-color: #cae8ca;
                    border: red 2px solid;
                    padding: 10px 20px;
                    border-radius:10px; }

          .button:hover { background:#4CAF50; }

      </style>
  </head>
</html>

<div class="border">
        <p>Library System</p>
</div>

<body>
  <div class="button">
      <?php
      // Initialize the session
      session_start();
      date_default_timezone_set('Asia/Kuala_Lumpur');
      $currentDate = date('Y-m-d H:i:s');

          // Check if the user is logged in, if not then redirect him to login page
          if(!isset($_SESSION['id'])){
              header('Location: login.php?login=false');
          } else{
            $studId = $_SESSION['id'];
          }


          $conn = mysqli_connect('localhost', 'root', '', 'library');
          $dateSql = "Select bookID from borrow where DATEDIFF(now(), duration) <= 7 AND studentID = $studId ;";
          $date = mysqli_query($conn, $dateSql);
          
          if ($date->num_rows > 0) {
              while ($row = $date->fetch_assoc()) {
                  $bookID = $row['bookID'];
                  $getNameSql = "select name from books where id = $bookID;";
                  $getName = mysqli_query($conn, $getNameSql);
                  if($getName->num_rows > 0){
                    while ($row = $getName->fetch_assoc()){
                      echo '<a href="./view.php?name='.$row["name"].'&page=1">'.$row["name"].'</a><br><br>';
                    }
                  }
              }
          } else {
              echo "You have not own any book.";
          }
          ?>
  </div>

        <br>
        <div class="button">
          <?php
          //Go back button
          echo '<a href="./welcome.php"> Go Back </a>';
          ?>
        </div>
</body>