<?
/********************************************************************************
*** What's New : 반품방법(불량통보)
********************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.record.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<SCRIPT LANGUAGE="JavaScript">
$(document).ready(function(){
	$(".t-partno").css("width","160px");
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
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/layer/buy_menu.php"); ?>
<!-- //layer-left-menu -->

<?
	$recordcnt = 1;
	$searchand .= "and reg_mem_idx <> ".$_SESSION["MEM_IDX"]." and (sell_mem_idx = ".$_SESSION["MEM_IDX"]." or buy_mem_idx = ".$_SESSION["MEM_IDX"].") and status = $status and confirm_yn = 'N'"; 			
	$cnt = QRY_CNT("fty_history",$searchand);				
	if ($cnt > 0) { 
			if (!$page){ $page = 1;}
			$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
			$result =QRY_RCD_HISTORY_LIST($recordcnt, $searchand, $page, "fty", "fty_history_idx desc");
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
				<div class="layer-pagination red">
						<? 
						$layerNum="layer";
						$loadPage = "21_1_07";
						$varNum = "?mn=29&status=$status";			
						include $_SERVER["DOCUMENT_ROOT"]."/include/paging3.php"; ?>								
				</div>
				<!-- //layer-pagination -->
				<?=GET_RCD_HISTORY_LIST("21_1_07", $odr_det_idx, "fty")?>
			
			</div>
			<!-- //layer-content -->
<?}?>
