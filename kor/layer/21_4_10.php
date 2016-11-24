<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.record.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
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
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/layer/sell_menu.php"); ?>
<!-- //layer-left-menu -->
<?//수령 paging이 odr_det별로 됨.
	  
	$recordcnt = 1;
	$searchand .= "and reg_mem_idx <> ".$_SESSION["MEM_IDX"]." and sell_mem_idx = ".$_SESSION["MEM_IDX"]."  and status = $status and confirm_yn = 'N'"; 			
    
	
	
	$cnt = QRY_CNT("fty_history",$searchand);				
	if ($cnt >0 ) { 
			if (!$page){ $page = 1;}
			$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
			$result =QRY_RCD_HISTORY_LIST($recordcnt, $searchand, $page, "fty","fty_history_idx desc");
			if($result){
				$row = mysql_fetch_array($result);
				$odr_idx= replace_out($row["odr_idx"]);	
				$odr_det_idx= replace_out($row["odr_det_idx"]);	
				$loadPage = "21_4_10";
			}
			
		?>
			<!-- //layer-left-menu -->

			<!-- layer-content -->
			<div class="layer-content">
				<!-- layer-pagination -->
				<div class="layer-pagination red">
						<? 
						$layerNum="layer";
						$varNum = "?mn=18&status=$status";			
						include $_SERVER["DOCUMENT_ROOT"]."/include/paging3.php"; ?>								
				</div>
				<!-- //layer-pagination -->
				<?echo GET_RCD_HISTORY_LIST($loadPage, $odr_det_idx , "fty")?>
			
			</div>
			<!-- //layer-content -->
	<?}?>
<!-- //layer-left-menu -->
