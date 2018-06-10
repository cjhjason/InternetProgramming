<?php
$dquery = 'DELETE FROM tbl_accounts WHERE acct_id = '.(int)$acct_id.'Limit 1;';
$cquery = 'INSERT INTO tbl_accounts (acc_login, acc_name, acc_password) VALUES (\''.$acc_login.'\',\''.$acc_name.'\',\''.sha1($acc_password).'\');';
$uquery = 'UPDATE tbl_accounts SET acc_login = \''.$acc_login.'\', acc_name = \''.acc_name = \''.$acc_name.'\', 


 ?>
