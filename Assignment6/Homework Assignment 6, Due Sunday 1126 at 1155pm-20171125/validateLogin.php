<?php
//Connect Database
error_reporting(E_ALL);
ini_set( 'display_errors','1');
$con= mysqli_connect('cse-curly.cse.umn.edu','F17CS4131U15','mypasswordis8507','F17CS4131U15','3306');
// Check connection
if (mysqli_connect_errno())
  {
  echo 'Failed to connect to MySQL:' . mysqli_connect_error();
  }

session_start();

if (isset($_POST['name']) and isset($_POST['password'])){


    //Assigning posted values to variables.
    $name = $_POST['name'];
    // sha1 encode
    $password = sha1($_POST['password']);

    //Checking the values are existing in the database or not
    $query = "SELECT * FROM `tbl_accounts` WHERE acc_login='$name' and acc_password='$password'";

    $result = mysqli_query($con, $query) or die(mysqli_error($con));
    $count = mysqli_num_rows($result);


    //If the posted values are equal to the database values, then session will be created for the user.
    if ($count == 1){
        $_SESSION['username'] = $name;
    }else{
        //If the login credentials doesn't match, he will be shown with an error message.
        $fmsg = "Invalid Login Credentials.";
        }
}
//if the user is logged in Greets the user with message
if (isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    echo "Hi " . $username . "";
    echo "This is the Members Area";
    echo "<a href='logout.php'>Logout</a>";
    }else{
        //When the user visits the page first time, simple login form will be displayed.
    }




 ?>
