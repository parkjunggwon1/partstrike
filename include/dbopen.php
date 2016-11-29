<?
session_start();
$osdir = $_SERVER["DOCUMENT_ROOT"];


$conn=mysql_connect("localhost","root","wjdrnjs1");  // 서버 /ID/pw
mysql_select_db("pjg0319", $conn); // DB 명 수정
mysql_query("SET NAMES UTF8");

?>
<?
include $osdir."/include/function.php";

include $osdir."/include/config.php";

include $osdir."/sql/sql.php";

?>