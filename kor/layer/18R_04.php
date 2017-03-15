<?
/************************************************************************************************************
** 운임입력창(18R_04) : 거절(반품 및 교환) 시 마지막 물품 거절 시점에
** 2016-05-16 : 앞에서 입력 받은 거절 수량 전달(18R_05)
************************************************************************************************************/
?>
<script>ready();</script>
<div class="layer-hd">
	<h1>운임</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form>
		<div class="txt-warning">운임을 입력해 주시기 바랍니다. 문제가 발생했을 때, 운임이 입력되어 있지 않다면 운임을 환불받으실 수 없습니다. </div>
		<div class="mr-tb15 t-ct">
			<label class="c-red2">운임 <span lang="en">US$</span> : <input type="text" class="i-txt2 c-blue onlynum numfmt" name="buyer_delivery_fee" id="buyer_delivery_fee" value="" style="width:67px"></label>
		</div>
		<div class="btn-area t-rt">
			<button type="button" class="btn_delivery_18R_05" odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>" det_cnt="<?=$det_cnt?>" ><img src="/kor/images/btn_ok.gif" alt="확인"></button>
		</div>
	</form>
</div>

<script type="text/javascript">
	//운임 입력 창(구매자) - 거절 시(마지막 아이템에서)
	
	$(".btn_delivery_18R_05").click(function(){

		var odr_idx = $(this).attr("odr_idx");
 		var odr_det_idx = $(this).attr("odr_det_idx");
		var det_cnt = $(this).attr("det_cnt");
		var f =  document.f6;
		if ($("#buyer_delivery_fee").val()=="")
		{
			alert_msg("운임을 입력해 주세요.");
			$("#buyer_delivery_fee").focus();			
		}else{
			maskoff();
			$.ajax({
					url: "/kor/proc/odr_proc.php", 
					data: "typ=updbuyerdelifee&odr_idx="+odr_idx+"&buyer_delivery_fee="+$("#buyer_delivery_fee").val(),
					encType:"multipart/form-data",
					success: function (data) {	
						if (trim(data) == "SUCCESS"){
							

							$(".btn-area.t-rt button").attr("onclick","alert_msg('처리중입니다.')");
							f.typ.value="refuse";
							f.target = "proc";
							f.action = "/kor/proc/odr_proc.php";
							f.submit();	
							alert_msg("답변 하였습니다.");
							//closeCommLayer("layer4");
							//openLayer("layer3","18R_05","?odr_idx="+$("#odr_idx_30_20").val()+"&odr_det_idx="+odr_det_idx+"&fault_method="+$(this).attr("fault_method")+"&fault_quantity="+fault_quantity);
						}
					}
			});				
		}

	});

</script>