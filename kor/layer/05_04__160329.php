<?/******************************************************************************
*************************** 화면 : 발주창(카트) **********************************
**** 2016-03-25 : 한개품목일때 '납기확인중'품목은 '발주','삭제' 불가 처리
********************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
if (!$_SESSION["MEM_IDX"]){ReopenLayer("layer6","alert","?alert=sessionend");exit;}
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<script src="/kor/js/menu.js"></script>
<script>ready();</script>
<?if (!$odr_idx){
	$part=get_part($part_idx);
	$sell_mem_idx = $part[mem_idx];
	$sell_rel_idx = $part[rel_idx];
	$part_type = $part[part_type];
	$session_mem_idx = $_SESSION["MEM_IDX"];
	$odr_idx = get_any("odr a left outer join odr_det b", "odr_idx", "part_idx = $part_idx and imsi_odr_no <> ''");	
	if ($odr_idx){
		$odr=get_odr($odr_idx);
		$imsi_odr_no = $odr[imsi_odr_no];
	}
}else{
	$odr=get_odr($odr_idx);
	$odr_status = $odr[odr_status];
	$sell_mem_idx = $odr[sell_mem_idx];
	$sell_rel_idx = $odr[sell_rel_idx];
	$delivery_addr_idx= $odr[delivery_addr_idx];
	$ship_info= $odr[ship_info];
	$ship_account_no= $odr[ship_account_no];
	$insur_yn= $odr[insur_yn];
	$memo= $odr[memo];
	$imsi_odr_no = $odr[imsi_odr_no];
	$save_yn = $odr[save_yn];
	
	$s_nation = get_any("member","nation", "mem_idx=$sell_mem_idx");
	$b_nation = get_any("member","nation", "mem_idx=$session_mem_idx");
	//odr_det 수량
	$det_cnt = QRY_CNT("odr_det"," and odr_idx=$odr_idx ");
}
?>
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
						openCommLayer("layer3","05_04","?odr_idx="+$("#odr_idx_05_04").val());
						//$("#tr_"+idx).remove();
					}else{
						alert(data);
					}
				}
		});		
//		}
	}
	//-- 선택 삭제----------------------------------------------------------------------------------------------------------
	function del_sel(){
		var det_cnt = $("#det_cnt").val();
		//det_cnt = parseInt(det_cnt);
		var sel_box, part_type, det_idx, del_cnt=0, delv_cnt=0;
		if(det_cnt>1){ //-- 여러개 일때 --------------------------
			sel_box = $("input[name^=odr_det_idx]:checked");
		}else{	//-- 한개일때 ---------------------------------------
			sel_box = $("input[name^=odr_det_idx]");
		}
		sel_box.each(function(e){ //실제 삭제 처리 (선택 갯수만큼 반복)--------------------
			part_type = $(this).attr("part_type");
			det_idx = $(this).val();
			//alert("det_idx:"+det_idx);
			//우선 Stock만 여기서 삭제---
			if(part_type==1 || part_type==3 || part_type==4){
				$.ajax({
					url: "/kor/proc/odr_proc.php", 
					data: "tbl=odr_det&idx="+det_idx+"&typ=del",
					encType:"multipart/form-data",
					success: function (data) {	
						if (trim(data) == "SUCCESS"){		
							//openCommLayer("layer3","05_04","?odr_idx="+$("#odr_idx_05_04").val());
							del_cnt++;
						}else{
							alert(data);
						}
					}
				});
			} else{delv_cnt++;} // Stock 제품만 삭제
		}); //end each.
		///삭제 시 현재 갯수와 삭제 갯수가 같을경우 창(0504) 닫자
		if(del_cnt == det_cnt && det_cnt>0){  //모두 삭제 시
			document.location.href="/kor/";
		} else if(del_cnt){
			openCommLayer("layer3","05_04","?odr_idx="+$("#odr_idx_05_04").val());
		}
		if(delv_cnt>0){
			alert_del("삭제","삭제하시겠습니까?","btn_ok");
		}
	}
	function del16(det_idx){
		$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php", 
		data: { actty : "DLP", //Delete period
				actidx : $("#odr_idx_05_04").val(),
				det_idx : det_idx,
				actkind : '구매자 삭제'
		},
			dataType : "html" ,
			async : false ,
			success: function(data){ 
			//	alert_msg("삭제 메세지를 보냈습니다.");
				//document.location.href="/kor/";
				//delv_cnt++;
			}
		});
	}
	//-- 납기 제품 선택 삭제------------------------------------------------------------------------------------
	function del_delv(){
		var det_cnt = $("#det_cnt").val(); //납기 삭제 전 남은 수량
		var delv_cnt=0;
		alert("det_cnt:"+det_cnt);
		if(det_cnt>1){ //-- 여러개 일때 --------------------------
			sel_box = $("input[name^=odr_det_idx]:checked");
			sel_box.each(function(e){ //실제 삭제 처리 (선택 갯수만큼 반복)--------------------
				part_type = $(this).attr("part_type");
				det_idx = $(this).val();
				if(part_type==2 || part_type==5 || part_type==6){
					del16(det_idx);
					delv_cnt++;
				}
			}); // end of each.
		}else{	//-- 한개일때 ---------------------------------------
			sel_box = $("input[name^=odr_det_idx]");
			part_type = sel_box.attr("part_type");
			det_idx = sel_box.val();
			if(part_type==2 || part_type==5 || part_type==6){
				del16(det_idx);
				delv_cnt++;
			}
		}
		/**
		sel_box.each(function(e){ //실제 삭제 처리 (선택 갯수만큼 반복)--------------------
			part_type = $(this).attr("part_type");
			det_idx = $(this).val();
			alert("part_type:"+part_type);
			alert("det_idx:"+det_idx);
			if(part_type==2 || part_type==5 || part_type==6){
				$.ajax({ 
				type: "GET", 
				url: "/ajax/proc_ajax.php", 
				data: { actty : "DLP", //Delete period
						actidx : $("#odr_idx_05_04").val(),
						det_idx : det_idx,
						actkind : '구매자 삭제'
				},
					dataType : "html" ,
					async : false ,
					success: function(data){ 
					//	alert_msg("삭제 메세지를 보냈습니다.");
						//document.location.href="/kor/";
						delv_cnt++;
					}
				});
			}
		}); // end of each.
		**/
		if(det_cnt == delv_cnt){ //-- 남은게 없어------------
			document.location.href="/kor/";
		}else{ //-- 남은게 있어...
			alert("NORD");
			$.ajax({ //------------------ 남은거 새 발주번호---
			type: "GET", 
			url: "/ajax/proc_ajax.php", 
			data: { actty : "NORD", //새 odr 로 잔여 아이템 복사(납기품목 제외), 기존 odr 품목 삭제(납기품목 제외) 2016-03-23 신규작성
					actidx : $("#odr_idx_05_04").val()
					//actkind : $(this).attr("new_odr_idx")
			},
				dataType : "html" ,
				async : false ,
				success: function(data){ 
						openCommLayer("layer3","05_04","?odr_idx="+data); //창 여는거 아래꺼 처리 후에 하자..
				}
			});
			//기존 발주번호 에서 납기 제품 빼고 삭제!!
			//메시지창 닫고
			$("section[class^='layer6']").removeClass("open");
			$("body").removeClass("open-layer");
			//What's New 창 닫고
		}

	}
	//옵션(체크박스) 클릭------------------------------------------------------------------
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
		if (obj.value=="")
		{
			$("#nation").parent().attr("lang","en");
		}else{
			if(obj.value ==$("#s_nation").val() && obj.value ==$("#b_nation").val()){
				$(".company-info-wrap [lang=en]").attr("lang","ko");
				$(".company-info-wrap input").css("ime-mode","active");
			}else{
				$(".company-info-wrap [lang=ko]").attr("lang","en");
				$(".company-info-wrap input").css("ime-mode","disabled");
			}
		}
		if(obj.value== "1"){
			$(".roadname").show();
			$(".roadname_1").hide();
		}else{
			$(".roadname_1").show();
			$(".roadname").hide();
		}
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
			//$("#dosi").siblings("label").text("모국어");
			$("#sigungu").val("");
			$("input[name=zipcode]").val("");
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
	$("input[name=insur_yn]").click(function(){
		if($(this).hasClass("checked")){
			$(this).parent().next().html(" : No");
		}else{
			$(this).parent().next().html(" : Yes");
		
		}
	});

	if($("#ship_info").attr("disabled")!="disabled"){
		$("#ship_info option:gt(4)").attr("lang","ko");
	}


	/** 주석처리 2016-03-23
	if($input.length==1){  //하나일 때는 default로 체크
		$input.prop("checked",true);
		$input.addClass("checked");
		$input.attr("disabled",true);
		if($input.hasClass("endure")){$("#whole_part_type").val("E");}
		$("#del_1_"+$input.val()).show();
		$("#del_"+$input.val()).hide();		
	}
	**/
	/** 2016-03-23 주석처리
	//1개일때는 납기 뒷부분 th 아예 빼버리기
	if($("#layerPop3 .stock-list-table").find("tr[id^=tr]").length ==1){
		$("#layerPop3 .stock-list-table th:contains('납기')").next().remove();
		$("#layerPop3 .stock-list-table tr[id^=tr_] td:last").remove();
	}else{
		$(".txt_stock").css("width","186px");
	}
	**/

	//-- 수량 변경
	$("#layerPop3 .stock-list-table input[name^=odr_quantity] , #layerPop3 #ship_account_no, #layerPop3 #memo").keyup(function(e){
		checkActive();
	});
	//-- 선적 선택
	$("#layerPop3 #ship_info").change(function(e){
		checkActive();
	});
	//-- 옵션(체크박스) 클릭
	$("#layerPop3 .stock-list-table input[name^=odr_det_idx]").click(function(e){
		checkActive();
	});

	/*$("body").on("click", "input[name='direct']" , function(){
		if($(this).prop("checked")==true){
			$("#ship_info").attr("disabled",true);
			$("#ship_info option:eq(0)").attr("selected", "selected");
			$("#ship_info").siblings("label").text("");
			$("#ship_account_no").val("Direct receipt");
			
		}else{
			$("#ship_info").attr("disabled",false);
			$("#ship_account_no").val("");
		}
		checkActive();
	});*/

	checkActive();
	<?if ($save_yn =="Y"){?>
		$("#layerPop3 .btn-area :eq(2)").css("cursor","").removeClass("btn-dialog-save").attr("src","/kor/images/btn_order_save_1.gif");
	<?}?>
}); //end of Ready

