<? 
$sitename = "PARTStrike";
$headname = "PARTStrike";
$pageNum = replace_in($pageNum);
$subNum = replace_in($subNum);
$log_date = date("Y-m-d H:i:s");
$log_ip = $_SERVER['REMOTE_ADDR'];

//한페이지에 보여지는글수/페이지수
$recordcnt	=	10;		
$viewpagecnt =	10;

$se_path = $osdir."/upload/se";
$file_path = "/upload/file/";

$typ = replace_in($typ);
$idx = replace_in($idx);
$mode = replace_in($mode);
$page = replace_in($page);
$search = replace_in($search);
$strsearch = replace_in($strsearch);
$cate = replace_in($cate);
$config_sell_status = "status = 1 or status = 2 or status = 3 or status = 6 or status = 11 or status = 25  ";
$config_odr_sell_status = "odr_status = 1 or odr_status = 2 or odr_status = 3 or odr_status = 6 or odr_status = 11 or odr_status = 25  ";
//proc_ajax 의 fnProcReady(), function의 GET_MENU_CNT()도 같이 수정



if (!$page or $typ=="write")	$page = 1;

$param = "mode=$mode&page=$page&search=$search&strsearch=$strsearch&sch_title=$sch_title&cate=$cate&site=$site&rTy=$rTy&pTy=$pTy&OP=$OP";

//세션값 저장
$http_host = $_SERVER['HTTP_HOST'];
//default_img = "http://"&http_host&"/img/navi/kosia_logo.jpg"
//noimg = "http://"&http_host&"/img/navi/kosia_logo.jpg"

$session_mem_idx = $_SESSION["MEM_IDX"];			
$session_rel_idx = $_SESSION["REL_IDX"];			
$session_mem_id = $_SESSION["MEM_ID"];		
$session_com_idx = $_SESSION["REL_IDX"]==0?$_SESSION["MEM_IDX"]:$_SESSION["REL_IDX"];

$noimg= "http://$http_host/images/common/logo.png";
?>
