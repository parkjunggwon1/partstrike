<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>

<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<script>ready();</script>
<SCRIPT LANGUAGE="JavaScript">
$(document).ready(function(){
	$("#layerPop .stock-list-table tbody:eq(0) tr:eq(0) td").addClass("first");
});
</SCRIPT>
<!-- layer-tab -->
<div class="layer-tab">
	<ul>
		<li class="current"><a href="#" class="view-sell"><img src="/kor/images/layer_tab_sell_on.png" alt="판매"></a></li>
		<li><a href="#" class="view-buy"><img src="/kor/images/layer_tab_buy_off.png" alt="구매"></a></li>
	</ul>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<!-- //layer-tab -->

<!-- layer-left-menu -->
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/layer/sell_menu.php"); 
$recordcnt = 1;
$searchand .= "and sell_mem_idx = ".$_SESSION["MEM_IDX"]." and status = $status and confirm_yn = 'N'"; 			


$cnt = QRY_CNT("odr_history",$searchand);				

if ($cnt == 0 ){?>
<div class="layer-file" style="border-top:0">
		<table>
			<tbody>
				<tr>		
					
					<td class="c-red2 w100 t-ct"><!--처리할 납기 확인 요청건이 없습니다.--></td>
				</tr>
			</tbody>
		</table>
	</div>	
<?}else{
	if (!$page){ $page = 1;}
	$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
//	echo $searchand;
	$result =QRY_ODR_HISTORY_LIST($recordcnt, $searchand, $page, "odr_history_idx desc");
	if($result){
		$row = mysql_fetch_array($result);
		$odr_idx= replace_out($row["odr_idx"]);	
		$odr_det_idx= replace_out($row["odr_det_idx"]);	
	}
	?>
	<!-- //layer-left-menu -->
	<!-- layer-content -->
	<div class="layer-content">
		<!-- layer-pagination -->
		<div class="layer-pagination">
		<? 
		$layerNum="layer";
		$loadPage = "31_04";
		$varNum = "?mn=0$status&status=$status";			
		include $_SERVER["DOCUMENT_ROOT"]."/include/paging3.php"; ?>
		</div>  
		<!-- //layer-pagination -->
		<?=GET_ODR_HISTORY_LIST("31_04", $odr_idx , $odr_det_idx)?>
	</div>
	<!-- //layer-content -->
<?}?>

