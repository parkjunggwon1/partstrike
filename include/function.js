//공백 체크=========================================================
function trim(str){
  return str.replace(/(^\s+)|(\s+)$/,"");
}

//엔터키실행 onkeypress==============================================
function check_key(what){
	if(window.event.keyCode==13){			
		what();
		return;
	}
}

function check_search(){
	var f = document.searchfrm;
	f.page.value = 1;
	
	f.submit();
}
function setVal(val){
		document.searchfrm.strsearch.value=val;
	}
//이미지 팝업====================================================
function img_popup(imgi,pathfile){
	var img = new Image();
	img.src = document.getElementById(imgi).src;

	var height=parseInt(img.height)+10;
	var width=parseInt(img.width)+20;
	win_open('/img_popup.php?pathfile='+pathfile, imgi, width, height, '0', '0', 'yes', '1')
}
//아이프레임 리사이징================================================
function resizeHeight(FrameName) {
    if(document.all) {
		 var body_height = frames[FrameName].document.body.scrollHeight;
	} else {
		 var body_height= document.getElementById(FrameName).contentWindow.document.body.offsetHeight;
	}
	
	// 자료가 없을경우 레이어를 보이지 안케하기위해
	if(body_height != 0){ // 자료가 없을대에 높이를 지정해주세요
		document.getElementById(FrameName).style.height=body_height + "px";
	}else{
		document.getElementById(FrameName).style.height=400 + "px";
	}
}

//팝업================================================
function win_pop(page_name,width,height,name,scroll){
	var opt="menubar=no,toolbar=no,resizable=no,location=no,status=no,scrollbars="+scroll+",width="+width+",height="+height;
	var page=page_name;
	var win=open(page,name, opt);
}

//새창
//url : 열릴 url, win_name : 창이름, width : 가로크기, height : 세로크기,
//top : 상하위치, left : 좌우위치, scroll 스크롤유무, center : 새창 가운데 뜨게
//center true 일 경우 top, left 무시
//예시 : <a href="/html/01_fcs/" onclick="win_open(this.href, '', '800', '700', '', '', '1', '1');return false;">
// '/html/01_fcs/' 를 새창에서 가로 800, 세로 700, 가운데로 띄움
function win_open(url, win_name, width, height, top, left, scroll, center){
	if(top)	{
		p_top=top;
	}	else	{
		p_top=0;
	}
	if(left)	{
		p_left=left;
	}	else	{
		p_left=0;
	}
	if(center)	{
		p_top=(screen.height - height) / 2;
		p_left=(screen.width - width) / 2;
	}

	win=window.open(url, win_name, "width="+width+", height="+height+", top="+p_top+", left="+p_left+", scrollbars="+scroll);
	win.window.focus();
}

//이메일체크================================================
function validEmail(strEmail){
	var pattern = /^[_a-zA-Z0-9-\.]+@[\.a-zA-Z0-9-]+\.[a-zA-Z]+$/;
	return pattern.test(strEmail);
}

//아이디체크================================================
function validId(strId,min,max){
	var pattern = eval("/^[a-zA-Z0-9]{"+min+","+max+"}$/");
	return pattern.test(strId);
}

//비밀번호체크================================================
function validPassWord(strPassWord,min,max){
	var pattern = eval("/^[a-zA-Z0-9]{"+min+","+max+"}$/");
	return pattern.test(strPassWord);
}

//비밀번호체크================================================
function valid(strPassWord,min,max){
	var pattern = eval("/.{"+min+","+max+"}$/");
	return pattern.test(strPassWord);
}
//비밀번호체크================================================
function nullchk(obj,msg){
	if (trim(obj.value)==""){
		alert_msg(msg);
		obj.focus();
		return false;
	}

}
//비밀번호체크================================================
function nullchk_admin(obj,msg){
	if (trim(obj.value)==""){
		alert(msg);
		obj.focus();
		return false;
	}

}


//비밀번호체크================================================
function nullchkleng(obj,msg,min,max){
	if (trim(obj.value)=="" || trim(obj.value).length<min || trim(obj.value).length>max){
		alert(msg);
		obj.focus();
		return false;
	}

}

