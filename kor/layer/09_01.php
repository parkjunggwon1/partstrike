<?

/*****************************************************************
*** 화면 : 구매자 - 수정발주서(09_01)
*** 2016-04-14 : 선택 삭제 및 발주 하는 방식으로 수정
*****************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
if (!$_SESSION["MEM_IDX"]){ReopenLayer("layer6","alert","?alert=sessionend");exit;}
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<script src="/kor/js/menu.js"></script>
<script>ready();</script>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function del(tbl, idx){
//		if (confirm('정말 삭제하시겠습니까?'))
//		{
			$.ajax({
				url: "/kor/proc/odr_proc.php", 
				data: "tbl="+tbl+"&idx="+idx+"&typ=del",
				encType:"multipart/form-data",
				success: function (data) {	
					if (trim(data) == "SUCCESS"){		
						openCommLayer("layer3","09_01","?odr_idx="+$("#odr_idx_09_01").val());
						//$("#tr_"+idx).remove();
					}else{
						alert(data);
					}
				}
		});		
//		}
	}


$("input[name^=odr_det_idx]").click(function(e){
		if($(this).hasClass("checked")==false){  //누르는 순간 체크 됨.
			//check 됐을때.
			if ($("#chked_cnt").val() == 0)
			{
				if ($(this).hasClass("endure"))
				{
					$("input[name^=odr_det_idx].stock").prop("disabled",true);
					$("#whole_part_type").val("E");
				}else{
					$("input[name^=odr_det_idx].endure").prop("disabled",true);
					$("#whole_part_type").val("S");
				}
			}			
			
			$("#chked_cnt").val(parseInt($("#chked_cnt").val())+1);
		}else{  //누르는 순간 체크 해제 됨.
			if ($("#chked_cnt").val() == 1)
			{
				//$("input[name^=odr_det_idx].stock").prop("disabled",false);
				$("#f tr[id^=tr_]:not(:contains('확인'))").find("input[name^=odr_det_idx].stock").prop("disabled",false);
				$("#f tr[id^=tr_]:not(:contains('확인'))").find("input[name^=odr_det_idx].endure").prop("disabled",false);
				$("#whole_part_type").val("");
			}			
			$("#chked_cnt").val(parseInt($("#chked_cnt").val())-1);
		}
		
	});



function chgnation(obj){	
		if (obj=="")
		{
			//$("#nation").parent().attr("lang","en");
		}else{
			if(obj ==$("#s_nation").val() && obj ==$("#b_nation").val()){
				$(".company-info-wrap [lang=en]").attr("lang","ko");
				$(".company-info-wrap input").css("ime-mode","active");
			}else{
				//$(".company-info-wrap [lang=ko]").attr("lang","en");
				$(".company-info-wrap input").css("ime-mode","disabled");
			}
		}
		if(obj== "1"){
			$(".roadname").show();
			$(".roadname_1").hide();
		}else{
			$(".roadname_1").show();
			$(".roadname").hide();
		}
		$("#nation").val(obj).attr("selected", "selected");
		$("#nation").siblings("label").text($("#nation").children("option:selected").text());
		
		if (obj=="")
		{
			$("input[name=nation_nm]").val("");		
		}else{
			$.ajax({ 
			type: "GET", 
			url: "/ajax/proc_ajax.php", 
			data: { actty : "STC",
					actidx : obj
			},
				dataType : "html" ,
				async : false ,
				success: function(data){ 
					$("input[name=nation_nm]").val(data);	
				}
			});		
		}

		$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php", 
		data: { actty : "SDA",
				lang : "" , //language
				actidx : obj
		},
			dataType : "html" ,
			async : false ,
			success: function(data){ 
			var $data = $(data);
			$("#dosi").empty();
			$("#dosi").append($($data.html()));
			//$("#dosi").siblings("label").text("모국어");
			$("#sigungu").val("");
			//$("input[name=zipcode]").val("");
			$("#addr").val($("#nation").children("option:selected").text());
			
			 if($("#dosi option").length==1){   //도/시가 등록된게 없으면 텍스트 박스로 대체
				$("#dosi").parent().hide().next().val("").show();
			 }else{
				$("#dosi").parent().show().next().val("").hide();
			 }			
			}
		});



	}
	function chgdosi(obj){		
		var nation_code;
		$("#dosi").val(obj.value).attr("selected", "selected");
		$("#dosi_en").val(obj.value).attr("selected", "selected");
        $("#dosi").siblings("label").text($("#dosi").children("option:selected").text());
		$("#dosi_en").siblings("label").text($("#dosi_en").children("option:selected").text());
		$("#sigungu,#sigungu_en").val("");
			

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
			//$("#sigungu").siblings("label").text("모국어");
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
							
							$("#addr_en").val($("#dosi_en").children("option:selected").text()+", "+$("#nation").children("option:selected").text()+".");						
							$("#sp_addr_en u").html($("#dosi_en").children("option:selected").text()+", "+$("#nation").children("option:selected").text()+".");
							nation_code = $("#nation").children("option:selected").val();
							if (nation_code =="1" || nation_code =="2" ||nation_code =="142")
							{
								$("#addr").val($("#nation").children("option:selected").text()+" "+ $("#dosi").children("option:selected").text());
								$("#sp_addr u").html($("#nation").children("option:selected").text()+" "+ $("#dosi").children("option:selected").text());
							}else{
								$("#addr").val($("#dosi").children("option:selected").text()+", "+$("#nation").children("option:selected").text());
								$("#sp_addr u").html($("#dosi").children("option:selected").text()+", "+$("#nation").children("option:selected").text());

							}
							
						}
					});
			}
		});
	}

	function chgsigungu(obj,enty){
		var nation_code;
		nation_code = $("#nation").children("option:selected").val();
		var dosit = $("#dosi"+enty+" option").length == 1? $("#dositxt"+enty).val():$("#dosi"+enty).children("option:selected").text();		
		if ((nation_code =="1" || nation_code =="2" ||nation_code =="142") && enty=="")
		{
			$("#addr"+enty).val($("#nation").children("option:selected").text()+" "+dosit+" "+$("#sigungu"+enty).val());
			$("#sp_addr"+enty+" u").html($("#nation").children("option:selected").text()+" "+dosit+" "+$("#sigungu"+enty).val());
		}else{
			$("#addr"+enty).val($("#sigungu"+enty).val()+", "+dosit+", "+$("#nation").children("option:selected").text()+".");
			$("#sp_addr"+enty+" u").html($("#sigungu"+enty).val()+", "+dosit+", "+$("#nation").children("option:selected").text()+".");
		}
	}

function chgdositxt(obj,enty){		
		var nation_code = $("#nation").children("option:selected").val();
		if ((nation_code =="1" || nation_code =="2" ||nation_code =="142") && enty=="")
		{
			$("#addr"+enty).val($("#nation").children("option:selected").text()+" "+obj.value);
			$("#sp_addr"+enty+" u").html($("#nation").children("option:selected").text()+" "+obj.value);
		}else{
			$("#addr"+enty).val(obj.value+", "+$("#nation").children("option:selected").text());
			$("#sp_addr"+enty+" u").html(obj.value+", "+$("#nation").children("option:selected").text());
		}
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
			$(".company-info-wrap input").val("");
			$(".company-info-wrap select").val("");
			//$("#sp_addr").html("");
			$("#delv_load").val("09_01");
			$("#delivery_addr_idx").val("0");
			$(".company-rank td").attr('class',"");
			$(".company-info-wrap input,select").attr("disabled",true);
			$(".company-info-wrap select:eq(0)").attr("disabled",false);
			$("#ship_info").attr("disabled",false);	
			$(".company-info-wrap select:eq(1)").attr("disabled",true);
			$("#layerPop3 #btn-confirm").css("cursor","").removeClass("btn-order-confirm").attr("src","/kor/images/btn_order_confirm_1.gif");	
		}
		else
		{
			$("#delivery_addr_idx").val("aaaa");
			$("#ship_account_no").val("");	
			$("#ship_info option:eq(0)").attr("selected", "selected");
			$(".text_lang").text("");
		}		
	}
	function new_addr()
	{
		$(".company-info-wrap input").val("");
		$(".company-info-wrap select").val("");
		$("#sp_addr").html("");
		$("#delv_load").val("09_01");
		$("#delivery_addr_idx").val("0");
		$(".company-rank td").attr('class',"");
		$(".company-info-wrap input,select").attr("disabled",true);
		$(".company-info-wrap select:eq(0)").attr("disabled",false);
		$("#ship_info").attr("disabled",false);	
		$(".company-info-wrap select:eq(1)").attr("disabled",true);
		MustChk();
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

$(document).ready(function(){
	//sorting 부분
	var n=[];	
	$("#layerPop3 .stock-list-table tr[id^=tr_]").each(function(){
		n.push(parseInt($(this).attr("id").replace("tr_","")));
	});	
	var nSort = n.sort();
	for(i=nSort.length-1; i >=0; i--){
		$this = $("#layerPop3 .stock-list-table tr[id=tr_"+nSort[i]+"]").parent();
		$("#layerPop3 .stock-list-table tr[id=tr_"+nSort[i]+"]").parent().remove();
		$("#layerPop3 .stock-list-table thead:eq(0)").after($this);
	}	
	
	$("#layerPop3 .stock-list-table tbody:eq(0) tr:eq(0) td").addClass("first");
	$(".txt_stock:eq(0)").show();
	
	if($("#s_nation").val()!=$("#b_nation").val()){  //직접수령 같은 나라끼리만
		$("#ship_info option:last").remove();
	}
	var $input = $("input:checkbox[name^=odr_det_idx]");   //:enabled
	var $notamendinput = $("input:checkbox[amend_yn=N]"); 
	$("input[name=insur_yn]").click(function(){	
		if($(this).hasClass("checked")){			
			$(this).parent().next().html(" : No");
			$(this).attr("class"," ");
		}else{
			$(this).parent().next().html(" : Yes");
			$(this).attr("class","checked");
		}
	});

	if($("#ship_info").attr("disabled")!="disabled"){
		$("#ship_info option:gt(4)").attr("lang","ko");
	}

	if($input.length==1){  //하나일 때는 default로 체크
		$input.prop("checked",true);
		$input.addClass("checked");
		$input.attr("disabled",true);
		if($input.hasClass("endure")){$("#whole_part_type").val("E");}
		$("#del_1_"+$input.val()).show();
		$("#del_"+$input.val()).hide();		
	}
	
	

	//1개일때는 Company 뒷부분 th 아예 빼버리기
	/**
	if($("#layerPop3 .stock-list-table").find("tr[id^=tr]").length ==1){
		$("#layerPop3 .stock-list-table th:contains('Company')").next().remove();
		$("#layerPop3 .stock-list-table tr[id^=tr_] td:last").remove();
	}
	else{
		$(".txt_stock").css("width","186px");
	}
	**/

	$("#layerPop3 .stock-list-table input[name^=odr_quantity] , #layerPop3 #ship_account_no, #layerPop3 #memo").keyup(function(e){
		checkActive();
	});

	$("#layerPop3 #ship_info").change(function(e){
		checkActive();
	});

	$("#layerPop3 #delivery_chg").change(function(e){
		if(!$("#delivery_chg").is(":checked")){
			//delivery_load("");		
		}
		checkActive();
	});

	$("#layerPop3 .stock-list-table input[name^=odr_det_idx]").click(function(e){
		checkActive();
	});

	checkActive();
	//옵션 갯수에 따른 선택 안내 메세지
	var det_cnt = $("#det_cnt_0901").val();
	if(det_cnt = $("#det_cnt_0901").val()>1){
		$(".txt_option").show();
		$(".txt_option").css("margin-left","-470px");
	}



	$("input:checkbox[name^=odr_det_idx]").click(function(){	
		var amend_yn;
		amend_yn = "";
		$("input:checkbox[name^=odr_det_idx]").each(function(e){ //선택유무와 무관
			
			var chk_val;

			chk_val = $(this).is(":checked")
			if (chk_val==true)
			{
				amend_yn = amend_yn + $(this).attr("amend_yn");
				if (amend_yn.indexOf("Y"))
				{		
					if(amend_yn == "N")
					{
						$("#btn_cancel_09_01").css("cursor","pointer").addClass("btn-cancel-0901").attr("src","/kor/images/btn_cancel.gif");
					}
					else
					{
						$("#btn_del_09_01").hide();
						$("#btn_del_09_01").css("cursor","").attr("onclick","").attr("src","/kor/images/btn_delete2_1.gif");
						$("#btn_cancel_09_01").css("cursor","").removeClass("btn-cancel-0901").attr("src","/kor/images/btn_cancel_1.gif");	
					}						
					
				}
				else
				{				
					$("#btn_del_09_01").show();
					$("#btn_del_09_01").css("cursor","pointer").attr("onclick","del_sel();").attr("src","/kor/images/btn_delete2.gif");	
					$("#btn_cancel_09_01").css("cursor","").removeClass("btn-cancel-0901").attr("src","/kor/images/btn_cancel_1.gif");
				}
			}
			else
			{
				$("#btn_del_09_01").hide();
				$("#btn_del_09_01").css("cursor","").attr("onclick","del_sel();").attr("src","/kor/images/btn_delete2_1.gif");	

			}
			

		});
		
	});

	
}); //end of ready

