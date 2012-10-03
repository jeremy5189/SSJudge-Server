<?php
include('db-info.php');
date_default_timezone_set("Asia/Taipei");
$code = $_POST['code'];
if( $code != $add_code ) exit();

$name = $_POST['name'];
$problemID = $_POST['problem'];
$status = $_POST['status'];
$cpp = urldecode(base64_decode($_POST['cpp']));
$time = date("Y-m-d H:i:s");


$linkID = mysql_connect( $db_Address, $db_Username, $db_Password);
mysql_select_db($db_Name);
mysql_query("SET NAMES UTF8;");

$str = "INSERT INTO $table_Name ";
$str .= "(`ID`,`Name`,`ProblemID`,`Status`,`Cpp`,`Time`) ";
$str .= "VALUES ";
$str .= "('','$name','$problemID','$status','$cpp','$time');";

mysql_query($str , $linkID);
mysql_close($linkID);

echo "done";

?>
