/*********************************************************************************
*** 2016-03-31 : updateQty() 함수 수정, ready 밖으로 빼냄
*** 2016-04-04 : updateQty() 함수 수정, form 'f'를 'f_04_05'로 변경
*********************************************************************************/


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
	$("body").on("click","input[type=checkbox]",function(){
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
	$("body").on("click",".collapse-panel .panel-hd ",function(){
		$(this).next(".panel-bd").toggle();
		$(this).next(".stock-list-table").toggle();
		//$(this).next(".panel-bd").stop().slideDown("100");
		//$(this).next(".panel-bd").siblings(".panel-bd").stop().slideUp("100");
	});
	$(".collapse-panel .panel-hd:first-child").click();
	//---- 발주창(0504) 닫기(X) --------------------------------------------------------------
	$("section[class^='layer']").on("click",".btn-close",function(){

		var load_page = $("#loadPage").val();
		var menu_type_chk = getCookie('menu');
		var main_search_chk;
		
		if ($("input[name=top_part_no]").val().length>1)
		{
			setCookie('main_search',"y");	
			main_search_chk = getCookie('main_search');
		}
		else
		{
			setCookie('main_search',"n");	
			main_search_chk = getCookie('main_search');
		}

		if($(this).hasClass("0501"))
		{
			return;
		}

		if ($(this).hasClass("amend")){  // 기존 데이터 제외하고 amend 된 데이터 모두 삭제.
								
			$.ajax({ 
				type: "GET", 
				url: "/ajax/proc_ajax.php", 
				data: { actty : "RMA", //Remove amend data
						actidx : $(this).attr("odr_idx")
				},
					dataType : "html" ,
					async : false ,
					success: function(data){ 
//						document.location.href="/kor/";
					}
				});
		}else if($(this).hasClass("save")){  // 기존 데이터중 납기품목 제외하고 amend 된 데이터 모두 삭제. (저장 발주서) 2016-04-03
			
			$.ajax({ 
				type: "GET", 
				url: "/ajax/proc_ajax.php", 
				data: { actty : "RMS", //Remove amend data
						actidx : $(this).attr("odr_idx")
						},
				dataType : "html" ,
				async : false ,
				success: function(data){ 
					showajax(".col-right", "side_order");
					
					//document.location.href="/kor/";
				}
			});
		}
		
		//alert(getCookie('menu'));
		
		/*$.ajax({ 
			type: "GET", 
			url: "/ajax/cookie_get.php", 
			dataType : "text" ,
			async : false ,
			success: function(data){ 
					menu_type_chk = data;
			}
		});*/
				
		switch (menu_type_chk) {
			case "order_S"    : if(chkLogin()){order('S'); showajax(".col-right", "side_order");}
			           break;
			case "order_B"    : if(chkLogin()){order('B'); showajax(".col-right", "side_order");}
			           break;
			case "mybox"    : if(chkLogin()){showajax(".col-left", "mybox"); showajax(".col-right", "side_order");}
			           break;
			case "record_S"    : if(chkLogin()){record('S'); showajax(".col-right", "side_order");}
			           break;
			case "record_B"    : if(chkLogin()){record('B'); showajax(".col-right", "side_order");}
			           break;
			case "remit"    : if(chkLogin()){remit('C'); showajax(".col-right", "side_order");}
			           break;
			case "side_order"    : 
									if (main_search_chk=="y")
									{
										main_srch();
									}
									else
									{
										showajax(".col-right", "side_order");
									}
									
			           break;
			default    : 
							if($(this).hasClass("odr")){
			
								if($(".layer-section").hasClass("open")){
									if ($(this).attr("part_type") == "256")
									{					
										closeCommLayer("layer4");
									}
									else
									{
										closeCommLayer("layer");
										Refresh_Right();
									}
									
								}

								var mybox= $(this).hasClass("mybox");
								//기존 데이터 사라지게.(단, 납기 확인 중인 데이터 제외하고.)
									$.ajax({ 
									type: "GET", 
									url: "/ajax/proc_ajax.php", 
									data: { actty : "RM", //Remove
											actidx : $(this).attr("imsi_odr_no"),
											odrstat : $(this).attr("odr_status")//2016-03-27
									},
										dataType : "html" ,
										async : false ,
										success: function(data){ 
											if(mybox)
											{							
												showajax(".col-right", "side_order");
											}
											else
											{							
												main_srch();
											}
											
											//showajax(".col-right", "side_order");
										}
									});
							}else if ($(this).hasClass("amend")){  // 기존 데이터 제외하고 amend 된 데이터 모두 삭제.
								
								$.ajax({ 
									type: "GET", 
									url: "/ajax/proc_ajax.php", 
									data: { actty : "RMA", //Remove amend data
											actidx : $(this).attr("odr_idx")
									},
										dataType : "html" ,
										async : false ,
										success: function(data){ 
					//						document.location.href="/kor/";
										}
									});
							}else if($(this).hasClass("save")){  // 기존 데이터중 납기품목 제외하고 amend 된 데이터 모두 삭제. (저장 발주서) 2016-04-03
								
								$.ajax({ 
									type: "GET", 
									url: "/ajax/proc_ajax.php", 
									data: { actty : "RMS", //Remove amend data
											actidx : $(this).attr("odr_idx")
											},
									dataType : "html" ,
									async : false ,
									success: function(data){ 
										showajax(".col-right", "side_order");
										
										//document.location.href="/kor/";
									}
								});
							}

               break;
		}
				
		if($(this).hasClass("refresh_chk")){  // 기존 데이터중 납기품목 제외하고 amend 된 데이터 모두 삭제. (저장 발주서) 2016-04-03
			document.location.href="/kor/";
		}

	});
	
	$("section[class^='layer']").on("click",".btn-refresh",function(){
		document.location.href="/kor/";
	});

	$("section[class^='layer']").on("click",".btn-close",function(){
		
		//po-cancel 닫기(X)
		if ($(this).hasClass("po-cancel")){			
			var load_page = $("#load_page_30_08").val();
			openLayer("layer3",load_page,"?odr_idx="+$("#odr_idx_30_08").val());
			return;
		}

		//3016_cancel 닫기(X)
		if ($(this).hasClass("3016_cancel")){			
			var load_page = $("#load_page_3016_cancel").val();
			openLayer("layer3",load_page,"?odr_idx="+$("#odr_idx_3016_cancel").val());
		}
		else if (!$(this).hasClass("btn-order-periodconfirm"))
		{			
			$(this).parents("section[class^='layer']").removeClass("open");
			$("body").removeClass("open-layer");
			if($(this).parents("section[class^='layer']").hasClass("layer7-section")==true){
				$("#layerPop7").html("");
			}

			if($(this).parents("section[class^='layer']").hasClass("layer3-section")==true){				
				$("#layerPop3").empty();
			}
			
		}
		
	});
	//---모든레이어 닫고 페이지 새로고침(from:alert2.php)---------------------------------
	$("section[class^='layer']").on("click",".btn-close-refresh",function(){
		if (!$(this).hasClass("btn-order-periodconfirm"))
		{
			$(this).parents("section[class^='layer']").removeClass("open");
			$("body").removeClass("open-layer");
			if($(this).parents("section[class^='layer']").hasClass("layer7-section")==true){
				$("#layerPop7").html("");
			}
		}		
	});

	$("section[class^='layer']").on("click",".btn-close-company",function(){		
		$(this).parents("section[class^='layer']").removeClass("open");
		$("body").removeClass("open-layer");
	});

	$('.onlynum').css("ime-mode","disabled").keydown(function(event){ 		//숫자만 입력하게.(.도 포함) 		
	  if (event.which && (event.which == 190 || event.which == 110 || event.which > 45 && event.which < 58 || event.which == 8 || event.which > 95 && event.which < 106)) {			
	   } else { 
	   event.preventDefault(); 
	  } 
	 });

	 $('.no_hangul').css("ime-mode","disabled").keydown(function(event){ 		//한글만 입력 안되게.(.도 포함) 		 
	  if (event.which && (event.which != 229)) {			
	   } else { 
	   event.preventDefault(); 
	  } 
	 });
		 
	 $('.numfmt').css("ime-mode","disabled").keyup( function(event){   // 숫자 입력 하면 ,로 단위 끊어 표시하게.	 	
	 		check_value(this);
	 });

	 $('.onlyEngNum').css("ime-mode","disabled").keydown(function(event){ 		//ENG, 숫자만 입력하게.(.도 포함) 		 
	  if (event.which && (event.which == 13 || event.which == 32 ||event.which == 189 ||event.which == 190 || event.which == 110 || event.which > 45 && event.which < 58 || event.which == 8 || event.which > 64 && event.which < 91|| event.which > 95 && event.which < 123)) {			
	   } else { 
	   event.preventDefault(); 
	  } 
	 });

	//-- 레이어 창 열기 ------------------------------------
	function openLayer(layerNum,loadPage,varNum){
		$layer = $("."+layerNum+"-section");
		$layer.addClass("open");
		$layer.siblings("section").each(function() {
			if($(this).css("z-index")=="999"){
				$(this).css("z-index","990");
			}else if($(this).css("z-index")=="990"){
				$(this).css("z-index","980");
			}else{
				$(this).css("z-index","900");
			}
		});
		$layer.css("z-index","999");
		$("body").addClass("open-layer");
		!varNum? $var = "" : $var = varNum;
		$layer.find(">.layer-wrap").load("/kor/layer/"+loadPage+".php"+$var);
	}
	
	
	
	////////////////////////* sell & buy *///////////////////////////////////
	$(".layer-wrap").on("click", ".view-sell", function(){
		//openLayer("layer","layerSell");
		$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php", 
		data: { actty : "VSB", //ConFirm
				actidx : "sell",
				actkind : "menu"
		},
			dataType : "html" ,
			async : false ,
			success: function(data){ 
				if (data=="")
				{
					openLayer("layer","31_04","?mn=01&status=1&page=1");
				}else{
					goMenuJump(data);
				}				
			}
		});

		
	});
	
	$(".layer-wrap").on("click", ".view-buy", function(){
		//openLayer("layer","layerBuy");
		$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php", 
		data: { actty : "VSB", //ConFirm
				actidx : "buy",
				actkind : "menu"
		},
			dataType : "html" ,
			async : false ,
			success: function(data){ 
				if (data=="")
				{
					openLayer("layer","31_06","?mn=01&status=16&page=1");
				}else{
					goMenuJump(data);
				}				
			}
		});

		
	});
	
	$(".open-layer-sell").on("click",function(){
		openLayer("layer","layerSell");
	});
	
	$(".open-layer-buy").on("click",function(){
		openLayer("layer","layerBuy");
	});
	
	$("body").on("click",".sell-mn01",function(){
		openLayer("layer","31_04","?mn=01&status=1&page=1");
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
			alert_msg("로그인 후 이용하여 주시기 바랍니다.");
		}else{
			openLayer('layer','30_06','?mn=02&status=2&page=1');
		}
	});
	//--P.O Sheet(30_05) 화면 : '확정 발주서' 클릭 --------------------------------------------
	$("body").on("click",".orderConfirm",function(){
		//2017-03-16 : 별도 처리없이 그냥 닫음(1분후 전송기능 없애고, 앞에서 이미 전송했으므로...)
			if ($("#odr_idx_05_04").val() != $("#odr_idx_30_05").val())
			{	
				openLayer('layer3','05_04','?odr_idx='+$("#odr_idx_05_04").val());
			}else{
				//모두 닫기
				closeCommLayer("layer3"); //발주서창(05_04))
				//document.location.href="/kor/";
			}
			closeCommLayer("layer5");	//sheet
			closeCommLayer("layer4"); //공지창(30_05)
			if($(".layer-section").hasClass("open")){ //What's New 창 있으면 닫기
				closeCommLayer("layer");
			}
			//좌우화면 모두 새로고침
			if ($("input[name=top_part_no]").val().length>1){
				//main_srch();
				showajaxParam('.col-right','side_order','');
			} else{
				showajaxParam('.col-right','side_order','');
			}
			var $button_chk = $(this);

			$button_chk.children("button").attr("class","");	
			$button_chk.children("img").attr("src","/kor/images/loding_img.gif");
		/**
		$.ajax({
				url: "/kor/proc/odr_proc.php", 
				//data: "typ=odrconfirm&odr_idx="+$("#odr_idx_30_05").val()+"&sell_mem_idx="+$("#sell_mem_idx").val(), //JSJ
				data: "typ=odrconfirm2&odr_idx="+$("#odr_idx_30_05").val()+"&sell_mem_idx="+$("#sell_mem_idx").val(), //2016-04-05 'odrconfirm2' 로 수정
				encType:"multipart/form-data",
				success: function (data) {	
					if (trim(data) == "SUCCESS"){		
						//alert_msg("판매자에게 확정 발주서를 전송했습니다.");
						//alert($("#odr_idx_05_04").val()+"::::"+$("#odr_idx_30_05").val());
						var addParam="";
						//if ($("#odr_idx_05_04").val() != $("#odr_idx_30_05").val())
						//{							
						//	addParam = "index.php?odr_idx="+$("#odr_idx_05_04").val();
						//}
						//document.location.href="/kor/"+addParam;

						if ($("#odr_idx_05_04").val() != $("#odr_idx_30_05").val())
						{	
							openLayer('layer3','05_04','?odr_idx='+$("#odr_idx_05_04").val());
						}else{
							//모두 닫기
							closeCommLayer("layer3"); //발주서창(05_04))
							//document.location.href="/kor/";
						}
						closeCommLayer("layer5");	//sheet
						closeCommLayer("layer4"); //공지창(30_05)
						if($(".layer-section").hasClass("open")){ //What's New 창 있으면 닫기
							closeCommLayer("layer");
						}
						//좌우화면 모두 새로고침
						if ($("input[name=top_part_no]").val().length>1){
							main_srch();
						} else{
							showajaxParam('.col-right','side_order','');
						}
					}else{ //ajax 처리 후, error mesage
						alert_msg(data);
					}
				}
		});
		**/
	});	 
	//수정발주서 Sheet(P.O Amendment) 12_07 '확정 발주서' 클릭
	$("body").on("click",".odrAmendConfirm",function(){
		//openLayer("layer","30_06","?mn=02");
		odr_idx = $(this).attr("odr_idx");
		$.ajax({
				url: "/kor/proc/odr_proc.php", 
				//data: "typ=odramendconfirm&odr_idx="+$(this).attr("odr_idx"),  //JSJ
				data: "typ=odramendconfirm2&odr_idx="+$(this).attr("odr_idx")+"&amend_no="+$(this).attr("amend_no")+"&poa_no="+$("#poa_no_1207").val(),  //2016-04-15 : odramendconfirm2(Log 기록)으로 수정
				encType:"multipart/form-data",
				success: function (data) {	
					if (trim(data) == "SUCCESS"){		
						//alert_msg("판매자에게 확정 발주서를 전송했습니다.");
						//alert_msg("구매자에게 송장을 발송했습니다.");
						var menu_type_chk = getCookie('menu');

						closeCommLayer("layer5");	//invoic 닫고
						closeCommLayer("layer3");	//송장(3008) 닫고
						closeCommLayer("layer");
						
						switch (menu_type_chk) {
							case "order_S"    : if(chkLogin()){order('S'); showajax(".col-right", "side_order");}
							           break;
							case "order_B"    : if(chkLogin()){order('B'); showajax(".col-right", "side_order");}
							           break;
							case "mybox"    : if(chkLogin()){showajax(".col-left", "mybox"); showajax(".col-right", "side_order");}
							           break;
							case "record_S"    : if(chkLogin()){record('S'); showajax(".col-right", "side_order");}
							           break;
							case "record_B"    : if(chkLogin()){record('B'); showajax(".col-right", "side_order");}
							           break;
							case "remit"    : if(chkLogin()){remit('C'); showajax(".col-right", "side_order");}
							           break;
							case "side_order"    : showajax(".col-right", "side_order");
			           					break;
						}
						//document.location.href="/kor/";
					}else if(trim(data) == "ERR"){
						//재고 경고
						closeCommLayer("layer5");	//invoic 닫고
						closeCommLayer("layer3");	//수정발주서(0901) 닫고
						openLayer("layer5","30_09","?odr_idx="+odr_idx);	//invoice 다시 열고
						openLayer('layer3','09_01','?odr_idx='+odr_idx);		//수정발주서 다시 열고
						openLayer('layer4','alarm','?odr_idx='+odr_idx);		//경고창 띄우고
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
	//환불(구매자) 완료 처리-------------------------------------
	$("body").on("click",".refund_comple",function(){
		$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php", 
		data: { actty : "RCF", //ConFirm
				actidx : $(this).attr("odr_history_idx"),
				odr_idx : $(this).attr("odr_idx"),
				odr_det_idx : $(this).attr("odr_det_idx")
		},
			dataType : "json",
			async : false ,
			success: function(data){ 
				if(data.err == "OK"){
					openCommLayer("layer6","alarm_payment","?amt="+data.pay_amt);
				}else{
					alert(data.err);
				}
				//document.location.href="/kor/";
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
		confirmPwd();		
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
		//alert_msg("입금 확인 요청 메세지를 전송하였습니다.");
		alert_msg2("결제" ,"결제가 완료되었습니다.","btn_transmit");
//		document.location.href="/kor/";
	});
	$("body").on("click",".remit_submit2", function(){
		var f =  document.f6; 
		f.typ.value="bankfileup";
		f.target = "proc";
		//f.target = "_blank";
		f.action = "/kor/proc/odr_proc.php";
		f.submit();					
		alert_msg2("결제" ,"결제가 완료되었습니다.","btn_transmit");
//		document.location.href="/kor/";
	});
	
		//납기품목 납기(일자)선택 '전송'--------------------- from:31_05
	$("body").on("click",".sell-mn01-3106",function(){
		
		if($("#period").val()==""){
			alert_msg("납기 기간을 선택해 주세요.");
			$("#period").focus();
		}else{
			maskoff();
			var period;
			if($("#part_type_31_05").val()=="2"){
				period = $("#period").val();// + "WK";
			}else{
				period = $("#period").val() + "Days";
			}

			var $supp_qty = $(this).parent().parent().find("input[name=supply_quantity]");
			var $qty = $supp_qty.next();
			var $part_idx = $qty.next();
			var price_chk = $part_idx.next();
			var $button_chk = $(this);
			
			$.ajax({ 
				type: "GET", 
				url: "/ajax/proc_ajax.php?actty=part_info_chk&part_idx="+$part_idx.val()+"&price="+$qty.val().replace(",","")+"&qty="+$qty.val().replace(",","")+"&odr_qty="+$supp_qty.val().replace(",","")+"&type=period", 					
				dataType : "text" ,
				async : false ,
				success: function(data){
					var data_string = $.trim(data);
					var data_split = data_string.split( '_' );
					
					if(data_split[0]=="price")
					{	//가격변동 경고!!
						closeCommLayer("layer3");
						closeCommLayer("layer4");
						openCommLayer('layer3','31_05','?odr_det_idx='+$("#odr_det_idx_31_05").val()+'&part_type='+$("#part_type_31_05").val()+'&change=price&change_part_idx='+data_split[1]);
						openLayer('layer4','alarm2','?odr_det_idx='+$("#odr_det_idx_31_05").val());	//가격변동 경고창
						return;
					}
					else if(data_split[0]=="qty")
					{
						closeCommLayer("layer4");
						openLayer('layer3','31_05','?odr_det_idx='+$("#odr_det_idx_31_05").val()+'&part_type='+$("#part_type_31_05").val()+'&change=qty&change_part_idx='+data_split[1]);
						openLayer('layer4','alarm','?odr_det_idx='+$("#odr_det_idx_31_05").val());
						return;
					}
					else if(data_split[0]=="delete")
					{														
						closeCommLayer("layer4");				
						openLayer('layer3','31_05','?odr_det_idx='+$("#odr_det_idx_31_05").val()+'&part_type='+$("#part_type_31_05").val()+'&change=delete&change_part_idx='+data_split[1]);			
						openLayer('layer4','alarm4','?odr_det_idx='+$("#odr_det_idx_31_05").val()+"&part_idx="+data_split[1]);
						return;
					}	
					else
					{
						$button_chk.children("button").attr("class","");	
						$button_chk.children("img").attr("src","/kor/images/loding_img.gif");

						$.ajax({
							url: "/kor/proc/odr_proc.php", 
							//data: "typ=periodcfrm&odr_det_idx="+$("#odr_det_idx_31_05").val()+"&part_type="+$("#part_type_31_05").val()+"&part_no="+$("#part_no").val()+"&manufacturer="+encodeURIComponent($("#manufacturer").val())+"&package="+$("#package").val()+"&dc="+$("#dc").val()+"&supply_quantity="+$("#supply_quantity").val()+"&period="+$("#period").val()+"&pkind="+$(".layer-pagination.red .c-red2").text(),
							data: "typ=periodcfrm&odr_det_idx="+$("#odr_det_idx_31_05").val()+"&part_type="+$("#part_type_31_05").val()+"&part_no="+$("#part_no").val()+"&manufacturer="+encodeURIComponent($("#manufacturer").val())+"&package="+$("#package").val()+"&dc="+$("#dc").val()+"&rhtype="+$("select[name='rhtype[]']").val()+"&supply_quantity="+$("#supply_quantity").val()+"&period="+period+"&pkind="+$(".layer-pagination.red .c-red2").text(),
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
				}//success
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
		openLayer("layer","09_03","?mn=03&status=3");
	});
	$("body").on("click",".sell-mn03-1208",function(){
		openLayer("layer","12_08","?mn=03");
	});
	$("body").on("click",".sell-mn04",function(){
		openLayer("layer","10_04","?mn=04&status=4&page=1");
	});
	$("body").on("click",".sell-mn05",function(){
		openLayer("layer","30_15","?mn=05&status=5");
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
		openLayer("layer","30_22","?mn=06&status=6&page=1");
	});
	$("body").on("click",".sell-mn06-1225",function(){
		openLayer("layer","12_25","?mn=06");
	});
	$("body").on("click",".sell-mn07",function(){
		openLayer("layer","03_02","?mn=07&status=7&page=1");
	});
	$("body").on("click",".sell-mn08",function(){
		openLayer("layer","07_02","?mn=08&status=8");
	});
	$("body").on("click",".sell-mn08-1302",function(){
		openLayer("layer","13_02","?mn=08&status=8&page=1");
	});
	//거절 main popup
	$("body").on("click",".sell-mn09",function(){
		openLayer("layer","18R_06","?mn=09&status=9&page=1");
	});
	$("body").on("click",".sell-mn09-18r-10",function(){
		openLayer("layer","18R_10","?mn=09");
	});
	$("body").on("click",".sell-mn09-18r-14",function(){
		openLayer("layer","18R_14","?mn=09");
	});
	//수량부족 main popup
	$("body").on("click",".sell-mn10",function(){
		openLayer("layer","19_06","?mn=10&status=10&page=1");
	});
	$("body").on("click",".sell-mn10-1914",function(){
		openLayer("layer","19_14","?mn=10");
	});
	$("body").on("click",".sell-mn10-19-1-02",function(){
		openLayer("layer","19_1_02","?mn=10");
	});
	//반품선적완료 main popup
	$("body").on("click",".sell-mn11",function(){
		openLayer("layer","18R_19","?mn=11&status=11&page=1");
	});
	$("body").on("click",".sell-mn11-18-1-10",function(){
		openLayer("layer","18_1_10","?mn=11");
	});
	$("body").on("click",".sell-mn12",function(){
		openLayer("layer","21_05","?mn=12&status=12");
	});
	$("body").on("click",".sell-mn13",function(){
		openLayer("layer","21_1_04","?mn=13&status=13");
	});
	$("body").on("click",".sell-mn13-21-3-02",function(){
		openLayer("layer","21_3_02","?mn=13");
	});
	$("body").on("click",".sell-mn14",function(){
		openLayer("layer","21_1_09","?mn=14&status=25");
	});
	$("body").on("click",".sell-mn14-21-2-09",function(){
		openLayer("layer","21_2_09","?mn=14");
	});
	$("body").on("click",".sell-mn15",function(){
		openLayer("layer","21_7_02","?mn=15&status=26");
	});
	$("body").on("click",".sell-mn16",function(){
		openLayer("layer","21_3_10","?mn=16&status=27");
	});
	$("body").on("click",".sell-mn17",function(){
		openLayer("layer","21_4_11","?mn=17&status=14");
	});
	$("body").on("click",".sell-mn18",function(){
		openLayer("layer","21_4_10","?mn=18&status=28");
	});
	$("body").on("click",".sell-mn19",function(){
		openLayer("layer","21_14","?mn=19&status=30&page=1");
	});
	
	
	// 구매자 메인 팝업
	//납기확인 main popup
	$("body").on("click",".buy-mn01",function(){
		openLayer("layer","31_06","?mn=01&status=16&page=1");
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
	// 확정 송장 클릭시 - Invoice(30_09)
	$("body").on("click",".buy-mn03",function(){ 
		maskoff();

		//openLayer("layer","30_10","?mn=03");
		$.ajax({
				url: "/kor/proc/odr_proc.php", 
				//data: "typ=invconfirm&odr_idx="+$("#odr_idx_30_09").val()+"&sell_mem_idx="+$("#sell_mem_idx_30_09").val(),  //JSJ
				data: "typ=invconfirm2&odr_idx="+$("#odr_idx_30_09").val()+"&sell_mem_idx="+$("#sell_mem_idx_30_09").val()+"&inv_no="+$("#invoice_no_3009").val()+"&part_no_val="+$("#part_no_val").val(),  //2016-04-15 : invconfirm2(품목 Log 기록)로 변경
				encType:"multipart/form-data",
				success: function (data) {	
					var data_string = $.trim(data);
					var data_split = data_string.split( '_' );
					
					if($.trim(data_split[0])=="PRICE"){	//가격변동 경고!!
							//2016-12-11 : 재고 경고
							closeCommLayer("layer5");	//invoic 닫고
							closeCommLayer("layer4");	//공지창 닫고
							closeCommLayer("layer3");	//송장(3008) 닫고
							openLayer("layer5","30_05","?odr_idx="+$("#odr_idx_30_09").val());	//P.O 다시 열고
							openLayer('layer3','30_08','?odr_idx='+$("#odr_idx_30_09").val());		//송장 다시 열고
							openLayer('layer4','alarm2','?odr_idx='+$("#odr_idx_30_09").val()+"&part_idx="+data_split[1]);	//가격변동 경고창
							return;
					}else if ($.trim(data_split[0])=="ERR"){
							//2016-12-11 : 재고 경고
							closeCommLayer("layer5");	//invoic 닫고
							closeCommLayer("layer4");	//공지창 닫고
							closeCommLayer("layer3");	//송장(3008) 닫고
							openLayer("layer5","30_05","?odr_idx="+$("#odr_idx_30_09").val());	//P.O 다시 열고
							openLayer('layer3','30_08','?odr_idx='+$("#odr_idx_30_09").val());		//송장 다시 열고
							openLayer('layer4','alarm','?odr_idx='+$("#odr_idx_30_09").val()+"&part_idx="+data_split[1]);							
							return;							
					}
					else if ($.trim(data_split[0])=="DELETE"){	
							//2016-12-11 : 재고 경고
							closeCommLayer("layer5");	//invoic 닫고
							closeCommLayer("layer4");	//공지창 닫고
							closeCommLayer("layer3");	//송장(3008) 닫고
							openLayer("layer5","30_05","?odr_idx="+$("#odr_idx_30_09").val());	//P.O 다시 열고
							openLayer('layer3','30_08','?odr_idx='+$("#odr_idx_30_09").val());		//송장 다시 열고
							openLayer('layer4','alarm3','?odr_idx='+$("#odr_idx_30_09").val()+"&part_idx="+data_split[1]+"&fromLoadPage="+$("#fromLoadPage").val());	
							return;							
					}	
					else if (trim(data) == "SUCCESS"){		
//						alert_msg("구매자에게 송장을 발송했습니다.");
						var menu_type_chk = getCookie('menu');

						closeCommLayer("layer5");	//invoic 닫고
						closeCommLayer("layer3");	//송장(3008) 닫고
						closeCommLayer("layer4");	//공지창 닫고
						closeCommLayer("layer");
						
						switch (menu_type_chk) {
							case "order_S"    : if(chkLogin()){order('S'); showajax(".col-right", "side_order");}
							           break;
							case "order_B"    : if(chkLogin()){order('B'); showajax(".col-right", "side_order");}
							           break;
							case "mybox"    : if(chkLogin()){showajax(".col-left", "mybox"); showajax(".col-right", "side_order");}
							           break;
							case "record_S"    : if(chkLogin()){record('S'); showajax(".col-right", "side_order");}
							           break;
							case "record_B"    : if(chkLogin()){record('B'); showajax(".col-right", "side_order");}
							           break;
							case "remit"    : if(chkLogin()){remit('C'); showajax(".col-right", "side_order");}
							           break;
							case "side_order"    : showajax(".col-right", "side_order");
			           					break;
						}
						//document.location.href="/kor/";
					}else{
						//2016-12-11 : 재고 경고
						closeCommLayer("layer5");	//invoic 닫고
						closeCommLayer("layer4");	//공지창 닫고
						closeCommLayer("layer3");	//송장(3008) 닫고
						openLayer("layer5","30_05","?odr_idx="+$("#odr_idx_30_09").val());	//P.O 다시 열고
						openLayer('layer3','30_08','?odr_idx='+$("#odr_idx_30_09").val());		//송장 다시 열고
						openLayer('layer4','alarm','?odr_idx='+$("#odr_idx_30_09").val());		//경고창 띄우고
					}
				}
		});		
	});

	

	$("body").on("click",".buy-mn03-3010",function(){  // left menu에서 송장 클릭시
		openLayer("layer","30_10","?mn=03");
	});

	$("body").on("click",".buy-mn03-1212",function(){
		openLayer("layer","12_12","?mn=03");
	});
	$("body").on("click",".buy-mn03-1705",function(){
		openLayer("layer","17_05","?mn=03");
	});
	$("body").on("click",".buy-mn04",function(){
		openLayer("layer","01_37","?mn=04");
	});
	$("body").on("click",".buy-mn05",function(){
		openLayer("layer","08_02","?mn=05");
	});
	$("body").on("click",".buy-mn06",function(){
		openLayer("layer","10_02","?mn=06");
	});
	$("body").on("click",".buy-mn07",function(){
		openLayer("layer","30_14","?mn=07");
	});
	$("body").on("click",".buy-mn07-18-2-15",function(){
		openLayer("layer","18_2_15","?mn=07");
	});
	$("body").on("click",".buy-mn07-0122",function(){
		openLayer("layer","01_22","?mn=07");
	});
	$("body").on("click",".buy-mn08",function(){
		openLayer("layer","30_20","?mn=08&status=21&page=1");
	});
	$("body").on("click",".buy-mn08-18r-01",function(){
		openLayer("layer","18R_01","?mn=08&status=13&page=1");
	});
	$("body").on("click",".buy-mn08-18r-25",function(){
		openLayer("layer","18R_25","?mn=08&status=13&page=1");
	});
	$("body").on("click",".buy-mn09",function(){
		openLayer("layer","02_02","?mn=09&status=7&page=1");
	});
	$("body").on("click",".buy-mn10",function(){
		openLayer("layer","13_04","?mn=10&status=8&page=1");
	});
	$("body").on("click",".buy-mn10-1304",function(){
		openLayer("layer","13_04","?mn=10&status=8&page=1");
	});
	$("body").on("click",".buy-mn11",function(){
		openLayer("layer","18R_08","?mn=11&status=9&page=1");
	});
	$("body").on("click",".buy-mn12",function(){
		openLayer("layer","19_08","?mn=12&status=10&page=1");
	});
	$("body").on("click",".buy-mn12-19-2-04",function(){
		openLayer("layer","19_2_04","?mn=12&status=10&page=1");
	});
	$("body").on("click",".buy-mn13",function(){
		openLayer("layer","18R_16","?mn=13&status=22");
	});
	$("body").on("click",".buy-mn13-18-1-02",function(){
		openLayer("layer","18_1_02","?mn=13&status=22");
	});
	$("body").on("click",".buy-mn14",function(){
		openLayer("layer","19_21","?mn=14&status=23");
	});
	$("body").on("click",".buy-mn15",function(){
		openLayer("layer","30_23","?mn=15&status=6");
	});
	$("body").on("click",".buy-mn16",function(){
		openLayer("layer","19_1_06","?mn=16&status=24");
	});
	$("body").on("click",".buy-mn16-19-1-06",function(){
		openLayer("layer","19_1_06","?mn=16&status=24");
	});
	$("body").on("click",".buy-mn17",function(){
		openLayer("layer","21_07","?mn=17&status=12");
	});
	$("body").on("click",".buy-mn18",function(){
		openLayer("layer","21_1_02","?mn=18&status=13");
	});
	$("body").on("click",".buy-mn18-21-3-04",function(){
		openLayer("layer","21_3_04","?mn=18&status=13");
	});
	$("body").on("click",".buy-mn20",function(){
		openLayer("layer","21_6_03","?mn=20&status=26");
	});
	$("body").on("click",".buy-mn21",function(){
		openLayer("layer","21_1_14","?mn=21&status=27");
	});
	$("body").on("click",".buy-mn22",function(){
		openLayer("layer","21_5_13","?mn=22&status=14");
	});
	$("body").on("click",".buy-mn23",function(){
		openLayer("layer","21_1_07","?mn=23&status=29");
	});
	$("body").on("click",".buy-mn23-21-2-02",function(){
		openLayer("layer","21_2_02","?mn=23&status=29");
	});
	$("body").on("click",".buy-mn24",function(){
		openLayer("layer","21_5_12","?mn=24&status=28");
	});	
	$("body").on("click",".buy-mn25",function(){
		openLayer("layer","21_16","?mn=25&status=30");
	});	
	$("body").on("click",".buy-mn32",function(){
		openLayer("layer","1304_accept","?mn=32&status=32");
	});	
	
	////////////////////////* sheet *///////////////////////////////////
	//order sheet 실 발주 처리 [공지]화면의 '발주서 확인' 버튼 -----------------------
	$("body").on("click",".btn-view-sheet",function(){		
			var odr_idx = $(this).attr("odr_idx");
			var $button_chk = $(this);			

			$.ajax({ 
				type: "GET", 
				url: "/ajax/proc_ajax.php", 
				//data: { actty : "MRO", //Move to Real order Process
				data: { actty : "MRO_ONCE", //Move to Real order at once 2017-03-16
						delivery_addr_idx : $("#delivery_addr_idx").val(),
						session_mem_idx : $("#session_mem_idx").val(),
						sell_mem_idx : $("#sell_mem_idx").val(),	//2017-03-16
						delivery_save_yn : $("#delivery_save_yn").val(),
						nation : $("#nation").val(),
						com_name : $("#com_name").val(),
						manager : $("#manager").val(),
						pos_nm : $("#pos_nm").val(),
						depart_nm : $("#depart_nm").val(),
						com_type : $("#com_type").val(),
						tel : $("#tel").val(),
						fax : $("#fax").val(),
						hp : $("#hp").val(),
						email : $("#email").val(),
						homepage : $("#homepage").val(),
						zipcode : $("#zipcode").val(),
						dosi : $("#dosi").val(),
						dositxt : $("#dositxt").val(),
						sigungu : $("#sigungu").val(),
						addr_det : $("#addr_det").val(),
						addr : $("#addr").val(),
						log_date : $("#log_date").val(),
						log_ip : $("#log_ip").val(),
						actidx : $(this).attr("odr_idx"),						
						actkind : $(this).attr("new_odr_idx")
					},
				dataType : "text" ,
				async : false ,
				success: function(data){
					regNumber = /^[0-9]*$/;
					if(!regNumber.test($.trim(data))) {

						var data_string = $.trim(data);
						var data_split = data_string.split( '_' );

						if(data_split[0]=="PRICE"){	//가격변동 경고!!
							closeCommLayer("layer3");
							closeCommLayer("layer4");
							openCommLayer('layer3','05_04','?odr_idx='+odr_idx+'&change=price&change_part_idx='+data_split[1]);
							openLayer('layer4','alarm2','?odr_idx='+odr_idx);	//가격변동 경고창
							return;
						}
						else if(data_split[0]=="ERR")
						{
							closeCommLayer("layer4");
							openLayer('layer3','05_04','?odr_idx='+odr_idx+'&change=qty&change_part_idx='+data_split[1]);
							openLayer('layer4','alarm','?odr_idx='+odr_idx);
							return;
						}
						else if(data_split[0]=="delete")
						{														
							closeCommLayer("layer4");							
							if ($("#det_cnt").val() > 1 || (data_split[2]==2 || data_split[2]==5 || data_split[2]==6))
							{								
								openLayer('layer3','05_04','?odr_idx='+odr_idx+'&change=delete&change_part_idx='+data_split[1]);
							}														
							openLayer('layer4','alarm4','?odr_idx='+odr_idx+"&part_idx="+data_split[1]);
							return;
						}	
					}
					else
					{
						$button_chk.children("button").attr("class","");	
						$button_chk.children("img").attr("src","/kor/images/loding_img.gif");

						openLayer("layer5","30_05","?odr_idx="+data); //P.O Sheet
						$(".layer5-section .btn-close img").css("display","none"); //X버튼 숨기기
					}
						
					
				}//success
			});
		
		//$("layer5-section .btn-close").css("display","none");
	});

	//--------------------------------------------------------------------------------
	$("body").on("click",".btn-view-amend-sheet-forread",function(){
		openLayer("layer5","12_07","?odr_idx="+$(this).attr("odr_idx")+"&load_page=09_01");
	});
	
	//What's New(구매자) 취소(13_04)화면 '수락' 버튼------
	$("body").on("click",".btn-confirm-1304s",function(){ //실제 취소 처리(DB)

		var part_type = $(this).attr("part_type");

		if (part_type ==2)
		{
			openCommLayer("layer4","13_04_1","?&actidx="+$(this).attr("odr_history_idx"));
		}
		else
		{
			$.ajax({ 
			type: "GET", 
			url: "/ajax/proc_ajax.php", 
			data: { actty : "CF", //ConFirm
					actidx : $(this).attr("odr_history_idx")
			},
				dataType : "html" ,
				async : false ,
				success: function(data){ 
					//document.location.href="/kor/";
					closeCommLayer("layer");
					Refresh_Right();
				}
			});
		}
		

		//openCommLayer("layer4","13_04_1","?&actidx="+$(this).attr("odr_history_idx"));		

	});

	//What's New(구매자) 취소(13_04_1)화면 '종료' 버튼------
	$("body").on("click",".btn-confirm-1304_1s",function(){ //실제 취소 처리(DB)
		
		$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php", 
		data: { actty : "13_04_CF", //ConFirm
				actidx : $(this).attr("odr_history_idx")
		},
			dataType : "html" ,
			async : false ,
			success: function(data){ 
				//document.location.href="/kor/";
				closeCommLayer("layer");
				closeCommLayer("layer4");
				Refresh_Right();
			}
		});
		

	});

	//What's New(구매자) (1304_accept)계약금 재 입금화면 '입금' 버튼------
	$("body").on("click",".btn-confirm-1304_accept",function(){ //실제 취소 처리(DB)
		
		openCommLayer("layer4","13_04_2","?&actidx="+$(this).attr("odr_history_idx")+"&down_payment="+$(this).attr("down_payment"));
		

	});

	//What's New(구매자) 판매자 구매자 계약금 복구화면 '수락' 버튼------
	$("body").on("click",".btn-confirm-1304_2_ok",function(){ //실제 취소 처리(DB)
		
		$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php", 
		data: { actty : "13_04_OK", //ConFirm
				actidx : $(this).attr("odr_history_idx"),
				pay_amt : $(this).attr("pay_amt")
		},
			dataType : "html" ,
			async : false ,
			success: function(data){ 
				//document.location.href="/kor/";
				closeCommLayer("layer");
				closeCommLayer("layer4");
				Refresh_Right();
				document.location.href="/kor/";			
			}
		});
			
	});

	
	//판매자 송장화면(30_08), 수정발주서(09_01)에서 품목 선택 후 취소 버튼-> '취소'(po_cancel.php, odr_cancel.php)화면에서 '종료'버튼
	$("body").on("click",".btn-po-cancel",function(){ //실제 취소 처리(DB)
		var f = document.f_pocancel;
		f.target = "proc";
		//f.target = "_blank";
		f.action = "/ajax/proc_ajax.php";
		f.submit();		
	});
	//선적(3016)화면에서 취소 버튼 -> '취소' 화면에서 '환불' 버튼
	$("body").on("click",".btn-refund-cancel",function(){
		/** 기존(바로DB처리)
		var f = document.f_pocancel;
		f.target = "proc";
		//f.target = "_blank";
		f.action = "/ajax/proc_ajax.php";
		f.submit();	
		**/
		//INVOICE SHEET 필요
		var extraVal="" , odr_idx="";
		openLayer("layer5","30_16_04","?odr_idx="+$("#odr_idx_3016_cancel").val()+"&cancel_det_idx="+$("#cancel_det_idx").val());
	});
	//판매자 송장화면(30_08), 수정발주서(09_01) : '취소' 버튼 -----------------------------------------2016-04-12
	$("body").on("click",".btn-cancel-3008, .btn-cancel-0901",function(){
		var load_page = $("#load_page").val();
		var det_cnt = $("#det_cnt_"+load_page).val(); //det 수량

		if(det_cnt==1){
			var $chked_det = $("input[name^=odr_det_idx]");//품목 1개일때
		}else{
			var $chked_det = $("input[name^=odr_det_idx]:checked");//품목 2개 이상
		}
		var cancel_det_idx = [];
		$chked_det.each(function(e){
			cancel_det_idx.push($(this).val());
		});
		openCommLayer("layer3","po_cancel","?odr_idx="+$("#odr_idx_"+load_page).val()+"&cancel_det_idx="+cancel_det_idx+"&load_page="+load_page);
	});
	//판매자 선적화면(30_16) : '취소' 버튼 -----------------------------------------2016-04-11
	$("body").on("click",".btn-cancel-3016",function(){
		var load_page = $("#load_page").val();
		openCommLayer("layer3","3016_cancel","?odr_idx="+$("#odr_idx_"+load_page).val()+"&load_page="+load_page);
		var det_cnt = $("#det_cnt_"+load_page).val(); //det 수량

		if(det_cnt==1){
			var $chked_det = $("input[name^=odr_det_idx]");//품목 1개일때
		}else{
			var $chked_det = $("input[name^=odr_det_idx]:checked");//품목 2개 이상
		}
		var cancel_det_idx = [];
		$chked_det.each(function(e){
			cancel_det_idx.push($(this).val());
		});
		openCommLayer("layer3","3016_cancel","?odr_idx="+$("#odr_idx_"+load_page).val()+"&cancel_det_idx="+cancel_det_idx+"&load_page="+load_page);
	});
	//판매자 송장화면(30_08) : '송장 확인' 버튼 ----------------------------------2016-04-12
	$("body").on("click",".btn-view-sheet-3009",function(){		
		var err = false;
		var varNum;
		/** 2016-09-04 : 공급수량은 키 입력 이벤트로 제한 처리 하였으므로 아래 주석처리
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
		**/

		if($("#det_cnt_30_08").val() == 1 && $("input[name^=odr_det_idx]").attr("part_type")=="2" && $("#odr_period").val() > 2){
			//alert("지속...NCNR");
			openCommLayer("layer4","ncnr","");
		}else if (err == false){
			maskoff();
			var f =  document.f;
			 f.target = "proc";
			 //f.target = "_blank";
			 f.action = "/kor/proc/odr_proc.php";
			 f.submit();
			 maskon();
		}

	});

	//송장의 NCNR 공지에서 '송장확인' 클릭------------------------------
	$("body").on("click",".btn-3008-ncnr",function(){
			maskoff();
			var f =  document.f;
			 f.target = "proc";
			 f.action = "/kor/proc/odr_proc.php";
			 f.submit();				
	});
	//구매자 : 지연(1주자동) 확인 ------------------------
	$("body").on("click",".btn-08-02",function(){
		var his_idx = $(this).attr("history_idx");

		$.ajax({
				url: "/kor/proc/odr_proc.php", 
				data: "typ=delay1&odr_idx="+$("#odr_idx_08_02").val()+"&history_idx="+$(this).attr("history_idx"),
				encType:"multipart/form-data",
				success: function (data) {	
					if (trim(data) == "SUCCESS"){
						Refresh_Right();
						closeCommLayer("layer");
					}
				}
		});		
		/**
		var f =  document.f_08_02;
		f.history_idx.value = his_idx;
		f.target = "proc";
		f.action = "/kor/proc/odr_proc.php";
		f.submit();
		**/
	});


	//송장 
	$("body").on("click",".btn-view-sheet-3011",function(){
		//송장 click case : $("#loadPage").val() == "03_10", "01_37"?
		
		if($("#list_"+$("#loadPage").val()).html().indexOf("확인중")>0){
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
	// 송장(Commercial Invoice) : 2016-04-25, 
	$("body").on("click",".btn-view-sheet-3017a",function(){
		var extraVal="";
		odr_idx = $("#odr_idx_30_16").val();
		if ($(this).attr("for_readonly")!=""){extraVal = extraVal+"&for_readonly="+$(this).attr("for_readonly");}
		openLayer("layer5","30_17","?odr_idx="+odr_idx+extraVal);
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
		openLayer("layer5","19_1_04","?odr_idx="+$(this).parent().attr("odr_idx")+"&odr_history_idx="+$(this).parent().attr("odr_history_idx")+"&odr_det_idx="+$(this).parent().attr("odr_det_idx")+"&forgenl="+$(this).parent().attr("forgenl")+"&for_readonly="+$(this).attr("for_readonly"));	
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
	//-- 선적중량 입력 화면(30_18)에서 패킹리스트(Packing List) 버튼 클릭 -------------------------------------------------------------------------------------------------
	$("body").on("click",".btn-view-sheet-3019",function(){
		maskoff();
		$.ajax({
				url: "/kor/proc/odr_proc.php", 
				data: "typ=updweight&odr_idx="+$("#odr_idx").val()+"&ship_weight="+$("#ship_weight").val()+"&weight_type="+$("#weight_type").val(),
				encType:"multipart/form-data",
				success: function (data) {	
					if (trim(data) == "SUCCESS"){
						closeCommLayer("layer4"); //선적중량 화면(30_18)
						$("#weight_yn").val("Y"); //선적(30_16)에서 중량입력
						//$("#weight_yn").val(trim(s_weight)); //선적(30_16)에서 중량입력
						$(".btn-view-sheet-3011").click();
					}
				}
		},'json');		
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
		if(parseInt($("#psb").val().replace(/,/gi,""))<parseInt($("#rqst_amt").val().replace("$","").replace(/,/gi,"")) || $("#rqst_amt").val().replace("$","")==""){
			alert_msg("금액을 다시 확인해 주세요.");
		}else{
			var extra="";
			if($("#remitTy").val()=="Y"){
				 extra = "&remitTy=Y";
			}
			openLayer("layer5","23_23","?rqst_amt="+$("#rqst_amt").val().replace("$","")+extra);
		}
	});

	$("body").on("click",".btn-view-sheet-0120-r",function(){
			openLayer("layer5","01_20","?rqst_amt="+$("#rqst_amt").val().replace("$",""));
	});

	// 수정 발주서 amend sheet '발주서 확인' 클릭 from:09_01 
	$("body").on("click",".btn-view-sheet-1207",function(){
		
		var $chked_odr = $("input[name^=odr_det_idx]:checked");
		var odr_idx = $(this).attr("odr_idx");
		var insur_chk = "";
		if($("#insur_yn").attr("class")=="checked")
		{
			insur_chk = "o";
		}
		else
		{
			insur_chk = "";
		}

		//alert($("#ship_info").val();
		
		if($chked_odr.length==0){ 
			alert_msg("발주서를 선택해 주세요.");
		}else{
			var err = false; 
			maskoff();
			//err = updateQty();
			err = updateQty_temp();
			maskon();
			//err = true;
			
			//2016-04-18 : 송장번호 생성 및 저장
			$.ajax({
					url: "/kor/proc/odr_proc.php", 
					data: "typ=poano&odr_idx="+odr_idx+"&ship_info="+$("#ship_info").val()+"&ship_account_no="+$("#ship_account_no").val()+"&memo="+encodeURIComponent($("#memo").val())+"&insur_yn="+insur_chk+"&delivery_addr_idx="+$("#delivery_addr_idx").val(),
					encType:"multipart/form-data",
					success: function (data) {							
						if($.trim(data)=="STOCK"){
							//alert("재고수량 변경 경고!!");
							closeCommLayer("layer4");
							openLayer('layer3','09_01','?odr_idx='+odr_idx);
							openLayer('layer4','alarm','?odr_idx='+odr_idx);
						}else{
							if($.trim(data)=="SUCCESS"){
								openLayer("layer5","12_07","?odr_idx="+odr_idx+"&loadPage=09_01"); //12_07에서의 번호생성은 삭제
							}else{
								alert($.trim(data));
							}
						}							
					}
			});
		
		}

	});

	//agreement sheet - 구매자
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
		//openLayer("layer5","21_3_01","?odr_det_idx="+odr_det_idx+"&odr_idx="+odr_idx+"&bpway="+bpway);
		openLayer("layer5","21_4_01","?odr_det_idx="+odr_det_idx+"&odr_idx="+odr_idx+"&bpway="+bpway);
	});

	//연구소 agreement sheet
	//2016-10-11 : 21_04.php 의 form id 값이 'f2104' 이어서 아래 주정하였으나 다시 롤백됨. 다시 수정.
	$("body").on("click",".btn-view-sheet-21-4-01",function(){
		var odr_idx = $("#f2104 input[name=odr_idx]").val();
		var odr_det_idx = $("#f2104 input[name=odr_det_idx]").val();			
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

	//sheet 인쇄하기 
	$("body").on("click",".sheet-wrap .btn-area .f-lt",function(){

		var win_options = " width=820 height=1190 top=0 left=400 scrollbars=no";   
		window.open("about:blank","WinStory",win_options);
		var f =  document.ftop;
		var $this = $(".layer5-section");
		var prt = $this.html();
		$this=$(prt);
		$this.find(".btn-area").remove();		
		f.typ.value =encodeURIComponent($this.html());
		f.method = "post";
		f.target = "WinStory";
		f.action = "/kor/layer/print.php";
		f.submit();		
	});
		
	////////////////////////////////////////////////////////////////////
	
	
	
	////////////////////////* dialog *///////////////////////////////////
	$("body").on("click",".btn-order , .btn-dialog-3102",function(){
		
		var menu_type_chk = $(this).attr("menu_type");
		if (menu_type_chk=="M")
		{			
			setCookie("menu","side_order");
		}
		else if (menu_type_chk=="S")
		{			
			setCookie("menu","mybox");
		}
		else
		{
			setCookie("menu","side_order");
		}
		
		var loadPage  = $(this).attr("class")=="btn-dialog-3102" ? "31_02" : "05_04";
		if (mem_idx=="")
		{
			alert_msg("로그인 후 이용하여 주시기 바랍니다.");
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
			alert_msg("로그인 후 이용하여 주시기 바랍니다.");
		}else{
			 var f =  document.ftop;
			 f.part_idx.value=$(this).attr("id");
			 f.part_type.value=$(this).attr("part_type");
			 f.typ.value="write";
			 f.target = "proc";
			 f.action = "/kor/proc/odr_proc.php";
			 f.submit();		
		}
	});
	//--- 납기받은창(31_06) '발주'버튼, 발주추가(05_01) 닫기(X) ------------------
	$("body").on("click",".btn-order-periodconfirm",function(){
		var LoadPage;
		var odr_idx;
		if($(this).hasClass("0501")){
			odr_idx = $("#odr_idx_05_01").val();
		}else{
			odr_idx = $("#odr_idx_31_06").val();
		}
		LoadPage = $("#f_add input[name=fromLoadPage").val()=="09_01" ? "09_01" : "05_04";
		openLayer("layer3",LoadPage,"?odr_idx="+odr_idx);  //2016-04-05
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
		//alert($("input:hidden[name^=odr_det_idx]").val());
		if ($("input:checkbox[name^=odr_det_idx]").length == 0)
		{
			var odr_det_idx_val = $("input:hidden[name^=odr_det_idx]").val();			
			openLayer("layer3","30_21","?loadPage="+$("#loadPage").val()+"&odr_idx="+$("#odr_idx_"+$("#loadPage").val()).val()+"&odr_det_idx="+odr_det_idx_val);			
			return;
		}
		else
		{
			if($("input[name^=odr_det_idx]").length>1){ //-- 여러개 일때 --------------------------
				$chked_odr_det = $("input[name^=odr_det_idx]:checked");
			}else{	//-- 한개일때 ---------------------------------------
				$chked_odr_det = $("input[name^=odr_det_idx]");
			}
		}

		var ch_odr_det_idx = [];
		$chked_odr_det.each(function(e){
					ch_odr_det_idx.push($(this).val());
		});
		openLayer("layer3","30_21","?loadPage="+$("#loadPage").val()+"&odr_idx="+$("#odr_idx_"+$("#loadPage").val()).val()+"&odr_det_idx="+ch_odr_det_idx);
	});

	//수령(fault) 다이얼로그
	$("body").on("click",".btn-dialog-3021-f",function(){
		openLayer("layer3","30_21_F","?loadPage="+$("#loadPage").val()+"&odr_idx="+$(this).parent().attr("odr_idx")+"&odr_det_idx="+$(this).parent().attr("odr_det_idx")+"&odr_history_idx="+$(this).parent().attr("odr_history_idx"));
	});

	//지연 다이얼로그
	$("body").on("click",".btn-dialog-3021_D",function(){
		openLayer("layer3","30_21","?ty=Delay&loadPage="+$("#loadPage").val()+"&odr_idx="+$("#odr_idx_"+$("#loadPage").val()).val());
	});
	
	//운임 입력 창(구매자) - 거절 시(마지막 아이템에서)
	$("body").on("click",".btn-dialog-18R05",function(){
		var odr_det_idx = $(this).attr("odr_det_idx");
		var fault_quantity = $(this).attr("fault_quantity");
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
							openLayer("layer3","18R_05","?odr_idx="+$("#odr_idx_30_20").val()+"&odr_det_idx="+odr_det_idx+"&fault_method="+$(this).attr("fault_method")+"&fault_quantity="+fault_quantity);
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
	//부족 or 거절 수량 다이얼로그 ---------------------------------------------------------------------------
	//2016-05-16 : 수량부족, 거절 에서 공통으로 사용
	$("body").on("click",".btn-dialog-1905",function(){
	//openLayer("layer3","19_05","");
		var act_ty = $(this).attr("act_ty");
		var fault_sum = parseInt($(this).attr("fault_sum")) + parseInt($("#fault_quantity").val());
		var supply_sum  = parseInt($(this).attr("supply_sum"));
		if ($("#fault_quantity").val()=="")
		{
			alert_msg("부족 수량 개수를 입력해 주세요.");
			$("#fault_quantity").focus();			
		}else{
			if(fault_sum == supply_sum){  //모두 거절 일경우 - 운임 입력 창
				closeCommLayer("layer4");
				//openLayer("layer4","18R_04", "?odr_det_idx="+$(this).attr("odr_det_idx")); //기존(JSJ) 운임 입력 창
				openLayer("layer4","18R_04","?odr_idx="+$("#odr_idx_30_20").val()+"&odr_det_idx="+$(this).attr("odr_det_idx")+"&fault_method="+$(this).attr("fault_method")+"&fault_quantity="+$("#fault_quantity").val());
			}else{
				closeCommLayer("layer4");
				openLayer("layer3","18R_05","?odr_idx="+$("#odr_idx_30_20").val()+"&odr_det_idx="+$(this).attr("odr_det_idx")+"&fault_method="+$(this).attr("fault_method")+"&fault_quantity="+$("#fault_quantity").val());
			}
		}

		
	});

	//What's New : 거절 - '답변서'버튼
	$("body").on("click",".btn-dialog-18R09",function(){
		//openLayer("layer3","18R_09");
		openLayer("layer3","18R_05","?odr_idx="+$("#odr_idx_18R_08").val()+"&odr_det_idx="+$(this).parent().attr("odr_det_idx"));
	});
	
	//답변서(fault) ---------------------------------------------
	$("body").on("click",".btn-dialog-1908",function(){
		//openLayer("layer3","18R_07");
		openLayer("layer3","18R_05","?fault_method=3&fault_quantity="+$("#fault_quantity").val()+"&odr_idx="+$("#odr_idx_19_08").val()+"&odr_det_idx="+$(this).parent().attr("odr_det_idx"));
	});

	//What's New : 거절(구매자) '반품'(승인) 버튼 클릭
	$("body").on("click",".btn-dialog-return",function(){
		var title ="반품";
		var msg = "판매자의 반품요청을 수락하시겠습니까?";
		openCommLayer("layer6","msg_return","?btn=btn_ok&btncss=buyer_ok&alert_title="+encodeURIComponent(title)+"&alert_msg="+encodeURIComponent(msg)+"&odr_idx="+$("#odr_idx_18R_08").val()+"&odr_det_idx="+$(this).parent().attr("odr_det_idx"));
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
	//----------------- 발주 추가 -------------------------------
	$("body").on("click",".btn-dialog-0501",function(){
		var err = false; 
		//alert('123');
		//err = updateQty(); //2016-04-03 '05_04' 추가
		if (err == false)
		{
			saveExtraInfo();
			openLayer("layer3","05_01","?odr_idx="+$("#odr_idx_05_04").val()+"&fromLoadPage=05_04");
			$("#addsearch_part_no").focus();
		}
	});
	//-- 발주추가 검색창(05_01) '검색' 클릭--------------------
	$("body").on("click", ".btn-addsearch", function(){
		btn_addSearch();
	});

	
	$("body").on("click",".btn-dialog-0501-from_0901",function(){
		var err = false; 
		//err = updateQty();
		
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
	//-- 발주추가창(0501)에서 납기품목, Stock품목 수량 입력후 '확인' 버튼----------------- (From:class.partinfo.php => GET_ADDPART_LIST)---------------------
	$("body").on("click",".btn-dialog-addperiodreq,.btn-dialog-add",function(){
		var $odr_qty = $(this).parent().parent().find("input[name=odr_quantity]");
		var $qty = $odr_qty.next();
		var $part_idx = $qty.next();
		var $part_type = $part_idx.next();
		var price_chk = $(this).attr("price").replace(",","");
		var qty_chk = $(this).attr("quantity");
		var stock_type=$(this).attr("class");		
		if($odr_qty.val()==""){
				$odr_qty.focus();
		}else if ($part_type!="2" && parseInt(numOffMask($odr_qty.val())) > parseInt(numOffMask($qty.val())))
		{
				alert_msg("발주수량을 다시 확인해 주세요.");
				$odr_qty.focus();
				return false;
		}else{
			maskoff();
			$.ajax({ 
				type: "GET", 
				url: "/ajax/proc_ajax.php?actty=part_info_chk&part_idx="+$part_idx.val()+"&price="+price_chk+"&qty="+qty_chk+"&odr_qty="+$odr_qty.val(), 					
				dataType : "text" ,
				async : false ,
				success: function(data){
					var data_string = $.trim(data);
					var data_split = data_string.split( '_' );
					if ($part_type.val()==2 || $part_type.val()==5 || $part_type.val()==6 )
					{
						openLayer("layer4","31_03","?part_idx="+$part_idx.val()+"&odr_idx="+$("#odr_idx_05_01").val()+"&odr_quantity="+$odr_qty.val()+"&price="+price_chk+"&fromPage=add&fromLoadPage="+$("#fromLoadPage").val()+"&addsearch_part_no="+$("#addsearch_part_no").val());
						return;
					}

					if($.trim(data_split[0])=="price"){	//가격변동 경고!!
							closeCommLayer("layer3");
							closeCommLayer("layer4");
							openCommLayer('layer3','05_01','?odr_idx='+$("#odr_idx_05_01").val()+'&addsearch_part_no='+$("#addsearch_part_no").val()+'&change=price&part_idx='+$part_idx.val()+"&fromLoadPage="+$("#fromLoadPage").val());
							openLayer('layer4','alarm2','?odr_idx='+$("#odr_idx_05_01").val()+"&part_idx="+$part_idx.val());	//가격변동 경고창
							return;
					}else if ($.trim(data_split[0])=="qty"){							
							//alert("재고수량 변경 경고!!");
							closeCommLayer("layer4");
							openLayer('layer3','05_01','?odr_idx='+$("#odr_idx_05_01").val()+'&addsearch_part_no='+$("#addsearch_part_no").val()+'&change=qty&part_idx='+$part_idx.val()+"&fromLoadPage="+$("#fromLoadPage").val());
							openLayer('layer4','alarm','?odr_idx='+$("#odr_idx_05_01").val()+"&part_idx="+$part_idx.val());
							return;							
					}
					else if ($.trim(data_split[0])=="delete"){							
							//alert("재고수량 변경 경고!!");
							closeCommLayer("layer4");
							openLayer('layer3','05_01','?odr_idx='+$("#odr_idx_05_01").val()+'&addsearch_part_no='+$("#addsearch_part_no").val()+'&change=delete&part_idx='+$part_idx.val()+"&fromLoadPage="+$("#fromLoadPage").val());
							openLayer('layer4','alarm3','?odr_idx='+$("#odr_idx_05_01").val()+"&part_idx="+$part_idx.val()+"&fromLoadPage="+$("#fromLoadPage").val());
							return;							
					}		
					else
					{

						if(stock_type=="btn-dialog-add"){ //Stock 품목 추가
				
							var f =  document.f_addproc;
							f.typ.value="write";
							f.part_idx.value=$part_idx.val();
							f.part_type.value=$part_type.val(); 
							//f.odr_quantity.value=$odr_qty.val();  //2016-03-25 SCRIPT5007 때문에 원문 주석처리
							$('#odr_quantity_0501').val($odr_qty.val());  //2016-03-25 SCRIPT5007 때문에 신규 작성
							f.target = "proc";
							f.action = "/kor/proc/odr_proc.php";
							f.submit();
											 		
						}else{ //--------------------------------------납기품목 확인 메세지창							
							//openLayer("layer4","31_03","?part_idx="+$part_idx.val()+"&odr_idx="+$("#odr_idx_31_06").val()+"&odr_quantity="+$odr_qty.val()+"&fromPage=add&fromLoadPage="+$("#fromLoadPage").val()+"&addsearch_part_no="+$("#addsearch_part_no").val());
							//2015-04-05 위에꺼에서 odr_idx 가져오는 객체를 $("#odr_idx_05_01") 로 변경
							
						}
					}			
				}//success
			});		

			
		}				
	});

	//발주서(0504) 저장 ---------------------------------
	$("body").on("click",".btn-dialog-save",function(){
		var err = false;
		var varNum;
		var f =  document.f_05_04;  //2016-04-02 layer4에 <form name='f' ... 가 또 있음d
		//var f =  ("#f_05_04");
		maskoff();		
		err = updateQty();

		if ($(this).attr("save_key") == "on")
		{			
			$.ajax({
				type: "GET", 
				url: "/kor/proc/odr_proc.php", 
				data: { 
						typ : "save_key", //
						actidx : f.odr_idx.value
				},
				success: function (data) {	
					
				}
			});	
			
		}

		if ($(this).attr("onclick") != "del_sel();")
		{
			if (err == false){
				//What's New 창에서 납기 받은 제품 저장 시 별도 Proc.
				if($("#odr_status").val() == 16){ //납기받은 품목
					f.typ.value = "persave";
				}else{
					f.typ.value = "odredit";
				}
				f.save_yn.value = "Y";
				f.target = "proc";
				f.action = "/kor/proc/odr_proc.php";
				f.submit();			
			}
		}
		
		var menu_type_chk = getCookie('menu');
				
		switch (menu_type_chk) {
			case "order_S"    : if(chkLogin()){order('S'); showajax(".col-right", "side_order");}
			           break;
			case "order_B"    : if(chkLogin()){order('B'); showajax(".col-right", "side_order");}
			           break;
			case "mybox"    : if(chkLogin()){showajax(".col-left", "mybox"); showajax(".col-right", "side_order");}
			           break;
			case "record_S"    : if(chkLogin()){record('S'); showajax(".col-right", "side_order");}
			           break;
			case "record_B"    : if(chkLogin()){record('B'); showajax(".col-right", "side_order");}
			           break;
			case "remit"    : if(chkLogin()){remit('C'); showajax(".col-right", "side_order");}
			           break;
			case "side_order"    : showajax(".col-right", "side_order");
       					break;
		}
	});

	//-- 배송지 변경 : 저장 버튼 ---------------------------------
	$("body").on("click",".delivery_save",function(){
		$("#delivery_save_yn").val("Y");

		$("#typ").val("delivery_save");		
		delivery_save();	//menu.js
	});

	$("body").on("click",".delivery_del",function(){
		$("#typ").val("delivery_del");		
		delivery_save();
	});

	
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
		openLayer("layer4","19_16", "?odr_det_idx="+$(this).attr("odr_det_idx"));
	});

	$("body").on("click",".btn-dialog-19_15_1",function(){
		openLayer("layer4","19_15_1", "?odr_det_idx="+$(this).parent().attr("odr_det_idx"));
	});	
	
	//수량 부족 후 추가 선적 다이얼로그 -> param추가 후 교환 선적으로 연결
	$("body").on("click",".btn-dialog-1917",function(){
//		openLayer("layer3","19_17");

		openLayer("layer3","18R_21","?fault_quantity="+$("#fault_quantity").val()+"&fault_select=3&odr_idx="+$("#odr_idx_"+$("#loadPage").val()).val()+"&odr_det_idx="+$(this).attr("odr_det_idx")+"&ship_info="+$("#ship_info_1916").val());
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

	$("body").on("click",".btn-dialog-21-5-06",function(){
		openLayer("layer3","21_5_06","?odr_det_idx="+$(this).attr("odr_det_idx")+"&odr_idx="+$(this).attr("odr_idx"));
	});

	// request rnd용 반품 선적
	$("body").on("click",".btn-dialog-21-2-03_rnd",function(){
		openLayer("layer3","21_5_06","?odr_det_idx="+$(this).attr("odr_det_idx")+"&odr_idx="+$(this).attr("odr_idx"));
	});

	$("body").on("click",".btn-dialog-21-2-10",function(){
		openLayer("layer3","21_2_10","?odr_det_idx="+$(this).attr("odr_det_idx")+"&odr_idx="+$(this).attr("odr_idx"));
	});
	//Test Report 에서 '동의' 클릭
	$("body").on("click",".btn-dialog-21-4-13",function(){
		openLayer("layer3","21_4_13","?tTy="+$(this).attr("tTy")+"&testresult="+$(this).attr("testresult")+"&loadPage="+$("#loadPage").val()+"&fty_history_idx="+$(this).attr("fty_history_idx"));
	});
	////////////////////////////////////////////////////////////////////
	
	
	////////////////////////* pop *///////////////////////////////////
	$("body").on("click",".buy-mn03_0115",function(){//지속적 공급 가능 주문에서 확정 송장 클릭시에는 바로 처리 하지 않고, 공지를 한번 띄운 후 처리한다. 
		openLayer("layer4","01_15","?odr_idx="+$("#odr_idx_30_09").val());
	});


	//-- [발주] 창(05_04)의 '발주서 확인' 클릭 -------------------------------------------------------
	$("body").on("click",".btn-order-confirm",function(){		
		var err = false; 
		var det_cnt = $("#det_cnt").val(); //det 수량
		maskoff();
		err = updateQty();	//수량변경(ajax-UQ), 발주수정(ajax-odr_proc.php?typ=odredit)
		if (err == false)
		{
			if(det_cnt==1){
				var $chked_odr = $("input[name^=odr_det_idx]");//품목 1개일때
				if($("input[name^=odr_det_idx]").attr("part_type")=="2"){
					$("#whole_part_type").val("E");
				}else{
					$("#whole_part_type").val("S");
				}
			}else{
				var $chked_odr = $("input[name^=odr_det_idx]:checked");//품목 2개 이상
			}
			if($chked_odr.length==0){ 
				alert_msg("발주서를 선택해 주세요.");
			}else{
					var new_odr_idx = [];
					$chked_odr.each(function(e){
						new_odr_idx.push($(this).val());
					});
					$("#new_odr_idx").val(new_odr_idx);
				var formData = $("#f_05_04").serialize(); 
				openCommLayer("layer4","30_04","?"+formData+"&odr_idx="+$("#odr_idx_05_04").val()+"&new_odr_idx="+new_odr_idx+"&whole_part_type="+$("#whole_part_type").val());
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
	//--- 선적(30_16) 화면에서 패킹리스트(Packing List) 버튼 클릭--------------------------------------------------------------------------------
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

	//선전완료 화면(30_20)에서 '거절' 버튼 클릭 --------------------------------------------------------------------
	$("body").on("click",".btn-pop-18R04",function(){
		//var $chked_odr_det = $("input[name^=odr_det_idx]:checked");
		//선택과 상관없이 det count
		var det_cnt = $("input[name^=odr_det_idx]").length;
		if($("input[name^=odr_det_idx]").length>1){ //-- 여러개 일때 --------------------------
			$chked_odr_det = $("input[name^=odr_det_idx]:checked");
		}else{	//-- 한개일때 ---------------------------------------
			$chked_odr_det = $("input[name^=odr_det_idx]");
		}
		if($chked_odr_det.length==0){
			alert_msg("제품을 선택해 주세요.");
		}else{
			var ch_odr_det_idx = [];
			$chked_odr_det.each(function(e){
						ch_odr_det_idx.push($(this).val());
			});
			//마자막 물품인지 체크(det_cnt)하여 수량입력창에 전달. - 그 다음 창에서 운임 입력창 여부
			if(det_cnt>1){  //남은게 있다..
				//openLayer("layer3","18R_05","?odr_idx="+$("#odr_idx_30_20").val()+"&odr_det_idx="+ch_odr_det_idx); 2016-05-16
				//수량 입력 창
				openLayer("layer4","19_04","?det_cnt="+det_cnt+"&odr_idx="+$("#odr_idx_30_20").val()+"&odr_det_idx="+ch_odr_det_idx); //2016-05-16
			}else{	//남은게 없다.(마직막)
				openLayer("layer4","19_04","?det_cnt=0&odr_idx="+$("#odr_idx_30_20").val()+"&odr_det_idx="+ch_odr_det_idx);
				//openLayer("layer4","18R_04", "?odr_det_idx="+ch_odr_det_idx); //기존(JSJ) 운임 입력 창
			}
		}
	});
	
	$("body").on("click",".btn-pop-18-2-08",function(){
		openLayer("layer4","18_2_08","?odr_idx="+$(this).parent().attr("odr_idx")+"&odr_det_idx="+$(this).parent().attr("odr_det_idx"));
	});
	

	

	$("body").on("click",".btn-remittance",function(){
		openLayer("layer4","23_21");
	});	

	//결제 팝업 (Black Ver) : Invoice 서류에서 [결재] --------------------------------------------
	$("body").on("click",".btn-pop-3012",function(){
		//2017-01-09 : odr_det 테이블의 데이터를 Invoice 데이터로 Update
		$.ajax({ 
			type: "GET", 
			url: "/ajax/proc_ajax.php", 
			data: { actty : "DIU",
				odr_idx : $(this).attr("odr_idx")
			},
			dataType : "json" ,
			async : false ,
			success: function(data){
				if(data.err == "OK"){
				}else{
					alert(data.err);
				}
			}
		});

		if ($(this).attr("tot_amt")=="")
		{

			$(this).attr("tot_amt",$("#tot_"+$(this).attr("odr_idx")).val());
		}
		openLayer("layer4","30_12","?odr_idx="+$(this).attr("odr_idx")+"&odr_det_idx="+$(this).attr("odr_det_idx")+"&tot_amt="+$(this).attr("tot_amt")+"&fromLoadPage="+$(this).attr("fromLoadPage")+"&deposit_yn="+$(this).attr("deposit_yn")+"&charge_type="+$(this).attr("charge_type"));
	});
	//결제 팝업 (Red Ver) --------------------------------------------------------------------
	$("body").on("click",".btn-pop-21-1-11",function(){		
		openLayer("layer4","21_1_11","?odr_idx="+$(this).attr("odr_idx")+"&odr_det_idx="+$(this).attr("odr_det_idx")+"&tot_amt="+$("#tot_"+$(this).attr("odr_det_idx")).val()+"&fromLoadPage="+$(this).attr("fromLoadPage")+"&charge_type="+$(this).attr("charge_type"));
	});

	//결제창에서 Mybank 클릭시 (Black ver)
	$("body").on("click",".btn-pop-18-2-11",function(){
		if ($(this).attr("charge_type")=="14"){  //14:회원가입비
			openLayer("layer4","18_2_11","?tot_amt="+$(this).attr("tot_amt")+"&charge_type="+$(this).attr("charge_type")+"&memfee_id="+$(this).attr("memfee_id")+"&typ=write");
		}else{
			if($(this).attr("fromLoadPage")=="18_2_09"){ //18_2_09 : Invoice(환불) : 부대비용 포함
				openLayer("layer4","18_2_11","?odr_idx="+$(this).attr("odr_idx")+"&odr_det_idx="+$(this).attr("odr_det_idx")+"&tot_amt="+$("#tot_"+$(this).attr("odr_idx")).val()+"&typ=pay_access");
			}else{ //일반 거래
				openLayer("layer4","18_2_11","?odr_idx="+$("#odr_idx_30_09").val()+"&tot_amt="+$("#tot_"+$("#odr_idx_30_09").val()).val()+"&typ=pay");
			}
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
	//메인 검색에서 납기품목 수량 입력 후 '확인' 버튼--------------------
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
			openLayer("layer4","31_03","?callfrom=main&part_idx="+$("#part_idx").val()+"&odr_quantity="+$("#odr_quantity").val()+"&price="+$("#price").val());
		}
	});
	//---- 납기확인 바랍니다. [전송]---
	$("body").on("click",".periodreq",function(){
		$(this).children("img").attr("src","/kor/images/loding_img.gif");		
		$(this).attr("class","");	
		maskoff();

		var part_idx = $(this).attr("part_idx");
		var price_chk = $(this).attr("price");
		var qty_chk = $(this).attr("qty");
		var odr_quantity = $(this).attr("odr_quantity");
		var fromLoadPage = $(this).attr("fromLoadPage");
		
		$.ajax({ 
				type: "GET", 
				url: "/ajax/proc_ajax.php?actty=part_info_chk&part_idx="+part_idx+"&price="+price_chk+"&qty="+qty_chk+"&odr_qty="+odr_quantity, 					
				dataType : "text" ,
				async : false ,
				success: function(data){
					var data_string = $.trim(data);
					var data_split = data_string.split( '_' );

					if($.trim(data_split[0])=="price"){	//가격변동 경고!!
							closeCommLayer("layer3");
							closeCommLayer("layer4");
							if (fromLoadPage=="05_04")
							{
								openCommLayer('layer3','05_01','?odr_idx='+$("#odr_idx").val()+'&addsearch_part_no='+$("#addsearch_part_no").val()+'&change=price&part_idx='+part_idx+"&fromLoadPage="+$("#fromLoadPage").val());
							}
							else
							{
								openCommLayer('layer3','31_02','?part_idx='+part_idx+'&change=price&change_part_idx='+data_split[1]);
							}
							
							openLayer('layer4','alarm2','');	//가격변동 경고창
							return;
					}else if ($.trim(data_split[0])=="qty"){							
							//alert("재고수량 변경 경고!!");
							closeCommLayer("layer4");
							if (fromLoadPage=="05_04")
							{
								openLayer('layer3','05_01','?odr_idx='+$("#odr_idx_05_01").val()+'&addsearch_part_no='+$("#addsearch_part_no").val()+'&change=qty&part_idx='+part_idx+"&fromLoadPage="+$("#fromLoadPage").val());
							}
							else
							{
								openCommLayer('layer3','31_02','?part_idx='+part_idx+'&change=qty&change_part_idx='+data_split[1]);
							}
							
							openLayer('layer4','alarm','');
							return;							
					}
					else if ($.trim(data_split[0])=="delete"){							
							//alert("재고수량 변경 경고!!");
							closeCommLayer("layer4");				
							if (fromLoadPage=="05_04")
							{
								openLayer('layer3','05_01','?odr_idx='+$("#odr_idx_05_01").val()+'&addsearch_part_no='+$("#addsearch_part_no").val()+'&change=delete&part_idx='+part_idx+"&fromLoadPage="+$("#fromLoadPage").val());
								openLayer('layer4','alarm3','?part_idx='+part_idx+'&change=delete&change_part_idx='+data_split[1]+"&fromLoadPage="+fromLoadPage);
							}
							else
							{
								openCommLayer('layer3','31_02','?part_idx='+part_idx+'&change=qty&change_part_idx='+data_split[1]);
								openLayer('layer4','alarm','');
							}
							
							//
					
							return;							
					}		
					else
					{						
						var frompage = $("input[name='fromPage']").val();
						var f =  document.f;
						 f.target = "proc";
						 //f.target = "_blank";
						 f.action = "/kor/proc/odr_proc.php";
						 f.submit();
						 if(frompage != "add"){
							 //Refresh_Right();
							 //Refresh_MainSh(); //2016-04-08
							 showajax(".col-right", "side_order"); //2017-0417
						 }
					}			
				}//success
			});		
	});

	//도착 01_36(지속적 공급가능한..... 의 판매자 물품 도착)
	$("body").on("click",".btn-submit-0136",function(){
		var f =  document.f_01_36;
		f.target = "proc";
		f.action = "/kor/proc/odr_proc.php";
		f.submit();		
	});
	//구매자 수령,지연(30_21) 전송(처리)--------------------------------------------
	$("body").on("click",".succEnd",function(){
		maskoff();
		var f =  document.f;
		var det_idx = $("#odr_det_idx").val();
		var ary = det_idx.split(",");
		var det_cnt = $("#det_cnt_3021").val();

		if($(this).hasClass("succEnd")){  // -------- 수령 ------------------------------
			if(det_cnt != ary.length){  //----- 일부일경우 ------			
				if(ary.length){ //1개 이상부터...
					//복제하고, 전체처럼 proc
					$.ajax({ 
						type: "GET", 
						url: "/ajax/proc_ajax.php?det_idx="+det_idx, 
						data: { actty : "ODRCP", //주문 복제
								odr_idx : $("#odr_idx_3021").val()
								},
						dataType : "html" ,
						async : false ,
						success: function(data){
							//alert("data"+trim(data));
							$("#odr_idx_3021").val(trim(data));
							$("#typ_3021").val("succEnd2");
						}
					});
				}else{ //1개일때..
					$("#typ_3021").val("succEnd");
				}
			}else{  //--------------------- 전체 -------------------
				$("#typ_3021").val("succEnd2");
			}
			f.target = "proc";
			f.action = "/kor/proc/odr_proc.php";
			f.submit();

			var menu_type_chk = getCookie('menu');

			closeCommLayer("layer5");	//invoic 닫고
			closeCommLayer("layer3");	//송장(3008) 닫고
			closeCommLayer("layer");
			
			switch (menu_type_chk) {
				case "order_S"    : if(chkLogin()){order('S'); showajax(".col-right", "side_order");}
				           break;
				case "order_B"    : if(chkLogin()){order('B'); showajax(".col-right", "side_order");}
				           break;
				case "mybox"    : if(chkLogin()){showajax(".col-left", "mybox"); showajax(".col-right", "side_order");}
				           break;
				case "record_S"    : if(chkLogin()){record('S'); showajax(".col-right", "side_order");}
				           break;
				case "record_B"    : if(chkLogin()){record('B'); showajax(".col-right", "side_order");}
				           break;
				case "remit"    : if(chkLogin()){remit('C'); showajax(".col-right", "side_order");}
				           break;
				case "side_order"    : showajax(".col-right", "side_order");
           					break;
			}
		}

		/** 2016-05-18 주석처리.
		if($(this).hasClass("succEnd")){  //우선, 수령에서만 복제 적용
			if(det_cnt > ary.length){  //----- 일부일경우 복제
				$.ajax({ 
					type: "GET", 
					url: "/ajax/proc_ajax.php?det_idx="+det_idx, 
					data: { actty : "ODRCP", //주문 복제
							odr_idx : $("#odr_idx_3021").val()
							},
					dataType : "html" ,
					async : false ,
					success: function(data){
						//alert("data"+trim(data));
						$("#odr_idx_3021").val(trim(data));
						$("#typ_3021").val("succEnd2");
					}
				});
			}
		}
		**/
		//f.target = "proc";
		//f.action = "/kor/proc/odr_proc.php";
		//f.submit();		
	});
	//fault 수령------------------ 30_21_F ---------------------------------
	$("body").on("click",".faultEnd",function(){
		f.target = "proc";
		f.action = "/kor/proc/odr_proc.php";
		f.submit();	
	});
	//판매자 : 수령 확인(완료처리, 입금처리)-------------------------
	$("body").on("click",".btn_3022",function(){
		var odr_idx = $(this).attr("odr_idx");
		var odr_det_idx = $("input[name^=odr_det_idx]");
		//odr의 전체 or 일부 판단...
		if(odr_det_idx.length < $("#det_cnt_3022").val()){ //odr의 일부
			odr_det_idx = $("input[name^=odr_det_idx]").val();
		}else{ //odr의 전체
			odr_det_idx = 0;
		}
		$.ajax({ 
			type: "GET", 
			url: "/ajax/proc_ajax.php", 
			data: { actty : "CF2", //odr 완료처리 (입금처리도 해야 함)
					odr_idx : odr_idx,
					odr_det_idx : odr_det_idx
					},
			//dataType : "html" ,
			dataType : "json" ,
			async : false ,
			success: function(data){
				if(data.err == "OK"){
					if(data.mybank_hold > 0){
						alert("보증금 반환.");
					}else{
						openCommLayer("layer6","alarm_payment","?amt="+data.pay_amt);
					}
				}else{
					alert(data.err);
				}
				/** 
				if(trim(data).length>0){
					alert(trim(data));
				}else{
					//document.location.href="/kor/"; //이유 : 로그인 자리에 있는 'MyBank' 금액이 갱신되야함.
					openCommLayer("layer6","alarm_payment","?amt=");
				}
				**/
			}
		});

	});
	//alert3 버튼 클릭 ----------------------------------------------
	$("body").on("click",".btn-alert3",function(){
		//납기 답변 -> 알림창 -> 삭제
		if($(this).hasClass("31_05")){
			$(this).children("img").attr("src","/kor/images/loding_img.gif");
			$.ajax({ 
			type: "GET", 
			url: "/ajax/proc_ajax.php", 
			data: { actty : "DLP2", //Delete period 2
					actidx : $("#odr_idx_"+$("#loadPage").val()).val(),
					actkind : "판매자 삭제"
			},
				dataType : "html" ,
				async : false ,
				success: function(data){ 
					//document.location.href="/kor/";
					Refresh_Right();
					closeCommLayer("layer6"); //현재 메시지 창
					closeCommLayer("layer3"); //납기확인 창
					closeCommLayer("layer"); //what's New 창
				}
			});
		} //end if 31_05
	});

	//납기 확인 요청시 삭제 버튼 클릭 팝업
	$("body").on("click",".btn-pop-0201",function(){
		alert3("삭제","삭제 시 해당 품목은 당신의 재고 목록에서 삭제됩니다. <br>만약 해당 품목을 판매하고 싶다면 재 등록해 주시기 바랍니다.","btn_end","31_05","Y"); //2016-04-07
		//openLayer("layer4","02_01");  //기존
	});

	//납기 확인 요청 -> 삭제 버튼 -> 삭제(경고) 팝업에서 종료 버튼 클릭시(기존)
	$("body").on("click",".del_confirm",function(){
		//alert("loadPage:"+$("#loadPage").val());
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
				//	alert_msg("삭제 메세지를 보냈습니다.");
					document.location.href="/kor/";
				}
			});
		}
	});
	$("body").on("click",".btn-pop-0119",function(){
		openLayer("layer4","01_19");
	});
	$("body").on("click",".btn-pop-2322",function(){
		openLayer("layer4","23_22");
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
		// 판매자 지정 운송 체크시 actkind :CH
		
			$.ajax({ 
				type: "GET", 
				url: "/ajax/proc_ajax.php", 
				data: { actty : "GAC", //get appoint carrier
						actkind : $this.hasClass("checked")==true ? "CH":"",
						actidx : $this.attr("odr_idx")
				},
					dataType : "html" ,
					async : false ,
					success: function(data){ 
							if ($this.hasClass("checked"))
							{	
								//alert(trim(data) == "");
								if (trim(data) == "")
								{
									openLayer("layer4","15_04","?odr_idx="+$this.attr("odr_idx")+"&loadPage="+$this.attr("loadPage"));
								}else{
									$this.parent().addClass("c-red");
									$this.parent().find("span[id=appoint]").html(": <img src='/kor/images/icon_"+trim(data)+".gif' height='15'>");
								}
							}else{
								$this.parent().removeClass("c-red");
								$this.parent().find("span[id=appoint]").html("");
							}
					}
			});

	});
	$("body").on("click",".btn-pop-1706",function(){
		openLayer("layer4","17_06", "?odr_idx="+$(this).attr("odr_idx"));
	});
	$("body").on("click",".btn-pop-1904",function(){
		var $chked_odr_det = $("input[name^=odr_det_idx]:checked");
		if($chked_odr_det.length==0){
			
			if ($("input[name^=odr_det_idx]").length > 0)
			{				
				openLayer("layer4","19_04", "?det_cnt=1&odr_det_idx="+$("input[name^=odr_det_idx]").val()+"&fault_method="+$(this).attr("fault_method"));
			}
			else
			{			
				alert_msg("제품을 선택해 주세요.");
			}
			
		}else{
			var ch_odr_det_idx = [];
			$chked_odr_det.each(function(e){
						ch_odr_det_idx.push($(this).val());
			});
			
			openLayer("layer4","19_04", "?det_cnt=1&odr_det_idx="+ch_odr_det_idx+"&fault_method="+$(this).attr("fault_method"));
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
	//21_4_13 에서 '입금' 클릭
	$("body").on("click",".btn-pop-21-4-14",function(){
		openLayer("layer4","21_4_14","?tTy="+$(this).attr("tTy")+"&testresult="+$(this).attr("testresult")+"&fty_history_idx="+$(this).attr("fty_history_idx")+"&pay="+$(this).attr("pay")+"&pay_method="+$(this).attr("pay_method"));
	});

	//21_4_14 에서 '입금' 클릭
	$("body").on("click",".btn-end-pop",function(){
		openLayer("layer4","fault_end_pop","?tTy="+$(this).attr("tTy")+"&testresult="+$(this).attr("testresult")+"&fty_history_idx="+$(this).attr("fty_history_idx")+"&pay="+$(this).attr("pay")+"&pay_method="+$(this).attr("pay_method"));
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
		var mode=$(this).attr("mode");
		if ($(this).attr("ref")){
			openLayer("layer3","message_02","?ref="+$(this).attr("ref")+"&ref2="+$(this).attr("ref2")+"&lev="+$(this).attr("lev")+"&step="+$(this).attr("step")+"&mode="+$(this).attr("mode"));
		}else{
			openLayer("layer3","message_02","?mode="+$(this).attr("mode"));
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
			alert_msg("로그인 후 이용하여 주시기 바랍니다.");
		}else if(com_idx == $(this).attr("sell_com_idx")){
			alert_msg("판매회사와 구매회사가 동일합니다.");
		}else{			
			 var f =  document.ftop;
			 f.part_idx.value=$(this).attr("id");
			 f.part_type.value=$(this).attr("part_type");
			 f.work.value=$(this).attr("work");
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
		$(".select.opt1:eq(0) label").html("Nation");
		$(".select.opt1:eq(0) select").remove();
		$(".select.opt1:eq(1) label").html("City/Province");
		$(".select.opt1:eq(1) select").remove();
		$(".select.opt2 label").html("Manufacturer");
		$(".select.opt2 select").remove();
		$("#sel_nation").val("");
		$("#sel_manufacturer").val("");

		main_srch();		
	});

	//[Whst' New]창 => '발주서 확인' 버튼 클릭----------------------------------
	$("body").on("click",".btn-view-sheet-forread",function(){
		var param="";
		if ($(this).attr("forread")=="Y"){
			param = "&forread=Y";
		}
		openLayer("layer5","30_05","?odr_idx="+$(this).attr("odr_idx")+param);
	});
	

}); //end if ready..
//-------------------------- 수량 변경(ajax 처리 - UQ) ----------------------------------------------------------------
function updateQty(){
	var err = false;
	var qty, amd_yn, quantity;
	
	//-- Row 수량만큼 반복--------------------
	$("input[name^=odr_quantity]").each(function(){
		
		if($(this).val()==""){
			qty = 0;
		}else{
			qty = $(this).val();
			amd_yn = $(this).attr("amd_yn"); //수정발주서 여부
			quantity = $(this).attr("quantity"); //기존 재고
			supply_quantity = $(this).attr("supply_quantity"); //공급 수량
		}
		//alert("qty:"+qty);
		/*if(parseInt($(this).parent().prev().prev().text().replace(/,/gi,"")) < parseInt($(this).val())){
			alert_msg("수량을 다시 확인해 주세요.");
			$(this).focus();
			err = true;
			return false;
		}else{*/
			maskoff();
			//alert("qty:"+qty+", det_idx:"+$(this).attr("odr_det_idx"));

			$.ajax({ 
				type: "GET", 
				url: "/ajax/proc_ajax.php", 
				data: { actty : "UQ", //Update QUANTITY
						actidx : $(this).attr("odr_det_idx"),
						actkind : qty,
						amd_yn : amd_yn,	//수정발주서 여부
						//supply_quantity : supply_quantity,	//공급 수량
						load_page : $("#load_page").val(),
						quantity : quantity	//발주가능 재고
				},
				dataType : "html" ,
				async : false ,
				success: function(data){ 		
						maskoff();
				}
			});
		//}
	});	//-- end of Row 수량만큼 반복--------------------
	
	//-- 배송지 변경--------------------
	//2016-04-08 form 'f' 를 'f_05_04'로 변경
	//if($("#delivery_chg").is(":checked") && f.com_name.value!=""){	

	if($("#delivery_chg").is(":checked")){
			if($("#delivery_addr_idx").val()=="" || $("#delivery_addr_idx").val()=="0"){   //save_yn='N'으로 먼저 저장해야 함.
				$("#delivery_save_yn").val("N");
				$("#typ").val("delivery_save");		
				delivery_save();
			}			
	}else{
		$("#delivery_addr_idx").val("");
	}
	//-- ship 정보 Update-----------------------------
	if (err == false)
	{
		if($("section[class^='layer3']").hasClass("open")){ //2016-04-04
			$("#f_05_04 input[name=typ]").val("odredit");
			var formData = $("#f_05_04").serialize(); 
		}else{
			$("#f input[name=typ]").val("odredit");
			var formData = $("#f").serialize(); 
		}
		$.ajax({
				url: "/kor/proc/odr_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {
					err=false;
				}
		});		
	}
	return err;
}

function updateQty_temp(){
	var err = false;
	var qty, amd_yn, quantity;
	
	//-- Row 수량만큼 반복--------------------
	$("input[name^=odr_quantity]").each(function(){
		
		if($(this).val()==""){
			qty = 0;
		}else{
			qty = $(this).val();
			amd_yn = $(this).attr("amd_yn"); //수정발주서 여부
			quantity = $(this).attr("quantity"); //기존 재고
			supply_quantity = $(this).attr("supply_quantity"); //공급 수량
		}
		//alert("qty:"+qty);
		if(parseInt($(this).parent().prev().prev().text().replace(/,/gi,"")) < parseInt($(this).val())){
			alert_msg("수량을 다시 확인해 주세요.");
			$(this).focus();
			err = true;
			return false;
		}else{
			maskoff();
			//alert("qty:"+qty+", det_idx:"+$(this).attr("odr_det_idx"));

			$.ajax({ 
				type: "GET", 
				url: "/ajax/proc_ajax.php", 
				data: { actty : "UQ_TEMP", //Update QUANTITY
						actidx : $(this).attr("odr_det_idx"),
						actkind : qty,
						amd_yn : amd_yn,	//수정발주서 여부
						//supply_quantity : supply_quantity,	//공급 수량
						load_page : $("#load_page").val(),
						quantity : quantity	//발주가능 재고
				},
				dataType : "html" ,
				async : false ,
				success: function(data){ 		
						maskoff();
				}
			});
		}
	});	//-- end of Row 수량만큼 반복--------------------
	
	//-- 배송지 변경--------------------
	//2016-04-08 form 'f' 를 'f_05_04'로 변경
	//if($("#delivery_chg").is(":checked") && f.com_name.value!=""){			
	if($("#delivery_chg").is(":checked")){		

	//alert($("#delivery_addr_idx").val());	
			if($("#delivery_addr_idx").val()==""){   //save_yn='N'으로 먼저 저장해야 함.
				$("#delivery_save_yn").val("N");
				$("#typ").val("delivery_save");		
				delivery_save();
			}			
	}else{
		$("#delivery_addr_idx").val("");
	}
	//-- ship 정보 Update-----------------------------
	if (err == false)
	{
		if($("section[class^='layer3']").hasClass("open")){ //2016-04-04
			$("#f_05_04 input[name=typ]").val("odredit");
			var formData = $("#f_05_04").serialize(); 
		}else{
			$("#f input[name=typ]").val("odredit");
			var formData = $("#f").serialize(); 
		}
		$.ajax({
				url: "/kor/proc/odr_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {
					err=false;
				}
		});		
	}
	return err;
}

function Refresh_MainSh(){
	if ($("input[name=top_part_no]").val().length>1){
		main_srch();
	} else{
		Refresh_Right();
	}
}
//---------------------------------------------------- 메인 검색 ------------------------------------------------------------------
function main_srch(){
	if ($("input[name=top_part_no]").val().length>1)
	{
	$("#sel_nation").val($("#opt1 option:selected").length==0?"":$("#opt1 option:selected").val());
	$("#sel_manufacturer").val($("#opt2 option:selected").length==0?"":$("#opt2 option:selected").val());
	$("#ftop_sch input[name=actty]").val("mainsrch");
	//2017-04-05 : 특수문자, 공백 제거 관련
	var tStr = /[\{\}\[\]\/?.,;:|\)*~`!^\-_+<>@\#$%&\\\=\(\'\"]/gi
	var oriPartNo = $("#top_part_no").val();
	var shPartNo = oriPartNo.replace(tStr,"");
	shPartNo = shPartNo.replace(/^\s+|\s+$/g,"");
	shPartNo = shPartNo.replace(/\s/g,"");
	$("#top_part_no").val(shPartNo);

	var oriManu = $("#top_manufacturer").val();
	var shManu = oriManu.replace(tStr,"");
	shManu = shManu.replace(/^\s+|\s+$/g,"");
	shManu = shManu.replace(/\s/g,"");
	$("#top_manufacturer").val(shManu);

	setMenuNull();
	var formData = $("#ftop_sch").serialize(); 
		$.ajax({
				url: "/ajax/proc_ajax.php", 
				data: formData,
				success: function (data) {
					var spldata = data.split(":::");					
					if($("#stockList").length==0){
						showajax(".col-left", "main_stock");
					}
					$("#stockList .stock-list-table tbody").remove();
					$("#stockList .stock-list-table").append($(spldata[0]).fadeIn(300));
					
					var ary = new Array();
					var idx, newidx;
					// 2017-04-17 검색 금액 부분 스트링-> FLOAT 타입으로 변경 - 박정권
					$("#stockList tbody[id^=tbd]").each(function(e){							
						if (typeof($(this).find("tr:eq(1) td:eq(8)").html())=="string")
						{
							var price = $(this).find("tr:eq(1) td:eq(8)").html().replace("$","");
							price = price.replace(",","");
							//alert(parseFloat(price));
							ary.push(parseFloat(price));
						}else{
							ary.push(parseFloat("999999999999"));							
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
					$("#stockList .stock-list-table tbody td").removeClass("first");
					$("#stockList .stock-list-table tbody:eq(0) td:eq(0)").addClass("first");
					if($("input[name=area]:checked").length==1){
						$(".select.type3.opt1:eq(0)").hide();
						$(".select.type3.opt1:eq(1) option:eq(0)").prop("checked", true);
						$(".select.type3.opt1:eq(1)").show();
					}else{						
						$(".select.type3.opt1:eq(1)").hide();
						$(".select.type3.opt1:eq(0) option:eq(0)").prop("checked", true);
						$(".select.type3.opt1:eq(0)").show();
					}
					right_side();
					ready();
					var equl = $("input[name=area]").prop("checked")== true ? "1":"0";
					$(".select.opt1:eq("+equl+") select").remove();
					$(".select.opt1:eq("+equl+")").append($(spldata[1]));
					$(".select.opt2 select").remove();
					$(".select.opt2").append($(spldata[2]));
					$("select[name^=opt]").change(function(e){
						if($(this).attr("name")=="opt1"){
							$(".select.opt2 label").html("Manufacturer");
							$(".select.opt2 select option:eq(0)").prop("selected",true);
						}
						main_srch();
						
					});
					
				}
		});
		$("#top_part_no").val(oriPartNo);
		$("#top_manufacturer").val(oriManu);
	}else{
		alert_msg("2자 이상 입력바랍니다");
	}	
}
//--- 발주추가 검색창(05_01) 검색처리------------------------
function btn_addSearch(){
		if ($("#f_add input[name=addsearch_part_no]").val().length>1)
		{
			openCommLayer("layer3","05_01","?odr_idx="+$("#odr_idx_05_01").val()+"&addsearch_part_no="+$("#addsearch_part_no").val()+"&fromLoadPage="+$("#fromLoadPage").val());
			$("#addsearch_part_no").focus();
		}else{
			alert_msg("2자 이상 입력바랍니다");
		}	
	}
	


function confirmPwd(){
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
	}
//운송회사 변경 -------------------------------------------------------------------------
function chg_ship_info(obj){
	
	var ship_ch_btn = $("#delivery_addr_idx").val();
	var load_page = $("#delv_load").val();
	var chk_val=$("input:checkbox[id='delivery_chg']").is(":checked");
	//alert(load_page);
		if (obj.value)
		{
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
							if (load_page != "undefined")
							{
								if (obj.value<5)  //일반 운송업체
								{
									$("#ship_account_no").val(trim(data)==""?"Address":data).show().parent().prev().find("span").show();
									$("#memo").removeClass("i-txt2").addClass("i-txt5");
									$(".text_lang").attr('lang','en');	
									
								}else{ //다른 운송업체
									$("#ship_account_no").val("").hide().parent().prev().find("span").hide();
									$("#memo").removeClass("i-txt5").addClass("i-txt2");
								}

								if (obj.value==6){ //직접수령
									$("#insur_yn,#delivery_chg").attr("disabled", true).attr("checked", false).removeClass("checked");
									$("input[name=insur_yn]").parent().next().html(" : No");
									$(".company-info-wrap").hide();

								}else{
									$("#insur_yn,#delivery_chg").attr("disabled", false);
								}
								if(load_page=="05_04" || load_page=="09_01")
								{
									/*
									if (ship_ch_btn == 0)
									{
										$("#ship_account_no").val("");
									}
									*/
									if (chk_val==true)
									{
										$("#ship_account_no").val("");
									}
								}
							}
							
							
				}
			});		
		}	
		else
		{
			$("#ship_account_no").val("");
		}
	
}

function data_del()
{
	location.href="/odr_data_del.php";
}
function getCookie(cName) {
	cName = cName + '=';
	var cookieData = document.cookie;
	var start = cookieData.indexOf(cName);
	var cValue = '';
	if(start != -1){
	   start += cName.length;
	   var end = cookieData.indexOf(';', start);
	   if(end == -1)end = cookieData.length;
	   cValue = cookieData.substring(start, end);
	}
	return unescape(cValue);
}



function setCookie(cookieName, value, exdays){
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var cookieValue = escape(value) + ((exdays==null) ? "" : "; expires=" + exdate.toGMTString());
    document.cookie = cookieName + "=" + cookieValue;
}