function checkActive(){

	//alert("checkActive");
	var Erchkbox = false , ErchkCnt = true;
	var det_cnt = $("#det_cnt_0901").val();
	var okCnt = 0, sel_cnt = 0, supp_qty = 0;
	if(det_cnt>1){ //-- 여러개 일때 --------------------------
		sel_box = $("input[name^=odr_det_idx]:checked");
		selCnt = sel_box.length;
	}else{	//-- 한개일때 ---------------------------------------
		sel_box = $("input[name^=odr_det_idx]");
		selCnt=1;
		cntOK = true;
	}
	//det 갯수만큼 반복(발주수량으로...)
	maskoff();
	$("input[name^=odr_quantity]").each(function(e){ //선택유무와 무관
		supp_qty = $(this).attr("supply_quantity");
		odr_qty = parseInt($(this).val());
		quantity = parseInt($(this).attr("quantity"));  //현 재고.
		if(supp_qty.length > 0){
			//if($(this).val().length>0 && odr_qty <= quantity && odr_qty>0) okCnt++;
			if(odr_qty <= quantity && odr_qty>0) okCnt++;
			else $(this).val("");
		}else{
			if($(this).val()>0) 	okCnt++;
		}
	});
	maskon();
	//선적정보
	if(($("#ship_info option:selected").val()>=5  && $("#memo").val()=="") ||$("#ship_info option:selected").val()<5  && $("#ship_account_no").val()=="" || $("#ship_info option:selected").val()==""){
		ErchkCnt = false;
	}

	var chk_val=$("input:checkbox[id='delivery_chg']").is(":checked");
	if(chk_val==true && MustChk()!=true)
	{
		ErchkCnt = false;	
	}
	//발주서 확인 버튼 활성
	if(okCnt == det_cnt && ErchkCnt && selCnt == det_cnt && supp_qty <= odr_qty){
		$("#layerPop3 .btn-area :eq(1)").css("cursor","pointer").addClass("btn-view-sheet-1207").attr("src","/kor/images/btn_order_confirm.gif");
	}else{
		$("#layerPop3 .btn-area :eq(1)").css("cursor","").removeClass("btn-view-sheet-1207").attr("src","/kor/images/btn_order_confirm_1.gif");
	}
	//취소버튼 활성
	if(selCnt>0){
		$("#btn_cancel_09_01").css("cursor","pointer").addClass("btn-cancel-0901").attr("src","/kor/images/btn_cancel.gif");
	}else{
		$("#btn_cancel_09_01").css("cursor","").removeClass("btn-cancel-0901").attr("src","/kor/images/btn_cancel_1.gif");
	}

	/**
	$("#layerPop3 .stock-list-table").find("tr[id^=tr]").each(function(e){
		if($(this).find("input[name^=odr_det_idx]").prop("checked")==true){
		Erchkbox = true;
		}
		if($(this).find("input[name^=odr_quantity]").val()==""){				
			ErchkCnt = false;
		}			
	});

	if(($("#ship_info option:selected").val()>=5  && $("#memo").val()=="") ||$("#ship_info option:selected").val()<5  && $("#ship_account_no").val()=="" || $("#ship_info option:selected").val()=="" ){
		ErchkCnt = false;
	}

	if ($("input:checkbox[amend_yn=Y]").length==0 && ($("#delivery_addr_idx").val()=="" || $("#delivery_chg").hasClass("checked")==false))
	{
		ErchkCnt =false;
	}
	if (Erchkbox==true && ErchkCnt == true){
		$("#layerPop3 .btn-area :eq(1)").css("cursor","pointer").addClass("btn-view-sheet-1207").attr("src","/kor/images/btn_order_confirm.gif");
	}else{
		$("#layerPop3 .btn-area :eq(1)").css("cursor","").removeClass("btn-view-sheet-1207").attr("src","/kor/images/btn_order_confirm_1.gif");
	}
	**/
}

