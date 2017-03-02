<?

$conn=mysql_connect("localhost","evictor23","whgdmstodrkr2710");  // 서버 /ID/pw
mysql_select_db("evictor23", $conn); // DB 명 수정




$sql = "truncate `odr`";
$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

$sql = "truncate `odr_det`";
$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

$sql = "truncate `odr_history`";
$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

$sql = "truncate `mybox`";
$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());



header('Location: /kor/index.php');
?>