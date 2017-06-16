<?
/***************************************************************************************************************
**** 수령 POP : 30_21
**************************************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<div class="layer-hd">
	<h1><?if ($ty =="Delay"){?>지연<?}else{?>수령<?}?>(3021)</h1>
	<?if ($ty == ""){ $ty = "succEnd";}?>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<?
$det_cnt = QRY_CNT("odr_det"," and odr_idx=$odr_idx ");  //odr_det 수량
?>
<div class="layer-content">
	<form name="f" id="f">
		<!-- form1 -->
		<input type="hidden" name="typ" id="typ_3021" value="<?=$ty?>">
		<input type="hidden" name="odr_idx" id="odr_idx_3021" value="<?=$odr_idx?>">		
		<!-- 주문이 완료 되기 위한 일련번호 추가 hidden 값-->
		<input type="hidden" name="odr_det_idx" id="odr_det_idx" value="<?=$odr_det_idx?>">
		<input type="hidden" name="det_cnt" id="det_cnt_3021" value="<?=$det_cnt?>">
		<!-- //form1 -->
	</form>

		
		<div id="file_30_21" class="layer-file"></div>
		<div class="layer-data">
			<table class="stock-list-table" id="list_30_21">				
			</table>
		</div>
		
		<div class="btn-area t-rt">
			<button type="button" class="<?=$ty?>" odr_idx="<?=$odr_idx?>"><img src="/kor/images/btn_transmit.gif" alt="종료"></button>
		</div>
	
</div>



<SCRIPT LANGUAGE="JavaScript">
<!--

$(document).ready(function(){	
	$("#list_30_21").html($("#list_<?=$loadPage?>").html());
	<?if ($ty == "Delay"){?> 
		$("#layerPop3 .noinput:eq(0)").css("display","none");
		$("#file_30_21").html($("#file_<?=$loadPage?>").html());
		$("#file_30_21 td:eq(1)").html("1 Week 자동연장");
	<?}else{?>
		//수령 일때 
		var odr_det = "<?=$odr_det_idx?>";
		var ary = odr_det.split(",");
		$("#list_30_21 tbody[id^=tbd]").css("display","none");
		$("#list_30_21 tr[id^=tr_]").parent("tbody").css("display","none");
		$("#list_30_21 tr[id^=tr_]").css("display","none");
		$("#list_30_21 tr.bg-none").css("display","none");		
		//$("#list_30_21 th:eq(0)").remove();

		for (i=0;i<ary.length;i++)
		{
			
			$("#list_30_21 #tr_"+ary[i]).parent("tbody").css("display",""); 
			$("#list_30_21 #tr_"+ary[i]).css("display","");
			$("#list_30_21 #tr_"+ary[i]).next("tr").css("display",""); 
			//$("#list_30_21 #tr_"+ary[i]).find("td:eq(0)").remove();
			$("#list_30_21 #detail_"+ary[i]).remove();  //2016-04-24 부품상태 등 세부정보 생략
		}
		

	<?}?>


});
-->
</SCRIPT>