function nullchecked(obj,msg){
	var that = 0;
	for(var i=0;i<obj.length;i++){
		if (obj[i].checked==true){
			that = 1;
			break;
		}
	}
	if (that!=1){		
		obj[0].focus();
		return false;	
	}
}

//수량체크================================================
function isNumeric(s) 
{
	for (i=0; i<s.length; i++) {
		c = s.substr(i, 1);
		if (c < "0" || c > "9") return false;
	}
	return true;
}

function isNum(numchar)
{
	len = numchar.value.length ;
	ch = numchar.value.charAt(len - 1) ;
	if ( ( ch < '0' ) || ( ch > '9') )
	{
		str = numchar.value ;
		for ( i = 0 ; i < len ; i ++ ){
			numchar.value = str.substr(0, len - 1) ;
		}
	}
}

//?================================================
function isKorean(obj) { 
    //var len = obj.value.length; 
    var len = obj.length; 
    var numUnicode; 

    for(i=0;i < len; i++)
    { 
        //numUnicode = obj.value.charCodeAt(i) 
        numUnicode = obj.charCodeAt(i) 
        if ( 44032 <= numUnicode && numUnicode <= 55203 ) 
        { 
            continue; 
        }else{ 
            return false; 
            break; 
        } 
    } 

    return true; 
} 

//전체체크================================================
function alldel_chk(bool){			
	var obj = document.getElementsByName("delchk[]");
	if (bool=="")
	{
		bool = (obj[0].checked==true)?false:true;
	}
	for (var i=0; i<obj.length; i++) {
		obj[i].checked = bool;
		if (bool==true)
			obj[i].className = "checked";
		else
			obj[i].className= "";
	}
}







//플래쉬영상 추가'20120513================================================
function objflash(URL,wid,hei,mode,LT,scale)
{
document.write("<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0' width='"+wid+"' height='"+hei+"'>");
document.write("<param name='movie' value='"+URL+"'>");
document.write("<param name='quality' value='high'>");
document.write("<param name='wmode' value='"+mode+"'>");
document.write("<param name='salign' value='"+LT+"'>");
document.write("<param name='scale' value='" + scale + "'>");
document.write("<embed src='"+URL+"' width='"+wid+"' height='"+hei+"' quality='high' wmode='"+mode+"' scale='"+scale+"' salign='"+LT+"' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash'></embed>");
document.write("</object>");
}


function objflash2(URL,wid,hei,mode,LT,scale,Fid)
{
document.write("<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0' width='"+wid+"' height='"+hei+"' id='"+Fid+"'>");
document.write("<param name='movie' value='"+URL+"'>");
document.write("<param name='quality' value='high'>");
document.write("<param name='WMODE' value='"+mode+"'>");
document.write("<param name='salign' value='"+LT+"'>");
document.write("<param name='scale' value='" + scale + "'>");
document.write("<embed id='"+Fid+"' src='"+URL+"' width='"+wid+"' height='"+hei+"' quality='high' wmode='"+mode+"' scale='"+scale+"' salign='"+LT+"' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash'></embed>");
document.write("</object>");
}

//엑셀다운로드
function down_excel(url){
	if (!confirm("엑셀 파일로 다운로드 하시겠습니까?")) return;
	var f = document.excel_down;
	f.action=url+".asp";
	f.submit();
}


function gogo(idx){
	location.href=document.getElementById("go_"+idx).href;
}

//날짜검색=========================================================================================
function setSearchDate(num){
	var now = new Date();
	var enddate = now.getFullYear()+'-'+fncLPAD((now.getMonth()+1))+'-'+fncLPAD(now.getDate());
	var startdate
	now.setDate(now.getDate() - num);
	startdate = now.getFullYear()+'-'+fncLPAD((now.getMonth()+1))+'-'+fncLPAD(now.getDate())
	document.searchfrm.startdate.value=startdate;
	document.searchfrm.enddate.value=enddate;
}
function setSearchDate2(value1,value2,num){
	var now = new Date();
	var enddate = now.getFullYear()+'-'+fncLPAD((now.getMonth()+1))+'-'+fncLPAD(now.getDate());
	var startdate
	now.setDate(now.getDate() - num);
	startdate = now.getFullYear()+'-'+fncLPAD((now.getMonth()+1))+'-'+fncLPAD(now.getDate())
	document.getElementById(value1).value=startdate;
	document.getElementById(value2).value=enddate;
}
function fncLPAD(num){
	if(num<10) return '0'+num;
	else return ''+num;
}
//날짜검색=========================================================================================