function checkActive(){
		var Erchkbox = false , ErchkCnt = true;
		var det_cnt = $("#det_cnt").val();
		$("#layerPop3 .btn-area :eq(2)").css("cursor","pointer").addClass("btn-dialog-save").attr("src","/kor/images/btn_order_save.gif");
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

		if(det_cnt==1){
			if($("input[name^=odr_det_idx]").attr("odr_status") != 1) {Erchkbox = true;}
		}

		if (Erchkbox==true && ErchkCnt == true)
		{
			$("#layerPop3 .btn-area :eq(1)").css("cursor","pointer").addClass("btn-order-confirm").attr("src","/kor/images/btn_order_confirm.gif");
		}else{
			$("#layerPop3 .btn-area :eq(1)").css("cursor","").removeClass("btn-order-confirm").attr("src","/kor/images/btn_order_confirm_1.gif");
			//$("#layerPop3 .btn-area :eq(2)").css("cursor","").removeClass("btn-dialog-save").attr("src","/kor/images/btn_order_save_1.gif");
			
		}
		//-- 삭제버튼 처리
		if(Erchkbox == true) {
			$("#btn_del_0504").css("cursor","pointer").attr("onclick","del_sel();").attr("src","/kor/images/btn_delete2.gif");
		}else{
			$("#btn_del_0504").css("cursor","").attr("onclick","").attr("src","/kor/images/btn_delete2_1.gif");
		}
	}

