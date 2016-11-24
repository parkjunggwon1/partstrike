<?
/***************************************************************************************************
*** What's New : 선적 완료(구매) 30_20
***************************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.record.php";
// multi history : 12_06 참고하기
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<script>ready();</script>
<SCRIPT LANGUAGE="JavaScript">
<!--
//버튼 활성 비활성 하자
function checkActive(){
	//alert($("input:checkbox[name^=odr_det_idx]").length);
	//$("input:checkbox[name^=odr_det_idx]").hide();
	if ($("input:checkbox[name^=odr_det_idx]").length == 0)
	{
		$("#btn_3020_1").css("cursor","pointer").addClass("btn-pop-1904").attr("src","/kor/images/btn_lack.gif").attr("fault_method","3"); //수량부족
		$("#btn_3020_2").css("cursor","pointer").addClass("btn-pop-18R04").attr("src","/kor/images/btn_refuse.gif");  //거절
		$("#btn_3020_3").css("cursor","pointer").addClass("btn-dialog-3021").attr("src","/kor/images/btn_receipt.gif");	//수령		
		return;
	}

	if($("input[name^=odr_det_idx]").length>1){ //-- 여러개 일때 --------------------------
		sel_box = $("input[name^=odr_det_idx]:checked");
		selCnt = sel_box.length;
	}else{	//-- 한개일때 ---------------------------------------
		sel_box = $("input[name^=odr_det_idx]");
		selCnt=1;
		$("#guide_3020").hide();
	}
	//수량부족, 거절
	if(selCnt == 1){
		$("#btn_3020_1").css("cursor","pointer").addClass("btn-pop-1904").attr("src","/kor/images/btn_lack.gif").attr("fault_method","3"); //수량부족
		$("#btn_3020_2").css("cursor","pointer").addClass("btn-pop-18R04").attr("src","/kor/images/btn_refuse.gif");  //거절
	}else{
		$("#btn_3020_1").css("cursor","").removeClass("btn-pop-1904").attr("src","/kor/images/btn_lack_1.gif"); //수량부족
		$("#btn_3020_2").css("cursor","").removeClass("btn-pop-18R04").attr("src","/kor/images/btn_refuse_1.gif");  //거절
	}
	//수령
	if(selCnt > 0){
		$("#btn_3020_3").css("cursor","pointer").addClass("btn-dialog-3021").attr("src","/kor/images/btn_receipt.gif");	//수령
	}else{
		$("#btn_3020_3").css("cursor","").removeClass("btn-dialog-3021").attr("src","/kor/images/btn_receipt_1.gif");	//수령
	}
	//fault 수령버튼
	if($("#fault_yn").val() == "Y"){
		$("#btn_3020_3").css("cursor","").removeClass("btn-dialog-3021").attr("src","/kor/images/btn_receipt_1.gif");	//수령
		$("#btn_3020_3").css("cursor","pointer").addClass("btn-dialog-3021-f").attr("src","/kor/images/btn_receipt.gif");	//수령
	}
}
function show_msg(idx){
	$("#msg_cont_"+idx).toggle("fast");
}
$(document).ready(function(){
	$("#layerPop .stock-list-table tbody:eq(0) tr:eq(0) td").addClass("first");
	//-- 옵션(체크박스) 클릭
	$("#layerPop .stock-list-table input[name^=odr_det_idx]").click(function(e){
		checkActive();
	});
	checkActive();
});
//-->
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
if ($status=="") { $status ="21";}
$searchand .= "and buy_mem_idx = ".$_SESSION["MEM_IDX"]." and status = $status and confirm_yn='N'"; 		

$cnt = QRY_CNT("odr_history",$searchand);				
if ($cnt == 0 ){?>
<div class="layer-file">
		<table>
			<tbody>
				<tr>		
					
					<td class="c-red2 w100 t-ct"><!--선적완료된 내역이 없습니다.--></td>
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
		$fault_yn = replace_out($row["fault_yn"]);
	}
	$det_cnt = QRY_CNT("odr_det"," and odr_idx=$odr_idx ");  //odr_det 수량
	?>
	<!-- //layer-left-menu -->

	<!-- layer-content -->
	<div class="layer-content">
		<!-- layer-pagination -->
		<div class="layer-pagination">
				<? 
				$layerNum="layer";
				$loadPage = "30_20";
				$varNum = "?mn=08&status=$status";			
				include $_SERVER["DOCUMENT_ROOT"]."/include/paging3.php"; ?>
		</div>
		<!-- //layer-pagination -->
		<?
		if($fault_yn == 'Y'){
			//echo "/FAULT=Y";
			echo GET_ODR_HISTORY_LIST("30_20_F", $odr_idx, $odr_det_idx);
		}else{
			//echo "/FAULT=N";
			echo GET_ODR_HISTORY_LIST("30_20", $odr_idx);
		}
		?>
		<input type="hidden" name="fault_yn" id="fault_yn" value="<?=$fault_yn;?>">
	</div>
	<!-- //layer-content -->
<?}?>