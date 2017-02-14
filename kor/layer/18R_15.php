<?
/************************************************************************************************
** 반품 방법(18R_15) : 거절(교환, 반품) 시
************************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
?><div class="layer-hd">
	<h1>반품방법</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<form name="f_18R_15" id="f_18R_15" method="post" enctype="multipart/form-data">		
<input type="hidden" name="typ" id="typ" value="return_method">
<input type="hidden" name="odr_idx" value="<?=$odr_idx?>">
<input type="hidden" name="odr_det_idx" value="<?=$odr_det_idx?>">
<input type="hidden" name="status" value="22">
<input type="hidden" name="status_name" value="반품방법">
<input type="hidden" name="fault_select" value="<?=$fault_select?>">
<input type="hidden" name="ship_type" value="2">

<?  $odr = get_odr($odr_idx);
	$sell_mem_idx = $odr[sell_mem_idx];
	$buy_mem_idx = $odr[mem_idx];
	$delivery_addr_idx = $odr_det[delivery_addr_idx];
?>
<input type="hidden" name="sell_mem_idx" value="<?=$sell_mem_idx?>">
<input type="hidden" name="buy_mem_idx" value="<?=$buy_mem_idx?>">
<div class="layer-content pd-l20">
	<table class="detail-table">
		<tbody>
			<tr>
				<th scope="row" colspan="4"><label class="ipt-rd rd c-red"><input type="radio" name="return_method" value="1" ><span></span> 반품포기</label></th>
			</tr>
			<tr>
				<th scope="row"><label class="ipt-rd rd c-red"><input type="radio" name="return_method" value="2" class="checked" checked><span></span> 선적정보:</label></th>
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
				<td colspan="4" class="pd-l20"><label class="ipt-chk chk2"><input type="checkbox" name="insur_yn" <?if ($insur_yn=="Y"){echo "checked class='checked'";}?> value="Y"><span></span> 운송보험</label></td>
			</tr>
			<tr>
				<td colspan="4" class="pd-l20"><label class="ipt-chk chk2  com-chck"><input type="checkbox" name="delivery_chg" id="delivery_chg"  <?if ($delivery_addr_idx){echo "checked class='checked'";}?>><span></span> 배송지 변경</label></td>			
			</tr>
			<tr>
				<td colspan="4" lang="en"><strong class="c-black">Memo</strong> <input type="text" class="i-txt5" id ="memo" name="memo" value="<?=$memo?>" style="width:323px"></td>
			</tr>
		</tbody>
	</table>
	
	<div class="company-info-wrap" style="display:<?if (!$delivery_addr_idx){echo"none";}?>">
		<?echo GET_CHG_ODR_DELIVERY_ADDR($delivery_addr_idx,"18R_15",$odr_idx);?>
	</div>



	<div class="btn-area t-rt">
		<button type="button" class="return_chk" onclick="check();"><img src="/kor/images/btn_transmit_1.gif" alt="전송"></button>
	</div>
</div>
</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
var account_no_val = false;
var ship_info_val = false;

$("input[name=return_method]").click(function(){

	var delivery_chk_val = $('input:checkbox[id="delivery_chg"]').is(":checked");

	if (delivery_chk_val==true)
	{
		var delivery_chk = MustChk();
	}
	else
	{
		var delivery_chk = true;
	}

	if($(this).val()=="1"){
		$(".ship input,.ship select").attr("readonly",true).attr("disabled",true);
		$(".return_chk").children("img").attr("src","/kor/images/btn_transmit.gif");
		$(".return_chk").attr("onclick","check();");	
	}else{
		$(".ship input,.ship select").attr("readonly",false).attr("disabled",false);
		if (account_no_val==true && ship_info_val==true && delivery_chk == true)
		{
			//alert(account_no_val);
			//alert(ship_info_val);
			$(".return_chk").children("img").attr("src","/kor/images/btn_transmit.gif");
			$(".return_chk").attr("onclick","check();");	
			$("#typ").val("return_method");
		}
		else
		{
			//alert(account_no_val);
			//alert(ship_info_val);
			$(".return_chk").children("img").attr("src","/kor/images/btn_transmit_1.gif");
			$(".return_chk").attr("onclick","");	
			$("#typ").val("delivery_save");
		}
	}
});
$(document).ready(function(){

	$("#ship_account_no").keyup(function(e){	
		
		var delivery_chk_val = $('input:checkbox[id="delivery_chg"]').is(":checked");

		if (delivery_chk_val==true)
		{
			var delivery_chk = MustChk();
		}
		else
		{
			var delivery_chk = true;
		}

		if ($("#ship_account_no").val()=="")
		{
			account_no_val =false;
		}
		else
		{
			account_no_val =true;
		}

		if (account_no_val==true && ship_info_val==true && delivery_chk ==true)
		{

			$(".return_chk").children("img").attr("src","/kor/images/btn_transmit.gif");
			$(".return_chk").attr("onclick","check();");	
			$("#typ").val("return_method");
		}
		else
		{
			$(".return_chk").children("img").attr("src","/kor/images/btn_transmit_1.gif");
			$(".return_chk").attr("onclick","");	
			$("#typ").val("delivery_save");
		}
	});

	$("#ship_info").change(function(){	
		var delivery_chk = MustChk();
		var delivery_chk_val = $('input:checkbox[id="delivery_chg"]').is(":checked");

		if (delivery_chk_val==true)
		{
			var delivery_chk = MustChk();
		}
		else
		{
			var delivery_chk = true;
		}

		if ($("#ship_account_no").val()=="")
		{
			account_no_val =false;
		}
		else
		{
			account_no_val =true;
		}

		if ($("#ship_info option:selected").val() == "")
		{
			ship_info_val = false;
		}
		else
		{
			ship_info_val = true;
		}

		if (account_no_val==true && ship_info_val==true && delivery_chk ==true)
		{
			//alert(delivery_chk);
			//alert(account_no_val);
			$(".return_chk").children("img").attr("src","/kor/images/btn_transmit.gif");
			$(".return_chk").attr("onclick","check();");	
			$("#typ").val("return_method");
		}
		else
		{
			//alert(delivery_chk);
			//alert(account_no_val);
			$(".return_chk").children("img").attr("src","/kor/images/btn_transmit_1.gif");
			$(".return_chk").attr("onclick","");	
			$("#typ").val("delivery_save");
		}
	});

	$("#delivery_chg").change(function(){	
		var delivery_chk = MustChk();
		var delivery_chk_val = $('input:checkbox[id="delivery_chg"]').is(":checked");

		if (delivery_chk_val==true)
		{
			$("#ship_account_no").val("");
		}
		
	});


	//$(".ship input,.ship select").attr("readonly",true).attr("disabled",true);
});

//------------ 버튼 활성 or 비활성 ------------------------------------------------------------------
function checkActive(){


		var delivery_chk = MustChk();
		var delivery_chk_val = $('input:checkbox[id="delivery_chg"]').is(":checked");

		if (delivery_chk_val==true)
		{
			var delivery_chk = MustChk();
		}
		else
		{
			var delivery_chk = true;
		}

		if ($("#ship_info option:selected").val() == "")
		{
			ship_info_val = false;
		}
		else
		{
			ship_info_val = true;
		}

		if ($("#ship_account_no").val()=="")
		{
			account_no_val =false;
		}
		else
		{
			account_no_val =true;
		}

		if (account_no_val==true && ship_info_val==true && delivery_chk ==true)
		{
			//alert(delivery_chk);
			//alert(account_no_val);
			$(".return_chk").children("img").attr("src","/kor/images/btn_transmit.gif");
			$(".return_chk").attr("onclick","check();");	
			$("#typ").val("return_method");
		}
		else
		{
			//alert(delivery_chk);
			//alert(account_no_val);
			$(".return_chk").children("img").attr("src","/kor/images/btn_transmit_1.gif");
			$(".return_chk").attr("onclick","");	
			$("#typ").val("delivery_save");
		}
		
	}	//end of checkActive()
	
	function no_post(str)
	{
		var s_nation ="<?=$s_nation?>";
		var check_val = $("input:checkbox[id='zipcode_no']").is(":checked");		
		var nation_code = $("#nation").children("option:selected").val();
		var nation_val=$("#nation").children("option:selected").text();		
		var zipcode_val=$("#zipcode").val();
		var dosi_val=$("#real_do_val").val();
		var sigungu_val=$("#sigungu").val();
		var detail_val=$("#addr_det").val();
		var post_val="";
		var post_val_en="";

		if (check_val==true)
		{
			post_val="";
			post_val_en="";

			$("#zipcode").attr("readonly",true);
			$("#zipcode").css("background-color",'rgb(235, 235, 228)');
			$("#zipcode").val(" ");
		}
		else
		{
			$("#zipcode").css("background-color",'');
			$("#zipcode").attr("readonly",false);

			
			post_val=" "+$("#zipcode").val()+", ";
			post_val_en=""+$("#zipcode").val()+", ";
			
		}
	
		
		$("#addr").val($("#addr_full").val()+" "+", "+post_val+" "+nation_val);
				
		$("#sp_addr").html($("#addr_full").val()+" "+", "+post_val+" "+nation_val);
		
		
	}

	function zipcode_txt(str)
	{
		
		var s_nation ="<?=$s_nation?>";
		var check_val = $("input:checkbox[id='zipcode_no']").is(":checked");
		var nation_code = $("#nation").children("option:selected").val();
		var nation_val=$("#nation").children("option:selected").text();		
		var zipcode_val=$("#zipcode").val();
		var dosi_val=$("#real_do_val").val();
		var sigungu_val=$("#sigungu").val();
		var detail_val=$("#addr_det").val();
		var post_val="";
		var post_val_en="";

		if (check_val==true)
		{
			post_val="";
			post_val_en="";

			$("#zipcode").attr("readonly",true);
			$("#zipcode").css("background-color",'rgb(235, 235, 228)');
			$("#zipcode").val(" ");
		}
		else
		{
			$("#zipcode").css("background-color",'');
			$("#zipcode").attr("readonly",false);

			
			post_val=" "+$("#zipcode").val()+", ";
			post_val_en=""+$("#zipcode").val()+", ";
			
		}
					
		$("#addr").val($("#addr_full").val()+" "+", "+post_val+" "+nation_val);
				
		$("#sp_addr").html($("#addr_full").val()+" "+", "+post_val+" "+nation_val);
	}

	function detail_addr(str)
	{			
		var s_nation ="<?=$s_nation?>";
		var check_val = $("input:checkbox[id='zipcode_no']").is(":checked");
		var nation_code = $("#nation").children("option:selected").val();
		var nation_val=$("#nation").children("option:selected").text();		
		var zipcode_val=$("#zipcode").val();
		var dosi_val=$("#real_do_val").val();
		var sigungu_val=$("#sigungu").val();
		var detail_val=$("#addr_det").val();
		var post_val="";
		var post_val_en="";

		if (check_val==true)
		{
			post_val="";
			post_val_en="";

			$("#zipcode").attr("readonly",true);
			$("#zipcode").css("background-color",'rgb(235, 235, 228)');
			$("#zipcode").val(" ");
		}
		else
		{
			$("#zipcode").css("background-color",'');
			$("#zipcode").attr("readonly",false);

			
			post_val=" "+$("#zipcode").val()+", ";
			post_val_en=""+$("#zipcode").val()+", ";
			
		}	
		
		
		$("#addr").val($("#addr_full").val()+" "+", "+post_val+" "+nation_val);
				
		$("#sp_addr").html($("#addr_full").val()+" "+", "+post_val+" "+nation_val);
					
	}

	function new_addr()
	{
		$(".company-info-wrap input").val("");
		$(".company-info-wrap select").val("");
		$("#sp_addr").html("");
		$("#delv_load").val("18R_15");
		$("#delivery_addr_idx").val("0");
		$(".company-rank td").attr('class',"");
		$(".company-info-wrap input,select").attr("disabled",true);
		$(".company-info-wrap select:eq(0)").attr("disabled",false);
		$("#ship_info").attr("disabled",false);	
		$(".company-info-wrap select:eq(1)").attr("disabled",true);
		$(".return_chk").children("img").attr("src","/kor/images/btn_transmit_1.gif");
		$(".return_chk").attr("onclick","");	
		$("#typ").val("delivery_save");
	}

	function add_change_sel()
	{
		var chk_val=$("input:checkbox[id='delivery_chg']").is(":checked");
		//alert(chk_val);
		if (chk_val==true)
		{
			$("#delivery_addr_idx").val("0");
			$("#ship_account_no").val("");	
			$("#ship_info option:eq(0)").attr("selected", "selected");
			$(".text_lang").text("");
		}
		else
		{
			$("#delivery_addr_idx").val("aaaa");
			$("#ship_account_no").val("");	
			$("#ship_info option:eq(0)").attr("selected", "selected");
			$(".text_lang").text("");
		}		
	}


	function ready(){
	var select = $("select");
	select.change(function(){
		var select_name = $(this).children("option:selected").text();
		$(this).siblings("label").text(select_name);
	});

	$('.onlynum').css("ime-mode","disabled").keydown(function(event){ 		//숫자만 입력하게.(.도 포함) 			
	  if (event.which && (event.which > 45 && event.which < 58 || event.which == 8 || event.which > 95 && event.which < 106)) {			
	   } else { 
	   event.preventDefault(); 
	  } 
	 });
		 
	 $('.numfmt').css("ime-mode","disabled").keyup( function(event){   // 숫자 입력 하면 ,로 단위 끊어 표시하게.
			check_value(this);
	 });
}
	

function check(){
		var f =  document.f_18R_15;	
		f.typ.value = "return_method";
		var formData = $("#f_18R_15").serialize();
		$.ajax({
				url: "/kor/proc/odr_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {						
					if (trim(data) == "SUCCESS"){		
						//alert_msg("반품 방법 메세지를 전송 하였습니다.");
						location.href="/kor/";
					}else{
						alert(data);
					}
				}
		});
		//f.action = "/kor/proc/odr_proc.php";
		//f.submit();
	}



	function chgnation(obj){		
	//판매국가
	var s_nation ="<?=$s_nation?>";	
		$("#addr").val("");
		$("#addr_en").val("");

		$("#sp_addr").html("");
		$("#sp_addr_en").html("");
		$("#real_doen_val").val("");
		$("#real_dokr_val").val("");
		$(".post_val").empty();
		$("#addr_det").val("");
		$("#return_val").val("");
		$("#real_do_val").val("");
		$("#addr_full").val("");

		$("#zipcode").val("");
		if (obj.value=="")
		{
			//$("#nation").parent().attr("lang","en");
		}else{
			if(obj.value ==$("#s_nation").val() && obj.value ==$("#b_nation").val()){
				//$(".company-info-wrap [lang=en]").attr("lang","ko");
				$(".company-info-wrap input").css("ime-mode","active");
			}else{
				//$(".company-info-wrap [lang=ko]").attr("lang","en");
				$(".company-info-wrap input").css("ime-mode","disabled");
			}
		}
		if(obj.value== "1"){	//한국---------
			$(".roadname").show();
			$(".roadname_1").hide();
		}else{	//그 외 국가-----------------
			$(".roadname_1").hide();
			$(".roadname").hide();
		}
		//국가번호 세팅~
		if (obj.value=="")
		{
			$("input[name=nation_nm]").val("");		
		}else{
			$.ajax({ 
			type: "GET", 
			url: "/ajax/proc_ajax.php", 
			data: { actty : "STC",
					actidx : obj.value
			},
				dataType : "html" ,
				async : false ,
				success: function(data){ 
					$("input[name=nation_nm]").val(data);	
				}
			});		
		}

		$("#nation").val(obj.value).attr("selected", "selected");
		$("#nation").siblings("label").text($("#nation").children("option:selected").text());
		
		$.ajax({ 
			type: "GET", 
			url: "/ajax/proc_ajax.php", 
			data: { actty : "NPT",
					actidx : obj.value
			},
				dataType : "text" ,
				async : false ,
				success: function(data){ 
					$(".post_val").empty();
					//alert($.trim(data));
					if ($.trim(data)!="")
					{
						if ( $.trim(data)=="KOR")
						{
							$("#zipcode_no").remove();
							$("#zipcode").css("background-color",'');
							$("#zipcode").attr("readonly",false);
						}
						else
						{
							$(".post_val").append("<input type='checkbox' name='zipcode_no' id='zipcode_no' value='1' onclick='javascript:no_post(this)';><span></span>우편번호없음");
						}
					}										
					
				}
		});	

		var same_nation = "";
		if (s_nation==obj.value)
		{
			same_nation = "";
		}
		else
		{
			same_nation = "_en";
		}

		$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php", 
		data: { actty : "SDA",
				lang : same_nation , //language
				actidx : obj.value
		},
			dataType : "html" ,
			async : false ,
			success: function(data){ 
			var $data = $(data);
			$("#dosi").empty();
			$("#dosi").append($($data.html()));
			$("#sigungu").val("");
			$("input[name=zipcode]").val("");			
			$("#korea_chk").val(same_nation);
			$("#addr").val($("#nation").children("option:selected").text());
			if(obj.value == $("#s_nation").val()){
				$("#sp_addr").html("");
			}else{
				$("#sp_addr").html(""+$("#nation").children("option:selected").text()+"");
			}
			
			 if($("#dosi option").length==1){   //도/시가 등록된게 없으면 텍스트 박스로 대체
				$("#dosi").parent().hide().next().val("").show();
			 }else{
				$("#dosi").parent().show().next().val("").hide();
			 }		
			 			 
			/* if (same_nation=="_en" && obj.value=="1")
			 {
				
				$("#dosi").parent().hide().next().val("").show();
				$(".roadname").hide();
				
			 }*/

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