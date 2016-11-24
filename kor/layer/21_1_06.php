<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
?><div class="layer-hd red">
	<h1>반품방법</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<form name="f" id="f" method="post" enctype="multipart/form-data">		
<input type="hidden" id="typ" name="typ" value="return_method">
<input type="hidden" name="odr_idx" value="<?=$odr_idx?>">
<input type="hidden" name="odr_det_idx" value="<?=$odr_det_idx?>">
<input type="hidden" name="status" value="29">
<input type="hidden" name="status_name" value="반품방법">
<input type="hidden" name="fault_select" value="<?=$fault_select?>">
<?	$odr_det = get_odr_det_each($odr_det_idx);
	$odr = get_odr($odr_det[odr_idx]);
	$sell_mem_idx = $odr[sell_mem_idx];
	$buy_mem_idx = $odr[mem_idx];
	$delivery_addr_idx = $odr_det[delivery_addr_idx];?>
	
<input type="hidden" name="sell_mem_idx" value="<?=$sell_mem_idx?>">
<input type="hidden" name="buy_mem_idx" value="<?=$buy_mem_idx?>">
<div class="layer-content pd-l20">
	<table class="detail-table">
		<tbody>
			<tr>
				<th scope="row" colspan="4"><label class="ipt-rd rd c-red"><input type="radio" name="return_method" value="1" class="checked" checked><span></span> 반품포기</label></th>
			</tr>
			<tr >
				<th scope="row"><label class="ipt-rd rd c-red"><input type="radio" name="return_method" value="2" ><span></span> 선적정보:</label></th>
				<td class="ship"><span class="c-grey2">운송회사</span>
					<div class="select type4" lang="en" style="width:70px">
						<label class="c-blue">선택</label>
						<?echo GF_Common_SetComboList("ship_info", "DLVR", "", 1, "True",  "선택", $ship_info , "");?>
					</div>
				</td>
				<th scope="row"><span lang="en" class="c-grey2">Account No.</span></th>
				<td  class="ship"><input type="text" class="i-txt2 c-blue" name ="ship_account_no" id="ship_account_no" value="<?=$ship_account_no?>" style="width:92px"></td>
			</tr>			
			<tr>
				<td colspan="4" class="pd-l20"><label class="ipt-chk chk2"><input type="checkbox" name="insur_yn" <?if ($insur_yn=="on"){echo "checked class='checked'";}?>><span></span> 운송보험</label></td>
			</tr>
			<tr>
				<td colspan="4" class="pd-l20"><label class="ipt-chk chk2  com-chck"><input type="checkbox" name="delivery_chg" id="delivery_chg"  <?if ($delivery_addr_idx){echo "checked class='checked'";}?>><span></span> 배송지 변경</label></td>
			</tr>
			<tr>
				<td colspan="4" lang="en"><strong class="c-red">Memo</strong> <input type="text" class="i-txt2 c-blue" id ="memo" name="memo" value="<?=$memo?>" style="width:323px"></td>
			</tr>
		</tbody>
	</table>

	<div class="company-info-wrap" style="display:<?if (!$delivery_addr_idx){echo"none";}?>">
		<?echo GET_CHG_ODR_DELIVERY_ADDR($delivery_addr_idx);?>
	</div>

	
	<div class="btn-area t-rt">
		<button type="button" onclick="check();"><img src="/kor/images/btn_transmit.gif" alt="전송"></button>
	</div>
</div>
</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
$("input[name=return_method]").click(function(){
	if($(this).val()=="1"){
		$(".ship input,.ship select").attr("readonly",true).attr("disabled",true);
	}else{
		$(".ship input,.ship select").attr("readonly",false).attr("disabled",false);
	}
});
$(document).ready(function(){
	$(".ship input,.ship select").attr("readonly",true).attr("disabled",true);
});

function check(){
		var f =  document.f;	
		f.typ.value = "return_method";
		var formData = $("#f").serialize(); 
		$.ajax({
				url: "/kor/proc/record_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {						
					if (trim(data) == "SUCCESS"){		
						alert_msg("반품 방법 메세지를 전송 하였습니다.");
						location.href="/kor/";
					}else{
						alert(data);
					}
				}
		});		
	}



	function chgnation(obj){
		$("#nation").val(obj.value).attr("selected", "selected");
		$("#nation").siblings("label").text($("#nation").children("option:selected").text());
		$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php", 
		data: { actty : "SDA",
				lang : "" , //language
				actidx : obj.value
		},
			dataType : "html" ,
			async : false ,
			success: function(data){ 
			var $data = $(data);
			$("#dosi").empty();
			$("#dosi").append($($data.html()));
			$("#dosi").siblings("label").text("도/시");
				$.ajax({ 
					type: "GET", 
					url: "/ajax/proc_ajax.php", 
					data: { actty : "SDA",
							lang : "_en" , //language
							actidx : obj.value
					},
						dataType : "html" ,
						async : false ,
						success: function(data){ 
							var $data = $(data);
							$("#dosi_en").empty();
							$("#dosi_en").append($($data.html()));
							$("#dosi_en").siblings("label").text("English");
							$("#sigungu,#sigungu_en").empty();
							$("#sigungu").siblings("label").text("시/군/구");
							$("#sigungu_en").siblings("label").text("English");


						}
					});
			}
		});



	}
	function chgdosi(obj){		
		
		$("#dosi").val(obj.value).attr("selected", "selected");
		$("#dosi_en").val(obj.value).attr("selected", "selected");
        $("#dosi").siblings("label").text($("#dosi").children("option:selected").text());
		$("#dosi_en").siblings("label").text($("#dosi_en").children("option:selected").text());


		$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php", 
		data: { actty : "SA",
				lang : "" , //language
				actidx : obj.value
		},
			dataType : "html" ,
			async : false ,
			success: function(data){ 
			var $data = $(data);
			$("#sigungu").empty();
			$("#sigungu").append($($data.html()));
			$("#sigungu").siblings("label").text("시/군/구");
				$.ajax({ 
					type: "GET", 
					url: "/ajax/proc_ajax.php", 
					data: { actty : "SA",
							lang : "_en" , //language
							actidx : obj.value
					},
						dataType : "html" ,
						async : false ,
						success: function(data){ 
							var $data = $(data);
							$("#sigungu_en").empty();
							$("#sigungu_en").append($($data.html()));
							$("#sigungu_en").siblings("label").text("English");
						}
					});
			}
		});
	}

	function chgsigungu(obj){
		$("#sigungu").val(obj.value).attr("selected", "selected");
		$("#sigungu_en").val(obj.value).attr("selected", "selected");
        $("#sigungu").siblings("label").text($("#sigungu").children("option:selected").text());
		$("#sigungu_en").siblings("label").text($("#sigungu_en").children("option:selected").text());
	}

-->
</SCRIPT>