<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>SSJudge</title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<style type="text/css">
	</style>
	
</head>
<body>

<?php

include('db-info.php');
if( $_GET['q'] != $access ) exit();

//防止注入
$sort = $_GET['s'];
if( $sort != "Name" && $sort != "ProblemID" && $sort != "Time" && $sort != "Status" )
	$sort = "no";


$linkID = mysql_connect( $db_Address, $db_Username, $db_Password);
mysql_select_db($db_Name);
mysql_query("SET NAMES UTF8;");

$display_id = $_GET['c'];
// 顯示程式碼頁面
if( isset($_GET['c']) && Is_Numeric ($display_id) )
{
	echo "
	<script type=\"text/javascript\" src=\"syhi/scripts/shCore.js\"></script>
	<script type=\"text/javascript\" src=\"syhi/scripts/shBrushCpp.js\"></script>
	<link type=\"text/css\" rel=\"stylesheet\" href=\"syhi/styles/shCoreDefault.css\"/>
	<script type=\"text/javascript\">SyntaxHighlighter.all();</script>";
	
	$str = "SELECT `Cpp` FROM $table_Name WHERE id=$display_id;";
		
	$result = mysql_query($str , $linkID);
	list($Cpp) = mysql_fetch_row($result);
	mysql_close($linkID);
	
	$Cpp = str_replace("\$n","\\n",$Cpp);
	echo "<a href=\"result.php?q=$access\">Go Back</a><hr/>";
	echo "<pre class=\"brush: cpp;\">".htmlspecialchars($Cpp)."</pre>";
}
else
{
	echo "<center><h2>SSJudge結果顯示器</h2>";
	echo "<p><a href=\"$teacher_website\">老師網站</a> &middot;";
	echo "<a href=\"list.php?q=$access\">題目列表</a> &middot;";
	echo "<a href=\"download/ssjudge-latest.zip\">最新版本</a> &middot;";
	echo "<a href=\"result.php?q=$access&s=Name\">姓名排序</a> &middot;";
	echo "<a href=\"result.php?q=$access&s=ProblemID\">題目排序</a> &middot;";
	echo "<a href=\"result.php?q=$access&s=Status\">狀態排序</a> &middot;";
	echo "<a href=\"result.php?q=$access&s=Time\">時間排序</a></p>";
	echo "<table border=\"1\" style=\"border-collapse:collapse;text-align:center;width:700px;\" borderColor=\"black\">
<tr><th>ID</th><th>姓名</th><th>題目</th><th>狀態</th><th>程式碼</th><th>時間</th><th>下載</th></tr>";

	if( $sort != "no" )
		$str = "SELECT `ID`,`Name`,`ProblemID`,`Status`,`Time` FROM $table_Name ORDER BY `$sort`;";
	else
		$str = "SELECT `ID`,`Name`,`ProblemID`,`Status`,`Time` FROM $table_Name ORDER BY `time;";
	
	$result = mysql_query($str , $linkID);
	$rows = mysql_num_rows($result);

	for( $i = 0; $i < $rows; $i++ )
	{
		list($ID,$Name,$ProblemID,$Status,$Time) = mysql_fetch_row($result);
		echo "<tr>"; // 表格: 列
		echo "<th>".($i+1)."</th>";
		echo "<th>$Name</th>"; 
		echo "<th>$ProblemID</th>";
	
		if( $Status == "AC" ) 
			echo "<th><font color=\"#00BB00\">$Status</font></th>";
		else
			echo "<th>$Status</th>";

		echo "<th><a href=\"result.php?q=$access&c=$ID\">View Code</a></th>";
	
		echo "<th>$Time</th>";
		echo "<th><a href=\"code.php?q=$code_access&c=$ID\">CPP</a></th>";
		echo "</tr>";
	}

	echo "</table></center>";
}

?>
</body>
</html>
