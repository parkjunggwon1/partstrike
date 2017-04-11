function indexpage() {location.href = "/main/main.php";}
function toppage() {location.href = "#";}


function login() {location.href = "/member/login.php";}

function chkLogin(){
	if (mem_idx =="")
	{
		alert_msg("로그인 후 이용하여 주시기 바랍니다.");
		return false;
	}else{
		return true;
	}
}

function alert_msg(msg){
	openCommLayer("layer6","alert","?alert_msg="+encodeURIComponent(msg));
}

//-- 메시지창(타이틀, 메세지, 버튼이미지) 모든 레이어 닫고 페이지 새로고침
function alert_msg2(title,msg,btn){
	openCommLayer("layer6","alert2","?btn="+btn+"&alert_title="+encodeURIComponent(title)+"&alert_msg="+encodeURIComponent(msg));
}
//-- 삭제 메시지창(타이틀, 메세지, 버튼이미지)
function alert_del(title,msg,btn){
	openCommLayer("layer6","alert_del","?btn="+btn+"&alert_title="+encodeURIComponent(title)+"&alert_msg="+encodeURIComponent(msg));
}

//-- 삭제 메시지창(타이틀, 메세지, 버튼이미지, 추가 파라메터가 있는 경우)
//   예) /kor/include/turnkey.php에서 턴키 삭제시 사용
function alert_del_extra(title,msg,btn,extra){
	openCommLayer("layer6","alert_del_extra","?btn="+btn+"&alert_title="+encodeURIComponent(title)+"&alert_msg="+encodeURIComponent(msg)+"&extra="+extra);
}

function alert3(title,msg,btn,btncss,close_yn){
	openCommLayer("layer6","alert3","?btn="+btn+"&btncss="+btncss+"&close_yn="+close_yn+"&alert_title="+encodeURIComponent(title)+"&alert_msg="+encodeURIComponent(msg));
}


var aryMenu = new Array(2);
function setMenu(topno, subno){
	if (topno=="" && subno =="")
	{
		topno = aryMenu[0];
		subno = aryMenu[1];
	}
	if (topno!="" && subno!="")
	{
		$(".gnb-wrap li").removeClass("active");
		$(".gnb2 li a").removeClass("chk");
		$(".gnb-wrap li.m"+topno).addClass("active").find("a img").attr("src","/kor/images/top_menu0"+topno+"_on.png");
		$(".gnb-wrap li.m"+topno+" .gnb2 li:eq("+(subno-1)+") a").addClass("chk");
		aryMenu[0] = topno;
		aryMenu[1] = subno;
		$(".box-type9").prev().remove().end().remove();

	}
}

function setMenuNull(){
	topno = aryMenu[0];
	if (topno!="")
	{
		$(".gnb-wrap li.m"+topno).find("a img").attr("src","/kor/images/top_menu0"+topno+".png");
	}
	$(".gnb-wrap li").removeClass("active");
	$(".gnb2 li a").removeClass("chk");
	aryMenu[0] = "";
	aryMenu[1] = "";
}

