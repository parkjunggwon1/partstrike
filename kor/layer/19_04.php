<?
/**********************************************************************************************************
*** 수량입력(19_04) : 수량부족 및 거절(반품, 교환) 시 수량(fault_quantity)입력
*** 2016-05-16 : 전체 거절 일 경우 운임 입력 받아야 한다.
**********************************************************************************************************/
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";

$act_txt = ($fault_method==3)? "부족":"거절";

//모두 거절 일 경우 때문에 아래 계산, '부족' 시에는 불 필요
if($det_cnt==0){	//마지막 아이템 일 경우
	//기존 supply_quantity 합계
	$supply_sum = get_any("odr_det", "SUM(supply_quantity)", "odr_idx = $odr_idx");
	//기존 fault_quantity 합계
	$fault_sum = get_any("odr_det", "SUM(fault_quantity)", "odr_idx = $odr_idx");
}

?>
<SCRIPT LANGUAGE="JavaScript">
	function checkActive(){
		var fault_quantity = $("#fault_quantity").val();
		if(fault_quantity > 0){
			$("#btn_19_04").css("cursor","pointer").addClass("btn-dialog-1905").attr("src","/kor/images/btn_ok.gif");
		}else{
			$("#btn_19_04").css("cursor","").removeClass("btn-dialog-1905").attr("src","/kor/images/btn_ok_1.gif");
		}
	}
	$(document).ready(function(){
		checkActive();
		$('#fault_quantity').keyup( function(event){   // 숫자 입력 하면 ,로 단위 끊어 표시하게.
			checkActive();
		});
	});
</SCRIPT>
<div class="layer-hd">
	<h1><?=($fault_method==3)? "수량 부족":"거절";?></h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form>
		<div class="txt-warning t-ct"><?=$act_txt?> 수량 개수를 입력 바랍니다. </div>
		<div class="mr-tb15 t-ct">
			<label class="c-red2"><span><?=$act_txt?> 수량 개수 : </span><input type="text" class="i-txt2 c-blue t-rt" id="fault_quantity" name="fault_quantity" value="" style="width:67px"> <span lang="en">EA</span></label>
		</div>
		<div class="btn-area t-rt">
				<img id="btn_19_04" src="/kor/images/btn_ok.gif" fault_method="<?=$fault_method;?>" fault_sum="<?=$fault_sum;?>" supply_sum="<?=$supply_sum;?>" odr_idx="<?=$odr_idx;?>" odr_det_idx="<?=$odr_det_idx?>" alt="확인">
		</div>
	</form>
</div>

