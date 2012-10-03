<?php
$add_table_str = "CREATE TABLE  `data_contest` (
 `ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
 `Name` TEXT NOT NULL ,
 `ProblemID` TEXT NOT NULL ,
 `Status` TEXT NOT NULL ,
 `Cpp` TEXT NOT NULL ,
 `Time` DATETIME NOT NULL
) ENGINE = MYISAM ;";

include('db-info.php');

$linkID = mysql_connect( $db_Address, $db_Username, $db_Password);
mysql_select_db($db_Name);
mysql_query("SET NAMES UTF8;");

$ret = mysql_query($add_table_str , $linkID);
if($ret)
	echo "MySQL Database Table installed!";
else
	echo "MySQL Database Error, please check your db-info.php";
?>
