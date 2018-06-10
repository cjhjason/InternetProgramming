<?php

$new_name = "someone";
$new_login_acc = "some";
$new_login_password = "xxxx";



// Get All
$table = "SELECT * FROM tbl_accounts";


// check login account
$query = "SELECT acc_login FROM tbl_accounts WHERE acc_login = $new_login_acc";
$result = $conn -> query($query);
if($result){
    // LOGIN NAME ALREADY EXIST
}else {
    // INSERT
    $new_name = "";
    $query = "INSERT INTO tbl_accounts (acc_name, acc_login, acc_password) VALUES ($new_name, $new_login_acc, '". sha1($new_login_password)."');"
    $result = $conn -> query($query);
}


// DELETE
$loginid_need_to_be_delete = "some2"
$query = "DELETE FROM tbl_accounts WHERE acc_id = $loginid_need_to_be_delete;";
$result = $conn -> query($query);

// UPDATE
$loginid_need_to_be_update = "some2"
$query = "  UPDATE tbl_accounts
            SET acc_name = $new_name, acc_login = $new_login_acc, acc_password = $new_login_password
            WHERE acc_id = $loginid_need_to_be_update;"
$result = $conn -> query($query);

 ?>
