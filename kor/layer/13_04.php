<?
/***************************************************************************************
*** What's New(구매자) : '취소' 화면
*** 2016-04-13 : '13_04s' 로 데이터 받아옴(class.odrinfo.php)
***************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>

<!-- layer-tab -->
<div class="layer-tab">
	<ul>
		<li><a href="#" class="view-sell"><img src="/kor/images/layer_tab_sell_off.png" alt="판매"></a><a href="#" class="btn-close"><img src="/kor/images/btn_layer_close.png" alt="close"></a></li>
		<li class="current"><a href="#" class="view-buy"><img src="/kor/images/layer_tab_buy_on.png" alt="구매"></a></li>
	</ul>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close.png" alt="close"></a>
</div>
<!-- //layer-tab -->

<!-- layer-left-menu -->
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/layer/buy_menu.php"); ?>
<!-- //layer-left-menu -->

<?
$recordcnt = 1;
//$searchand .= "and buy_mem_idx = ".$_SESSION["MEM_IDX"]." and status = 8 and confirm_yn='N' and fault_yn = 'Y'"; //기존 JSJ
$searchand .= "and buy_mem_idx = ".$_SESSION["MEM_IDX"]." and reg_mem_idx <> ".$_SESSION["MEM_IDX"]." and status = 8 and confirm_yn='N' and fault_yn = 'Y'";
$cnt = QRY_CNT("odr_history",$searchand);				
if ($cnt == 0 ){?>
<div class="layer-file">
		<table>
			<tbody>
				<tr>		
					
					<td class="c-red2 w100 t-ct"><!--취소 동의 내역이 없습니다.--></td>
				</tr>
			</tbody>
		</table>
	</div>	
<?}else{
	if (!$page){ $page = 1;}
	$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
	$result =QRY_ODR_HISTORY_LIST($recordcnt, $searchand, $page, "odr_history_idx desc");
	if($result){
		$row = mysql_fetch_array($result);
		$odr_idx= replace_out($row["odr_idx"]);	
	}
	?>
	<!-- //layer-left-menu -->

	<!-- layer-content -->
	<div class="layer-content">
		<!-- layer-pagination -->
		<div class="layer-pagination">
				<? 
				$layerNum="layer";
				$loadPage = "13_04";
				$varNum = "?mn=10&status=$status";			
				include $_SERVER["DOCUMENT_ROOT"]."/include/paging3.php"; ?>								
		</div>
		<!-- //layer-pagination -->
		<?//=GET_ODR_HISTORY_LIST("13_04",$odr_idx) //JSJ?>
		<?=GET_ODR_HISTORY_LIST("13_04s",$odr_idx) //2016-04-13?>
	</div>
	<!-- //layer-content -->
<?}?>
