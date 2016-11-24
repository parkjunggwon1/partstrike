<?
/***********************************************************************************************
*** What's New : 수량부족(구매자) 19_08
***********************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.record.php";
?>
<Script Language="javascript">
	$(document).ready(function(){
		$("#layerPop .stock-list-table tbody:eq(0) tr:eq(0) td").addClass("first");
	});
	function show_msg(idx){
		$("#msg_cont_"+idx).toggle("fast");
	}
</script>
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
$searchand .= "and reg_mem_idx <> ".$_SESSION["MEM_IDX"]." and status = $status and confirm_yn = 'N'"; 			
$cnt = QRY_CNT("odr_history",$searchand);				
if ($cnt == 0 ){?>
<div class="layer-file">
		<table>
			<tbody>
				<tr>		
					
					<td class="c-red2 w100 t-ct"><!--판매자가 발송한 수량부족 건이 없습니다.--></td>
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
		$odr_det_idx = replace_out($row["odr_det_idx"]);
		$fault_quantity = get_any("odr_det", "fault_quantity", "odr_idx=$odr_idx AND odr_det_idx=$odr_det_idx");
	}
	?>
	<!-- //layer-left-menu -->
	<input type="hidden" name="fault_quantity" id="fault_quantity" value="<?=$fault_quantity;?>">
	<!-- layer-content -->
	<div class="layer-content">
		<!-- layer-pagination -->
		<div class="layer-pagination">
				<? 
				$layerNum="layer";
				$loadPage = "19_08";
				$varNum = "?mn=0$status&status=$status";			
				include $_SERVER["DOCUMENT_ROOT"]."/include/paging3.php"; ?>								
		</div>
		<!-- //layer-pagination -->
		<?=GET_ODR_HISTORY_LIST("19_08", $odr_idx, $odr_det_idx)?>
	</div>
	<!-- //layer-content -->
<?}?>



	