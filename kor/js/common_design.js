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
	
	//checkbox
	$("body").on("click","input[type='checkbox']",function(){
		if($(this).prop("checked") == true){
			$(this).addClass('checked');
		}
		else if($(this).prop("checked") == false){
			$(this).removeClass('checked');
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
	  if (event.which && (event.which > 45 && event.which < 58 || event.which == 8)) {			
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
		openLayer("layer","layerSell");
	});
	
	$(".layer-wrap").on("click", ".view-buy", function(){
		openLayer("layer","layerBuy");
	});
	
	$(".open-layer-sell").on("click",function(){
		openLayer("layer","layerSell");
	});
	
	$(".open-layer-buy").on("click",function(){
		openLayer("layer","layerBuy");
	});
	
	$("body").on("click",".sell-mn01",function(){
		openLayer("layer","31_04","?mn=01");
	});
	$("body").on("click",".sell-mn02",function(){
		//openLayer("layer","30_06","?mn=02");
		$.ajax({
				url: "/kor/proc/odr_proc.php", 
				data: "typ=odrconfirm&odr_idx="+$("#odr_idx").val()+"&sell_mem_idx="+$("#sell_mem_idx").val(),
				encType:"multipart/form-data",
				success: function (data) {	
					if (trim(data) == "SUCCESS"){		
						alert("판매자에게 확정 발주서를 전송했습니다.");
						document.location.href="/kor/";
					}else{
						alert(data);
					}
				}
		});		
	});
	$("body").on("click",".sell-mn02-1601",function(){
		openLayer("layer","16_01","?mn=02");
	});
	$("body").on("click",".sell-mn02-1701",function(){
		openLayer("layer","17_01","?mn=02");
	});
	$("body").on("click",".sell-mn03",function(){
		openLayer("layer","09_03","?mn=03");
	});
	$("body").on("click",".sell-mn03-1208",function(){
		openLayer("layer","12_08","?mn=03");
	});
	$("body").on("click",".sell-mn04",function(){
		openLayer("layer","10_04","?mn=04");
	});
	$("body").on("click",".sell-mn05",function(){
		openLayer("layer","30_15","?mn=05");
	});
	$("body").on("click",".sell-mn05-0128",function(){
		openLayer("layer","01_28","?mn=05");
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
	$("body").on("click",".sell-mn06",function(){
		openLayer("layer","30_22","?mn=06");
	});
	$("body").on("click",".sell-mn06-1225",function(){
		openLayer("layer","12_25","?mn=06");
	});
	$("body").on("click",".sell-mn07",function(){
		openLayer("layer","03_02","?mn=07");
	});
	$("body").on("click",".sell-mn08",function(){
		openLayer("layer","07_02","?mn=08");
	});
	$("body").on("click",".sell-mn08-1302",function(){
		openLayer("layer","13_02","?mn=08");
	});
	$("body").on("click",".sell-mn09",function(){
		openLayer("layer","18R_06","?mn=09");
	});
	$("body").on("click",".sell-mn09-18r-10",function(){
		openLayer("layer","18R_10","?mn=09");
	});
	$("body").on("click",".sell-mn09-18r-14",function(){
		openLayer("layer","18R_14","?mn=09");
	});
	$("body").on("click",".sell-mn10",function(){
		openLayer("layer","19_06","?mn=10");
	});
	$("body").on("click",".sell-mn10-1914",function(){
		openLayer("layer","19_14","?mn=10");
	});
	$("body").on("click",".sell-mn10-19-1-02",function(){
		openLayer("layer","19_1_02","?mn=10");
	});
	$("body").on("click",".sell-mn11",function(){
		openLayer("layer","18R_19","?mn=11");
	});
	$("body").on("click",".sell-mn11-18-1-10",function(){
		openLayer("layer","18_1_10","?mn=11");
	});
	$("body").on("click",".sell-mn12",function(){
		openLayer("layer","21_05","?mn=12");
	});
	$("body").on("click",".sell-mn13",function(){
		openLayer("layer","21_1_04","?mn=13");
	});
	$("body").on("click",".sell-mn13-21-3-02",function(){
		openLayer("layer","21_3_02","?mn=13");
	});
	$("body").on("click",".sell-mn14",function(){
		openLayer("layer","21_1_09","?mn=14");
	});
	$("body").on("click",".sell-mn14-21-2-09",function(){
		openLayer("layer","21_2_09","?mn=14");
	});
	$("body").on("click",".sell-mn15",function(){
		openLayer("layer","21_7_02","?mn=15");
	});
	$("body").on("click",".sell-mn16",function(){
		openLayer("layer","21_3_10","?mn=16");
	});
	$("body").on("click",".sell-mn17",function(){
		openLayer("layer","21_4_11","?mn=17");
	});
	$("body").on("click",".sell-mn18",function(){
		openLayer("layer","21_4_10","?mn=18");
	});
	$("body").on("click",".sell-mn19",function(){
		openLayer("layer","21_14","?mn=19");
	});
	
	
	
	$("body").on("click",".buy-mn01",function(){
		openLayer("layer","31_06","?mn=01");
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
	$("body").on("click",".buy-mn03",function(){
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
		openLayer("layer","30_20","?mn=08");
	});
	$("body").on("click",".buy-mn08-18r-01",function(){
		openLayer("layer","18R_01","?mn=08");
	});
	$("body").on("click",".buy-mn08-18r-25",function(){
		openLayer("layer","18R_25","?mn=08");
	});
	$("body").on("click",".buy-mn09",function(){
		openLayer("layer","02_02","?mn=09");
	});
	$("body").on("click",".buy-mn10",function(){
		openLayer("layer","06_02","?mn=10");
	});
	$("body").on("click",".buy-mn10-1304",function(){
		openLayer("layer","13_04","?mn=10");
	});
	$("body").on("click",".buy-mn11",function(){
		openLayer("layer","18R_08","?mn=11");
	});
	$("body").on("click",".buy-mn12",function(){
		openLayer("layer","19_08","?mn=12");
	});
	$("body").on("click",".buy-mn12-19-2-04",function(){
		openLayer("layer","19_2_04","?mn=12");
	});
	$("body").on("click",".buy-mn13",function(){
		openLayer("layer","18R_16","?mn=13");
	});
	$("body").on("click",".buy-mn13-18-1-02",function(){
		openLayer("layer","18_1_02","?mn=13");
	});
	$("body").on("click",".buy-mn14",function(){
		openLayer("layer","19_21","?mn=14");
	});
	$("body").on("click",".buy-mn16",function(){
		openLayer("layer","18_2_16","?mn=16");
	});
	$("body").on("click",".buy-mn16-19-1-06",function(){
		openLayer("layer","19_1_06","?mn=16");
	});
	$("body").on("click",".buy-mn17",function(){
		openLayer("layer","21_07","?mn=17");
	});
	$("body").on("click",".buy-mn18",function(){
		openLayer("layer","21_1_02","?mn=18");
	});
	$("body").on("click",".buy-mn18-21-3-04",function(){
		openLayer("layer","21_3_04","?mn=18");
	});
	$("body").on("click",".buy-mn20",function(){
		openLayer("layer","21_6_03","?mn=20");
	});
	$("body").on("click",".buy-mn21",function(){
		openLayer("layer","21_1_14","?mn=21");
	});
	$("body").on("click",".buy-mn22",function(){
		openLayer("layer","21_5_13","?mn=22");
	});
	$("body").on("click",".buy-mn23",function(){
		openLayer("layer","21_1_07","?mn=23");
	});
	$("body").on("click",".buy-mn23-21-2-02",function(){
		openLayer("layer","21_2_02","?mn=23");
	});
	$("body").on("click",".buy-mn24",function(){
		openLayer("layer","21_5_12","?mn=24");
	});	
	$("body").on("click",".buy-mn25",function(){
		openLayer("layer","21_16","?mn=25");
	});	
	////////////////////////////////////////////////////////////////////

	
	////////////////////////* sheet *///////////////////////////////////
	$("body").on("click",".btn-view-sheet",function(){
		openLayer("layer5","30_05","?odr_idx="+$("#odr_idx").val());
	});
	$("body").on("click",".btn-view-sheet-3007",function(){
		openLayer("layer5","30_07");
	});
	$("body").on("click",".btn-view-sheet-3009",function(){
		openLayer("layer5","30_09");
	});
	$("body").on("click",".btn-view-sheet-3011",function(){
		openLayer("layer5","30_11");
	});
	$("body").on("click",".btn-view-sheet-3017",function(){
		openLayer("layer5","30_17");
	});
	$("body").on("click",".btn-view-sheet-3019",function(){
		openLayer("layer5","30_19");
	});
	$("body").on("click",".btn-view-sheet-18-1-05",function(){
		openLayer("layer5","18_1_05");
	});
	$("body").on("click",".btn-view-sheet-18-1-09",function(){
		openLayer("layer5","18_1_09");
	});
	$("body").on("click",".btn-view-sheet-0120",function(){
		openLayer("layer5","01_20");
	});
	$("body").on("click",".btn-view-sheet-1207",function(){
		openLayer("layer5","12_07");
	});
	$("body").on("click",".btn-view-sheet-21-1-01",function(){
		openLayer("layer5","21_1_01");
	});
	$("body").on("click",".btn-view-sheet-21-4-06",function(){
		openLayer("layer5","21_4_06");
	});
	$("body").on("click",".btn-view-sheet-21-4-12",function(){
		openLayer("layer5","21_4_12");
	});
	////////////////////////////////////////////////////////////////////
	
	
	
	////////////////////////* dialog *///////////////////////////////////
	$("body").on("click",".btn-order",function(){	
		if (mem_idx=="")
		{
			alert("로그인이 필요합니다.");
		}else if(mem_idx == $(this).attr("sell_mem_idx")){
			alert("판매자와 구매자가 동일합니다.");
		}else{
			openLayer("layer3","30_02","?part_idx="+$(this).attr("id"));
		}
	});	
	$("body").on("click",".btn-invoice-3008",function(){
		openLayer("layer3","30_08");
	});
	$("body").on("click",".btn-dialog-3016",function(){
		openLayer("layer3","30_16");
	});
	$("body").on("click",".btn-dialog-3021",function(){
		openLayer("layer3","30_21");
	});
	$("body").on("click",".btn-dialog-18R05",function(){
		openLayer("layer3","18R_05");
	});
	$("body").on("click",".btn-dialog-18R07",function(){
		openLayer("layer3","18R_07");
	});
	$("body").on("click",".btn-dialog-18R09",function(){
		openLayer("layer3","18R_09");
	});
	$("body").on("click",".btn-dialog-18R15",function(){
		openLayer("layer3","18R_15");
	});
	$("body").on("click",".btn-dialog-18R21",function(){
		openLayer("layer3","18R_21");
	});
	$("body").on("click",".btn-dialog-18-1-04",function(){
		openLayer("layer3","18_1_04");
	});
	$("body").on("click",".btn-dialog-18-2-12",function(){
		openLayer("layer3","18_2_12");
	});
	$("body").on("click",".btn-dialog-18-2-14",function(){
		openLayer("layer3","18_2_14");
	});
	$("body").on("click",".btn-dialog-3102",function(){
		openLayer("layer3","31_02");
	});
	$("body").on("click",".btn-dialog-3105",function(){
		openLayer("layer3","31_05");
	});
	$("body").on("click",".btn-dialog-0129",function(){
		openLayer("layer3","01_29");
	});
	$("body").on("click",".btn-dialog-0136",function(){
		openLayer("layer3","01_36");
	});
	$("body").on("click",".btn-dialog-0501",function(){
		openLayer("layer3","05_01","?sell_mem_idx="+$("#sell_mem_idx").val());
	});
	$("body").on("click",".btn-dialog-1001",function(){
		openLayer("layer3","10_01");
	});
	$("body").on("click",".btn-dialog-0504",function(){
		var err = false;
		var varNum;
		$("input[name^=odr_quantity]").each(function(){
			if($(this).val()==""){
				alert("수량을 입력하세요.");
				$(this).focus();
				err = true;
				return;
			}else if(parseInt($(this).parent().prev().prev().text()) < parseInt($(this).val())){
				alert("수량을 다시 확인해 주세요.");
				$(this).focus();
				err = true;
				return;
			}
		});		
		
		if (err == false)
		{
			var f =  document.f;
			 f.target = "proc";
			 f.action = "/kor/proc/odr_proc.php";
			 f.submit();				
		}
	});
	$("body").on("click",".btn-dialog-0901",function(){
		openLayer("layer3","09_01");
	});
	$("body").on("click",".btn-dialog-1219",function(){
		openLayer("layer3","12_19");
	});
	$("body").on("click",".btn-dialog-1210",function(){
		openLayer("layer3","12_10");
	});
	$("body").on("click",".btn-dialog-1905",function(){
		openLayer("layer3","19_05");
	});
	$("body").on("click",".btn-dialog-1917",function(){
		openLayer("layer3","19_17");
	});
	$("body").on("click",".btn-dialog-2104",function(){
		openLayer("layer3","21_04");
	});
	$("body").on("click",".btn-dialog-2106",function(){
		openLayer("layer3","21_06");
	});
	$("body").on("click",".btn-dialog-2108",function(){
		openLayer("layer3","21_08");
	});
	$("body").on("click",".btn-dialog-21-2-03",function(){
		openLayer("layer3","21_2_03");
	});
	$("body").on("click",".btn-dialog-21-2-10",function(){
		openLayer("layer3","21_2_10");
	});
	$("body").on("click",".btn-dialog-21-4-13",function(){
		openLayer("layer3","21_4_13");
	});
	////////////////////////////////////////////////////////////////////
	
	
	////////////////////////* pop *///////////////////////////////////
	$("body").on("click",".btn-order-confirm",function(){
		openLayer("layer4","30_04","?odr_idx="+$("#odr_idx").val());
	});
	$("body").on("click",".btn-pop-3012",function(){
		openLayer("layer4","30_12");
	});	
	$("body").on("click",".btn-pop-3013",function(){
		openLayer("layer4","30_13");
	});
	$("body").on("click",".btn-pop-3018",function(){
		openLayer("layer4","30_18");
	});
	$("body").on("click",".btn-pop-18R18",function(){
		openLayer("layer4","18R_18");
	});
	$("body").on("click",".btn-pop-18R20",function(){
		openLayer("layer4","18R_20");
	});
	$("body").on("click",".btn-pop-18R04",function(){
		openLayer("layer4","18R_04");
	});
	$("body").on("click",".btn-pop-18-1-08",function(){
		openLayer("layer4","18_1_08");
	});
	$("body").on("click",".btn-pop-18-2-08",function(){
		openLayer("layer4","18_2_08");
	});
	$("body").on("click",".btn-pop-18-2-11",function(){
		openLayer("layer4","18_2_11");
	});
	$("body").on("click",".btn-pop-3103",function(){
		openLayer("layer4","31_03");
	});
	$("body").on("click",".btn-pop-0201",function(){
		openLayer("layer4","02_01");
	});
	$("body").on("click",".btn-pop-0119",function(){
		openLayer("layer4","01_19");
	});
	$("body").on("click",".btn-pop-0135",function(){
		openLayer("layer4","01_35");
	});
	$("body").on("click",".btn-pop-0601",function(){
		openLayer("layer4","06_01");
	});
	$("body").on("click",".btn-pop-0701",function(){
		openLayer("layer4","07_01");
	});
	$("body").on("click",".btn-pop-1003",function(){
		openLayer("layer4","10_03");
	});
	$("body").on("click",".btn-pop-1301",function(){
		openLayer("layer4","13_01");
	});
	$("body").on("click",".btn-pop-1303",function(){
		openLayer("layer4","13_03");
	});
	$("body").on("click",".btn-pop-1305",function(){
		openLayer("layer4","13_05");
	});
	$("body").on("click",".btn-pop-1218",function(){
		openLayer("layer4","12_18");
	});
	$("body").on("click",".btn-pop-1504",function(){
		openLayer("layer4","15_04");
	});
	$("body").on("click",".btn-pop-1706",function(){
		openLayer("layer4","17_06");
	});
	$("body").on("click",".btn-pop-1904",function(){
		openLayer("layer4","19_04");
	});
	$("body").on("click",".btn-pop-1916",function(){
		openLayer("layer4","19_16");
	});
	$("body").on("click",".btn-pop-2001",function(){
		openLayer("layer4","20_01");
	});
	$("body").on("click",".btn-pop-2102",function(){
		openLayer("layer4","21_02");
	});
	$("body").on("click",".btn-pop-2103",function(){
		openLayer("layer4","21_03");
	});
	$("body").on("click",".btn-pop-2113",function(){
		openLayer("layer4","21_13");
	});
	$("body").on("click",".btn-pop-2115",function(){
		openLayer("layer4","21_15");
	});
	$("body").on("click",".btn-pop-21-1-15",function(){
		openLayer("layer4","21_1_15");
	});
	$("body").on("click",".btn-pop-21-4-14",function(){
		openLayer("layer4","21_4_14");
	});
	$("body").on("click",".btn-pop-21-5-05",function(){
		openLayer("layer4","21_5_05");
	});
	$("body").on("click",".btn-pop-21-6-02",function(){
		openLayer("layer4","21_6_02");
	});
	$("body").on("click",".btn-pop-21-7-01",function(){
		openLayer("layer4","21_7_01");
	});
	$("body").on("click",".btn-pop-1508",function(){
		openLayer("layer4","15_08");
	});
	$("body").on("click",".btn-pop-1509",function(){
		openLayer("layer4","15_09");
	});
	$("body").on("click",".btn-pop-2376",function(){
		openLayer("layer4","23_76");
	});
	////////////////////////////////////////////////////////////////////
	
	
	
	
});