//sns 메쉬업
function goSNS(sns){
	var f = document.snsf;
	
	f.sns.value = sns;
	f.target = "proc";
	f.action = "/oAuth/sns.asp";
	f.submit();
}


//sns 로그아웃
function snslogin(part){
	pageurl = "/oAuth/"+part+"/login.asp";
	if (part=="mariana"){
		var nowpage = location.href;
		document.location.href="/login.asp?return_url="+encodeURIComponent(nowpage);
	}else{
		window.open(pageurl,part,"width=800,height=600");
	}
}


//sns 로그인
function snslogout(part){
	pageurl = "/oAuth/"+part+"/logout.asp"
	window.open(pageurl,part,"width=800,height=600")
}

//sns를 이용한 코멘트 달기
function addComment(oForm) {
	if (!oForm)
		return;
	if (oForm.comm_content.value.length<1||oForm.comm_content.value.length>250){
		alert("댓글은 1자 이상 250자 이하로 입력해주세요.");
		return;
	}

	if (!confirm("댓글을 등록 하시겠습니까?")){
		return;
	}

	var comm_content_br = oForm.comm_content.value; 
	comm_content_br= comm_content_br.replace(/\r\n/gi, "<br>"); 
	comm_content_br= comm_content_br.replace(/\n/gi, "<br>"); 
	comm_content_br= comm_content_br.replace(/\r/gi, "<br>"); 

	var request = new HTTPRequest("POST", oForm.action);
	var queryString = "typ=comm_write";
	if(oForm["idx"])
		queryString += "&idx=" + encodeURIComponent(oForm["idx"].value);
	if(comm_content_br)
		queryString += "&comm_content=" + comm_content_br ;
	if(oForm["sns_url"])
		queryString += "&sns_url=" + encodeURIComponent(oForm["sns_url"].value);
	//alert(oForm["sns_url"].value)

	oForm.comm_content.value="";
	request.send(queryString);

	request.onSuccess = function () {
		//oForm["comm_content"].value="";
		
		//document.getElementById("reply_list").innerHTML = document.getElementById("reply_list").innerHTML + this.getText("/response/commentBlock");
		$('#comment_list').append(this.getText("/response/commentBlock"));
		var comm_idx = this.getText("/response/comm_idx");
		var coTop = $('#co'+comm_idx+'').position().top;
		//window.scrollTo(0,coTop);
		jQuery('html,body').animate( { 'scrollTop': coTop }, 'slow' );
		$('#co'+comm_idx+'').fadeOut().fadeIn();
	}

	request.onError = function() {
		//alert(this.getText("/response/description"));
	}
}

//숫자에 콤마 삽입 
function commaNum(num) { 
   var minus = false; 
   if (num < 0) { 
      num *= -1; 
      var minus = true; 
   } 
   var dotPos = (num+"").split(".") 
   var dotU = dotPos[0]; 
   var dotD = dotPos[1]; 
   var commaFlag = dotU.length%3; 
   var out = ""; 
   if (commaFlag) { 
      out = dotU.substring(0, commaFlag); 
      if (dotU.length > 3) out += ","; 
   } 
   for (var i = commaFlag; i < dotU.length; i+=3) { 
      out += dotU.substring(i, i+3); 
      if (i < dotU.length-3) out += ","; 
   } 
   if (minus) out = "-" + out; 
   if (dotD) return out + "," + dotD; 
   else return out; 
} 


 function numOnMask(me){
   var tmpH		
	if((me.indexOf(".",0))>0){//소수점이 들어왔을때 '.'를 빼고적용되게..
		var point = me.substring(me.indexOf("."),me.length);
		me = me.substring(0,me.indexOf("."));
	}
	
	if(me.charAt(0)=="-"){//음수가 들어왔을때 '-'를 빼고적용되게..
		tmpH=me.substring(0,1);
		me=me.substring(1,me.length);
	}	//me.indexOf('-')


	if (me.charAt(0)=="$") //$가 들어왔을 때 '$'를 빼고 적용되게
	{
		tmpH=me.substring(0,1);
		me=me.substring(1,me.length);
	}
	if(me.length > 3){
		var c=0;
		var myArray=new Array();
		for(var i=me.length;i>0;i=i-3){
				myArray[c++]=me.substring(i-3,i);
		}
		myArray.reverse();
		me=myArray.join(",");
	 }
	 if(tmpH){
		me=tmpH+me;
	 }

	 if (point)
	 {
		 me = me + point;
	 }

   return me

  }
