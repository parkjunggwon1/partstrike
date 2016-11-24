<?
session_start();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
include $_SERVER["DOCUMENT_ROOT"]."/include/function.php";

$mem_name = $_SESSION["MEM_NM"];
// 쿠키 생성
$_SESSION["MEM_IDX"]="";			
$_SESSION["MEM_ID"]="";	
$_SESSION["MEM_TYPE"]=	"";
$_SESSION["REL_IDX"]="";		
$_SESSION["MEM_NM"]="";	
$_SESSION["POS_NM"]="";
$_SESSION["MEM_NM_EN"]="";	
$_SESSION["POS_NM_EN"]="";
$_SESSION["NATION"]="";
$_SESSION["COM_IDX"]="";			
$_SESSION["DEPOSIT"]="";			



Page_Parent_Url("/kor/");
?>