function del_sel()
{

	var amend_yn;
	var odr_det_idx_val;
	amend_yn = "";
	$("input:checkbox[name^=odr_det_idx]").each(function(e){ //선택유무와 무관
		
		var chk_val;

		chk_val = $(this).is(":checked");
		odr_det_idx_val = $(this).attr("odr_det_idx2");
		part_type = $(this).attr("part_type");

		if (chk_val==true)
		{
			amend_yn = $(this).attr("amend_yn");
			
			if (amend_yn == "Y")
			{		
				$.ajax({ 
				type: "GET", 
				url: "/ajax/proc_ajax.php", 
				data: { actty : "RMAS2", //Remove amend data						
						odr_det_idx : $(this).attr("odr_det_idx2")
				},
					dataType : "html" ,
					async : false ,
					success: function(data){ 

						closeCommLayer("layer3"); //발주창
						openCommLayer("layer3","09_01","?odr_idx="+$("#odr_idx_09_01").val());
						
					}
				});
			}
			
		}
		
	});
}

//-->
</SCRIPT>

<div class="layer-hd">
	<h1>수정 발주서(09_01):<?=$odr_idx;?></h1>
	<a href="#" class="btn-close amend" odr_idx="<?=$odr_idx?>"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
<?if (!$odr_idx){
	$part=get_part($part_idx);
	$sell_mem_idx = $part[mem_idx];
	$sell_rel_idx = $part[rel_idx];
	$part_type = $part[part_type];
	$session_mem_idx = $_SESSION["MEM_IDX"];
	$odr_idx = get_any("odr", "odr_idx", "imsi_odr_no ='IM-".$sell_mem_idx."-".$session_mem_idx."'");	
}else{
	$odr=get_odr($odr_idx);
	$sell_mem_idx = $odr[sell_mem_idx];
	$sell_rel_idx = $odr[sell_rel_idx];
	$delivery_addr_idx= $odr[delivery_addr_idx];
	$ship_info= $odr[ship_info];
	$ship_account_no= $odr[ship_account_no];
	$insur_yn= $odr[insur_yn];
	$memo= $odr[memo];
}
$det_cnt = QRY_CNT("odr_det"," and odr_idx=$odr_idx ");  //odr_det 수량
?>
	<form name="f_09_01" id="f_09_01">
	<input type="hidden" name="odr_idx" id="odr_idx_09_01" value="<?=$odr_idx?>">	
	<input type="hidden" name="typ" id="typ" value="">
	<input type="hidden" name="det_cnt" id="det_cnt_0901" value="<?=$det_cnt;?>">
	<input type="hidden" name="sell_mem_idx" id="sell_mem_idx" value="<?=$sell_mem_idx?>">
	<input type="hidden" name="sell_rel_idx" id="sell_rel_idx" value="<?=$sell_rel_idx?>">
	<input type="hidden" name="session_mem_idx" id="session_mem_idx" value="<?=$session_mem_idx?>">
	<input type="hidden" name="session_rel_idx" id="session_rel_idx" value="<?=$session_rel_idx?>">
	<input type="hidden" name="chked_cnt" id="chked_cnt" value="0">
	<input type="hidden" name="new_odr_idx" id="new_odr_idx" value="">
	<input type="hidden" name="save_yn" id="save_yn" value="">
	<input type="hidden" name="whole_part_type" id="whole_part_type" value="">
	<input type="hidden" name="load_page" id="load_page" value="09_01">

	<table class="stock-list-table">
		<thead>
			<tr>
				<?if($det_cnt>1){?>
				<th scope="col" style="width:50px">Option</th>
				<?}?>
				<th scope="col" class="t-no" style="width:23px">No. </th>
				<th scope="col" class="t-nation">Nation</th>
				<th scope="col" class="t-partno" style="width:300px;">Part No.</th>
				<th scope="col" class="t-Manufacturer" style="width:180px;">Manufacturer</th>
				<th scope="col" class="t-Package" style="width:80px">Package</th>
				<th scope="col" class="t-dc" style="width:36px">D/C</th>
				<th scope="col" class="t-rohs" style="width:36px">RoHS</th>
				<th scope="col" class="t-oty" style="width:60px">O'ty</th>
				<th scope="col" class="t-unitprice" style="width:61px">Unit Price</th>
				<th scope="col" lang="ko" class="t-orderoty" style="width:66px">발주수량</th>
				<th scope="col" lang="ko"  class="t-supplyoty" style="width:66px">공급수량</th>
				<th scope="col" lang="ko" class="t-period" style="width:38px">납기</th>
				<th scope="col" class="t-company" style="width:76px">Company</th>
				<!--th scope="col" >&nbsp;</th-->
				</tr>
		</thead>
		<?	for ($i = 1; $i<=7; $i++){
				echo GET_ODR_DET_LIST("09_01", $i," and odr_idx=$odr_idx ", $det_cnt);
		}
		echo shipping_info($odr[odr_idx],"09_01");
		?>		
		</table>
	
	<div class="btn-area t-rt">
		<img src="/kor/images/btn_order_add.gif" alt="발주 추가" style="cursor:pointer"  class="btn-dialog-0501-from_0901">
		<img src="/kor/images/btn_order_confirm.gif" alt="발주서 확인" odr_idx="<?=$odr_idx?>" class="btn-view-sheet-1207">
		<img src="/kor/images/btn_cancel_1.gif" id="btn_cancel_09_01" alt="취소">
		<img src="/kor/images/btn_delete2_1.gif" style="display: none;" alt="삭제" id="btn_del_09_01">
	</div>
</div>

