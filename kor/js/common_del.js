$(document).ready(function(){
	
	//gnb
	$("#gnb>ul>li>a").on("mouseover",function(){
		$li = $(this).parent("li");
		$img = $(this).find(">img");
		$src = $img.attr("src");
		if($li.is(".active")){
		}else{
			$li.siblings("li").each(function(index, element) {
				$(this).removeClass("active");
				$(this).find(">a>img").attr("src",$(this).find(">a>img").attr("src").replace("_on\.",'.'));
			});
			$li.addClass("active");
			$src = $src.replace( '.',"_on\.");
			$img.attr("src",$src);
		}
	});
	
	$("#gnb>ul>li").on("mouseleave",function(){
		$(this).removeClass("active");
		$img = $(this).find(">a>img");
		$src = $img.attr("src");
		$img.attr("src",$img.attr("src").replace("_on\.",'.'));	
		setMenu("","");
	});
	

	//checkbox
	$("body").on("click","input[type='checkbox']",function(){
		if($(this).prop("checked") == true){
			$(this).addClass('checked');
		}
		else if($(this).prop("checked") == false){
			$(this).removeClass('checked');
		}
	});

	$("body").on("click",".record_history",function(){
		var $this = $(this);
			if ($this.find("img").attr("src") == "/kor/images/img_icon_record.gif")  //원 발주 내역 history 버전으로.
			{
				$this.find("img").attr("src", "/kor/images/img_icon_record_y.gif");
				$.ajax({ 
					type: "GET", 
					url: "/ajax/proc_ajax.php", 
					data: { actty : "SLS", //show layer step for history
							actidx : $this.attr("odr_idx"),
							actkind : $this.attr("odr_det_idx")							
					},
						dataType : "html" ,
						async : false ,
						success: function(data){ 
							var $data = $(data);
							$this.parent().siblings().hide();
							$this.parent().parent().append($data.find("ol li").addClass("fty"));
							
						}
				});
			}else{		// 불량 통보 history 버전으로.
				$this.find("img").attr("src", "/kor/images/img_icon_record.gif");				
				$this.parent().parent().find(".fty").remove();
				$this.parent().siblings().show();
			}
			
	});

	
	
	//radio
	$("body").on("click","input[type='radio']",function(){
		if($(this).prop("checked") == true){
			$("[name="+$(this).attr('name')+"]").removeClass('checked');
			$(this).addClass('checked');
		}
		else if($(this).prop("checked") == false){
			$(this).removeClass('checked');
		}
	});
	
	//company-info-wrap>check
	$("body").on("click",".com-chck>input",function(){
		if($(this).prop("checked") == true){
			$(".company-info-wrap").show();
		}
		else if($(this).prop("checked") == false){
			$(".company-info-wrap").hide();
		}
	});
	
	//select
	$("body").on("change","select",function(){
		$select_name = $(this).children("option:selected").text();
		$select_lang = $(this).children("option:selected").attr("lang");
		$(this).siblings("label").text($select_name);
		$(this).siblings("label").attr("lang",$select_lang);
	})
	
	//collapse-panel
	$("body").on("click",".collapse-panel .panel-hd",function(){
		$(this).next(".panel-bd").stop().slideDown("100");
		$(this).next(".panel-bd").siblings(".panel-bd").stop().slideUp("100");
	});
	$(".collapse-panel .panel-hd:first-child").click();
	
	$("section[class^='layer']").on("click",".btn-close",function(){
		$(this).parents("section[class^='layer']").removeClass("open");
		$("body").removeClass("open-layer");
	});
	
	$("section[class^='layer']").on("click",".btn-close",function(){
		$(this).parents("section[class^='layer']").removeClass("open");
		$("body").removeClass("open-layer");
	});

	$('.onlynum').css("ime-mode","disabled").keypress(function(event){ 		//숫자만 입력하게.(.도 포함) 
	  if (event.which && (event.which == 190 || event.which == 110 || event.which > 45 && event.which < 58 || event.which == 8 || event.which > 95 && event.which < 106)) {			
	   } else { 
	   event.preventDefault(); 
	  } 
	 });
		 
	 $('.numfmt').css("ime-mode","disabled").keyup( function(event){   // 숫자 입력 하면 ,로 단위 끊어 표시하게.
			check_value(this);
	 });
	
	function openLayer(layerNum,loadPage,varNum){
		$layer = $("."+layerNum+"-section");
		$layer.addClass("open");
		$layer.siblings("section").css("z-index","900");
		$layer.css("z-index","999");
		$("body").addClass("open-layer");
		!varNum? $var = "" : $var = varNum;
		$layer.find(">.layer-wrap").load("/kor/layer/"+loadPage+".php"+$var);
	}
	
	
	////////////////////////* sell & buy *///////////////////////////////////
	$(".layer-wrap").on("click", ".view-sell", function(){
		//openLayer("layer","layerSell");
		openLayer("layer","31_04","?mn=01&status=1&page=1");
	});
	
	$(".layer-wrap").on("click", ".view-buy", function(){
		//openLayer("layer","layerBuy");
		openLayer("layer","31_06","?mn=01&status=16&page=1");
	});
	
	$(".open-layer-sell").on("click",function(){
		openLayer("layer","layerSell");
	});
	
	$(".open-layer-buy").on("click",function(){
		openLayer("layer","layerBuy");
	});
	
	$("body").on("click",".sell-mn01",function(){
		openLayer("layer","31_04","?mn=01&status=2&page=1");
	});

	$("body").on("mouseover", ".layer-left-menu>ul>li", function(){
		if ($(this).find("span.count").text() >0 )
		{
			$(this).addClass("current");
		}
	}).on("mouseout", ".layer-left-menu>ul>li", function(){
		if($(this).hasClass("this")==false){
			$(this).removeClass("current");
		}
	});

	$("body").on("click",".sell-mn02",function(){
		if (mem_idx=="")
		{
			alert_msg("로그인이 필요합니다.");
		}else{
			openLayer('layer','30_06','?mn=02&status=2&page=1');
		}
	});

	$("body").on("click",".orderConfirm",function(){
		//openLayer("layer","30_06","?mn=02");
		$.ajax({
				url: "/kor/proc/odr_proc.php", 
				data: "typ=odrconfirm&odr_idx="+$("#odr_idx_30_05").val()+"&sell_mem_idx="+$("#sell_mem_idx").val(),
				encType:"multipart/form-data",
				success: function (data) {	
					if (trim(data) == "SUCCESS"){		
						//alert_msg("판매자에게 확정 발주서를 전송했습니다.");
						document.location.href="/kor/";
					}else{
						alert_msg(data);
					}
				}
		});		
	});	 

	$("body").on("click",".odrAmendConfirm",function(){
		//openLayer("layer","30_06","?mn=02");
		$.ajax({
				url: "/kor/proc/odr_proc.php", 
				data: "typ=odramendconfirm&odr_idx="+$(this).attr("odr_idx"),
				encType:"multipart/form-data",
				success: function (data) {	
					if (trim(data) == "SUCCESS"){		
						//alert_msg("판매자에게 확정 발주서를 전송했습니다.");
						document.location.href="/kor/";
					}else{
						alert_msg(data);
					}
				}
		});		
	});	 

	$("body").on("click",".complete",function(){
		$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php", 
		data: { actty : "CF", //ConFirm
				actidx : $(this).attr("odr_history_idx")
		},
			dataType : "html" ,
			async : false ,
			success: function(data){ 
				document.location.href="/kor/";
			}
		});
	});
	$("body").on("click",".completeOnly",function(){
		$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php", 
		data: { actty : "CFO", //ConFirm
				actidx : $(this).attr("odr_history_idx")
		},
			dataType : "html" ,
			async : false ,
			success: function(data){ 
				document.location.href="/kor/";
			}
		});
	});


	$("body").on("click",".charge_amt",function(){
		$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php", 
		data: { actty : "IM", //insert mybank
				actidx : $(this).attr("odr_idx"),
				actkind : $(this).attr("odr_det_idx"),
				mem_idx : $(this).attr("mem_idx"),
				rel_idx : $(this).attr("rel_idx")
		},
			dataType : "html" ,
			async : false ,
			success: function(data){ 
				document.location.href="/kor/";
			}
		});
	});

	

	$("body").on("click",".comsucc",function(){
		$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php", 
		data: { actty : "CS", //Completely success
				actidx : $(this).attr("fty_history_idx")
		},
			dataType : "html" ,
			async : false ,
			success: function(data){ 
				document.location.href="/kor/";
			}
		});
	});

	$("body").on("click", ".confirmpwd" , function(){
		
		$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php", 
		data: { actty : "PWC", //ConFirm
				actidx : mem_idx,
				actkind :$("#mem_pwd").val() 
		},
			dataType : "html" ,
			async : false ,
			success: function(data){ 
				if (data.trim() =="Y")
				{
					showajaxParam(".col-left", "joinus" , "typ=edit");
				}else{
					$("#mem_pwd").val("").focus();
				}
			}
		});
	});

	//반품 선적 모든 처리 완료 "전송" 버튼 클릭시 (Black Type)
	$("body").on("click",".return_submit", function(){
		$.ajax({
				url: "/kor/proc/odr_proc.php", 
				data: "typ=return_submit&odr_idx="+$("#odr_idx_18R_16").val()+"&odr_det_idx="+$(this).attr("odr_det_idx")+"&return_method="+$("#return_method").val(),
				encType:"multipart/form-data",
				success: function (data) {	
					if (trim(data) == "SUCCESS"){		
						document.location.href="/kor/";
					}else{
						alert_msg(data);
					}
				}
		});		
	});

	//반품 선적 모든 처리 완료 "전송" 버튼 클릭시 (Red Type)
	$("body").on("click",".return_submit_R", function(){
		$.ajax({
				url: "/kor/proc/record_proc.php", 
				data: "typ=return_submit&odr_idx="+$(this).attr("odr_idx")+"&odr_det_idx="+$(this).attr("odr_det_idx")+"&return_method="+$(this).attr("return_method"),
				encType:"multipart/form-data",
				success: function (data) {	
					if (trim(data) == "SUCCESS"){		
						document.location.href="/kor/";
					}else{
						alert_msg(data);
					}
				}
		});		
	});
	$("body").on("click",".remit_submit", function(){
		alert_msg("입금 확인 요청 메세지를 전송하였습니다.");
		document.location.href="/kor/";
	});
	

	$("body").on("click",".sell-mn01-3106",function(){
		if($("#period").val()==""){
			alert_msg("납기 기간을 선택해 주세요.");
			$("#period").focus();
		}else{
			maskoff();
			$.ajax({
				url: "/kor/proc/odr_proc.php", 
				data: "typ=periodcfrm&odr_det_idx="+$("#odr_det_idx_31_05").val()+"&part_type="+$("#part_type_31_05").val()+"&part_no="+$("#part_no").val()+"&manufacturer="+encodeURIComponent($("#manufacturer").val())+"&package="+$("#package").val()+"&dc="+$("#dc").val()+"&supply_quantity="+$("#supply_quantity").val()+"&period="+$("#period").val()+"&pkind="+$(".layer-pagination.red .c-red2").text(),
				encType:"multipart/form-data",
				success: function (data) {	
					if (trim(data) == "SUCCESS ALL" || trim(data) == "SUCCESS"){		
						//alert_msg("구매자에게 납기 확인 완료 메세지를 보냈습니다.");
						document.location.href="/kor/";
					}else if(trim(data) == "SUCCESS"){	
						// 아직 납기 처리 해야 할게 남아 있으므로 해다 페이지 reloading
						closeCommLayer("layer3");
						openLayer("layer","31_04","?mn=01&status=1&page=1");
					}else{
						alert_msg(data);
					}
				}  
		});		

		}
	});

	// 판매자 메인 팝업
	$("body").on("click",".sell-mn02-1601",function(){
		openLayer("layer","16_01","?mn=02");
	});
	$("body").on("click",".sell-mn02-1701",function(){
		openLayer("layer","17_01","?mn=02");
	});
	$("body").on("click",".sell-mn03",function(){
		openLayer("layer","09_03","?mn=03&status=2");
	});
	$("body").on("click",".sell-mn03-1208",function(){
		openLayer("layer","12_08","?mn=03");
	});
	$("body").on("click",".sell-mn04",function(){
		openLayer("layer","10_04","?mn=04&status=2&page=1");
	});
	$("body").on("click",".sell-mn05",function(){
		openLayer("layer","30_15","?mn=05&status=2");
	});
	$("body").on("click",".sell-mn05-0128",function(){
		openLayer("layer","01_28","?mn=05&status=5");
	});	
	$("body").on("click",".sell-mn05-1217",function(){
		openLayer("layer","12_17","?mn=05");
	});
	$("body").on("click",".sell-mn05-1609",function(){
		openLayer("layer","16_09","?mn=05");
	});
	$("body").on("click",".sell-mn05-1716",function(){
		openLayer("layer","17_16","?mn=05");
	});

	//수령 main popup
	$("body").on("click",".sell-mn06",function(){
		openLayer("layer","30_22","?mn=06&status=2&page=1");
	});
	$("body").on("click",".sell-mn06-1225",function(){
		openLayer("layer","12_25","?mn=06");
	});
	$("body").on("click",".sell-mn07",function(){
		openLayer("layer","03_02","?mn=07&status=2&page=1");
	});
	$("body").on("click",".sell-mn08",function(){
		openLayer("layer","07_02","?mn=08&status=2");
	});
	$("body").on("click",".sell-mn08-1302",function(){
		openLayer("layer","13_02","?mn=08&status=8&page=1");
	});
	//거절 main popup
	$("body").on("click",".sell-mn09",function(){
		openLayer("layer","18R_06","?mn=09&status=2&page=1");
	});
	$("body").on("click",".sell-mn09-18r-10",function(){
		openLayer("layer","18R_10","?mn=09");
	});
	$("body").on("click",".sell-mn09-18r-14",function(){
		openLayer("layer","18R_14","?mn=09");
	});
	//수량부족 main popup
	$("body").on("click",".sell-mn10",function(){
		openLayer("layer","19_06","?mn=10&status=2&page=1");
	});
	$("body").on("click",".sell-mn10-1914",function(){
		openLayer("layer","19_14","?mn=10");
	});
	$("body").on("click",".sell-mn10-19-1-02",function(){
		openLayer("layer","19_1_02","?mn=10");
	});
	//반품선적완료 main popup
	$("body").on("click",".sell-mn11",function(){
		openLayer("layer","18R_19","?mn=11&status=2&page=1");
	});
	$("body").on("click",".sell-mn11-18-1-10",function(){
		openLayer("layer","18_1_10","?mn=11");
	});
	$("body").on("click",".sell-mn12",function(){
		openLayer("layer","21_05","?mn=12&status=2");
	});
	$("body").on("click",".sell-mn13",function(){
		openLayer("layer","21_1_04","?mn=13&status=2");
	});
	$("body").on("click",".sell-mn13-21-3-02",function(){
		openLayer("layer","21_3_02","?mn=13");
	});
	$("body").on("click",".sell-mn14",function(){
		openLayer("layer","21_1_09","?mn=14&status=2");
	});
	$("body").on("click",".sell-mn14-21-2-09",function(){
		openLayer("layer","21_2_09","?mn=14");
	});
	$("body").on("click",".sell-mn15",function(){
		openLayer("layer","21_7_02","?mn=15&status=2");
	});
	$("body").on("click",".sell-mn16",function(){
		openLayer("layer","21_3_10","?mn=16&status=2");
	});
	$("body").on("click",".sell-mn17",function(){
		openLayer("layer","21_4_11","?mn=17&status=2");
	});
	$("body").on("click",".sell-mn18",function(){
		openLayer("layer","21_4_10","?mn=18&status=2");
	});
	$("body").on("click",".sell-mn19",function(){
		openLayer("layer","21_14","?mn=19&status=2&page=1");
	});
	
	
	// 구매자 메인 팝업
	//납기확인 main popup
	$("body").on("click",".buy-mn01",function(){
		openLayer("layer","31_06","?mn=01&status=18&page=1");
	});
	$("body").on("click",".buy-mn02",function(){
		openLayer("layer","04_01","?mn=02");
	});
	$("body").on("click",".buy-mn02-0513",function(){
		openLayer("layer","05_13","?mn=02");
	});
	$("body").on("click",".buy-mn02-1206",function(){
		openLayer("layer","12_06","?mn=02");
	});
	$("body").on("click",".buy-mn02-1101",function(){
		openLayer("layer","11_01","?mn=02");
	});
	$("body").on("click",".buy-mn03",function(){  // 확정 송장 클릭시
		maskoff();
		//openLayer("layer","30_10","?mn=03");
		$.ajax({
				url: "/kor/proc/odr_proc.php", 
				data: "typ=invconfirm&odr_idx="+$("#odr_idx_30_09").val()+"&sell_mem_idx="+$("#sell_mem_idx_30_09").val(),
				encType:"multipart/form-data",
				success: function (data) {	
					if (trim(data) == "SUCCESS"){		
//						alert_msg("구매자에게 송장을 발송했습니다.");
						document.location.href="/kor/";
					}else{
						alert_msg(data);
					}
				}
		});		
	});

	

	$("body").on("click",".buy-mn03-3010",function(){  // left menu에서 송장 클릭시
		openLayer("layer","30_10","?mn=03&status=18");
	});

	$("body").on("click",".buy-mn03-1212",function(){
		openLayer("layer","12_12","?mn=03");
	});
	$("body").on("click",".buy-mn03-1705",function(){
		openLayer("layer","17_05","?mn=03");
	});
	$("body").on("click",".buy-mn04",function(){
		openLayer("layer","01_37","?mn=04&status=18&page=1");
	});
	$("body").on("click",".buy-mn05",function(){
		openLayer("layer","08_02","?mn=05&status=18&page=1");
	});
	$("body").on("click",".buy-mn06",function(){
		openLayer("layer","10_02","?mn=06&status=18&page=1");
	});
	$("body").on("click",".buy-mn07",function(){
		openLayer("layer","30_14","?mn=07&status=18&page=1");
	});
	$("body").on("click",".buy-mn07-18-2-15",function(){
		openLayer("layer","18_2_15","?mn=07");
	});
	$("body").on("click",".buy-mn07-0122",function(){
		openLayer("layer","01_22","?mn=07");
	});
	$("body").on("click",".buy-mn08",function(){
		openLayer("layer","30_20","?mn=08&status=18&page=1");
	});
	$("body").on("click",".buy-mn08-18r-01",function(){
		openLayer("layer","18R_01","?mn=08&status=13&page=1");
	});
	$("body").on("click",".buy-mn08-18r-25",function(){
		openLayer("layer","18R_25","?mn=08&status=13&page=1");
	});
	$("body").on("click",".buy-mn09",function(){
		openLayer("layer","02_02","?mn=09&status=18&page=1");
	});
	$("body").on("click",".buy-mn10",function(){
		openLayer("layer","06_02","?mn=10&status=18&page=1");
	});
	$("body").on("click",".buy-mn10-1304",function(){
		openLayer("layer","13_04","?mn=10&status=8&page=1");
	});
	$("body").on("click",".buy-mn11",function(){
		openLayer("layer","18R_08","?mn=11&status=18&page=1");
	});
	$("body").on("click",".buy-mn12",function(){
		openLayer("layer","19_08","?mn=12&status=18&page=1");
	});
	$("body").on("click",".buy-mn12-19-2-04",function(){
		openLayer("layer","19_2_04","?mn=12&status=10&page=1");
	});
	$("body").on("click",".buy-mn13",function(){
		openLayer("layer","18R_16","?mn=13&status=18");
	});
	$("body").on("click",".buy-mn13-18-1-02",function(){
		openLayer("layer","18_1_02","?mn=13&status=22");
	});
	$("body").on("click",".buy-mn14",function(){
		openLayer("layer","19_21","?mn=14&status=18");
	});
	$("body").on("click",".buy-mn15",function(){
		openLayer("layer","30_23","?mn=15&status=18");
	});
	$("body").on("click",".buy-mn16",function(){
		openLayer("layer","19_1_06","?mn=16&status=18");
	});
	$("body").on("click",".buy-mn16-19-1-06",function(){
		openLayer("layer","19_1_06","?mn=16&status=24");
	});
	$("body").on("click",".buy-mn17",function(){
		openLayer("layer","21_07","?mn=17&status=18");
	});
	$("body").on("click",".buy-mn18",function(){
		openLayer("layer","21_1_02","?mn=18&status=18");
	});
	$("body").on("click",".buy-mn18-21-3-04",function(){
		openLayer("layer","21_3_04","?mn=18&status=13");
	});
	$("body").on("click",".buy-mn20",function(){
		openLayer("layer","21_6_03","?mn=20&status=18");
	});
	$("body").on("click",".buy-mn21",function(){
		openLayer("layer","21_1_14","?mn=21&status=18");
	});
	$("body").on("click",".buy-mn22",function(){
		openLayer("layer","21_5_13","?mn=22&status=18");
	});
	$("body").on("click",".buy-mn23",function(){
		openLayer("layer","21_1_07","?mn=23&status=18");
	});
	$("body").on("click",".buy-mn23-21-2-02",function(){
		openLayer("layer","21_2_02","?mn=23&status=29");
	});
	$("body").on("click",".buy-mn24",function(){
		openLayer("layer","21_5_12","?mn=24&status=18");
	});	
	$("body").on("click",".buy-mn25",function(){
		openLayer("layer","21_16","?mn=25&status=18");
	});	
	////////////////////////////////////////////////////////////////////

	
	////////////////////////* sheet *///////////////////////////////////

	//order sheet
	$("body").on("click",".btn-view-sheet",function(){
			$.ajax({ 
			type: "GET", 
			url: "/ajax/proc_ajax.php", 
			data: { actty : "MRO", //Move to Real order Process
					actidx : $(this).attr("odr_idx"),
					actkind : $(this).attr("new_odr_idx")
			},
				dataType : "html" ,
				async : false ,
				success: function(data){ 
						openLayer("layer5","30_05","?odr_idx="+data);
						//"발주서 확인은 X 버튼을 삭제한다.
						
						$(".layer5-section .btn-close img").css("display","none");
				}
			});
		
		$("layer5-section .btn-close").css("display","none");
	});

	
	$("body").on("click",".btn-view-amend-sheet-forread",function(){
		openLayer("layer5","12_07","?odr_idx="+$(this).attr("odr_idx"));
	});


	$("body").on("click",".btn-view-sheet-3007",function(){
		openLayer("layer5","30_07");
	});
	$("body").on("click",".btn-view-sheet-3009",function(){		
		var err = false;
		var varNum;
		$("input[name^=supply_quantity]").each(function(){
			if($(this).val()==""){
				alert_msg("공급수량을 입력하세요.");
				$(this).focus();
				err = true;
				return false;
			}else if(parseInt($(this).parent().prev().text().replace(/,/gi,"")) < parseInt($(this).val())){
				alert_msg("공급수량을 다시 확인해 주세요.");
				$(this).focus();
				err = true;
				return false;
			}
		});	
		
		if (err == false)
		{
			maskoff();
			var f =  document.f;
			 f.target = "proc";
			 f.action = "/kor/proc/odr_proc.php";
			 f.submit();				
		}		
	});

	//송장 
	$("body").on("click",".btn-view-sheet-3011",function(){
		//송장 click case : $("#loadPage").val() == "03_10", "01_37"?
		
		if($("#list_"+$("#loadPage").val()).html().indexOf("확인 중")>0){
			alert_msg("납기 확인중인 부품이 있습니다.");
		}else{
			var extraVal="" , odr_idx="";
			//openLayer("layer5","30_11");
			if ($("#for_downpay_fr_seller").val()=="Y"){extraVal = "&for_downpay_fr_seller=Y";}
			if ($(this).attr("for_readonly")!=""){extraVal = extraVal+"&for_readonly="+$(this).attr("for_readonly");}
			if ($("#odr_idx_30_10").val()>0)
			{
				odr_idx = $("#odr_idx_30_10").val();	
			}else if($("#odr_idx_01_37").val()>0){
				odr_idx = $("#odr_idx_01_37").val();
				maskoff();
				extraVal = "&req_addcapa="+$("#req_addcapa").val();
			}else if ($("#odr_idx_30_20").val()>0)
			{
				odr_idx = $("#odr_idx_30_20").val();
				
			}else if ($("#odr_idx").val()>0)
			{
				odr_idx = $("#odr_idx").val();
			}else if ($("#odr_idx_"+$("#loadPage").val()).val()>0)
			{
				odr_idx = $("#odr_idx_"+$("#loadPage").val()).val();
			}else{
				odr_idx = $(this).parent().attr("odr_idx");
			}
			openLayer("layer5","30_09","?odr_idx="+odr_idx+extraVal);	
		}
	});
	//보증금용 송장 (판매자)
	$("body").on("click",".btn-view-sheet-1713",function(){
			openLayer("layer5","17_13","?odr_idx="+$("#odr_idx_"+$("#loadPage").val()).val());	
	});
	

	$("body").on("click",".account_upd_and_inv_confirm", function(){
		var $this = $(this);
		var account_no = $this.parent().parent().find("#account_no").val();
		var company_idx = $this.parent().parent().find("#company_idx").val();  //운송회사 idx
		var odr_idx = $("#odr_idx_"+$("#loadPage").val()).val();
		
		if($("input[name=appoint_account_yn]:checked").val()=="N"){
				account_no = "";
				company_idx = "";
		}
		
		$.ajax({ 
			type: "GET", 
			url: "/ajax/proc_ajax.php", 
			data: { actty : "UA", //update account no to ship table
					account_no : account_no, 
					odr_idx : odr_idx,
					ship_info : company_idx
			},
				dataType : "html",
				async : false ,
				success: function(data){ 	
						openLayer("layer5","30_09","?odr_idx="+odr_idx);	
			}
		});	
	});



	//위로금 송장
	$("body").on("click",".btn-view-sheet-21-3-06",function(){
		var extraVal="" , odr_idx="";
		openLayer("layer5","21_3_06","?odr_idx="+$(this).attr("odr_idx")+"&odr_det_idx="+$(this).attr("odr_det_idx"));	
	});

	//환불 송장
	$("body").on("click",".btn-view-sheet-19-1-04",function(){
		var extraVal="" , odr_idx="";
		openLayer("layer5","19_1_04","?odr_idx="+$(this).parent().attr("odr_idx")+"&odr_det_idx="+$(this).parent().attr("odr_det_idx")+"&forgenl="+$(this).parent().attr("forgenl"));	
	});

	//부대비용 송장
	$("body").on("click",".btn-view-sheet-18-2-09",function(){
		var extraVal="" , odr_idx="";
		openLayer("layer5","18_2_09","?odr_idx="+$(this).attr("odr_idx")+"&odr_det_idx="+$(this).attr("odr_det_idx"));	
	});

	
	$("body").on("click",".btn-view-sheet-21-1-10",function(){
		openLayer("layer5","21_1_10","?odr_idx="+$(this).attr("odr_idx")+"&odr_det_idx="+$(this).attr("odr_det_idx"));		
	});


	$("body").on("click",".btn-view-sheet-3017",function(){
		openLayer("layer5","30_17");
	});
	$("body").on("click",".btn-view-sheet-3019",function(){
		maskoff();
		$.ajax({
				url: "/kor/proc/odr_proc.php", 
				data: "typ=updweight&odr_idx="+$("#odr_idx").val()+"&ship_weight="+$("#ship_weight").val()+"&weight_type="+$("#weight_type").val(),
				encType:"multipart/form-data",
				success: function (data) {	
					if (trim(data) == "SUCCESS"){
						closeCommLayer("layer4");
						$(".btn-view-sheet-3011").click();
					}
				}
		});		
		//openLayer("layer5","30_19");// design
	});

	//반품 선적 서류	
	//1. Non-Commercial Invoice

	$("body").on("click",".btn-view-sheet-18-1-05",function(){		
		openLayer("layer5","18_1_05","?odr_idx="+$(this).attr("odr_idx")+"&odr_det_idx="+$(this).attr("odr_det_idx")+"&for_readonly="+$(this).attr("for_readonly"));		
	});
	//2. Packing List
	$("body").on("click",".btn-pop-21-2-06",function(){	
		if($("#ship_weight").val()==""){
			alert_msg("선적 중량을 입력 바랍니다.");
			return;
		}else{
			maskoff();
			$.ajax({
					url: "/kor/proc/record_proc.php", 
					data: "typ=updweight&ship_idx="+$("#ship_idx").val()+"&ship_weight="+$("#ship_weight").val()+"&weight_type="+$("#weight_type").val(),
					encType:"multipart/form-data",
					success: function (data) {	
						if (trim(data) == "SUCCESS"){
							closeCommLayer("layer4");
							var extraVal="";
							extraVal = "&odr_det_idx="+$("#odr_det_idx").val()+"&for_readonly=P";
							openLayer("layer5","18_1_05","?odr_idx="+$("#odr_idx").val()+extraVal);
						}
					}
			});		
		}
		
	});


	//3. 반품 사유서
	$("body").on("click",".btn-pop-18-1-08",function(){
		//ship_ty : 일반 발주에서의 반품인지, 불량 통보에서의 반품인지. (odr or rcd)
		openLayer("layer4","18_1_08","?ship_idx="+$(this).attr("ship_idx")+"&ship_type="+$(this).attr("ship_type"));		
	});

	$("body").on("click",".btn-view-sheet-18-1-09",function(){
		f = document.f5;
		if (nullchk(f.recv,"수신인을 입력하세요.")== false) return ;		
		if (nullchk(f.refer,"참조를 입력하세요.")== false) return ;		
		if (nullchk(f.content,"내용을 입력하세요.")== false) return ;		

		var formData = $("#f5").serialize(); 
			$.ajax({
					url: "/kor/proc/record_proc.php", 
					data: formData,
					encType:"multipart/form-data",
					success: function (data) {	
						if (trim(data) == "SUCCESS"){						
							closeCommLayer("layer4");
							openLayer("layer5","18_1_09","?ship_idx="+f.ship_idx.value);
						}
					}
			});

	});
	$("body").on("click",".btn-view-sheet-0120",function(){
		openLayer("layer5","01_20");
	});

	// 수정 발주서 amend sheet 
	$("body").on("click",".btn-view-sheet-1207",function(){
		var $chked_odr = $("input[name^=odr_det_idx]:checked");
		if($chked_odr.length==0){ 
			alert_msg("발주서를 선택해 주세요.");
		}else{
			var err = false; 
			err = updateQty();
			if (err == false)
			{
				openLayer("layer5","12_07","?odr_idx="+$(this).attr("odr_idx"));
			}
		}

	});

	//agreement sheet
	$("body").on("click",".btn-view-sheet-21-1-01",function(){
		var odr_idx = $("#f6 input[name=odr_idx]").val();
		var odr_det_idx = $("#f6 input[name=odr_det_idx]").val();		
		var bpway ="";
		if (typeof(odr_idx)=="undefined")
		{
			odr_idx = $(this).attr("odr_idx");
			odr_det_idx = $(this).attr("odr_det_idx");
			bpway = $(this).attr("bpway");
			
		}
		openLayer("layer5","21_1_01","?odr_det_idx="+odr_det_idx+"&odr_idx="+odr_idx+"&bpway="+bpway);
	});

	//agreement sheet
	$("body").on("click",".btn-view-sheet-21-3-01",function(){
		var odr_idx = $("#f6 input[name=odr_idx]").val();
		var odr_det_idx = $("#f6 input[name=odr_det_idx]").val();		
		var bpway ="";
		if (typeof(odr_idx)=="undefined")
		{
			odr_idx = $(this).attr("odr_idx");
			odr_det_idx = $(this).attr("odr_det_idx");
			bpway = $(this).attr("bpway");
			
		}
		openLayer("layer5","21_3_01","?odr_det_idx="+odr_det_idx+"&odr_idx="+odr_idx+"&bpway="+bpway);
	});

	//연구소 agreement sheet
	$("body").on("click",".btn-view-sheet-21-4-01",function(){
		var odr_idx = $("#f6 input[name=odr_idx]").val();
		var odr_det_idx = $("#f6 input[name=odr_det_idx]").val();		
		var bpway ="";
		if (typeof(odr_idx)=="undefined")
		{
			odr_idx = $(this).attr("odr_idx");
			odr_det_idx = $(this).attr("odr_det_idx");
			bpway = $(this).attr("bpway");
			
		}
		openLayer("layer5","21_4_01","?odr_det_idx="+odr_det_idx+"&odr_idx="+odr_idx+"&bpway="+bpway);
	});

	
	//판매자가 동의서에서 동의 버튼 클릭시 
	$("body").on("click",".agreeConfirm",function(){		
		var odr_idx = $(this).attr("odr_idx");
		var odr_det_idx = $(this).attr("odr_det_idx");
		var agreement_no = $(this).attr("agreement_no");
		var reason_ty = $(this).attr("reason_ty");
		
		$.ajax({
				url: "/kor/proc/record_proc.php", 
				data: "typ=agreeconfirm&odr_idx="+odr_idx+"&odr_det_idx="+odr_det_idx+"&agreement_no="+agreement_no+"&reason_ty="+reason_ty,
				encType:"multipart/form-data",
				success: function (data) {	
					if (trim(data) == "SUCCESS"){		
						//alert_msg("판매자에게 확정 발주서를 전송했습니다.");
						document.location.href="/kor/";
					}else{
						alert_msg(data);
					}
				}
		});		
	});	 


	$("body").on("click",".btn-view-sheet-21-4-06",function(){		
		openLayer("layer5","21_4_06","?odr_idx="+$(this).parent().attr("odr_idx")+"&odr_det_idx="+$(this).parent().attr("odr_det_idx"));
	});
	
	
	$("body").on("click",".btn-view-sheet-21-4-12",function(){
		openLayer("layer5","21_4_12","?fty_history_idx="+$(this).attr("fty_history_idx"));
	});
	////////////////////////////////////////////////////////////////////
	
	
	
	////////////////////////* dialog *///////////////////////////////////
	$("body").on("click",".btn-order , .btn-dialog-3102",function(){	
		var loadPage  = $(this).attr("class")=="btn-dialog-3102" ? "31_02" : "05_04";
		if (mem_idx=="")
		{
			alert_msg("로그인이 필요합니다.");
		}else if(com_idx == $(this).attr("sell_com_idx")){
			alert_msg("판매회사와 구매회사가 동일합니다.");
		}else{
			if (loadPage == "31_02")
			{
				openLayer("layer3", loadPage ,"?part_idx="+$(this).attr("id"));
			}else{
			 var f =  document.ftop;
			 f.part_idx.value=$(this).attr("id");
			 f.typ.value="write";
			 f.target = "proc";
			 f.action = "/kor/proc/odr_proc.php";
			 f.submit();		
			}			
		}
	});	
	$("body").on("click",".btn-turnkey", function(){
		if (mem_idx=="")
		{
			alert_msg("로그인이 필요합니다.");
		}else{
			 var f =  document.ftop;
			 f.part_idx.value=$(this).attr("id");
			 f.part_type.value=$(this).attr("part_type");
			 f.typ.value="writeturnkey";
			 f.target = "proc";
			 f.action = "/kor/proc/odr_proc.php";
			 f.submit();		
		}
	});
	$("body").on("click",".btn-order-periodconfirm",function(){
		var LoadPage;
		LoadPage = $("#f_add input[name=fromLoadPage").val()=="09_01" ? "09_01" : "05_04";		
		openLayer("layer3",LoadPage,"?odr_idx="+$("#odr_idx_31_06").val());		
	});
	$("body").on("click",".btn-invoice-3008",function(){
		openLayer("layer3","30_08","?odr_idx="+$(this).attr("odr_idx"));
	});

	$("body").on("click",".btn-appoint_reg",function(){
		var $this = $(this);	
		$.ajax({ 
				type: "GET", 
				url: "/ajax/proc_ajax.php", 
				data: { actty : "AR", //get appoint carrier
						actkind : $this.attr("odr_idx"), 
						actidx : $this.prev().find("select option:selected").val()

				},
					dataType : "html" ,
					async : false ,
					success: function(data){ 						
							openLayer("layer3",$this.attr("loadPage"),"?odr_idx="+$this.attr("odr_idx"));
							closeCommLayer("layer4");
				}
		});
	});

	$("body").on("click",".btn-reg-my-impship", function(){
		var $this = $(this);
		var account_no = $this.parents("tbody").find("#account_no").val();
		var company_idx = $this.parents("tbody").find("#company_idx").val();  //운송회사 idx
		if (account_no==""){alert_msg("Enter Account No.");return;} 
		if (company_idx==""){alert_msg("Enter Account No.");return;} 

		$.ajax({ 
			type: "GET", 
			url: "/ajax/proc_ajax.php", 
			data: { actty : "RS", //reg my impship
					actkind : account_no, 
					actidx : company_idx,
					com_idx : com_idx
			},
				dataType : "html",
				async : false ,
				success: function(data){ 	
						openLayer("layer4","15_08","?o_company_idx="+company_idx+"&com_idx="+com_idx);
			}
		});
	
		
	});


	//선적 다이얼로그
	$("body").on("click",".btn-dialog-3016",function(){
		openLayer("layer3","30_16","?odr_idx="+$("#odr_idx_30_15").val());
	});
	//수령 다이얼로그
	$("body").on("click",".btn-dialog-3021",function(){
		var $chked_odr_det = $("input[name^=odr_det_idx]:checked");
		if($chked_odr_det.length==0){
			alert_msg("제품을 선택해 주세요.");
		}else{
			var ch_odr_det_idx = [];
			$chked_odr_det.each(function(e){
						ch_odr_det_idx.push($(this).val());
			});
			openLayer("layer3","30_21","?loadPage="+$("#loadPage").val()+"&odr_idx="+$("#odr_idx_"+$("#loadPage").val()).val()+"&odr_det_idx="+ch_odr_det_idx);
		}
	});

	//지연 다이얼로그
	$("body").on("click",".btn-dialog-3021_D",function(){
		openLayer("layer3","30_21","?ty=Delay&loadPage="+$("#loadPage").val()+"&odr_idx="+$("#odr_idx_"+$("#loadPage").val()).val());
	});
	
	$("body").on("click",".btn-dialog-18R05",function(){
		var odr_det_idx = $(this).attr("odr_det_idx");
		if ($("#buyer_delivery_fee").val()=="")
		{
			alert_msg("운임을 입력해 주세요.");
			$("#buyer_delivery_fee").focus();			
		}else{
			maskoff();
			$.ajax({
					url: "/kor/proc/odr_proc.php", 
					data: "typ=updbuyerdelifee&odr_idx="+$("#odr_idx_30_20").val()+"&buyer_delivery_fee="+$("#buyer_delivery_fee").val(),
					encType:"multipart/form-data",
					success: function (data) {	
						if (trim(data) == "SUCCESS"){
							closeCommLayer("layer4");
							openLayer("layer3","18R_05","?odr_idx="+$("#odr_idx_30_20").val()+"&odr_det_idx="+odr_det_idx);
						}
					}
			});				
		}
	});

	

	//거절,회신서, 답변서 다이얼로그
	$("body").on("click",".btn-dialog-18R07",function(){
		var odr_det_idx = $(this).parent().attr("odr_det_idx");
		//openLayer("layer3","18R_07");
		openLayer("layer3","18R_05","?odr_idx="+$("#odr_idx_18R_06").val()+"&odr_det_idx="+odr_det_idx);
	});
	//수량부족,회신서, 답변서 다이얼로그
	$("body").on("click",".btn-dialog-1906",function(){
		//openLayer("layer3","18R_07");
		openLayer("layer3","18R_05","?fault_method=3&fault_quantity="+$("#fault_quantity").val()+"&odr_idx="+$("#odr_idx_19_06").val()+"&odr_det_idx="+$(this).parent().attr("odr_det_idx"));
	});
	//수량부족 다이얼로그
	$("body").on("click",".btn-dialog-1905",function(){
//		openLayer("layer3","19_05","");
		if ($("#fault_quantity").val()=="")
		{
			alert_msg("부족 수량 개수를 입력해 주세요.");
			$("#fault_quantity").focus();			
		}else{
			closeCommLayer("layer4");
			openLayer("layer3","18R_05","?odr_idx="+$("#odr_idx_30_20").val()+"&odr_det_idx="+$(this).attr("odr_det_idx")+"&fault_method=3&fault_quantity="+$("#fault_quantity").val());
		}

		
	});

	$("body").on("click",".btn-dialog-18R09",function(){
		//openLayer("layer3","18R_09");
		openLayer("layer3","18R_05","?odr_idx="+$("#odr_idx_18R_08").val()+"&odr_det_idx="+$(this).parent().attr("odr_det_idx"));
	});
	
	$("body").on("click",".btn-dialog-1908",function(){
		//openLayer("layer3","18R_07");
		openLayer("layer3","18R_05","?fault_method=3&fault_quantity="+$("#fault_quantity").val()+"&odr_idx="+$("#odr_idx_19_08").val()+"&odr_det_idx="+$(this).parent().attr("odr_det_idx"));
	});

	//반품방법 다이얼로그
	$("body").on("click",".btn-dialog-18R15",function(){
		openLayer("layer3","18R_15","?odr_idx="+$("#odr_idx_18R_06").val()+"&odr_det_idx="+$(this).parent().attr("odr_det_idx")+"&fault_select="+$(this).attr("fault_select"));
	});
	//동의서에서 (빨간 테두리) 반품방법 다이얼로그
	$("body").on("click",".btn-dialog-21-1-06",function(){
		openLayer("layer3","21_1_06","?odr_idx="+$(this).attr("odr_idx")+"&odr_det_idx="+$(this).attr("odr_det_idx"));
	});
	//선적(거절 후 교환 선적) 다이얼로그
	$("body").on("click",".btn-dialog-18R21",function(){		
		closeCommLayer("layer4");
		openLayer("layer3","18R_21","?odr_idx="+$("#odr_idx_"+$("#loadPage").val()).val()+"&odr_det_idx="+$(this).attr("odr_det_idx"));
		//openLayer("layer3","18R_21");
	});
	$("body").on("click",".btn-dialog-18-1-04",function(){
		openLayer("layer3","18_1_04","?odr_det_idx="+$(this).attr("odr_det_idx")+"&odr_idx="+$(this).attr("odr_idx")+"&return_method="+$(this).attr("return_method")+"&fault_select="+$(this).attr("fault_select"));
	});

	//신용카드 결제 창
	$("body").on("click",".btn-dialog-18-2-12",function(){
		pay_pop(document.payform);
	});
	$("body").on("click",".btn-dialog-18-2-14",function(){
		openLayer("layer3","18_2_14");
	});
	
	//납기 확인 다이얼로그
	$("body").on("click",".btn-dialog-3105",function(){
		openLayer("layer3","31_05","?part_type="+$(this).attr("part_type")+"&odr_det_idx="+$(this).attr("odr_det_idx"));
	});
	$("body").on("click",".btn-dialog-0129",function(){
		openLayer("layer3","01_29","?odr_idx="+$("#odr_idx_30_15").val());
	});
	$("body").on("click",".btn-dialog-0136",function(){
		openLayer("layer3","01_36","?odr_idx="+$("#odr_idx_30_15").val());
	});
	$("body").on("click",".btn-dialog-0501",function(){
		saveExtraInfo();
		openLayer("layer3","05_01","?odr_idx="+$("#odr_idx_05_04").val());
		$("#addsearch_part_no").focus();
	});
	$("body").on("click", ".btn-addsearch", function(){
		btn_addSearch();
	});

	
	$("body").on("click",".btn-dialog-0501-from_0901",function(){
		saveExtraInfo();
		openLayer("layer3","05_01","?odr_idx="+$("#odr_idx_"+$("#loadPage").val()).val()+"&fromLoadPage=09_01");
		$("#addsearch_part_no").focus();
	});

	//지연 period가 없으면 자동 1주일 지연 처리. period가 있으면 period만큼 지연 확인 요청
	$("body").on("click",".Delay",function(){	
		var err = false;
		if($("#autoExtension").val()!="Y"){
			if ($("#period").val()=="")
			{
				alert_msg("납기 연장 납기일을 선택해 주세요.");
				var err = true;
				$("#period").focus();				
			}
		}
		if (err==false)
		{
			$.ajax({ 
			type: "GET", 
			url: "/ajax/proc_ajax.php", 
			data: { actty : "DP", //Delay Process
					actidx : $(this).attr("odr_idx"),
					actkind : $("#period").val()
			},
				dataType : "html" ,
				async : false ,
				success: function(data){ 
						if ($("#autoExtension").val()!="Y")
						{
							alert_msg("구매자에게 납기 연장 확인 요청 메세지를 보냈습니다.");
						}else{
							alert_msg("1 Week 자동연장 되었습니다.");
						}						
					document.location.href="/kor/";
				}
			});

		}
	});

	//한번 이상 지연시 지연 다이얼로그
	$("body").on("click",".btn-dialog-1001",function(){
		openLayer("layer3","10_01","?odr_idx="+$("#odr_idx_"+$("#loadPage").val()).val());
	});


	$("body").on("click",".btn-dialog-0504",function(){
		var err = false;
		var varNum;
		$("input[name^=odr_quantity]").each(function(){
			if($(this).val()==""){
			//	alert_msg("수량을 입력하세요.");
				$(this).focus();
				err = true;
				return false;
			}else if(parseInt($(this).parent().prev().prev().text().replace(/,/gi,"")) < parseInt($(this).val())){
			//	alert_msg("수량을 다시 확인해 주세요.");
				$(this).focus();
				err = true;
				return false;
			}
		});		
		
		if (err == false)
		{
			maskoff();
			var f =  document.f;
			 f.target = "proc";
			 f.action = "/kor/proc/odr_proc.php";
			 f.submit();				
		}
	});

	$("body").on("click",".btn-dialog-addperiodreq,.btn-dialog-add",function(){
		var $odr_qty = $(this).parent().parent().find("input[name=odr_quantity]");
		var $qty = $odr_qty.next();
		var $part_idx = $qty.next();
		var $part_type = $part_idx.next();
		if($odr_qty.val()==""){
				alert_msg("수량을 입력하세요.");
				$odr_qty.focus();
		}else if ($part_type!="2" && parseInt(numOffMask($odr_qty.val())) > parseInt(numOffMask($qty.val())))
		{
				alert_msg("발주수량을 다시 확인해 주세요.");
				$odr_qty.focus();
				return false;
		}else{
			maskoff();
			if($(this).attr("class")=="btn-dialog-add"){
				 var f =  document.f_addproc;
				 f.typ.value="write";
				 f.part_idx.value=$part_idx.val();
				 f.part_type.value=$part_type.val();
				 f.odr_quantity.value=$odr_qty.val();
				 f.target = "proc";
				 f.action = "/kor/proc/odr_proc.php";
				 f.submit();		
			}else{
				openLayer("layer4","31_03","?part_idx="+$part_idx.val()+"&odr_idx="+$("#odr_idx_31_06").val()+"&odr_quantity="+$odr_qty.val()+"&fromPage=add&fromLoadPage="+$("#fromLoadPage").val()+"&addsearch_part_no="+$("#addsearch_part_no").val());
			}
		}				
	});

	
	$("body").on("click",".btn-dialog-save",function(){
			var err = false;
			var varNum;
			$("input[name^=odr_quantity]").each(function(){
				if($(this).val()==""){
					alert_msg("수량을 입력하세요.");
					$(this).focus();
					err = true;
					return false;
				}else if(parseInt($(this).parent().prev().prev().text().replace(/,/gi,"")) < parseInt($(this).val())){
					alert_msg("수량을 다시 확인해 주세요.");
					$(this).focus();
					err = true;
					return false;
				}
			});		
			
			if (err == false)
			{				
				$("#save_yn").val("Y");
				$("#typ").val("odredit");
				maskoff();
				var f =  document.f;
				 f.target = "proc";
				 f.action = "/kor/proc/odr_proc.php";
				 f.submit();				
			}
	});


	$("body").on("click",".delivery_save",function(){
		$("#delivery_save_yn").val("Y");

		if (nullchk(f.com_name,"회사명을 입력하세요.")== false) return ;		
		$("#typ").val("delivery_save");		
		//alert($("#typ").val());
		delivery_save();
	});

	$("body").on("click",".delivery_del",function(){
		$("#typ").val("delivery_del");		
		delivery_save();
	});

	function delivery_save(){
			var f = document.f;
			var formData = $("#f").serialize(); 
			$.ajax({
					url: "/kor/proc/odr_proc.php", 
					data: formData,
					encType:"multipart/form-data",
					success: function (data) {	
						$.ajax({ 
						type: "GET", 
						url: "/ajax/proc_ajax.php", 
						data: { actty : "GDA", //get Delivery addr
								actidx : trim(data),
						},
							dataType : "html" ,
							async : false ,
							success: function(data2){ 		
								$(".company-info-wrap").html(data2);
							}
						});
					}
			});		

	}

	$("body").on("click",".btn-dialog-0901",function(){
		var odr_idx =  $(this).parent().attr("odr_idx");
		var odr_det_idx =  $(this).parent().attr("odr_det_idx");

		
		$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php", 
		data: { actty : "UAQ", //Update Add QUANTITY
				actidx : odr_idx,
				actkind : $("#req_addcapa").val()
		},
			dataType : "html" ,
			async : false ,
			success: function(data){ 		
				openLayer("layer3","09_01","?odr_det_idx="+odr_det_idx+"&odr_idx="+odr_idx);
			}
		});
	});
	$("body").on("click",".btn-dialog-1219",function(){
		openLayer("layer3","12_19");
	});
	$("body").on("click",".btn-dialog-1210",function(){
		openLayer("layer3","12_10");
	});

	$("body").on("click",".btn-dialog-1916",function(){
		openLayer("layer4","19_16", "?odr_det_idx="+$(this).parent().attr("odr_det_idx"));
	});
	
	//수량 부족 후 추가 선적 다이얼로그 -> param추가 후 교환 선적으로 연결
	$("body").on("click",".btn-dialog-1917",function(){
//		openLayer("layer3","19_17");
		closeCommLayer("layer4");
		openLayer("layer3","18R_21","?fault_quantity="+$("#fault_quantity").val()+"&fault_select=3&odr_idx="+$("#odr_idx_"+$("#loadPage").val()).val()+"&odr_det_idx="+$(this).attr("odr_det_idx"));
	});
	$("body").on("click",".btn-dialog-2104",function(){
		var odr_det_idx = $(this).attr("odr_det_idx"); 
		var odr_idx = $(this).attr("odr_idx"); 
		if ($("#faulty_delivery_fee").val()=="")
		{
			alert_msg("운임을 입력해 주세요.");
			$("#faulty_delivery_fee").focus();			
		}else{
			maskoff();
			$.ajax({
					url: "/kor/proc/odr_proc.php", 
					data: "typ=updfaultydelifee&odr_idx="+odr_idx+"&faulty_delivery_fee="+$("#faulty_delivery_fee").val(),
					encType:"multipart/form-data",
					success: function (data) {	
						if (trim(data) == "SUCCESS"){
							closeCommLayer("layer4");
							openLayer("layer3","21_04","?odr_det_idx="+odr_det_idx);
						}
					}
			});				
		}
	});

	$("body").on("click",".btn-dialog-2106",function(){
		var odr_det_idx = $(this).attr("odr_det_idx"); 
			openLayer("layer3","21_04","?odr_det_idx="+odr_det_idx);
	});
	$("body").on("click",".btn-dialog-2108",function(){
		var odr_det_idx = $(this).attr("odr_det_idx"); 
		openLayer("layer3","21_04","?odr_det_idx="+odr_det_idx);
	//	openLayer("layer3","21_08");
	});
	$("body").on("click",".btn-dialog-21-2-03",function(){
		openLayer("layer3","21_2_03","?odr_det_idx="+$(this).attr("odr_det_idx")+"&odr_idx="+$(this).attr("odr_idx"));
	});

	// request rnd용 반품 선적
	$("body").on("click",".btn-dialog-21-2-03_rnd",function(){
		openLayer("layer3","21_5_06","?odr_det_idx="+$(this).attr("odr_det_idx")+"&odr_idx="+$(this).attr("odr_idx"));
	});

	$("body").on("click",".btn-dialog-21-2-10",function(){
		openLayer("layer3","21_2_10","?odr_det_idx="+$(this).attr("odr_det_idx")+"&odr_idx="+$(this).attr("odr_idx"));
	});
	$("body").on("click",".btn-dialog-21-4-13",function(){
		openLayer("layer3","21_4_13","?tTy="+$(this).attr("tTy")+"&testresult="+$(this).attr("testresult")+"&loadPage="+$("#loadPage").val()+"&fty_history_idx="+$(this).attr("fty_history_idx"));
	});
	////////////////////////////////////////////////////////////////////
	
	
	////////////////////////* pop *///////////////////////////////////
	$("body").on("click",".buy-mn03_0115",function(){//지속적 공급 가능 주문에서 확정 송장 클릭시에는 바로 처리 하지 않고, 공지를 한번 띄운 후 처리한다. 
		openLayer("layer4","01_15","?odr_idx="+$("#odr_idx_30_09").val());
	});

	
	function updateQty(){
		var err = false;
		$("input[name^=odr_quantity]").each(function(){
			if($(this).val()==""){
				alert_msg("수량을 입력하세요.");
				$(this).focus();
				err = true;
				return false;
			}else if(parseInt($(this).parent().prev().prev().text().replace(/,/gi,"")) < parseInt($(this).val())){
				alert_msg("수량을 다시 확인해 주세요.");
				$(this).focus();
				err = true;
				return false;
			}else{
				maskoff();
				$.ajax({ 
					type: "GET", 
					url: "/ajax/proc_ajax.php", 
					data: { actty : "UQ", //Update QUANTITY
							actidx : $(this).attr("odr_det_idx"),
							actkind : $(this).val()
					},
						dataType : "html" ,
						async : false ,
						success: function(data){ 		
								maskoff();
						}
					});
			}
		});	


		if($("#delivery_chg").is(":checked")){
			if (nullchk(f.com_name,"회사명을 입력하세요.")== false){
				err = true; 				
			}else{
				if($("#delivery_addr_idx").val()==""){   //save_yn='N'으로 먼저 저장해야 함.
					$("#delivery_save_yn").val("N");
					$("#typ").val("delivery_save");		
					delivery_save();
				}
			}
		}else{
			$("#delivery_addr_idx").val("");
		}


		if (err == false)
		{
			$("#f input[name=typ]").val("odredit");
			var formData = $("#f").serialize(); 
			$.ajax({
					url: "/kor/proc/odr_proc.php", 
					data: formData,
					encType:"multipart/form-data",
					success: function (data) {									
						if($("#odr_idx_"+$("#loadPage").val()).parent().html().indexOf("확인 중")>0){
							err =true;
							alert_msg("납기 확인중인 부품이 있습니다.");							
						}else{
							err=false;
						}

					}
			});		
		}
		return err;
	}

	$("body").on("click",".btn-order-confirm",function(){
		var err = false; 
		err = updateQty();
		
		if (err == false)
		{
			var $chked_odr = $("input[name^=odr_det_idx]:checked");
			if($chked_odr.length==0){ 
				alert_msg("발주서를 선택해 주세요.");
			}else{
					var new_odr_idx = [];
					$chked_odr.each(function(e){
						new_odr_idx.push($(this).val());
					});
					$("#new_odr_idx").val(new_odr_idx);
				openLayer("layer4","30_04","?odr_idx="+$("#odr_idx_05_04").val()+"&new_odr_idx="+new_odr_idx+"&whole_part_type="+$("#whole_part_type").val());
			}
		}		
	});

	

	$("body").on("click",".btn-pop-3013",function(){
		if ($(this).parent().attr("fromLoadPage") == "21_4_06") //red version으로
		{
			openLayer("layer4","21_5_03","?odr_idx="+$(this).parent().attr("odr_idx")+"&odr_det_idx="+$(this).parent().attr("odr_det_idx")+"&tot_amt="+$(this).parent().attr("tot_amt")+"&fromLoadPage="+$(this).parent().attr("fromLoadPage")+"&deposit_yn="+$(this).parent().attr("deposit_yn")+"&charge_type="+$(this).parent().attr("charge_type"));
		}else{
			openLayer("layer4","30_13","?odr_idx="+$(this).parent().attr("odr_idx")+"&odr_det_idx="+$(this).parent().attr("odr_det_idx")+"&tot_amt="+$(this).parent().attr("tot_amt")+"&fromLoadPage="+$(this).parent().attr("fromLoadPage")+"&deposit_yn="+$(this).parent().attr("deposit_yn")+"&charge_type="+$(this).parent().attr("charge_type"));
		}
		
	});
	$("body").on("click",".btn-pop-3018",function(){	
		var extraVal="";
		if($("#odr_det_idx").length>0){
			extraVal = "&odr_det_idx="+$("#odr_det_idx").val();
		}
		if ($(this).attr("ver")=="black")
		{
			extraVal = extraVal +"&ver=black";
		}
		openLayer("layer4","30_18","?odr_idx="+$("#odr_idx").val()+extraVal);
	});

	//반품선적 버튼 (Black)
	$("body").on("click",".btn-pop-18R18",function(){
		openLayer("layer4","18R_18","?odr_idx="+$(this).parent().attr("odr_idx")+"&odr_det_idx="+$(this).parent().attr("odr_det_idx"));
	});
	//반품선적 버튼 (Red)
	$("body").on("click",".btn-pop-21-1-08",function(){
		openLayer("layer4","21_1_08", "?odr_idx="+$(this).attr("odr_idx")+"&odr_det_idx="+$(this).attr("odr_det_idx")+"&return_method="+$(this).attr("return_method"));
	});
	


	$("body").on("click",".btn-pop-18R20",function(){
		openLayer("layer4","18R_20","?odr_det_idx="+$(this).parent().attr("odr_det_idx"));
	});
	$("body").on("click",".btn-pop-18R04",function(){
		var $chked_odr_det = $("input[name^=odr_det_idx]:checked");
		if($chked_odr_det.length==0){
			alert_msg("제품을 선택해 주세요.");
		}else{
			var ch_odr_det_idx = [];
			$chked_odr_det.each(function(e){
						ch_odr_det_idx.push($(this).val());
			});
			openLayer("layer4","18R_04", "?odr_det_idx="+ch_odr_det_idx);
		}
	});
	
	$("body").on("click",".btn-pop-18-2-08",function(){
		openLayer("layer4","18_2_08","?odr_idx="+$(this).parent().attr("odr_idx")+"&odr_det_idx="+$(this).parent().attr("odr_det_idx"));
	});
	

	

	$("body").on("click",".btn-remittance",function(){
		openLayer("layer4","23_21");
	});	

	//결제 팝업 (Black Ver)
	$("body").on("click",".btn-pop-3012",function(){

		if ($(this).attr("tot_amt")=="")
		{

			$(this).attr("tot_amt",$("#tot_"+$(this).attr("odr_idx")).val());
		}
		openLayer("layer4","30_12","?odr_idx="+$(this).attr("odr_idx")+"&odr_det_idx="+$(this).attr("odr_det_idx")+"&tot_amt="+$(this).attr("tot_amt")+"&fromLoadPage="+$(this).attr("fromLoadPage")+"&deposit_yn="+$(this).attr("deposit_yn")+"&charge_type="+$(this).attr("charge_type"));
	});	
	//결제 팝업 (Red Ver)
	$("body").on("click",".btn-pop-21-1-11",function(){		
		openLayer("layer4","21_1_11","?odr_idx="+$(this).attr("odr_idx")+"&odr_det_idx="+$(this).attr("odr_det_idx")+"&tot_amt="+$(this).attr("tot_amt")+"&fromLoadPage="+$(this).attr("fromLoadPage")+"&charge_type="+$(this).attr("charge_type"));
	});	

	//결제창에서 Mybank 클릭시 (Black ver)
	$("body").on("click",".btn-pop-18-2-11",function(){
		if($(this).attr("fromLoadPage")=="18_2_09"){
			openLayer("layer4","18_2_11","?odr_idx="+$(this).attr("odr_idx")+"&odr_det_idx="+$(this).attr("odr_det_idx")+"&tot_amt="+$("#tot_"+$(this).attr("odr_idx")).val()+"&typ=pay_access");
		}else{
			openLayer("layer4","18_2_11","?odr_idx="+$("#odr_idx_30_09").val()+"&tot_amt="+$("#tot_"+$("#odr_idx_30_09").val()).val()+"&typ=pay");
		}
	});

	//결제창에서 Mybank 클릭시 (Red ver)
	$("body").on("click",".btn-pop-21-1-12",function(){
		var targetPage;
			if($(this).attr("fromLoadPage")=="21_3_06"){
				targetPage="21_3_08";
			}else if($(this).attr("fromLoadPage")=="21_4_06"){
				targetPage="21_4_08";
			}else{
				targetPage ="21_1_12";
			}
		openLayer("layer4",targetPage,"?odr_idx="+$(this).attr("odr_idx")+"&odr_det_idx="+$(this).attr("odr_det_idx")+"&tot_amt="+$("#tot_"+$(this).attr("odr_det_idx")).val());
	});

	$("body").on("click",".btn-pop-3103",function(){
		
		if($("#odr_quantity").val()==""){
				alert_msg("발주수량을 입력하세요.");
				$("#odr_quantity").focus();				
				return false;
		}else if ($(this).attr("part_type")!="2" && parseInt(numOffMask($("#odr_quantity").val())) > parseInt(numOffMask($("#quantity").val())))
		{
			alert_msg("발주수량을 다시 확인해 주세요.");
			$("#odr_quantity").focus();				
				return false;
		}else{
			maskoff();
			openLayer("layer4","31_03","?part_idx="+$("#part_idx").val()+"&odr_quantity="+$("#odr_quantity").val());
		}
	});

	$("body").on("click",".periodreq",function(){
		maskoff();
		var f =  document.f;
		 f.target = "proc";
		 f.action = "/kor/proc/odr_proc.php";
		 f.submit();		
	});



	$("body").on("click",".succEnd , .arrival",function(){
		maskoff();
		var f =  document.f;
		 f.target = "proc";
		 f.action = "/kor/proc/odr_proc.php";
		 f.submit();		
	});

	//납기 확인 요청시 삭제 버튼 클릭 팝업
	$("body").on("click",".btn-pop-0201",function(){
		openLayer("layer4","02_01");
	});

	//납기 확인 요청 -> 삭제 버튼 -> 삭제 팝업에서 종료 버튼 클릭시 
	$("body").on("click",".del_confirm",function(){
		if ($("#reason").val()=="")
		{
			alert_msg("사유를 입력해 주세요.");
			$("#reason").focus();				
		}else{
			$.ajax({ 
			type: "GET", 
			url: "/ajax/proc_ajax.php", 
			data: { actty : "DLP", //Delete period
					actidx : $("#odr_idx_"+$("#loadPage").val()).val(),
					actkind : $("#reason").val()
			},
				dataType : "html" ,
				async : false ,
				success: function(data){ 
					alert_msg("삭제 메세지를 보냈습니다.");
					document.location.href="/kor/";
				}
			});
		}
	});
	$("body").on("click",".btn-pop-0119",function(){
		openLayer("layer4","01_19");
	});
	$("body").on("click",".btn-pop-0135",function(){
		openLayer("layer4","01_35","?odr_idx="+$("#odr_idx_30_15").val());
	});
	$("body").on("click",".btn-pop-0601",function(){
		openLayer("layer4","06_01");
	});
	$("body").on("click",".btn-pop-0701",function(){
		openLayer("layer4","07_01");
	});
	//납기 연장 수락 팝업
	$("body").on("click",".btn-pop-1003",function(){
		openLayer("layer4","10_03","?odr_history_idx="+$(this).attr("odr_history_idx"));
	});
	//납기 연장 수락 버튼 클릭시
	$("body").on("click",".delay_accept",function(){
			$.ajax({ 
				type: "GET", 
				url: "/ajax/proc_ajax.php", 
				data: { actty : "DA", //Delay Accept Process
						actidx : $(this).attr("odr_history_idx")
				},
					dataType : "html" ,
					async : false ,
					success: function(data){ 
							document.location.href="/kor/";
					}
			});
	});

	//납기 연장 허가 안함. 발주 취소.
	$("body").on("click",".btn-pop-1301",function(){
		openLayer("layer4","13_01");
	});


	$("body").on("click", ".cancel_odr",function(){
		
		$.ajax({ 
			type: "GET", 
			url: "/ajax/proc_ajax.php", 
			data: { actty : "CO", //Cancel Odr Process
					actidx : $("#odr_idx_"+$("#loadPage").val()).val(),
					actkind : "1"				   
			},
				dataType : "html" ,
				async : false ,
				success: function(data){ 
						alert_msg('납기 기한을 지키지 않아 취소 처리 하였습니다.');
						document.location.href="/kor/";
				}
		});
	});

	//판매자 납기 어겨 취소된 경우 계약금을 구매자에게 넘기는것 수락 버튼
	$("body").on("click",".btn-pop-1303",function(){
		openLayer("layer4","13_03");
	});

	$("body").on("click",".btn-pop-1303_1",function(){
		$.ajax({ 
				type: "GET", 
				url: "/ajax/proc_ajax.php", 
				data: { actty : "AC", //Accept Cancel
						actidx : $("#odr_idx_"+$("#loadPage").val()).val()
				},
					dataType : "html" ,
					async : false ,
					success: function(data){ 
							document.location.href="/kor/";
					}
			});
	});

	// 판매자 납기 어겨 취소된 경우 계약금 return proccess
	$("body").on("click", ".downpay_return", function(){
		$.ajax({ 
				type: "GET", 
				url: "/ajax/proc_ajax.php", 
				data: { actty : "RP", //return pay proccess
						actidx : $("#odr_idx_"+$("#loadPage").val()).val()
				},
					dataType : "html" ,
					async : false ,
					success: function(data){ 
							document.location.href="/kor/";
					}
			});
	});

	$("body").on("click",".btn-pop-1305",function(){
		openLayer("layer4","13_05","?odr_idx="+$("#odr_idx_"+$("#loadPage").val()).val()); 
	});
	

	$("body").on("click",".btn-pop-1218",function(){
		openLayer("layer4","12_18");
	});
	$("body").on("click",".btn-pop-1504",function(){
		var $this = $(this);
		if ($(this).hasClass("checked"))// 판매자 지정 운송 체크
		{
			$.ajax({ 
				type: "GET", 
				url: "/ajax/proc_ajax.php", 
				data: { actty : "GAC", //get appoint carrier
						actidx : $this.attr("odr_idx")
				},
					dataType : "html" ,
					async : false ,
					success: function(data){ 
							if (trim(data) == "")
							{
								openLayer("layer4","15_04","?odr_idx="+$this.attr("odr_idx")+"&loadPage="+$this.attr("loadPage"));
							}else{
								$this.parent().addClass("c-red");
								$this.parent().find("span[id=appoint]").html(": <img src='/kor/images/icon_"+trim(data)+".gif' height='15'>");
							}							
					}
			});

		}else{  //지정 운송 해지
			$this.parent().removeClass("c-red");
			$this.parent().find("span[id=appoint]").html("");


		}

		
	});
	$("body").on("click",".btn-pop-1706",function(){
		openLayer("layer4","17_06", "?odr_idx="+$(this).attr("odr_idx"));
	});
	$("body").on("click",".btn-pop-1904",function(){
		var $chked_odr_det = $("input[name^=odr_det_idx]:checked");
		if($chked_odr_det.length==0){
			alert_msg("제품을 선택해 주세요.");
		}else{
			var ch_odr_det_idx = [];
			$chked_odr_det.each(function(e){
						ch_odr_det_idx.push($(this).val());
			});
			
			openLayer("layer4","19_04", "?odr_det_idx="+ch_odr_det_idx);
		}
	});

	//RND 후 종료 작업
	$("body").on("click",".btn-end-proc",function(){
		var $this = $(this);
		$.ajax({ 
			type: "GET", 
			url: "/ajax/proc_ajax.php", 
			data: { actty : "EP",
					actidx : $this.attr("fty_history_idx"),
					actkind : $this.attr("faulty_delivery_fee"),
					tTy : $this.attr("tTy"),
					testresult : $this.attr("testresult"),
			},
				dataType : "html" ,
				async : false ,
				success: function(data){ 
					document.location.href="/kor/";					
				}
		});
	});

	$("body").on("click",".btn-pop-1916",function(){
		openLayer("layer4","19_16");
	});
	$("body").on("click",".btn-pop-2001",function(){
		openLayer("layer4","20_01","?his_type="+$(this).attr("his_type")+"&history_idx="+$(this).attr("history_idx")+"&invoice_no="+$(this).attr("invoice_no")); 
	});
	$("body").on("click",".btn-pop-2102",function(){
		openLayer("layer4","21_02","?odr_det_idx="+$(this).attr("odr_det_idx")); 
	});
	$("body").on("click",".btn-pop-2103",function(){
		openLayer("layer4","21_03","?odr_det_idx="+$(this).attr("odr_det_idx")); 
	});
	$("body").on("click",".btn-pop-2113",function(){
		openLayer("layer4","21_13","?odr_det_idx="+$(this).attr("odr_det_idx")); 
	});
	$("body").on("click",".btn-pop-2115",function(){
		openLayer("layer4","21_15","?odr_det_idx="+$(this).attr("odr_det_idx")); 
	});
	$("body").on("click",".btn-pop-21-1-15",function(){
		openLayer("layer4","21_1_15","?odr_idx="+$(this).attr("odr_idx")+"&odr_det_idx="+$(this).attr("odr_det_idx")+"&mem_idx="+$(this).attr("mem_idx")+"&rel_idx="+$(this).attr("rel_idx"));
	});
	$("body").on("click",".btn-pop-21-4-14",function(){
		openLayer("layer4","21_4_14","?tTy="+$(this).attr("tTy")+"&testresult="+$(this).attr("testresult")+"&fty_history_idx="+$(this).attr("fty_history_idx"));
	});
	$("body").on("click",".btn-pop-21-5-05",function(){
		openLayer("layer4","21_5_05","?odr_idx="+$(this).attr("odr_idx")+"&odr_det_idx="+$(this).attr("odr_det_idx"));
	});
	$("body").on("click",".btn-pop-21-6-02",function(){
		openLayer("layer4","21_6_02","?odr_idx="+$(this).parent().attr("odr_idx")+"&odr_det_idx="+$(this).parent().attr("odr_det_idx"));
	});
	$("body").on("click",".btn-pop-21-7-01",function(){
		openLayer("layer4","21_7_01","?odr_idx="+$(this).parent().attr("odr_idx")+"&odr_det_idx="+$(this).parent().attr("odr_det_idx"));
	});
	$("body").on("click",".btn-pop-1508",function(){
		openLayer("layer4","15_08","?o_company_idx="+$(this).attr("o_company_idx")+"&com_idx="+$(this).attr("com_idx"));
	});
	$("body").on("click",".btn-pop-1509",function(){
		openLayer("layer4","15_09","?o_company_idx="+$(this).attr("o_company_idx"));
	});
	$("body").on("click",".btn-pop-2376",function(){
		openLayer("layer4","23_76");
	});
	////////////////////////////////////////////////////////////////////
	
	
	
	// 메세지
	$("body").on("click",".msg-02",function(){
		if ($(this).attr("ref")){
			openLayer("layer3","message_02","?ref="+$(this).attr("ref")+"&ref2="+$(this).attr("ref2")+"&lev="+$(this).attr("lev")+"&step="+$(this).attr("step"));
		}else{
			openLayer("layer3","message_02");
		}
	});
	$("body").on("click",".msg-03",function(){
		openLayer("layer3","message_03");
	});
	$("body").on("click",".open-msg",function(){
		$(this).parents("	tr").next("tr.msg-wrap").toggle();
		document.getElementById("proc").src="/kor/proc/board_proc.php?typ=send_result&idx="+$(this).attr("idx");
		$(this).className = "nonre open-msg"
	});
	
	$("body").on("click",".btn-mybox",function(){	
		if (mem_idx==""){
			alert_msg("로그인이 필요합니다.");
		}else if(com_idx == $(this).attr("sell_com_idx")){
			alert_msg("판매회사와 구매회사가 동일합니다.");
		}else{			
			 var f =  document.ftop;
			 f.part_idx.value=$(this).attr("id");
			 f.part_type.value=$(this).attr("part_type");
			 f.typ.value="mybox_in";
			 f.target = "proc";
			 f.action = "/kor/proc/odr_proc.php";
			 f.submit();		
		}
	});
	
	$("input[name=top_rhtype]").click(function(e){
				if($(this).hasClass("checked")){ //체크 해지시 
					$("input[name=both]").val("N");
					if($(this).val() =="HF"){
							$("input[value=RoHS]").removeClass("checked");
							$("input[value=RoHS]").prop("checked", false);
					}
				}else{   //체크시
					if($(this).val() =="RoHS"){
							$("input[value=HF]").addClass("checked");
							$("input[value=HF]").prop("checked", true);
							$("input[name=both]").val("Y");
							
					}
				}

		});



		
	$(".main_srch").click(function(e){
		main_srch();		
	});

	
	$("body").on("click",".btn-view-sheet-forread",function(){
		openLayer("layer5","30_05","?odr_idx="+$(this).attr("odr_idx"));
	});

	

});

