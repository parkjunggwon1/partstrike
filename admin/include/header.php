<?
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.board.php";
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/admin.php";
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/mode_title.php";
?>
<head>
<title><?=$headname?> 관리자페이지입니다</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<LINK href="/admin/style.css" rel="StyleSheet" title="style" type="text/css">
<script language=javascript src='/include/function.js'></script>
 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>

</head>
<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/menu.php";


?>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"  align="center">