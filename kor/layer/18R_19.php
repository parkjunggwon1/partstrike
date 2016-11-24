<?
/******************************************************************************************************************
*** What's New : 반품선적완료(판매자) 18R-19
*** 2016-05-10 : 반품은 한 건씩 처리 하므로, 옵션상자 없애고 발주수량을 반품수량으로 변경 등 컬럼 항목 수정
*******************************************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.record.php";
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

<!-- layer-left-menu -->
<?$recordcnt = 1;
$searchand .= "and sell_mem_idx = ".$_SESSION["MEM_IDX"]." and status = $status and confirm_yn = 'N'"; 			
$cnt = QRY_CNT("odr_history",$searchand);				
if ($cnt == 0 ){?>
<div class="layer-file">
		<table>
			<tbody>
				<tr>		
					
					<td class="c-red2 w100 t-ct"><!--반품 선적 완료 건이 없습니다.--></td>
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
				$loadPage = "18R_19";
				$varNum = "?mn=0$status&status=$status";			
				include $_SERVER["DOCUMENT_ROOT"]."/include/paging3.php"; ?>								
		</div>
		<!-- //layer-pagination -->
		<?=GET_ODR_HISTORY_LIST("18R_19", $odr_idx,$odr_det_idx)?>
	</div>
	<!-- //layer-content -->
<?}?>


<SCRIPT LANGUAGE="JavaScript">
<!--
$(document).ready(function(){
	$("#data_18R_19 .stock-list-table tbody:eq(0) tr:eq(0) td").addClass("first");
	var $input = $("input:checkbox[name^=odr_det_idx]:enabled");
	if($input.length==1){  //하나일 때는 default로 체크
		$input.prop("checked",true);
		$input.addClass("checked");
		$input.attr("disabled",true);
		$("#del_1_"+$input.val()).show();
		$("#del_"+$input.val()).hide();
	}
});
	function show_msg(idx){
		$("#msg_cont_"+idx).toggle("fast");
	}
//-->
</SCRIPT>