function numOffMask(me){
	    var tmp=me.split(",");
 	    tmp=tmp.join("");
	    return tmp;
}

function check_value(me){
	var myStr=numOffMask(me.value);
	me.value=numOnMask(myStr);
}      


function maskoff(){
jQuery("input:text.numfmt").each(function(i){
		jQuery(this).val(jQuery(this).val().replace(/,/gi,""));
	});
$('.onlynum').css("ime-mode","disabled").keydown(function(event){ 		//숫자만 입력하게.(.도 포함) 		
	  if (event.which && (event.which == 190 || event.which == 110 || event.which > 45 && event.which < 58 || event.which == 8 || event.which > 95 && event.which < 106)) {			
	   } else { 
	   event.preventDefault(); 
	  } 
	 });
}

function maskon(){
jQuery("input:text.numfmt").each(function(i){
		check_value(this);
	});
$('.onlynum').css("ime-mode","disabled").keydown(function(event){ 		//숫자만 입력하게.(.도 포함) 		
	
	  if (event.which && (event.which == 190 || event.which == 110 || event.which > 45 && event.which < 58 || event.which == 8 || event.which > 95 && event.which < 106)) {			
	   } else { 
	   event.preventDefault(); 
	  } 
	 });
}

function win_zip(frm_name, frm_zip1, frm_zip2, frm_addr1, frm_addr2)
{
	url = "/member/zipcode_search.php?frm_name="+frm_name+"&frm_zip1="+frm_zip1+"&frm_zip2="+frm_zip2+"&frm_addr1="+frm_addr1+"&frm_addr2="+frm_addr2;
	window.open(url, "winZip", "left=50,top=50,width=500,height=550,scrollbars=yes");
}

function is_checked(elements_name){
    var checked = false;
    var chk = document.getElementsByName(elements_name);
    for (var i=0; i<chk.length; i++) {
        if (chk[i].checked) {
            checked = true;
        }
    }
    return checked;
}

//이미지 리사이징================================================
function img_resize(imgi,wid,hei){			
	var img = new Image();
	img.src = document.getElementById(imgi).src;
	
	var height=img.height;
	var width=img.width;
	if (width>height){

		if (width>parseInt(wid)){
			document.getElementById(imgi).width = wid;
		}else{
			document.getElementById(imgi).width=img.width;
		}
		
	}else{
		if (height>hei){
			document.getElementById(imgi).height = hei;
		}else{
			document.getElementById(imgi).height=img.height;
		}
	}
}

function wrestNumeric(fld) 
    { 
        if (fld.value.length > 0) 
        { 
            for (i = 0; i < fld.value.length; i++) 
            { 
                if (fld.value.charAt(i) < '0' || fld.value.charAt(i) > '9') 
                { 
                    alert("숫자만 입력가능합니다."); 
                    fld.value="";
					fld.focus();  
					return false;  
                }
            }
        }
    }
function wrestNumeric2(fld) 
    { 
        if (fld.value.length > 0) 
        { 
            for (i = 0; i < fld.value.length; i++) 
            { 
                if (fld.value.charAt(i) < '1' || fld.value.charAt(i) > '9') 
                { 
                    alert("수량은 1 이상만 가능합니다."); 
                    fld.value="1";
					fld.focus();  
					return false;  
                }
            }
        }
    }
 function number_format(data) 
{
	
	var tmp = '';
	var number = '';
	var cutlen = 3;
	var comma = ',';
	var i;
   
	len = data.length;
	mod = (len % cutlen);
	k = cutlen - mod;
	for (i=0; i<data.length; i++) 
	{
		number = number + data.charAt(i);
		
		if (i < data.length - 1) 
		{
			k++;
			if ((k % cutlen) == 0) 
			{
				number = number + comma;
				k = 0;
			}
		}
	}

	return number;
}

