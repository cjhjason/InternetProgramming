<?php
// chen4566
// Jinhao Chen

$uName = $_POST["UserName"];
$uPass = $_POST["UserPass"];
$sql = 'SE;ECT * FROM Users WHERE Name = "'.$uName.'"AND Pass = "'.$uPass.'" ;';

// 1.
$_POST["UserName"] = "or";
$_POST["UserPass"] = "or";
// If the user only Name will  WHERE Name = '' or '' same as password
// inside or clause
// null = null always true "null=null"


// 2.
$_POST["UserName"] = "=";
$_POST["UserPass"] = "=";
// If the user only Name will  WHERE Name = '' = '' same as password. result will always be true




 ?>
