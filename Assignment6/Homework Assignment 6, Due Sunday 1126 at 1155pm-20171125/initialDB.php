<?php

// include once 'database_HW6F17.php';

// Create connection


$conn = mysqli_connect('cse-curly.cse.umn.edu','F17CS4131U15','2447','F17CS4131U15','3306');

if ($conn -> connect_error){
    // report error
    die("Connection failed: " . mysqli_connect_error());
} else {
    // setup your query
    echo "Connected successfully";

    // Create my Table
    $sql = "CREATE TABLE tbl_accounts (
        acc_id INT(8) PRIMARY KEY,
        acc_name VARCHAR(30),
        acc_login VARCHAR(20),
        acc_password VARCHAR(20)
        )";

    if ($conn->query($sql) === TRUE) {
        echo "Table tbl_accounts created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    $conn->close();
}


//mypasswordis8507


 ?>
