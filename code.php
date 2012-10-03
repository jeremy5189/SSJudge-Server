<?php
include('db-info.php');
iconv_set_encoding("output_encoding", "Windows-1252");
if( $_GET['q'] != $dl_code ) exit();

$ID = $_GET['c'];

$linkID = mysql_connect( $db_Address, $db_Username, $db_Password);
mysql_select_db($db_Name);
mysql_query("SET NAMES UTF8;");

$str = "SELECT * FROM $table_Name WHERE id=$ID;";
$result = mysql_query($str , $linkID);
list($pid,$name,$pname,$status,$code,$time) = mysql_fetch_row($result);
mysql_close($linkID);

$name = str_replace("\r","",$name);
$name = str_replace("\n","",$name);

$header  = "/***********************************************/\r\n";
$header .= "/*  Problem: $pname\r\n";                                 
$header .= "/*  Result: $status by SSJudge(ID:$ID)\r\n";           
$header .= "/*  Author: $name at $time\r\n";  
$header .= "/***********************************************/\r\n";

$code = str_replace("\$n","\\n",$code);
$file_content = $header . "\r\n\r\n" . $code;
mb_convert_encoding($file_content,"Windows-1252","UTF-8");
$file_name = $pname."($ID).cpp";

header('Content-type:application/force-download'); //告訴瀏覽器 為下載 
header('Content-Transfer-Encoding: binary'); //編碼方式
header("Content-Disposition:attachment;filename=$file_name"); //檔名
//echo iconv("UTF-8", "Windows-1252", $file_content);
echo $file_content;

?>