function main_srch(){
	var formData = $("#ftop_sch").serialize(); 
		$.ajax({
				url: "/ajax/proc_ajax.php", 
				data: formData,
				success: function (data) {	
					if($("#stockList").length==0){
						showajax(".col-left", "main_stock");
					}
					$("#stockList .stock-list-table tbody").remove();
					$("#stockList .stock-list-table").append($(data).fadeIn(300));
					
					var ary = new Array();
					var idx, newidx;
					$("#stockList tbody[id^=tbd]").each(function(e){						
						if (typeof($(this).find("tr:eq(1) td:eq(8)").html())=="string")
						{
							ary.push($(this).find("tr:eq(1) td:eq(8)").html());
						}else{
							ary.push("$99999999");
						}
					});

					var aryIdx = new Array();
					var temp1 , temp2;
					for (i=0;i<6;i++ )	{aryIdx.push(i);}

					for(i = 0; i < ary.length; i++) {
					   for(j = 0; j < (ary.length - i-1); j++) {
						 if((ary[j]) > (ary[j + 1])) {
						   temp1 = ary[j];
						   ary[j] = ary[j + 1];
						   ary[j + 1] = temp1;
						   temp2 = aryIdx[j];
						   aryIdx[j] = aryIdx[j + 1];
						   aryIdx[j + 1] = temp2;
						 }
					   }
					 }

					 var $sel, totsel="";
					 for (i=0;i<6 ;i++)
					 {										 
						idx =aryIdx[i];						
						newidx = idx+1;
						
						$sel = $("#stockList .stock-list-table #tbd_"+newidx);		
						totsel = totsel + "<tbody id= 'tbd_"+newidx+"'>"+$sel.html()+"</tbody>\n";
					 }
					$("#stockList .stock-list-table tbody").remove();
					$("#stockList .stock-list-table").append($(totsel).fadeIn(300));
					$("#stockList .stock-list-table tbody:eq(0) td:eq(0)").addClass("first");
					if($("input[name=area]:checked").length==1){
						$(".select.type3.opt1:eq(0)").hide();
						$(".select.type3.opt1:eq(1)").show();
					}else{
						$(".select.type3.opt1:eq(0)").show();
						$(".select.type3.opt1:eq(1)").hide();
					}
					ready();
				}
		});		
}

function btn_addSearch(){
		openCommLayer("layer3","05_01","?odr_idx="+$("#odr_idx_31_06").val()+"&addsearch_part_no="+$("#addsearch_part_no").val()+"&fromLoadPage="+$("#fromLoadPage").val());
		$("#addsearch_part_no").focus();
	}
	