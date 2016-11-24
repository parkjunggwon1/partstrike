<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
?>
<script language="javascript">
	function sel_ship_info(obj){
		if (obj.value){
			$.ajax({ 
				type: "GET", 
				url: "/ajax/proc_ajax.php", 
				data: { actty : "GAN", //Get Account Number
						actidx : "29",
						actkind :obj.value 
				},
				dataType : "html" ,
				async : false ,
				success: function(data){ 
							if (obj.value<5){  //일반 운송업체
								$("#account_no_21505").val(data);
							}else{ //다른 운송업체
								$("#account_no_21505").val("");
							}
				}
			});		
		}	
	}
</script>
<div class="layer-hd red">
	<h1>반품 방법</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<form name="f21505" id="f21505" method="post" enctype="multipart/form-data">		
<div class="layer-content">
<?$parts_mem_idx = get_any("member", "min(mem_idx)", "mem_type = 0");
  $parts=sql_fetch("select * from impship where rel_idx = trim('$parts_mem_idx')");

?>
	<p class="txt-warning t-ct"><img src="/kor/images/top_logo.png" alt="PARTStrike" style="height:18px"></p>
		<span class="c-red">선적정보&nbsp;:&nbsp;</span>
		<span >운송회사&nbsp;&nbsp;</span>
		<!--img alt="" src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$parts[company_idx]))?>.gif"-->
		<div class="select type4" lang="en" style="width:110px">
		<label class="c-blue text_lang"></label>
		<?=GF_Common_SetComboListSrch("ship_info", "DLVR", "", 1, "True",  "", 0 ,"onchange='sel_ship_info(this)'","");?>
		</div>
		&nbsp;&nbsp;&nbsp;
		<span lang="en">Account No. :</span>
		<input type="text" class="i-txt2 c-blue t-rt" name ="ship_account_no" id="account_no_21505" value="" style="width:92px;ime-mode:disabled;">
		<!--span class="c-blue" lang="en"><?=$parts[account_no]?></span-->


	<button type="button" class="btn-dialog-21-2-03_rnd" odr_idx ="<?=$odr_idx?>"  odr_det_idx="<?=$odr_det_idx?>"></button>
	<div class="btn-area t-rt">
		<button type="button" onclick="check();"><img src="/kor/images/btn_return_shipping.gif" alt="반품선적" ></button>
	</div>
</div>

<input type="hidden" id="typ" name="typ" value="return_method">
<input type="hidden" name="odr_idx" value="<?=$odr_idx?>">
<input type="hidden" name="odr_det_idx" value="<?=$odr_det_idx?>">
<input type="hidden" name="reason_ty" value="6">
<input type="hidden" name="ship_type" value="4">
<!--input type="hidden" name="ship_info" value="<?=$parts[company_idx]?>"-->
<!--input type="hidden" name="ship_account_no" value="<?=$parts[account_no]?>"-->
<input type="hidden" name="return_method" value="2">
<input type="hidden" name="status" value="29">
<input type="hidden" name="status_name" value="반품방법">
<input type="hidden" name="etc1" id="etc1_21505" value="">
<?	$odr_det = get_odr_det_each($odr_det_idx);
	$odr = get_odr($odr_det[odr_idx]);
	$sell_mem_idx = $odr[sell_mem_idx];
	$buy_mem_idx = $odr[mem_idx];
	$delivery_addr_idx = $odr_det[delivery_addr_idx];?>
	
<input type="hidden" name="sell_mem_idx" value="<?=$sell_mem_idx?>">
<input type="hidden" name="buy_mem_idx" value="<?=$buy_mem_idx?>">
</form>

<SCRIPT LANGUAGE="JavaScript">
<!--
function check(){
		var f =  document.f21505;	
		f.typ.value = "return_method";
		var formData = $("#f21505").serialize(); 
		$.ajax({
				url: "/kor/proc/record_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {						
					if (trim(data) == "SUCCESS"){				
						closeCommLayer("layer4");
						$(".btn-dialog-21-2-03_rnd").click();
					}else{
						alert(data);
					}
				}
		});		
	}
-->
</SCRIPT>