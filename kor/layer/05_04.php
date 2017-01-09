<?
/*************************** 화면 : 발주창(카트) **********************************************************************
**** 2016-03-25 : 한개품목일때 '납기확인중'품목은 '발주','삭제' 불가 처리
**** 2016-03-29 : 삭제관련 다시 정리(stock과 납기확인 품목 따로 삭제시 페이지 리로드에 의한 선택값 증발 문제)
**** 2016-08-06 : class.odrinfo.php 에 있던 shipping_info()를 선.착불 여부에따라 호출 다르게...
**********************************************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
if (!$_SESSION["MEM_IDX"]){ReopenLayer("layer6","alert","?alert=sessionend");exit;}
?>

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
	$det_cnt = QRY_CNT("odr_det"," and odr_idx=$odr_idx ");  //odr_det 수량
	$per_cnt = QRY_CNT("odr_det"," and odr_idx=$odr_idx and odr_status=16 ");  //납기 받은 품목 수
	$turnkey_cnt = QRY_CNT("odr_det"," and odr_idx=$odr_idx and part_type=7 ");  //턴키
}
//국제 배송비 관련
$trade_type = ($s_nation == $b_nation)? 1:0;
$dlvr_cnt = QRY_CNT("freight_charge"," and trade_type=$trade_type and rel_idx = $sell_mem_idx 
							AND (f_dest_idx = $b_nation or f_dest_idx LIKE '$b_nation,%' or f_dest_idx LIKE '%,$b_nation,%' or f_dest_idx LIKE ',%$b_nation')");  //선불 배송비 등록여부
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
		var sel_box, part_type, det_idx, del_cnt=0, delv_cnt=0;
		var err = false;
		err = updateQty();
		if(err == false){
			//수량 및 배송정보 Update 후 삭제하자 2016-03-31
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
						async:false,
						data: "tbl=odr_det&idx="+det_idx+"&typ=del",
						encType:"multipart/form-data",
						success: function (data) {	
							if (trim(data) == "SUCCESS"){		
								del_cnt++;
							}else{
								alert(data);
							}
						}
					});
				} else{delv_cnt++;} // Stock 제품만 삭제
			}); //end each.
			//alert("del_cnt:"+del_cnt);
			//alert("det_cnt:"+det_cnt);
			if(del_cnt == det_cnt && det_cnt>0){  //모두 삭제 시
				if($(".layer-section").hasClass("open")) closeCommLayer("layer");
				Refresh_MainSh(); //메인 검색 실행
				closeCommLayer("layer3"); //발주창
			} else if(delv_cnt==0){  //삭제한게 있고, 납기 삭제할게 없을때만 새로고침
				openCommLayer("layer3","05_04","?odr_idx="+$("#odr_idx_05_04").val());
			}
			if(delv_cnt>0){
				alert_del("삭제","삭제하시겠습니까?","btn_ok");
			}
		}
	}
	//-- 납기 제품 선택 삭제------------------------------------------------------------------------------------
	function del_delv(){
		var det_cnt = $("#det_cnt").val(); //납기 삭제 전 남은 수량
		var delv_cnt=0;
		var err = false;
		err = updateQty();
		if(err == false){
			if(det_cnt>1){ //-- 여러개 일때 --------------------------
				sel_box = $("input[name^=odr_det_idx]:checked");
			}else{	//-- 한개일때 ---------------------------------------
				sel_box = $("input[name^=odr_det_idx]");
			}
			sel_box.each(function(e){ //실제 삭제 처리 (선택 갯수만큼 반복)--------------------
				part_type = $(this).attr("part_type");
				det_idx = $(this).val();
				if(part_type==2 || part_type==5 || part_type==6){
					$.ajax({ 
						type: "GET", 
						url: "/ajax/proc_ajax.php",
						async:false,
						data: { actty : "DLP", //Delete period
								actidx : $("#odr_idx_05_04").val(),
								det_idx : det_idx,
								actkind : '구매자 삭제'
								},
						dataType : "html" ,
						async : false ,
						success: function(data){ 
							delv_cnt++;
						}
					});
				}
			}); // end of each.

			if(det_cnt == delv_cnt){ //-- 남은게 없어------------
				closeCommLayer("layer6"); //메시지창
				closeCommLayer("layer3"); //발주창
				//document.location.href="/kor/";
				if($(".layer-section").hasClass("open")) closeCommLayer("layer");  //What's New 창
				Refresh_Right();  //오른쪽만 새로고침
			}else{ //-- 남은게 있어...
				if($(".btn-close").hasClass("save")){ // 저장일 경우... 발주번호 새로 따지 않는다. 2016-04-04
					openCommLayer("layer3","05_04","?odr_idx="+$("#odr_idx_05_04").val()); //기존 저장창
				}else{
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
				}
				//메시지창 닫고
				closeCommLayer("layer6");
			}
		}
	}
//-- 국가 변경 -------------------------
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
	//도시 변경
	function chgdosi(obj){		
		var nation_code;
		var s_nation = $("#s_nation").val();

		$("#dosi").val(obj.value).attr("selected", "selected");
		$("#dosi_en").val(obj.value).attr("selected", "selected");
        $("#dosi").siblings("label").text($("#dosi").children("option:selected").text());
		$("#dosi_en").siblings("label").text($("#dosi_en").children("option:selected").text());
		//$("#sigungu,#sigungu_en").val("");
		$("#real_do_val").val($("#dosi").children("option:selected").text());	
		

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
			//$("#sigungu").empty();
			//$("#sigungu").append($($data.html()));
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
							var post_val;
							var check_val = $("input:checkbox[id='zipcode_no']").is(":checked");
							//$("#sigungu_en").empty();
							//$("#sigungu_en").append($($data.html()));
							//$("#sigungu_en").siblings("label").text("English");

							$("#real_do_val").val($("#dosi").children("option:selected").text());
							
							$("#addr_en").val($("#dosi_en").children("option:selected").text()+", "+$("#nation").children("option:selected").text()+".");						
							$("#sp_addr_en u").html($("#dosi_en").children("option:selected").text()+", "+$("#nation").children("option:selected").text()+".");
							nation_code = $("#nation").children("option:selected").val();
							
							if (check_val==true)
							{
								post_val="";

								$("#zipcode").attr("readonly",true);
								$("#zipcode").css("background-color",'rgb(235, 235, 228)');
								$("#zipcode").val(" ");
							}
							else
							{
								$("#zipcode").css("background-color",'');
								$("#zipcode").attr("readonly",false);
								
								post_val=" "+$("#zipcode").val()+", ";
								
							}

							if (s_nation==nation_code)
							{
								if ((nation_code =="1" || nation_code =="2" || nation_code =="142") && s_nation == nation_code)
								{
									$("#addr").val($("#addr_full").val()+" "+", "+post_val+" "+nation_val);
				
									$("#sp_addr").html($("#addr_full").val()+" "+", "+post_val+" "+nation_val);
								}else{							
									$("#addr").val($("#addr_det").val()+" "+$("#sigungu").val()+" "+$("#dosi").children("option:selected").text()+", "+post_val+$("#nation").children("option:selected").text());
									$("#sp_addr").html($("#addr_det").val()+" "+$("#sigungu").val()+" "+$("#dosi").children("option:selected").text()+", "+post_val+$("#nation").children("option:selected").text());

								}
							}
							else
							{
								$("#addr").val($("#addr_det").val()+" "+$("#sigungu").val()+" "+$("#dosi").children("option:selected").text()+", "+post_val+$("#nation").children("option:selected").text());
								$("#sp_addr").html($("#addr_det").val()+" "+$("#sigungu").val()+" "+$("#dosi").children("option:selected").text()+", "+post_val+$("#nation").children("option:selected").text());
							}
							
						}
					});
			}
		});
	}
	//시.군.구 변경
	function chgsigungu(obj,enty){
		var nation_code;
		nation_code = $("#nation").children("option:selected").val();
		var check_val = $("input:checkbox[id='zipcode_no']").is(":checked");
		var dosit = $("#dosi"+enty+" option").length == 1? $("#dositxt"+enty).val():$("#dosi"+enty).children("option:selected").text();		
		var s_nation = $("#s_nation").val();
		var post_val;
		var post_val_en;
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
		if (s_nation==nation_code)
		{
			if ((nation_code =="1" || nation_code =="2" || nation_code =="142") && s_nation == nation_code)
			{
				$("#addr").val($("#addr_full").val()+" "+", "+post_val+" "+nation_val);
				
				$("#sp_addr").html($("#addr_full").val()+" "+", "+post_val+" "+nation_val);
			}else{
				$("#addr").val($("#addr_det").val()+" "+$("#sigungu").val()+" "+dosit+", "+post_val+$("#nation").children("option:selected").text()+".");
				$("#sp_addr").html($("#addr_det").val()+" "+$("#sigungu").val()+" "+dosit+", "+post_val+$("#nation").children("option:selected").text()+".");
			}
		}
		else
		{
			$("#addr").val($("#addr_det").val()+" "+$("#sigungu").val()+" "+dosit+", "+post_val+$("#nation").children("option:selected").text()+".");
			$("#sp_addr").html($("#addr_det").val()+" "+$("#sigungu").val()+" "+dosit+", "+post_val+$("#nation").children("option:selected").text()+".");
		}
	}

function chgdositxt(obj,enty){				
		var nation_code = $("#nation").children("option:selected").val();
		var check_val = $("input:checkbox[id='zipcode_no']").is(":checked");
		var post_val;
		var post_val_en;
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
	
		$("#real_do_val").val(obj.value);
		if (s_nation==nation_code)
		{
			if ((nation_code =="1" || nation_code =="2" ||nation_code =="142") && enty=="")
			{
				$("#addr").val($("#addr_full").val()+" "+", "+post_val+" "+nation_val);
				
				$("#sp_addr").html($("#addr_full").val()+" "+", "+post_val+" "+nation_val);
			}else{
				$("#addr").val($("#addr_det").val()+" "+$("#sigungu").val()+" "+obj.value+", "+post_val+$("#nation").children("option:selected").text()+".");
				$("#sp_addr").html($("#addr_det").val()+" "+$("#sigungu").val()+" "+obj.value+", "+post_val+$("#nation").children("option:selected").text()+".");

			}
		}
		else
		{
			$("#addr").val($("#addr_det").val()+" "+$("#sigungu").val()+" "+obj.value+", "+post_val+$("#nation").children("option:selected").text()+".");
			$("#sp_addr").html($("#addr_det").val()+" "+$("#sigungu").val()+" "+obj.value+", "+post_val+$("#nation").children("option:selected").text()+".");
		}
	}
//선불 배송비 - 운송회사 선택
function dlvr_click(obj){
	var mem_idx = $("#session_mem_idx").val();
	var dlvr_corp = $(obj).attr("corp_nm");
	var dlvr_pay = $(obj).attr("dlvr_pay");
	$("#sp_pay").html(dlvr_corp+" $"+dlvr_pay);
	$("#dlvr_pay").val(dlvr_pay);
	$.ajax({ 
	type: "GET", 
	url: "/ajax/proc_ajax.php", 
	data: { actty : "GAN", //Get Account Number
			actidx : mem_idx,
			actkind :obj.value 
	},
		dataType : "html" ,
		async : false ,
		success: function(data){
				$("#dlvr_acc").val(trim(data));
		}
	});		
}
$(document).ready(function(){

	var delivery_chg=$("input:checkbox[id='delivery_chg']").is(":checked");
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

	//'선적정보' 위치 조정
	//$(".detail-table").css('margin-top','2px');

	var odr_idx = '<?=$odr_idx?>';
	<?if (odr_idx == "")
	{
	?>
		add_change_sel();
	<?
	}
	?>
	
	//sorting 부분
	var n=[];	
	$("#layerPop3 .stock-list-table tr[id^=tr_]").each(function(){
		n.push(parseInt($(this).attr("id").replace("tr_","")));
	});	
	var nSort = n.sort();

	//20161121 클라이언트 정렬 주석처리 박정권
	/*for(i=nSort.length-1; i >=0; i--){
		$this = $("#layerPop3 .stock-list-table tr[id=tr_"+nSort[i]+"]").parent();
		$("#layerPop3 .stock-list-table tr[id=tr_"+nSort[i]+"]").parent().remove();
		$("#layerPop3 .stock-list-table thead:eq(0)").after($this);
	}	*/
	
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

	
alert(checkActive());


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

	//-- 값 변경
	$("#layerPop3 .stock-list-table input[name^=odr_quantity] , #layerPop3 #ship_account_no, #layerPop3 #memo").keyup(function(e){	
		maskoff();
		checkActive();	
		maskon();
	});
	//발주 수량 키업~
	$("#layerPop3 .stock-list-table input[name^=odr_quantity]").keyup(function(e){
		maskoff();	
		var quantity = $(this).parent().parent().find("input[name^=quantity]").val();
		//alert(quantity);
		if(parseInt($(this).val()) > parseInt(quantity)){
			$(this).val("");
		}
		maskon();
	});
	//-- 선적 선택
	$("#layerPop3 #ship_info").change(function(e){
		checkActive();
	});
	//-- 옵션(체크박스) 클릭
	$("#layerPop3 .stock-list-table input[name^=odr_det_idx]").click(function(e){
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
				$("#f_05_04 tr[id^=tr_]:not(:contains('확인'))").find("input[name^=odr_det_idx].stock").prop("disabled",false);
				$("#f_05_04 tr[id^=tr_]:not(:contains('확인'))").find("input[name^=odr_det_idx].endure").prop("disabled",false);
				$("#whole_part_type").val("");
			}			
			$("#chked_cnt").val(parseInt($("#chked_cnt").val())-1);
		}
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
	//공급수량 있는 품목의 옵션 안내 메세지 위치 조정
	if($("#t-supplyoty").hasClass("t-supplyoty")){
		$(".txt_option").css("margin-left","-545px");
	}
	//옵션 갯수에 따른 선택 안내 메세지
	var det_cnt = $("#det_cnt").val();
	if(det_cnt = $("#det_cnt").val()>1){
		$(".txt_option").show();
	}
	//선.착불 선택
	$("#layerPop3 .stock-list-table input[name^=dlvr_adv]").click(function(e){
		checkActive();
	});
	//선불.운송업체 선택
	$("#layerPop3 .stock-list-table input[name^=dlvr_corp]").click(function(e){
		checkActive();
	});

	checkActive();

	$("input[name=delivery_chg]").click(function(){
		
		if($(this).hasClass("checked") && MustChk()==true){
			$("#layerPop3 #btn-confirm").css("cursor","pointer").addClass("btn-order-confirm").attr("src","/kor/images/btn_order_confirm.gif");
			
		}else{
			
			$("#layerPop3 #btn-confirm").css("cursor","").removeClass("btn-order-confirm").attr("src","/kor/images/btn_order_confirm_1.gif");
		}
	});	
	
}); //end of Ready
//------------ 버튼 활성 or 비활성 ------------------------------------------------------------------
function checkActive(){

		var Erchkbox = false , ErchkCnt = true, FailCnt = 0;
		var det_cnt = $("#det_cnt").val();
		var dlvr_cnt = $("#dlvr_cnt").val();
		var turnkey_cnt = $("#turnkey_cnt").val();
		var chk_val=$("input:checkbox[id='delivery_chg']").is(":checked");
		$("#layerPop3 .btn-area :eq(2)").css("cursor","pointer").addClass("btn-dialog-save").attr("src","/kor/images/btn_order_save.gif"); //저장버튼
		//2016-03-30 ccolle-------------------------------------------------------------------
		if(det_cnt>1){ //-- 여러개 일때 --------------------------
			sel_box = $("input[name^=odr_det_idx]:checked");
			//$("#layerPop3 .btn-area :eq(2)").css("cursor","pointer").addClass("btn-dialog-save").attr("src","/kor/images/btn_order_save.gif"); //저장버튼
		}else{	//-- 한개일때 ---------------------------------------
			sel_box = $("input[name^=odr_det_idx]");
			/**
			//한개이고, 납기 받은거면 '저장' - 비활성 2016-04-05
			if(sel_box.attr("odr_status")==16){
				$("#layerPop3 .btn-area :eq(2)").css("cursor","").removeClass("btn-dialog-save").attr("src","/kor/images/btn_order_save_1.gif");
			}else{
				$("#layerPop3 .btn-area :eq(2)").css("cursor","pointer").addClass("btn-dialog-save").attr("src","/kor/images/btn_order_save.gif");
			}**/
		}
		var odr_qty=0, stock_qty=0;
		sel_box.each(function(e){ //선택 갯수만큼 반복--------------------
			Erchkbox = true;
			stock_qty = Number($(this).attr("quantity"));
			if($(this).attr("part_type")=='7'){
				odr_qty = 1;
			}else{
				odr_qty = $(this).parent().parent().parent().find("input[name^=odr_quantity]").val();
			}
			if(odr_qty == ""){
				odr_qty = 0;
			}else{
				odr_qty = Number(odr_qty);
			}
			if(odr_qty == "" || odr_qty<1) FailCnt++; //발주수량 유무.
			if($(this).attr("part_type")!='2' && $(this).attr("part_type")!='7'){ //지속적이 아닐 경우..2016-11-13:턴키도 안전재고 체크 무
				if(odr_qty > stock_qty) FailCnt++; //안전재고 체크
			}

		}); // end each
		//end of ccolle--------------------------------------------------------------------------------
		
		//선적정보 2016-11-06
		if(dlvr_cnt<1){	//선불 배송정보 없을 시..
			if(($("#ship_info option:selected").val()>=5  && $("#memo").val()=="") ||$("#ship_info option:selected").val()<5  && $("#ship_account_no").val()=="" || $("#ship_info option:selected").val()=="" ){
				ErchkCnt = false; 
			}
		}else{		//선불 배송정보 있을 시...
			//선불.착불 선택에 따라...
			var sel_adv = $("input:radio[name=dlvr_adv]:checked").val();
			
			if(sel_adv=="Y"){	//선불
				var dlvr_corp = $("input:radio[name='dlvr_corp']:checked").val();
				
				if(!(dlvr_corp && ($("#dlvr_acc").val() || chk_val))){
					ErchkCnt = false; 
				}
			}else if(sel_adv=="N"){	//착불
				if(($("#ship_info option:selected").val()>=5  && $("#memo").val()=="") ||$("#ship_info option:selected").val()<5  && $("#ship_account_no").val()=="" || $("#ship_info option:selected").val()=="" ){
					ErchkCnt = false; 
				}
			}else{
				ErchkCnt = false;
			}
		}
		


		if(det_cnt==1){
			if($("input[name^=odr_det_idx]").attr("odr_status") == 1) {
				Erchkbox = false;
			} else{
				Erchkbox = true;
			}
		}
		//-- 발주확인 버튼-------------------------
		if (Erchkbox==true && ErchkCnt == true && FailCnt==0 )
		{			
			if (chk_val==true)
			{
				if (MustChk()==true)
				{

					$("#layerPop3 #btn-confirm").css("cursor","pointer").addClass("btn-order-confirm").attr("src","/kor/images/btn_order_confirm.gif");
				}
				else
				{
					$("#layerPop3 #btn-confirm").css("cursor","").removeClass("btn-order-confirm").attr("src","/kor/images/btn_order_confirm_1.gif");
				}
				
			}
			else
			{
				$("#layerPop3 #btn-confirm").css("cursor","pointer").addClass("btn-order-confirm").attr("src","/kor/images/btn_order_confirm.gif");
				//$("#layerPop3 .btn-area :eq(1)").css("cursor","pointer").addClass("btn-order-confirm").attr("src","/kor/images/btn_order_confirm.gif");
			}
			
		}else{
			$("#layerPop3 #btn-confirm").css("cursor","").removeClass("btn-order-confirm").attr("src","/kor/images/btn_order_confirm_1.gif");
			//$("#layerPop3 .btn-area :eq(1)").css("cursor","").removeClass("btn-order-confirm").attr("src","/kor/images/btn_order_confirm_1.gif");
			
		}
		//-- 삭제버튼 처리 --------------------
		if(Erchkbox == true) {
			$("#btn_del_0504").css("cursor","pointer").attr("onclick","del_sel();").attr("src","/kor/images/btn_delete2.gif");
		}else{
			$("#btn_del_0504").css("cursor","").attr("onclick","").attr("src","/kor/images/btn_delete2_1.gif");
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
		$("#delv_load").val("05_04");
		$("#delivery_addr_idx").val("0");
		$(".company-rank td").attr('class',"");
		$(".company-info-wrap input,select").attr("disabled",true);
		$(".company-info-wrap select:eq(0)").attr("disabled",false);
		$("#ship_info").attr("disabled",false);	
		$(".company-info-wrap select:eq(1)").attr("disabled",true);
		$("#layerPop3 #btn-confirm").css("cursor","").removeClass("btn-order-confirm").attr("src","/kor/images/btn_order_confirm_1.gif");
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
	
	
//-->
</SCRIPT>


<div class="layer-hd">
	<h1>발주서</h1>
	<a href="#" class="btn-close<?=($save_yn =="Y")? " save":" odr";?>" odr_idx="<?=$odr_idx;?>" odr_status="<?=$odr_status;?>" imsi_odr_no="<?=$imsi_odr_no?>"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">

	<form name="f_05_04" id="f_05_04">
	<input type="hidden" name="odr_idx" id="odr_idx_05_04" value="<?=$odr_idx?>">
	<input type="hidden" name="typ" id="typ" value="">
	<input type="hidden" name="opnnerPage" id="opnnerPage" value="<?=$opnnerPage?>">
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
	<input type="hidden" id="per_cnt" value="<?=$per_cnt?>">
	<input type="hidden" id="odr_status" value="<?=$odr_status?>">
	<input type="hidden" id="dlvr_cnt" value="<?=$dlvr_cnt?>">
	<input type="hidden" id="turnkey_cnt" value="<?=$turnkey_cnt?>">
	<?
	if($per_cnt>0){
		$partno_width = 180;
	}else{
		if($det_cnt>1){
			$partno_width = 210;
		}else{
			$partno_width = 240;
		}
	}
	?>
	<table class="stock-list-table">
		<thead>
			<tr>
				<?if($det_cnt>1){?>
				<th scope="col" style="width:20px">Option</th>
				<?}?>
				<th scope="col" class="t-no">No. </th>
				<th scope="col" class="t-nation">Nation</th>
				<th scope="col" class="t-partno" Style="width:<?=$partno_width;?>px;"><?=($turnkey_cnt==0)?"Part No.":"Title"?></th>
				<th scope="col" class="t-Manufacturer"><?=($turnkey_cnt==0)?"Manufacturer":""?></th>
				<th scope="col" class="t-Package"><?=($turnkey_cnt==0)?"Package":""?></th>
				<th scope="col" class="t-dc"><?=($turnkey_cnt==0)?"D/C":""?></th>
				<th scope="col" class="t-rohs"><?=($turnkey_cnt==0)?"RoHS":""?></th>
				<th scope="col" class="t-oty"><?=($turnkey_cnt==0)?"O'ty":""?></th>
				<th scope="col" class="t-unitprice"><?=($turnkey_cnt==0)?"Unit Price":""?></th>
				<th scope="col" lang="ko" class="t-orderoty"><?=($turnkey_cnt==0)?"발주수량":"Price"?></th>
				<?if($per_cnt>0){?>
				<th scope="col" lang="ko" id="t-supplyoty" class="t-supplyoty">공급수량</th>
				<?}?>
				<th scope="col" lang="ko" class="t-period">납기</th>
				<!--th scope="col" lang="ko" style="width:50px">&nbsp;</th-->
			</tr>
		</thead>
		<?
		for ($i = 1; $i<=7; $i++){
			echo GET_ODR_DET_LIST("05_04", $i," and odr_idx=$odr_idx ", $det_cnt);	//include/class/class.odrinfo.php
		}
		if($dlvr_cnt > 0){
			echo pay_dlvr($odr[odr_idx], $sell_mem_idx, $b_nation);	//선.착불 배송비 선택 화면
		}else{
			echo shipping_info($odr[odr_idx],"05_04");
		}
		?>		
	</table>
	</form>
	<div class="btn-area t-rt">
		<?if($turnkey_cnt>0){?>
			<img id="btn-confirm" src="/kor/images/btn_order_confirm_1.gif" alt="발주서 확인">
		<?}else{?>
			<img src="/kor/images/btn_order_add.gif" class="btn-dialog-0501" alt="발주 추가" style="cursor:pointer">
			<img id="btn-confirm" src="/kor/images/btn_order_confirm_1.gif" alt="발주서 확인" style="cursor:pointer"><!--class="btn-order-confirm" -->
			
			<?if ($save_yn =="Y"){?>
				<img src="/kor/images/btn_order_save_1.gif" alt="발주 저장">
				<!--img src="/kor/images/btn_delete2.gif" alt="발주 삭제" style="cursor:pointer" class="btn-close odr" imsi_odr_no="<?=$imsi_odr_no?>"-->
			<?}else{?>
				<img src="/kor/images/btn_order_save.gif" alt="발주 저장" style="cursor:pointer" class="btn-dialog-save"><!--class="btn-dialog-save" -->
			<?}?>
			<img src="/kor/images/btn_delete2_1.gif" alt="삭제" id="btn_del_0504">
		<?}?>
	</div>
</div>

