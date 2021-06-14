<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if name is empty
    if(empty(trim($_POST["name"]))){
        $username_err = "Please enter name.";
    } else{
        $name = trim($_POST["name"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, name, password FROM student WHERE name = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $name;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if name exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $name, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if($password = $hashed_password){
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["name"] = $name;

                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if name doesn't exist
                    $username_err = "No account found with that name.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{   font: 14px sans-serif; 
                color:white;
                background-image: url("background.png");
                background-repeat: no-repeat;
                background-size: 100%;}
        
        .border{    font-size: 45px;
                    font-weight: bold; 
                    margin-top:60px;
                    text-decoration: underline;
                    letter-spacing: 5px;
                    text-shadow: 2px 2px 10px blue;
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
                    background: rgba(0,0,0,0.7); }
    </style>
</head>

<body>
<div class="border">
        <p>Library System</p>
</div>

<div class="max-width">
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
            <p>Admin? <a href="admin.php">Login as Admin here</a></p>
        </form>
    </div>
    </div>
</body>
</html>
