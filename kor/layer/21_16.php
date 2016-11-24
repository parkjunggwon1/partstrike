<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.record.php";
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
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/layer/buy_menu.php"); 

	//불량통보는 paging이 odr_det별로 됨.
	$recordcnt = 1;
	$searchand .= "and  (buy_mem_idx = ".$_SESSION["MEM_IDX"].") and status = $status and confirm_yn = 'N'"; 			
	$cnt = QRY_CNT("fty_history",$searchand);				

	
	if ($cnt > 0 ) {
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
						$loadPage = "21_16";
						$varNum = "?mn=0$status&status=$status";			
						include $_SERVER["DOCUMENT_ROOT"]."/include/paging3.php"; ?>								
				</div>

				
				<!-- //layer-pagination -->
				<?=GET_RCD_HISTORY_LIST("21_16", $odr_det_idx,"fty")?>
			
			</div>
			<!-- //layer-content -->

	
<?}?>