function joinus() {
	$("#partsContent").find(":not(.col-left,.col-right)").remove();
	showajax(".col-left", "terms");
//	showajax(".col-left", "joinus");

//	showajax(".col-left", "joinus2");
//	showajaxParam("#joinForm2", "mem", "rel_idx="+$("#rel_idx").val()+"&mem_type="+$("#mem_type").val());
//	showajaxParam("#f2 section", "impship", "rel_idx="+$("#rel_idx").val());
//	showajaxParam("#f3 section", "agency", "rel_idx="+$("#rel_idx").val());

	showajax(".col-right", "side");
}
//--- 오른쪽 section id="orderDraft" 새로고침(전체 새로고침 없이) 2016-03-30
function Refresh_Right(){
	$.ajax({
		url:"/kor/include/aj_side_order.php",
		success: function (data) {
			$("#orderDraft").html(data);
		}
	});
}
//--- 배송지변경 -> 저장 ---------------------------------------------------------------
function delivery_save(){
			var f = document.f;
			var load_page = $("#delv_load").val();
			var odr_idx= $("#odr_idx_"+load_page).val();
			var formData = $("#f_"+load_page).serialize(); 
			$.ajax({
					url: "/kor/proc/odr_proc.php", //typ=delivery_save
					data: formData,
					encType:"multipart/form-data",
					success: function (data) {
						//class.odrinfo.php : GET_CHG_ODR_DELIVERY_ADDR 호출
						$.ajax({ 
						type: "GET", 
						url: "/ajax/proc_ajax.php", 
						data: { actty : "GDA", //get Delivery addr
								actidx : trim(data),
								loadpage : load_page,
								odr_idx : odr_idx,
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



function editmyinfo(rel_idx) {	
	deleteCookie('menu');
	if (rel_idx =="")
	{
		alert_msg("로그인 후 이용하여 주시기 바랍니다.");
	}else if(rel_idx > 0){
		alert_msg("회사 관리자로 로그인 하여 사용할 수 있는 기능입니다. ");
	}else{
		//showajaxParam(".col-left", "joinus" , "typ=edit");
		showajax(".col-left", "askpasswd");
		setMenu(5, 1);
		//-->showajax(".col-right", "side_order");
	}
}

//저장된 배송지 불러오기
function delivery_load(idx,loadpage,odr_idx){
	$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php", 
		data: { actty : "GDA", //get Delivery addr
				actidx : idx,
				loadpage : loadpage,
				odr_idx : odr_idx,
		},
			dataType : "html" ,
			async : false ,
			success: function(data){ 		
				$(".company-info-wrap").html(data);
				checkActive();
			}
		});
}

function partreg(part) {	
	deleteCookie('menu');
	if (mem_idx =="")
	{
		alert_msg("로그인 후 이용하여 주시기 바랍니다.");
	}else{
		if (part ==""){part = "1";}
		showajaxParam(".col-left", "part", "part_type="+part);
		showajaxParam("#f3 #partlist", "partlist", "page=1&part_type="+part);
		showajaxParam(".col-right", "side_stock", "mode="+part);
		$(".gnb2 a").removeClass("chk");
		$(".gnb2 a:eq("+(part-1)+")").addClass("chk");
		setMenu(3, part);
	}
}

function right_order(){
	showajax(".col-right", "side_order");
}
function right_side(){
	showajax(".col-right", mem_idx==""?"side":"side_order");
	$(".box-type9").hide();					
}


function agreement() {	
	deleteCookie('menu');
	showajax(".col-left", "terms");
	//showajax(".col-left", "agreement");
//	showajax(".col-right", mem_idx==""?"side":"side_order");
	setMenu(6, 2);
}

function guide() {	
	deleteCookie('menu');
	showajax(".col-left", "guide");
//	showajax(".col-right", mem_idx==""?"side":"side_order");
	setMenu(6, 3);
}

function memfee(){
	deleteCookie('menu');
	if (mem_idx =="")
	{
		alert_msg("로그인 후 이용하여 주시기 바랍니다.");
	}else{
		showajax(".col-left", "memfee");
		showajaxParam("#memfeeleftTop", "memfee1", "");
		showajaxParam("#memfeeleftBottom", "memfee2", "");
		//-->showajax(".col-right", "side_order");
		setMenu(6, 4);
	}
}

function board(mode) {	
	deleteCookie('menu');
	if (mode!="AA001" &&mem_idx =="")
	{
		alert_msg("로그인 후 이용하여 주시기 바랍니다.");
	}else{
		showajax(".col-left", "board");
		showajaxParam("#boardleftTop", "boardlist", "page=1&wantcnt=20&mode="+mode);
		
		switch(mode){
			case("AA001"):
		//		showajax(".col-right", mem_idx==""?"side":"side_order");
				setMenu(6, 1);
			break;
			case("AA002"):
			//-->	showajax(".col-right", mem_idx==""?"side":"side_order");
				setMenu(5, 4);
			break; 
			case("AA003"):
			//-->	showajax(".col-right", mem_idx==""?"side":"side_order");
				setMenu(5, 5);
			break; 
		} 
	}	
}
function boardview(mode,idx,main) {	
	showajax(".col-left", "board");
	showajaxParam("#boardleftTop", "boardlist", "page=1&wantcnt=20&mode="+mode);
	showajaxParam(".col-right", "side_board", "board_idx="+idx+"&main="+main);
	$(".board-list a[board_idx="+idx+"]").addClass("c-blue");
}
function blacklist(){
	showajaxParam(".col-right", "side_black_list", "");
}
function mybox(){
	showajax(".col-left", "mybox");
	//-->showajax(".col-right", "side_order");
	setMenu(1, 3);
}

function remit(ty){
	setCookie("menu","remit");
	showajaxParam(".col-left", "remit", "rel_idx="+ty);
	//-->showajax(".col-right", "side_order");
	setMenu(2, 3);
}
function agent(){
	deleteCookie('menu');
	showajax(".col-left", "agent");
	//showajax(".col-right", mem_idx==""?"side":"side_order");
	setMenu(5, 2);
}

function agentview(idx,nat,strsearch) {	
	//showajaxParam(".col-left", "agent", "strsearch="+strsearch);
	showajaxParam(".col-right", "side_agency_info", "idx="+idx+"&nat="+nat+"&strsearch="+strsearch);
}

function lab(){
	deleteCookie('menu');
	showajax(".col-left", "lab");
//	showajax(".col-right", mem_idx==""?"side":"side_order");
	setMenu(5, 3);
}
function contact(){
	deleteCookie('menu');
	showajax(".col-left", "contact");	
//	showajax(".col-right", mem_idx==""?"side":"side_order");
	setMenu(6, 5);
}

function order(odr_type){
	showajaxParam(".col-left", "order", "odr_type="+odr_type);
	//-->showajax(".col-right", "side_order");
	setMenu(1, odr_type=="S"?"1":"2");
}

function companyback(rel_idx){
	//showajaxParam(".col-left", "record", "odr_type=S");
	//setMenu(2,1);
	//
//	showajax(".col-right", "side_order");
}

function record(odr_type){
		
	setCookie("menu","record_" +odr_type);	

	showajaxParam(".col-left", "record", "odr_type="+odr_type);
	//-->showajax(".col-right", "side_order");
	setMenu(2, odr_type=="S"?"1":"2");
}

function side_company_info(rel_idx){
	showajaxParam(".col-right", "side_company_info", "rel_idx="+rel_idx);
	
}

function side_company_info2(rel_idx,mode){
	showajaxParam(".col-right", "side_company_info", "rel_idx="+rel_idx+"&mode="+mode);
	
}

function main_company_det(rel_idx, fr){
	var $slt =$("#gnb li[class^=m].active");
	var topno = $("#gnb li[class^=m]").index($slt)+1;
	var subno = $slt.find(".gnb2 a").index($slt.find(".chk"))+1;	
	$("#HidGnb").html(topno+":"+subno);
	$("#HidLeft").html(encodeURIComponent($(".col-left").html()));
	setMenuNull();
	showajaxParam("#partsContent", "main_company_det", "rel_idx="+rel_idx+"&mem_type="+fr);
}

function frReturn(rel_idx,fr){
	var cont = $("#HidGnb").html().split(":");
	setMenu(cont[0],cont[1]);

	if ((cont[0]=="1" && cont[1] =="1") || (cont[0]=="1" && cont[1] =="2"))
	{
		order(fr);
	}else{
		$(".col-left").html(decodeURIComponent($("#HidLeft").html()));
	}
	
	$("#HidGnb").html("");
	$("#HidLeft").html("");
	side_company_info2(rel_idx,fr);	
}

function layer_company_det(rel_idx){
	openCommLayer("layer7","company_info_layer","?rel_idx="+rel_idx);
//	openCommLayer("layer","31_04",'?mn=0'+splData[0]+'&status='+splData[0]+'&page=1&validyn='+splData[3]);
}

function turnkeyreg() {	
	deleteCookie('menu');
	if (mem_idx =="")
	{
		alert_msg("로그인 후 이용하여 주시기 바랍니다.");
	}else{
		showajax(".col-left", "turnkey");
		showajaxParam("#turnkeyManageTop", "turnkeyedit", "page=1");
		showajaxParam("#stockManage", "turnkeylist", "page=1");
		showajaxParam(".col-right", "side_stock", "mode=turnkey");
		setMenu(4, 1);
	}
}

function joinusform(){
	showajax(".col-left", "joinus");
}

function ready(){
	var select = $("select");
	select.change(function(){
		var select_name = $(this).children("option:selected").text();
		$(this).siblings("label").text(select_name);
	});

	$('.onlynum').css("ime-mode","disabled").keydown(function(event){ 		//숫자만 입력하게.(.도 포함) 		
	  if (event.which && (event.which == 190 || event.which == 110 || event.which > 45 && event.which < 58 || event.which == 8 || event.which > 95 && event.which < 106)) {			
	   } else { 
	   event.preventDefault(); 
	  } 
	 });
		 
	 $('.numfmt').css("ime-mode","disabled").keyup( function(event){   // 숫자 입력 하면 ,로 단위 끊어 표시하게.
			check_value(this);
	 });	
}

function onlyNumber(event){
	event = event || window.event;
	var keyID = (event.which) ? event.which : event.keyCode;
	
	if ( (keyID >= 48 && keyID <= 57) || (keyID >= 96 && keyID <= 105) || keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39 || keyID == 110 || keyID == 190 ) 
		return;
	else
		return false;
}
function removeChar(event) {
	event = event || window.event;
	var keyID = (event.which) ? event.which : event.keyCode;		

	if ( keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39 || keyID == 110 || keyID == 190 ) 

		return;
	else

		event.target.value = event.target.value.replace(/[^(0-9)|\$|\,|\.]/gi, '');
}

function removeChar2(event) {
	event = event || window.event;
	var keyID = (event.which) ? event.which : event.keyCode;		

	if ( keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39 || keyID == 10 || keyID == 190 ) 

		return;
	else

		event.target.value = event.target.value.replace(/[\ㄱ-ㅎㅏ-ㅣ가-힣]/g, '');
}

function saveExtraInfo(formNm, ProcUrl){
		var formData = $("#"+formNm).serialize(); 
		$.ajax({
				url: ProcUrl, 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {	

				}
		});		
}

function procReady(idx){  //처리 해야 할 일이 있으면 해당 팝업으로 자동으로 연결
	$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php", 
		data: { actty : "PR",
				actidx : idx
		},
			dataType : "html" ,
			async : false ,
			success: function(data){ 
				if (trim(data))
				{  
					goMenuJump(data);
				}
			}
		});
}

function goMenuJump(data){
//2번째 파라메터 splData[1] : sellmem_idx
// splData[0] : status splData[1] : sellmem_idx splData[2] : (odr or fty ) splData[3] : validyn (72시간 적용), splData[4] : paging
	var splData = data.split(":");		
	var page="1";
	var get_cookie = getCookie('menu');

	if (splData[5] !="M" && splData[6])
	{
		var menu_chk = splData[5];
		var menu_type = splData[6];

		setCookie("menu",menu_type + "_" +menu_chk);
	}	
	else
	{
		if (get_cookie=="remit" || get_cookie=="record_S" || get_cookie=="record_B")
		{

		}
		else
		{
			setCookie("menu","side_order");
		}
		
	}
	

	if(typeof(splData[4])!="undefined"){
		page=splData[4];
	}
	switch(trim(splData[0])){
	case("1"): //납기  (판매자 탭)
		openCommLayer("layer","31_04",'?mn=0'+splData[0]+'&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
	break;
	case("3"): //수정발주서  (판매자만 보이는 탭)
		openCommLayer("layer","09_03",'?mn=0'+splData[0]+'&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
	break;
	case("11"): //반품선적완료 (판매자 탭- Black Ver)
		openCommLayer('layer','18R_19','?mn='+splData[0]+'&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
	break; 
	case("25"): //반품선적완료(판매자 탭- Red Ver)
		openCommLayer("layer","21_1_09",'?mn=14&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
	break; 
	case("16"): //납기확인  (구매자 탭)
		openCommLayer("layer","31_06",'?mn=01&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
	break;
	case("24"): //환불  (구매자만 보이는 탭)
		openCommLayer("layer","19_1_06",'?mn=16&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
	break;
	
	case("2"): //발주서 
		openCommLayer('layer','30_06','?mn=0'+splData[0]+'&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
	break; 
	case("5"): //결제완료 
		if (trim(splData[1])==mem_idx)    
		{
			openCommLayer("layer","30_15","?mn=05"+'&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}else{
			openCommLayer("layer","30_14","?mn=07"+'&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}
	break; 
	case("27"): //결제완료F
		if (trim(splData[1])==mem_idx)   
		{
			openCommLayer("layer","21_3_10","?mn=16"+'&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}else{
			openCommLayer("layer","21_1_14","?mn=21"+'&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}
	break; 
	case("28"): //수령F
		if (trim(splData[1])==mem_idx)   
		{
			openCommLayer("layer","21_4_10","?mn=18"+'&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}else{
			openCommLayer("layer","21_5_12","?mn=24"+'&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}
	break; 
	case("4"): //납기연장확인 
		if (trim(splData[1])==mem_idx)    
		{
			openCommLayer("layer","10_04",'?mn=04&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}else{
			openCommLayer("layer","10_02",'?mn=06&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}
	break; 
	case("7"): //삭제의 경우 ( 구매자, 판매자 둘다 취소 통보 가능 .분기를 해주어야 함.)
		if (trim(splData[1])==mem_idx)    
		{
			openCommLayer("layer","03_02",'?mn=07&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}else{
			openCommLayer("layer","02_02",'?mn=09&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}
	break; 
	case("8"): //취소의 경우 ( 구매자, 판매자 둘다 취소 통보 가능 .분기를 해주어야 함.)
		if (trim(splData[1])==mem_idx)    
		{
			openCommLayer("layer","13_02",'?mn=08&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}else{
			openCommLayer("layer","13_04",'?mn=10&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}
	break; 
	case("9"): //거절도 구매자,판매자 둘다 가능하므로
		if (trim(splData[1])==mem_idx)    
		{
			openCommLayer('layer','18R_06','?mn=09&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}else{
			openCommLayer('layer','18R_08','?mn=11&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}
	break; 
	case("10"): //수량부족도 구매자,판매자 둘다 가능하므로
		if (trim(splData[1])==mem_idx)    
		{
			openCommLayer('layer','19_06','?mn=10&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}else{
			openCommLayer('layer','19_08','?mn=12&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}
	break; 
	case("12"): //불량통보도 구매자,판매자 둘다 가능
		if (trim(splData[1])==mem_idx)    
		{
			openCommLayer('layer','21_05','?mn=12&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}else{
			openCommLayer('layer','21_07','?mn=17&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}
	break; 
	case("13"): //동의서도 구매자,판매자 둘다 가능
		if (trim(splData[1])==mem_idx)    
		{
			openCommLayer('layer','21_1_04','?mn=13&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}else{
			openCommLayer('layer','21_1_02','?mn=18&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}
	break;
	case("14"): //결과 공지
		if (trim(splData[1])==mem_idx)    
		{
			openCommLayer('layer','21_4_11','?mn=17&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}else{
			openCommLayer('layer','21_5_13','?mn=22&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}
	break;					
	case("15"): //종료도 구매자/판매자 둘다 가능
		if (trim(splData[1])==mem_idx)    
		{
			openCommLayer('layer','21_14','?mn=19&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}else{
			openCommLayer('layer','21_16','?mn=25&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}
	break;

	case("30"): //종료F도 구매자/판매자 둘다 가능
		if (trim(splData[1])==mem_idx)    
		{
			openCommLayer('layer','21_14','?mn=19&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}else{
			openCommLayer('layer','21_16','?mn=25&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}
	break;

	case("26"): //거절F도 구매자/판매자 둘다 가능
		if (trim(splData[1])==mem_idx)    
		{
			openCommLayer('layer','21_7_02','?mn=15&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}else{
			openCommLayer('layer','21_6_03','?mn=20&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}
	break;
	
	case("18"): //송장 (구매자 탭)
		openCommLayer("layer","30_10","?mn=03&status="+splData[0]+'&page='+page);
	break; 
	case("19"): //도착 (구매자 탭)
		openCommLayer("layer","01_37","?mn=04&status="+splData[0]+'&page='+page);
	break; 
	case("21"): //선적완료(구매자 탭)
		openCommLayer("layer","30_20","?mn=08&status="+splData[0]+'&page='+page);
	break; 
	case("22"): //반품방법(구매자 탭)
		openCommLayer("layer","18R_16",'?mn=13&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
	break; 
	case("23"): //추가 선적완료(구매자 탭)
		openCommLayer("layer","19_21","?mn=14&status="+splData[0]);
	break; 
	case("29"): //반품방법F (구매자 탭)
			openCommLayer('layer','21_1_07','?mn=23&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
	break;
	case("20"): //지연 (구매자 탭)
		openCommLayer("layer","08_02",'?mn=05&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
	break; 
	case("6"): //수령(판매자 탭/구매자 탭)
		if (trim(splData[1])==mem_idx)    
		{
			openCommLayer("layer","30_22",'?mn=0'+splData[0]+'&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}else{
			openCommLayer("layer","30_23",'?mn=15&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		}
		
	break; 
	case("9"): //거절(구매자탭)
		openCommLayer('layer','18R_06','?mn=0'+splData[0]+'&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
	break; 
	case("32"): //수락(구매자 탭)
		openCommLayer("layer","1304_accept",'?mn=32&status='+splData[0]+'&page='+page+'&validyn='+splData[3]);
		
	break; 
	default:					
	break;
	} 
}

function showajax (target , gubun){
	$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php", 
		data: { actty : gubun
		},
			dataType : "html" ,
			async : false ,
			success: function(data){ 
				$(target).empty();
				$(target).append($(data).fadeIn(300));
				ready();
			}
		});

}
function showajaxParam(target,gubun, param){
	$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php?"+param, 
		data: { actty : gubun
		},
			dataType : "html" ,
			async : false ,
			success: function(data){ 
				$(target).empty();
				$(target).append($(data).fadeIn(300));
				ready();
			}
		});

}

function showPage(target, gubun){
	$page = $("."+target);
	$page.load(gubun);
}

function openCommLayer(layerNum,loadPage,varNum){
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
		$(".layer5-section .btn-close img").css("display","block");
		$layer.css("z-index","999");
		$("body").addClass("open-layer");
		!varNum? $var = "" : $var = varNum;
		if (loadPage =="alert2")
		{			
			$layer.find(">.layer-wrap").load("/kor/layer/"+loadPage+".php", {
				btn:"btn_transmit",
				alert_title:"선적",
				alert_msg:"선적이 완료되었습니다.",
				typ: $("#typ").val(), 
				weight_yn: $("#weight_yn").val(),
				status: $("#status").val(), 
				status_name: $("#status_name").val(),
				fault_yn: $("#fault_yn").val(), 
				fault_method: $("#fault_method").val(),
				sell_mem_idx: $("#sell_mem_idx").val(), 
				buy_mem_idx: $("#buy_mem_idx").val(),
				odr_idx: $("#odr_idx_30_16").val(), 
				odr_history_idx: $("#odr_history_idx").val(),
				no: $("#no").val(), 
				det_cnt: $("#det_cnt").val(),
				load_page: $("#load_page").val(), 
				ship_info: $("#ship_info").val(),
				delivery_no: $("#delivery_no").val(), 
				part_condition: $("#part_condition").val(),
				pack_condition1: $("#pack_condition1").val(),
				pack_condition2: $("#pack_condition2").val(),
				memo: $("#memo").val(),
				delivery_shop: $("#delivery_shop").val()
		   });
		}
		else if (loadPage =="alert_pay_ok")
		{			
			$layer.find(">.layer-wrap").load("/kor/layer/"+loadPage+".php", {
				alert_msg:"결제가 완료되었습니다.",
				typ: $("#typ").val(), 
				memfee_id: $("#memfee_id").val(),
				mem_idx: $("#mem_idx").val(), 
				rel_idx: $("#rel_idx").val(),
				tot_amt: $("#tot_amt").val(), 
				sell_mem_idx: $("#sell_mem_idx").val(), 
				sell_rel_idx: $("#sell_rel_idx").val(),
				odr_idx: $("#odr_idx").val(), 
				odr_det_idx: $("#odr_det_idx").val(),
				charge_method: $("#charge_method").val()				
	
		   });
		}
		else
		{
			$layer.find(">.layer-wrap").load("/kor/layer/"+loadPage+".php"+$var);
		}
		
	}
function closeCommLayer(layerNum){
	$layer = $("."+layerNum+"-section");
	//$layer.html("");
	$layer.removeClass("open");
	$("body").removeClass("open-layer");
}

function joinus02() {location.href = "/member/join02.php";}
function review_write(idx) {location.href = "/search/review_write.php?idx="+idx;}
function fac_write(idx) {location.href = "/search/fac_write.php?idx="+idx;}
function qna_write(idx) {location.href = "/customer/qna_write.php?bd_idx="+idx;}
function qna() {location.href = "/customer/qna.php";}
function search_subway() {location.href = "/search/search_subway_result.php";}
function search_gu(a1,a2) {location.href = "/search/search_result.php?a1="+a1+"&a2="+a2;}
function search_area(a1,a2,a3) {location.href = "/search/search_result.php?a1="+a1+"&a2="+a2+"&a3="+a3;}
function search_area_map(a1,a2,a4) {location.href = "/search/search_result.php?a1="+a1+"&a2="+a2+"&a4="+a4;}
function modify(){location.href = "/member/modify.php";}
function idsearch(){location.href = "/member/idsearch.php";}
function search_view(idx){location.href = "/search/search_area_view.php?idx="+idx;}
//////////// members
function mem_login() {location.href = "/member/login.php";}
function mem_logout() {proc.location.href = "/kor/proc/logout.php";}

function email_pop() {window.open("../member/email_pop.php","","width=490,height=330")} 
function pay_pop(form) {
  var win_options = " width=1000 height=753 top=150 left=400 scrollbars=yes";   
  window.open("about:blank","Win",win_options);
  form.action="/paypal/paypopup.php";
  form.target = "Win" ;
  form.submit();
}

function setCookie(cookieName, value, exdays){
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var cookieValue = escape(value) + ((exdays==null) ? "" : "; expires=" + exdate.toGMTString());
    document.cookie = cookieName + "=" + cookieValue;
}

function getCookie(cookieName) {
    cookieName = cookieName + '=';
    var cookieData = document.cookie;
    var start = cookieData.indexOf(cookieName);
    var cookieValue = '';
    if(start != -1){
        start += cookieName.length;
        var end = cookieData.indexOf(';', start);
        if(end == -1)end = cookieData.length;
        cookieValue = cookieData.substring(start, end);
    }
    return unescape(cookieValue);
}
function deleteCookie(cookieName){
    var expireDate = new Date();
    expireDate.setDate(expireDate.getDate() - 1);
    document.cookie = cookieName + "= " + "; expires=" + expireDate.toGMTString();
}