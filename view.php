<!doctype html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <style type="text/css">
          body{   background-color: #00aeae;
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

      </style>
  </head>
</html>

      <?php
      session_start();
      if(!isset($_SESSION['id'])){
          header('Location: login.php?login=false');
      }
      $conn = mysqli_connect('localhost', 'root', '', 'library');
      $name = $_GET['name'];
      $maxpageSQL = "select page from books where name = '".$name."';";
      $exec = mysqli_query($conn, $maxpageSQL);

      // Go Back Button
      echo '<a href="./booksOwned.php"> Go Back </a><br><br>';

      //getting the maximum page number of the book from database
      if ($exec->num_rows > 0) {
          while ($row = $exec->fetch_assoc()) {
              $maxpage = $row["page"];
          }
      }
      $page = $_GET['page'];
      if($page == $maxpage){
        $next = $maxpage;
      } else{
        $next = $page + 1;
      }

      if($page == 1){
        $prev = 1;
      } else{
        $prev = $page - 1;
      }
      
      
      //set path to the file directory
      $path = './upload/'.$name.'/'.$page;
      $exts = array('png', 'jpg', 'jpeg');
      foreach($exts as $ext){
          if(file_exists($path.'.'.$ext)) {
              $newPath = $path . '.' . $ext;
          }
      }

      //html display file
      echo '<title>'.$name.'</title>';
      echo '<img src="'.$newPath.'" width="620px" height="620px" target="_blank"><br>';
      
      //next and previous button
      echo '<a href="./view.php?name='.$name.'&page='.$prev.'">Previous Page</a> <span style="padding-left: 450px;">';
      echo '<a href="./view.php?name='.$name.'&page='.$next.'">Next Page</a><br>';

      ?>
