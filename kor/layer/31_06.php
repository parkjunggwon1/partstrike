<?@header("Content-Type: text/html; charset=utf-8");
/**************************************************************************************
What's New => '납기확인이 완료되었습니다.'
**************************************************************************************/
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<SCRIPT LANGUAGE="JavaScript">
$(document).ready(function(){
	$("#layerPop .stock-list-table tbody:eq(0) tr:eq(0) td").addClass("first");
});
</SCRIPT>
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
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/layer/buy_menu.php"); 
$recordcnt = 1;
$searchand .= "and buy_mem_idx = ".$_SESSION["MEM_IDX"]." and status = $status and confirm_yn = 'N'"; 			
//echo $searchand;

$cnt = QRY_CNT("odr_history",$searchand);				

if ($cnt == 0 ){?>
<div class="layer-file">
		<table>
			<tbody>
				<tr>		
					
					<td class="c-red2 w100 t-ct"><!--납기 확인 완료건이 없습니다.--></td>
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
		if (QRY_CNT("odr_history", "and  odr_idx = $odr_idx and status = 19 ")>0){  //물건이 도착한 상태에서 납기 확인을 한 것임으로 도착 탭으로 점핑해야 함.
			ReopenLayer("layer","01_37","?mn=04");

		}
	}
	?>
	<!-- //layer-left-menu -->

	<!-- layer-content -->
	<div class="layer-content">
		<!-- layer-pagination -->
		<div class="layer-pagination">
				<? 
				$layerNum="layer";
				$loadPage = "31_06";
				$varNum = "?mn=0$status&status=$status";			
				include $_SERVER["DOCUMENT_ROOT"]."/include/paging3.php"; ?>								
		</div>
		<!-- //layer-pagination -->
		<?=GET_ODR_HISTORY_LIST("31_06", $odr_idx)?>
	</div>
	<!-- //layer-content -->
<?}?>