//-->
</SCRIPT>


<div class="layer-hd">
	<h1>발주서(0504)-<?=$odr_idx;?>(<?="odr_status:".$odr_status;?>)</h1>
	<a href="#" class="btn-close<?if($save_yn !="Y"){?> odr<?}?>" odr_status="<?=$odr_status;?>" imsi_odr_no="<?=$imsi_odr_no?>"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">

	<form name="f" id="f">
	<input type="hidden" name="odr_idx" id="odr_idx_05_04" value="<?=$odr_idx?>">
	<input type="hidden" name="typ" id="typ" value="">
	<input type="hidden" name="sell_mem_idx" id="sell_mem_idx" value="<?=$sell_mem_idx?>">
	<input type="hidden" name="sell_rel_idx" id="sell_rel_idx" value="<?=$sell_rel_idx?>">
	<input type="hidden" name="session_mem_idx" id="session_mem_idx" value="<?=$session_mem_idx?>">
	<input type="hidden" name="session_rel_idx" id="session_rel_idx" value="<?=$session_rel_idx?>">
	<input type="hidden" name="chked_cnt" id="chked_cnt" value="0">
	<input type="hidden" name="new_odr_idx" id="new_odr_idx" value="">
	<input type="hidden" name="old_odr_idx" id="old_odr_idx" value="">
	<input type="hidden" name="save_yn" id="save_yn" value="">
	<input type="hidden" name="whole_part_type" id="whole_part_type" value="">
	<input type="hidden" id="s_nation" value="<?=$s_nation?>">
	<input type="hidden" id="b_nation" value="<?=$b_nation?>">
	<input type="hidden" id="det_cnt" value="<?=$det_cnt?>">

	<table class="stock-list-table">
		<thead>
			<tr>
				<th scope="col" style="width:50px">
				<?=($det_cnt>1)? "Option":"&nbsp;";?>
				<!--<span lang="ko">선적</span><br>-->
				</th>
				<th scope="col" class="t-no">No. </th>
				<th scope="col" class="t-nation">Nation</th>
				<th scope="col" class="t-partno">Part No.</th>
				<th scope="col" class="t-Manufacturer">Manufacturer</th>
				<th scope="col" class="t-Package">Package</th>
				<th scope="col" class="t-dc">D/C</th>
				<th scope="col" class="t-rohs">RoHS</th>
				<th scope="col" class="t-oty">O'ty</th>
				<th scope="col" class="t-unitprice">Unit Price</th>
				<th scope="col" lang="ko" class="t-orderoty">발주수량</th>
				<!--<th scope="col" lang="ko">공급수량 </th>-->
				<th scope="col" lang="ko" class="t-period">납기</th>
				<!--th scope="col" lang="ko" style="width:50px">&nbsp;</th-->
			</tr>
		</thead>
	<?
	for ($i = 1; $i<=7; $i++){
				echo GET_ODR_DET_LIST("05_04", $i," and odr_idx=$odr_idx ", $det_cnt);	//include/class/class.odrinfo.php
		}
		echo shipping_info($odr[odr_idx],"05_04");
		?>		
	</table>
	</form>
	<div class="btn-area t-rt">
		<img src="/kor/images/btn_order_add.gif" class="btn-dialog-0501" alt="발주 추가" style="cursor:pointer">
		<img src="/kor/images/btn_order_confirm_1.gif" alt="발주서 확인" style="cursor:pointer"><!--class="btn-order-confirm" -->
		
		<?if ($save_yn =="Y"){?>
			<img src="/kor/images/btn_order_save_1.gif" alt="발주 저장">
			<img src="/kor/images/btn_delete2.gif" alt="발주 삭제" style="cursor:pointer" class="btn-close odr" imsi_odr_no="<?=$imsi_odr_no?>">
		<?}else{?>
			<img src="/kor/images/btn_order_save.gif" alt="발주 저장" style="cursor:pointer" class="btn-dialog-save"><!--class="btn-dialog-save" -->
			<img src="/kor/images/btn_delete2_1.gif" alt="삭제" id="btn_del_0504">
		<?}?>

	</div>
</div>

