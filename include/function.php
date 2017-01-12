<?

//경고창
function Page_Msg_Back($msg){
	echo "
		<script language='javascript'>
			alert(\"$msg\");
		    history.back();
		</script>
	";
}
function Page_Msg_Back1($msg){
	echo "
		<script language='javascript'>
			alert_msg(\"$msg\");
		    history.back();
		</script>
	";
}

function Page_Msg($msg){
	echo "
		<script language='javascript'>
			alert(\"$msg\");
		</script>
	";
}

function Page_Msg1($msg){
	echo "
		<script language='javascript'>
			alert_msg(\"$msg\");
		</script>
	";
}

function Page_Msg_Need($msg){
		echo "
		<script language='javascript'>
			parent.alert(\"$msg\");
		</script>
	";
}

function Page_Msg_Need1($msg){
		echo "
		<script language='javascript'>
			parent.alert_msg(\"$msg\");
		</script>
	";
}
//사용자정의 창(타이틀,메세지,버튼) menu.js => alert_msg2(title,msg,btn)
function Page_Msg_Need2($title,$msg,$btn){
		echo "
		<script language='javascript'>
			parent.alert_msg2(\"$title\",\"$msg\",\"$btn\");
		</script>
	";
}


function Page_Url($url){
	echo "
		<script language='javascript'>
			location.href='$url'
		</script>
	";
}

function Page_Parent_Url($url){
	echo "
		<script language='javascript'>
			parent.location.href='$url'
		</script>
	";
}
//-- 오른쪽 새로고침----------- 2016-03-31
function Parent_Refresh_Right(){
	echo "
		<script language='javascript'>
			parent.Refresh_Right();
		</script>
	";
}
//-- 왼쪽 검색결과 새로고침 ------------- 2016-04-08
function Search_Refresh(){
	echo "
	<script language='javascript'>
		Refresh_MainSh();
	</script>
	";
}
//-- Parent 왼쪽 검색결과 새로고침 ------------- 2016-04-08
function Parent_Search_Refresh(){
	echo "
	<script language='javascript'>
		parent.Refresh_MainSh();
	</script>
	";
}

function Page_Opener_Url($url){
	echo "
		<script language='javascript'>
			opener.location.href='$url';
			self.close();
		</script>
	";
}

function Page_Parent_Msg_Url($msg,$url){
	echo "
		<script language='javascript'>
			parent.alert(\"$msg\");
			parent.location.href='$url'
		</script>
	";
}

function Page_Parent_Msg_Url1($msg,$url){
	echo "
		<script language='javascript'>
			parent.alert_msg(\"$msg\");
			parent.location.href='$url'
		</script>
	";
}

function Page_Parent_Msg_Url2($msg,$url){
	echo "
		<script language='javascript'>
			parent.location.href='$url'
		</script>
	";
}

function Page_Msg_Url($msg,$url){
	echo "
		<script language='javascript'>
			alert(\"$msg\");
			location.href='$url'
		</script>
	";
}

function Page_Msg_Url1($msg,$url){
	echo "
		<script language='javascript'>
			alert_msg(\"$msg\");
			location.href='$url'
		</script>
	";
}

function Page_ImgUpload($no , $filename){
	echo "
			<script language='javascript'>
				parent.document.getElementById('fileimg$no').src =\"/upload/file/$filename\";
				parent.document.getElementById('fileimg$no').width =\"72\";
				parent.document.getElementById('fileimg$no').height =\"72\";
				parent.document.getElementById('file_o$no').value =\"$filename\";
				parent.document.f6.file$no.value='';
			</script>

	";
}

function Page_ImgUpload_Board($max_idx, $no , $filename,$ref){
	if($ref){
		$temp_typ="comm_edit";
	}else{
		$temp_typ="edit";
	}
	echo "
			<script language='javascript'>
				parent.document.getElementById('fileimg$no').src =\"/upload/file/$filename\";
				parent.document.getElementById('file_o$no').src =\"$filename\";
				parent.document.writefrm.file$no.value='';
				parent.document.getElementById('idx').value = '$max_idx';
				parent.document.getElementById('typ').value = '$temp_typ';
			</script>

	";
}

function Page_Chg_Mybox($already,$part_idx){
	$already_saved = $already == "1" ? "Aleady Saved":"";	
	echo "
			<script language='javascript'>
				parent.document.getElementById('mybox_$part_idx').src =\"/kor/images/btn_mybox$already.gif\";
				parent.document.getElementById('mybox_$part_idx').title =\"$already_saved\";				
			</script>

	";
}

function Page_Updval($typ,$val){
	echo "
			<script language='javascript'>
				parent.document.f6.$typ.value='$val';
			</script>

	";
}


function PageReLoad($msg, $part_type){
		echo "
			<script language='javascript'>
				";
		if ($part_type == 7){
			echo "parent.turnkeyreg();";
		}else{
			echo "parent.partreg('$part_type');";
		}
		echo "</script>";
}

function ReopenLayer($layerNum,$loadPage,$varNum){
		echo "
			<script language='javascript'>
				parent.openCommLayer(\"$layerNum\",\"$loadPage\",\"$varNum\");
				";
		echo "</script>";
}

function OpenLayer($layerNum,$loadPage,$varNum){	
		echo "
			<script language='javascript'>			
				openCommLayer(\"$layerNum\",\"$loadPage\",\"$varNum\");
				";
		echo "</script>";
}



function ReopenLayer2($target,$gubun,$param){
		echo "
			<script language='javascript'>
				parent.showajaxParam(\"$target\",\"$gubun\",\"$param\");
				";
		echo "</script>";
}

function ReopenPage($target,$gubun){
		echo "
			<script language='javascript'>
				parent.showPage(\"$target\",\"$gubun\");
				";
		echo "</script>";
}

function closeLayer($layerNum){
		echo "
			<script language='javascript'>
				parent.closeCommLayer(\"$layerNum\");
				";
		echo "</script>";
}

function RequestFile($name){	
	global $HTTP_POST_FILES;

	return $HTTP_POST_FILES[$name];
}

Function replace_in($string){
  if ($string){
	//$string = strtolower($string);

	$string = str_replace("&nbsp;"," ",$string);
	$string = str_replace("&#160;"," ",$string);

	$string = str_replace("\\","",$string);
	$string = str_replace("(","",$string);
	$string = str_replace(")","",$string);
    $string = str_replace("'","''",$string);
	$string = str_replace("--", "-.-",$string);
	$string = str_replace("#","##",$string);
	$string = str_replace("$","$$",$string);
	$string = str_replace("sp_","",$string);
	$string = str_replace("xp_","",$string);
	$string = str_replace("select","**select**",$string);
	$string = str_replace("drop","**drop**",$string);
    $string = str_replace("alter","**alter**",$string);
    $string = str_replace("begin","**begin**",$string);
    $string = str_replace("create","**create**",$string);
    $string = str_replace("exec","**exec**",$string);
    $string = str_replace("execute","**execute**",$string);
    $string = str_replace("insert","**insert**",$string);
    $string = str_replace("sys","**sys**",$string);
    $string = str_replace("sysobjects","**sysobjects**",$string);
    $string = str_replace("update","**update**",$string);
    $string = str_replace("cursor","**cursor**",$string);
	$string = str_replace("union","**union**",$string);
	$string = str_replace(chr(39),"''",$string);
	$string = str_replace(chr(13)&chr(10),"<br>",$string);
  }
  return $string;
}
Function replace_out($string){
  if ($string){
	$string = str_replace(chr(13)&chr(10),"<br>",$string);
	$string = str_replace("><br>",">",$string);
	$string = str_replace("<br />"," ",$string);
	$string = str_replace("##","#",$string);
	$string = str_replace("$$","$",$string);
	$string = str_replace("**select**","select",$string);
	$string = str_replace("**drop**","drop",$string);
    $string = str_replace("**alter**","alter",$string);
    $string = str_replace("**begin**","begin",$string);
    $string = str_replace("**create**","create",$string);
    $string = str_replace("**exec**","exec",$string);
    $string = str_replace("**execute**","execute",$string);
    $string = str_replace("**insert**","insert",$string);
    $string = str_replace("**sys**","sys",$string);
    $string = str_replace("**sysobjects**","sysobjects",$string);
    $string = str_replace("**update**","update",$string);
    $string = str_replace("**cursor**","cursor",$string);
	$string = str_replace("**union**","union",$string);
	$string = str_replace("<br />","",$string);
	$string = str_replace(chr(13)&chr(10),"<br>",$string);
  }
  return $string;
}
// 일반 넘어온값

// 텍스트 에어리어 이용한값 DB저장
Function replace_con_in($string){
  if ($string){
    $string = str_replace("'","''",$string);
    $string = str_replace("<br>",chr(13)&chr(10),$string);
	$string = str_replace("drop","**drop**",$string);
    $string = str_replace("alter","**alter**",$string);
    $string = str_replace("begin","**begin**",$string);
    $string = str_replace("create","**create**",$string);
    $string = str_replace("exec","**exec**",$string);
    $string = str_replace("execute","**execute**",$string);
    $string = str_replace("insert","**insert**",$string);
    $string = str_replace("sys","**sys**",$string);
    $string = str_replace("sysobjects","**sysobjects**",$string);
    $string = str_replace("update","**update**",$string);
    $string = str_replace("cursor","**cursor**",$string);
  }
   return $string;
}


// 텍스트 에어리어 이용한값 DB에서 불러오기
Function replace_con_out($string){
  if ($string){
    $string = str_replace("''","'",$string);
    $string = str_replace(chr(10),"<br>",$string);
	$string = str_replace("<br/>",chr(13),$string);
	$string = str_replace(" ","&nbsp;",$string);
	$string = str_replace("drop","**drop**",$string);
    $string = str_replace("alter","**alter**",$string);
    $string = str_replace("begin","**begin**",$string);
    $string = str_replace("create","**create**",$string);
    $string = str_replace("exec","**exec**",$string);
    $string = str_replace("execute","**execute**",$string);
    $string = str_replace("insert","**insert**",$string);
    $string = str_replace("sys","**sys**",$string);
    $string = str_replace("sysobjects","**sysobjects**",$string);
    $string = str_replace("update","**update**",$string);
    $string = str_replace("cursor","**cursor**",$string);
  }
  return $string;
}

Function r_null($str,$want){
  if ($str){
	$str = $want;
  }Else{
	$str = $str;
  }

  return $str;
}

Function r_want($str,$a,$b){
	If ($str==$a){
		$r_want = $b;
	}Else{
		$r_want = $str;
	}	
}

Function r_want2($str,$a,$b,$c){
	If ($str==$a){
		$r_want = $b;
	}Else{
		$r_want = $c;
	}	
	return $r_want;
}

//'hit 증가 함수
Function plushit($tablename,$field1,$field2,$idx){
	$sql = " update $tablename set $field1 = $field1 + 1  where $field2=$idx";
	$result=mysql_query($sql);
}

//'hit 증가 함수
Function minushit($tablename,$field1,$field2,$idx){
	$sql = " update $tablename set $field1 = $field1 - 1  where $field2=$idx";
	$result=mysql_query($sql);
}

//'value 변경 함수
Function update_val($tablename, $field1, $field2, $field3, $field4){
	$sql = " update $tablename  set $field1 = '$field2' where $field3 = '$field4'";
//	echo $sql;
	$result=mysql_query($sql);
	if ($tablename == "odr" && $field1 == "odr_status"){  
		update_val($tablename, "status_edit_mem_idx",$session_mem_idx, $field3, $field4);
	}
		
}

//'value 변경 함수
Function update_want($tablename, $how, $what){
	$sql = " update $tablename  set $how where 1=1 $what";
	$result=mysql_query($sql);
}

function cutbyte($msg, $limit) {

	$msg = substr($msg, 0, $limit);
	for ($i = $limit - 1; $i > 1; $i--) {  
		if (ord(substr($msg,$i,1)) < 128) break;
	}

	$msg = substr($msg, 0, $limit - ($limit - $i + 1) % 2);

	return $msg;

}

Function minusvalue($tablename,$field1,$field2,$idx,$value){
	$sql = " update $tablename set $field1 = $field1 - $value  where $field2='$idx' ";
	$result=mysql_query($sql);
}

//'인덱스 맥스 값 구하기
Function get_count_plus($tblname,$searchand){
	$maxidxsql = " select count(*) as max_idx from $tblname where 1=1 $searchand";
	$maxresult=mysql_query($maxidxsql);
	$maxrow = mysql_fetch_array($maxresult);

	$max_idx = $maxrow["max_idx"];
	If ($max_idx>0) {
		$max_idx= $max_idx+1;
	} else { 
		$max_idx = 1;
	}
	return $max_idx;
}

//'인덱스 맥스 값 구하기
Function get_max_idx_plus($tblname,$idx){
	$maxidxsql = " select max($idx) as max_idx from $tblname ";
	$maxresult=mysql_query($maxidxsql);
	$maxrow = mysql_fetch_array($maxresult);

	$max_idx = $maxrow["max_idx"];
	If ($max_idx>0) {
		$max_idx= $max_idx+1;
	} else { 
		$max_idx = 1;
	}
	return $max_idx;
}

//'인덱스 맥스 값 구하기
Function get_max_idx($tblname,$idx){
	$maxidxsql = " select max($idx) as max_idx from $tblname ";
	$maxresult=mysql_query($maxidxsql);
	$maxrow = mysql_fetch_array($maxresult);

	$max_idx = $maxrow["max_idx"];
	If ($max_idx>0) {
		$max_idx= $max_idx;
	} else { 
		$max_idx = 1;
	}
	return $max_idx;
}


//'인덱스 맥스 값 구하기
Function get_max_plus_search($tblname,$idx,$searchand){
	$maxidxsql = " select max($idx) as max_idx from $tblname where 1=1 $searchand";
	//echo $maxidxsql;
	$maxresult=mysql_query($maxidxsql);
	$maxrow = mysql_fetch_array($maxresult);

	$max_idx = $maxrow["max_idx"];
	If ($max_idx>0) {
		$max_idx= $max_idx+1;
	} else { 
		$max_idx = 1;
	}
	return $max_idx;
}

//'원하는값 찾기
Function get_want($tblname,$want,$searchand){

	$wantsql = " select $want as wantvalue from $tblname where 1=1 $searchand ";
//	echo $wantsql;
	$wantresult=mysql_query($wantsql);
	$wantrow = mysql_fetch_array($wantresult);

	$wantvalue = $wantrow["wantvalue"];
	
	return $wantvalue;
}


function chg_characterset(  $p1   ){
	  $p1  = iconv("EUC-KR", "UTF-8", $p1);
    return $p1;
}

function validId($val,$min,$max){
	if(!ereg("(^[0-9a-zA-Z]{".$min.",".$max."}$)",$val)) {
		$validId = "false";
	}else{
		$validId = "true";
	}
	return $validId;
}

function validPwd($val,$min,$max){
	if(preg_match("/[0-9]/",$val)=="0" or preg_match("/[a-zA-Z]/",$val)=="0" or !ereg("(^.{".$min.",".$max."}$)",$val)){
		$validPwd = "false";
	}else{
		$validPwd = "true";
	}
	return $validPwd;
}

function validNickname($val,$min,$max){
	if(!ereg("(^.{".$min.",".$max."}$)",$val)){
		$validPwd = "false";
	}else{
		$validPwd = "true";
	}
	return $validPwd;
}


function validEmail($val){	
	if(!eregi("^([[:alnum:]_%+=.-]+)@([[:alnum:]_.-]+)\.([a-z]{2,3}|[0-9]{1,3})$",$val)) 	{ 
		$validEmail = "false";
	}else{
		$validEmail = "true";
	}
	return $validEmail;
}

function cateimg($val){	
	if ($val == 1){
		//$cateimg = "/images/board/t_dowon.png";
	}else if ($val == 2){
		$cateimg = "/images/board/t_dowon.png";
	}else if ($val == 3){
		$cateimg = "/images/board/t_samgo.png";
	}else if ($val == 4){
		$cateimg = "/images/board/t_gunwoong.png";
	}else if ($val == 5){
		$cateimg = "/images/board/t_yosan.png";
	}else if ($val == 6){
		$cateimg = "/images/board/t_samkuk.png";
	}else if ($val == 7){
		$cateimg = "/images/board/t_samkuk.png";
	}else if ($val == 8){
		$cateimg = "/images/common/t_review123.png";
	}else {
		$cateimg = "";
	}
	return $cateimg;

}

function getColumn_nm($no){	
	switch ($no) {
	   case "1":
		 $column_nm = "logo";
		 break;
	   case "2":
		   $column_nm = "sign";
		  break;
	   case "3":
		   $column_nm = "reg_no";
		  break;
	   case "4":
	   case "5":
	   case "6":
	   case "7":
		   $column_nm = "certi".($no-3);
		  break;
	   case "8":
	   case "9":
   	   case "10":
	   case "11":
		  $column_nm = "store".($no-7);
		  break;
	 }
	return $column_nm;
}

Function get_noimg($file_path,$img,$noimg){
	If (!$img) {
		$get_noimg = $noimg;
	} Else {
		$get_noimg = $file_path.$img;
	}

	return $get_noimg;
}



function get_noimg_photo($file_path,$img,$noimg){  //width :72, height : 58 짜리 photo size (사이트 내의 모든 photo size)
	If (!$img) {
		$get_noimg = "src='".$noimg."'";
	} Else {
		$get_noimg = "src='".$file_path.$img."'";	
		//$arrImgInfo = getImageSize("../".$file_path.$img);
		//$org_width = $arrImgInfo[0];
		//$org_height = $arrImgInfo[1];
		//if ($org_width >= $org_height){
			$get_noimg .=" width = '72'";
		//}else{
			$get_noimg .=" height = '72'";
		//}
	}
	//exit;
	return $get_noimg;
}


function chkLogin($mem_idx){
	if ($mem_idx==""){
		Page_Msg_Url1("로그인 후 이용하여 주시기 바랍니다.","/kor/");
		exit;
	}
}
//'인덱스 맥스 값 구하기
Function get_this($tblname,$f1,$f2,$v){

	$thissql = " select $f1 as thisvalue from $tblname where $f2='$v'";
	$thisresult=mysql_query($thissql);
	$thisrow = mysql_fetch_array($thisresult);

	$thisvalue = $thisrow["thisvalue"];
	
	return $thisvalue;
}

function get_cut($val,$num,$point="..."){
	$num = $num - strlen($point);
	if(mb_strlen($val,'UTF-8')>$num){
		$val = mb_substr($val,0,$num,'UTF-8').$point;
	}

	return $val;
}

function cut_len($str,$len,$dot="..."){
	$num = $len - strlen($dot);
	if(mb_strlen($str,'UTF-8')>$len){
		$str = mb_substr($str,0,$num,'UTF-8').$dot;
	}
	return $str;
}

// TEXT 형식으로 변환 //
function get_text($str, $html=0)
{
    /* 3.22 막음 (HTML 체크 줄바꿈시 출력 오류때문)
    $source[] = "/  /";
    $target[] = " &nbsp;";
    */

    // 3.31
    // TEXT 출력일 경우 &amp; &nbsp; 등의 코드를 정상으로 출력해 주기 위함
    if ($html == 0) {
        $str = html_symbol($str);
    }

    $source[] = "/</";
    $target[] = "&lt;";
    $source[] = "/>/";
    $target[] = "&gt;";
    //$source[] = "/\"/";
    //$target[] = "&#034;";
    $source[] = "/\'/";
    $target[] = "&#039;";
    //$source[] = "/}/"; $target[] = "&#125;";
    if ($html) {
        $source[] = "/\n/";
        $target[] = "<br/>";
    }

    return preg_replace($source, $target, $str);
}

function get_comment($num){
	$comment_text = "";

	if($num>0){ $comment_text="&nbsp;&nbsp;[$num]";}

	return $comment_text;
}




//-------------------------------------------------------------------------------
// Function 명 : GF_Common_SetComboList
// 용       도 : 공통코드 selectbox 항목 출력
// 작 성 일 시 :
// 수 정 이 력 : 2013-09-25 (정선진)
//-------------------------------------------------------------------------------


Function GF_Common_SetComboList($CheckBoxName,$CommTy, $ParCode, $Depth, $IsBlank, $BlankString, $CheckValue, $StyleOption,$lang="",$id=""){
		if($id){
			$GF_Common_SetComboList .="<select ".$StyleOption." name='".$CheckBoxName."' id='".$id."'>\n";
		}else{
			$GF_Common_SetComboList .="<select ".$StyleOption." name='".$CheckBoxName."' id='".$CheckBoxName."'>\n";
		}
		If($IsBlank=="True"){			
			$GF_Common_SetComboList .="<option value='' ".($CheckValue==null?"selected":"").">" .$BlankString ."</option>\n";
		}
		If ($Depth == "") {$Depth = " =1";}else{ $Depth = "=".$Depth;}		
		if ($lang==""){
			$result =QRY_COMMON_LIST($CommTy ,$ParCode, $Depth);		
		}else{
			$result =QRY_COMMON_LIST_LANG($CommTy ,$ParCode, $Depth,$lang);		
		}
		while($row = mysql_fetch_array($result)){
			$dtl_code = replace_out($row["dtl_code"]);
			$code_desc = replace_out($row["code_desc"]);
			If(strcmp($CheckValue,$dtl_code)==0){
				$GF_Common_SetComboList .="<option value='".$dtl_code."' selected>".$code_desc."</option>\n";
			}else{
				$GF_Common_SetComboList .="<option value='".$dtl_code."'>".$code_desc."</option>\n";
			}
		}
		$GF_Common_SetComboList .="</select>\n";	
		return $GF_Common_SetComboList;
}


Function GF_Common_SetComboListSrch($CheckBoxName,$CommTy, $ParCode, $Depth, $IsBlank, $BlankString, $CheckValue, $StyleOption,$srch, $lang=""){		
		$GF_Common_SetComboList .="<select ".$StyleOption." name='".$CheckBoxName."' id='".$CheckBoxName."'>\n";
		If($IsBlank=="True"){			
			$GF_Common_SetComboList .="<option value='' ".($CheckValue==null?"selected":"").">" .$BlankString ."</option>\n";
		}
		If ($Depth == "") {$Depth = " =1";}else{ $Depth = "=".$Depth;}
		
		if ($lang==""){
			$result =QRY_COMMON_LIST_SRCH($CommTy ,$ParCode, $Depth , $srch);		
		}else{
			$result =QRY_COMMON_LIST_SRCH_LANG($CommTy ,$ParCode, $Depth,$srch, $lang);		
		}
		while($row = mysql_fetch_array($result)){
			$dtl_code = replace_out($row["dtl_code"]);
			$code_desc = replace_out($row["code_desc"]);
			$code_desc_en = replace_out($row["code_desc_en"]);
			If(strcmp($CheckValue,$dtl_code)==0){
				$GF_Common_SetComboList .="<option value='".$dtl_code."' selected>".$code_desc."</option>\n";
			}else{
				$GF_Common_SetComboList .="<option value='".$dtl_code."'>".$code_desc."</option>\n";
			}
		}
		$GF_Common_SetComboList .="</select>\n";	
		return $GF_Common_SetComboList;
}

Function GF_Common_SetComboList_dosi($CheckBoxName,$CommTy, $ParCode, $Depth, $IsBlank, $BlankString, $CheckValue, $StyleOption,$snation,$bnation){
						
		if($id){
			$GF_Common_SetComboList_dosi .="<select ".$StyleOption." name='".$CheckBoxName."' id='".$id."'>\n";
		}else{
			$GF_Common_SetComboList_dosi .="<select ".$StyleOption." name='".$CheckBoxName."' id='".$CheckBoxName."'>\n";
		}
		If($IsBlank=="True"){			
			$GF_Common_SetComboList_dosi .="<option value='' ".($CheckValue==null?"selected":"").">" .$BlankString ."</option>\n";
		}
		If ($Depth == "") {$Depth = " =1";}else{ $Depth = "=".$Depth;}		
		if ($lang==""){
			$result =QRY_COMMON_LIST($CommTy ,$ParCode, $Depth);		
		}else{
			$result =QRY_COMMON_LIST_LANG($CommTy ,$ParCode, $Depth,$lang);		
		}
		while($row = mysql_fetch_array($result)){
			$dtl_code = replace_out($row["dtl_code"]);
			$code_desc ="";
			if($snation==$bnation)
			{
				$code_desc = replace_out($row["code_desc"]);				
			}
			else
			{
				$code_desc = replace_out($row["code_desc_en"]);					
			}

			If(strcmp($CheckValue,$dtl_code)==0){
				$GF_Common_SetComboList_dosi .="<option value='".$dtl_code."' selected>".$code_desc."</option>\n";
			}else{
				$GF_Common_SetComboList_dosi .="<option value='".$dtl_code."'>".$code_desc."</option>\n";
			}
		}
		$GF_Common_SetComboList_dosi .="</select>\n";	
		return $GF_Common_SetComboList_dosi;
}
//-------------------------------------------------------------------------------
// Function 명 : GF_Common_SetCheckboxList
// 용       도 : 공통코드 checkbox 항목 출력
// 작 성 일 시 :
// 수 정 이 력 : 2013-09-25 (정선진)
//-------------------------------------------------------------------------------
Function GF_Common_SetCheckboxList($ListType , $CheckBoxName,$CommTy, $ParCode, $Depth, $CheckValue, $StyleOption){		
		If ($Depth == "") {$Depth = " =1";}else{ $Depth = "=".$Depth;}		
		$result =QRY_COMMON_LIST($CommTy ,$ParCode, $Depth);		
		while($row = mysql_fetch_array($result)){
			$dtl_code = replace_out($row["dtl_code"]);
			$code_desc = replace_out($row["code_desc"]);
			If(eregi($dtl_code  , $CheckValue)){
				$GF_Common_SetCheckboxList .="<input type='".$ListType."' name='".$CheckBoxName."' value='".$dtl_code."' checked>".$code_desc.$StyleOption;
			}else{
				$GF_Common_SetCheckboxList .="<input type='".$ListType."' name='".$CheckBoxName."' value='".$dtl_code."'>".$code_desc.$StyleOption;
			}
		}
		return $GF_Common_SetCheckboxList;
}

//-------------------------------------------------------------------------------
// Function 명 : GF_warea_SetComboList
// 용       도 : 지도 검색용 지역 selectbox 항목 출력
// 작 성 일 시 :
// 수 정 이 력 : 2013-09-25 (정선진)
//-------------------------------------------------------------------------------

Function GF_warea_SetComboList($CheckBoxName,$ParCode, $Depth, $IsBlank, $BlankString, $CheckValue, $StyleOption){		
		$GF_Common_SetComboList .="<select ".$StyleOption." name='".$CheckBoxName."' id='".$CheckBoxName."'>\n";
		If($IsBlank=="True"){			
			$GF_Common_SetComboList .="<option value='' ".($CheckValue==null || $CheckValue=="" ?"selected":"").">" .$BlankString ."</option>\n";
		}
		If ($ParCode == "") {$ParCode = " =''";}else{ $ParCode = "=".$ParCode;}		
		If ($Depth == "") {$Depth = " =1";}else{ $Depth = "=".$Depth;}		
		$result =QRY_WAREA_LIST($ParCode, $Depth);		
		while($row = mysql_fetch_array($result)){
			$WC_IDX = replace_out($row["WC_IDX"]);
			$CATE_NAME = replace_out($row["CATE_NAME"]);
			If(strcmp($CheckValue,$WC_IDX)==0){
				$GF_Common_SetComboList .="<option value='".$WC_IDX."' selected>".$CATE_NAME."</option>\n";
			}else{
				$GF_Common_SetComboList .="<option value='".$WC_IDX."'>".$CATE_NAME."</option>\n";
			}
		}
		$GF_Common_SetComboList .="</select>\n";	
		return $GF_Common_SetComboList;
}


//-------------------------------------------------------------------------------
// Function 명 : GF_Common_GetSingleList
// 용       도 : 공통 코드 선택된 항목 텍스트 출력
// 작 성 일 시 :
// 수 정 이 력 : 2013-10-01 (정선진)
//-------------------------------------------------------------------------------
Function GF_Common_GetSingleList($CommTy, $CheckValue){
	If ($CheckValue ==""){
			$GF_Common_GetSingleList = "";
	}else{
		$GF_Common_GetSingleList =QRY_COMMON_SINGLELIST($CommTy ,$CheckValue);		
	}

	return $GF_Common_GetSingleList;
}

Function GF_Common_GetSingleList_LANG($CommTy, $CheckValue, $lang){
	If ($CheckValue ==""){
			$GF_Common_GetSingleList_LANG = "";
	}else{
		$GF_Common_GetSingleList_LANG =QRY_COMMON_SINGLELIST_LANG($CommTy ,$CheckValue, $lang);		
	}

	return $GF_Common_GetSingleList_LANG;
}



//-------------------------------------------------------------------------------
// Function 명 : GF_Common_GetMultiList
// 용       도 : 공통 코드 선택된 항목 텍스트 출력
// 작 성 일 시 :
// 수 정 이 력 : 2013-10-01 (정선진)
//-------------------------------------------------------------------------------
Function GF_Common_GetMultiList($CommTy, $CheckValue){
	If ($CheckValue ==""){
			$GF_Common_GetMultiList = "";
	}else{
		$result =QRY_COMMON_MULTILIST($CommTy ,$CheckValue);		
		while($row = mysql_fetch_array($result)){
			$code_desc = replace_out($row["code_desc"]);			
			if ($GF_Common_GetMultiList!=""){ $GF_Common_GetMultiList.=", ";}
			$GF_Common_GetMultiList .=$code_desc;
		}
	}

	return $GF_Common_GetMultiList;
}

//-------------------------------------------------------------------------------
// Function 명 : GF_Common_SetComboList
// 용       도 : 공통코드 selectbox 항목 출력
// 작 성 일 시 :
// 수 정 이 력 : 2013-09-25 (정선진)
//-------------------------------------------------------------------------------



Function GF_Productty_SetComboList($CheckBoxName,$IsBlank, $BlankString, $CheckValue, $StyleOption){		
		$GF_Common_SetComboList .="<select ".$StyleOption." name='".$CheckBoxName."' id='".$CheckBoxName."'>\n";
		If($IsBlank=="True"){			
			$GF_Common_SetComboList .="<option value='' ".($CheckValue==null?"selected":"").">" .$BlankString ."</option>\n";
		}
		If ($Depth == "") {$Depth = " =1";}else{ $Depth = "=".$Depth;}		
		$result =QRY_PRODUCTTY_LIST($CommTy);	
		while($row = mysql_fetch_array($result)){
			$dtl_code = replace_out($row["gubun"]);
			$code_desc = replace_out($row["title"]);
			If(strcmp($CheckValue,$dtl_code)==0){
				$GF_Common_SetComboList .="<option value='".$dtl_code."' selected>".$code_desc."</option>\n";
			}else{
				$GF_Common_SetComboList .="<option value='".$dtl_code."'>".$code_desc."</option>\n";
			}
		}
		$GF_Common_SetComboList .="</select>\n";	
		return $GF_Common_SetComboList;
}


//-------------------------------------------------------------------------------
// Function 명 : GF_Category_SetComboList
// 용       도 : 중분류 selectbox 항목 출력(product_type 테이블)
// 작 성 일 시 :
// 수 정 이 력 : 2013-09-25 (정선진)
//-------------------------------------------------------------------------------

function GF_Category_SetComboList($CheckBoxName,$mode, $IsBlank, $BlankString, $CheckValue, $StyleOption){	
	
	$GF_Category_SetComboList .="<select ".$StyleOption." name='".$CheckBoxName."' id='".$CheckBoxName."'>\n";
		If($IsBlank=="True"){	
			$GF_Category_SetComboList .="<option value='' ".($CheckValue==null?"selected":"").">" .$BlankString ."</option>\n";
		}
		$result =QRY_CATEGORY_LIST($mode,$searchand);	
		while($row = mysql_fetch_array($result)){
			$product_type_idx = replace_out($row["product_type_idx"]);
			$product_type_name = replace_out($row["product_type_name"]);
			If(strcmp($CheckValue,$product_type_idx)==0){
				$GF_Category_SetComboList .="<option value='".$product_type_idx."' selected>".$product_type_name."</option>\n";
			}else{
				$GF_Category_SetComboList .="<option value='".$product_type_idx."'>".$product_type_name."</option>\n";
			}
		}
		$GF_Category_SetComboList .="</select>\n";	
		return $GF_Category_SetComboList;
	
}

//-------------------------------------------------------------------------------
// Function 명 : GF_Common_GetSingleList
// 용       도 : 공통 코드 선택된 항목 텍스트 출력
// 작 성 일 시 :
// 수 정 이 력 : 2013-10-01 (정선진)
//-------------------------------------------------------------------------------
Function GF_Category_GetSingleList($mode, $CheckValue){
	If ($CheckValue ==""){
			$GF_Common_GetSingleList = "";
	}else{
		$GF_Common_GetSingleList =QRY_CATEGORY_SINGLELIST($mode ,$CheckValue);		
	}

	return $GF_Common_GetSingleList;
}

//-------------------------------------------------------------------------------
// Function 명 : get_each_single_quotation
// 용       도 : 문자열을 ADE -> 'A','D','E' 로 리턴 하고 싶을때(쿼리할때 쓰임) QRY_COMMON_MULTILIST 참조
// 작 성 일 시 :
// 수 정 이 력 : 2013-11-01 (정선진)
//-------------------------------------------------------------------------------
function get_each_single_quotation($val){
	for ($i = 0; $i < strlen($val); $i++){
			if ($i !=0) {$str .= ",";}
			$str .= "'".substr($val,$i,1)."'";
		}
	return $str;
}

Function get_any($tbl,$that,$whereqry){
	$thatsql = " select ifnull($that,'diff') as that from $tbl where 1=1 and $whereqry ";
//	echo $thatsql;
	$thatresult=mysql_query($thatsql);
	$thatrow = mysql_fetch_array($thatresult);
	$that = $thatrow["that"];
	return $that;
}


function CAR_SetComboList($CheckBoxName,$CompanyIdx, $IsBlank, $BlankString, $CheckValue, $StyleOption){
		$CAR_SetComboList .="<select ".$StyleOption." name='".$CheckBoxName."' id='".$CheckBoxName."'>\n";
		If($IsBlank=="True"){			
			$CAR_SetComboList .="<option value='' ".($CheckValue==null?"selected":"").">" .$BlankString ."</option>\n";
		}
		if ($CompanyIdx) { 
			$result =QRY_CAR_LIST($CompanyIdx);		
			while($row = mysql_fetch_array($result)){
				$car_idx = replace_out($row["car_idx"]);
				$car_name = replace_out($row["car_name"]);
				If(strcmp($CheckValue,$car_idx)==0){
					$CAR_SetComboList .="<option value='".$car_idx."' selected>".$car_name."</option>\n";
				}else{
					$CAR_SetComboList .="<option value='".$car_idx."'>".$car_name."</option>\n";
				}
			}
		}
		$CAR_SetComboList .="</select>\n";	
		return $CAR_SetComboList;
}

function CAR_SetComboListwithYear($CheckBoxName,$CompanyIdx, $IsBlank, $BlankString, $CheckValue, $StyleOption){
		$CAR_SetComboListwithYear .="<select ".$StyleOption." name='".$CheckBoxName."' id='".$CheckBoxName."'>\n";
		If($IsBlank=="True"){			
			$CAR_SetComboListwithYear .="<option value='' ".($CheckValue==null?"selected":"").">" .$BlankString ."</option>\n";
		}
		if ($CompanyIdx) { 
			$result =QRY_CAR_LIST($CompanyIdx);		
			while($row = mysql_fetch_array($result)){
				$car_idx = replace_out($row["car_idx"]);
				$car_name = replace_out($row["car_name"]);
				$start_year = replace_out($row["start_year"]);
				$end_year = replace_out($row["end_year"]);
				$car_full_name = $car_name."-".$start_year."년~".($end_year==""?"현재":$end_year)."년";

				If(strcmp($CheckValue,$car_idx)==0){
					$CAR_SetComboListwithYear .="<option value='".$car_idx."' selected>".$car_full_name."</option>\n";
				}else{
					$CAR_SetComboListwithYear .="<option value='".$car_idx."'>".$car_full_name."</option>\n";
				}
			}
		}
		$CAR_SetComboListwithYear .="</select>\n";	
		return $CAR_SetComboListwithYear;
}

function MANAGER_SetComboList($CheckBoxName,$rel_idx,$IsBlank, $BlankString, $CheckValue, $StyleOption){
		$MANAGER_SetComboList .="<select ".$StyleOption." name='".$CheckBoxName."' id='".$CheckBoxName."'>\n";
		If($IsBlank=="True"){			
			$MANAGER_SetComboList .="<option value='' ".($CheckValue==null?"selected":"").">" .$BlankString ."</option>\n";
		}
		if ($rel_idx) { 
			$result = QRY_MEMBER_LIST("","and (mem_idx = '$rel_idx' or rel_idx='$rel_idx')","");
			while($row = mysql_fetch_array($result)){
				$mem_idx= replace_out($row["mem_idx"]);
				$mem_id= replace_out($row["mem_id"]);
				If(strcmp($CheckValue,$mem_idx)==0){
					$MANAGER_SetComboList .="<option lang='en' value='".$mem_idx."' selected>".$mem_id."</option>\n";
				}else{
					$MANAGER_SetComboList .="<option lang='en' value='".$mem_idx."'>".$mem_id."</option>\n";
				}				
			}				
		}
		$MANAGER_SetComboList .="</select>\n";	
		return $MANAGER_SetComboList;
}

function AGENCY_SetComboList($CheckBoxName,$rel_idx,$IsBlank, $BlankString, $CheckValue, $StyleOption){
		$MANAGER_SetComboList .="<select ".$StyleOption." name='".$CheckBoxName."' id='".$CheckBoxName."'>\n";
		If($IsBlank=="True"){			
			$MANAGER_SetComboList .="<option value='' ".($CheckValue==null?"selected":"").">" .$BlankString ."</option>\n";
			//$MANAGER_SetComboList .="<option value=''>직접입력</option>\n";
		}
		if ($rel_idx!="") { 
			$result = QRY_LIST("agency","all","","and (rel_idx=0 or rel_idx='$rel_idx') ","agency_name");
			while($row = mysql_fetch_array($result)){
				$idx= replace_out($row["idx"]);
				$agency_idx= replace_out($row["agency_idx"]);
				$agency_name= replace_out($row["agency_name"]);
				If(strcmp($CheckValue,$idx)==0){
					$MANAGER_SetComboList .="<option lang='en' value='".$idx."' selected>".$agency_name."</option>\n";
				}else{
					$MANAGER_SetComboList .="<option lang='en' value='".$idx."'>".$agency_name."</option>\n";
				}				
			}				
		}
		$MANAGER_SetComboList .="</select>\n";	
		return $MANAGER_SetComboList;
}

function GF_PRODUCT_ACCESSORY($modechr,$param){
	$searchand .= "and bd_gubun = 'BB006' and instr(bd_cate,'".$modechr."') and bd_blind<> 'Y'";
	$cnt = QRY_CNT("board",$searchand);
	$result = QRY_PRODUCT_LIST($searchand);
	
	if ($cnt > 0){
?>
	<!--<div id="tit_box02">
		<h3>액세서리</h3>
	</div>--><!--// tit_box -->
	<div id="gallery02">
	<ul>
		<?while($row = mysql_fetch_array($result)){
		$bd_idx= replace_out($row["bd_idx"]);
		$bd_title= replace_out($row["bd_title"]);
		$bd_title_sub= replace_out($row["bd_title_sub"]);
		$bd_file0= replace_out($row["bd_file0"]);
		?>
		<li><a href="product_view.php?idx=<?=$bd_idx?>&<?=$param?>"><img src="<?="/upload/file/".$bd_file0?>" width="128" height="96"></a>
		<a href="product_view.php?idx=<?=$bd_idx?>&<?=$param?>"><?=$bd_title.$bd_title_sub?></a>
		</li>
		<?}?>
	</ul>
	<?}
}


function get_odr_no($ty){     //purchase odr no
	//2016-12-07 : PO No. 생성 방식을 카운트에서 Max로 변경 - ccolle
	/** 본 주석처리 내용은 JSJ
	$cnt = QRY_CNT("odr","and odr_no like '".$ty.date("y")."%'");
	return $ty.date("y")."-PS".str_pad(fmod($cnt,99999)+1,5,"0",STR_PAD_LEFT).chr(65+floor($cnt/99999));
	**/
	$max_str = get_any("odr", "MAX(odr_no)" , "odr_status<99");
	$max_str = substr($max_str, 7, 6);
	$max_int = (int)$max_str;
	return $ty.date("y")."-PS".str_pad(fmod($max_int,99999)+1,5,"0",STR_PAD_LEFT).chr(65+floor($cnt/99999));
}


function get_odr_det_no($ty){  //agreement no
	$cnt = QRY_CNT("odr_det","and agreement_no like '".$ty.date("y")."%'");
	return $ty.date("y")."-PS".str_pad(fmod($cnt,99999)+1,5,"0",STR_PAD_LEFT).chr(65+floor($cnt/99999));
}


function get_auto_no($ty, $table, $column){  // 통합 no 생성
	global $odr_idx;

	if ($ty == "TFI"){
		//$addCl = " or testB_invoice like '".$ty.date("y")."%'"; //error에의한 주석처리.아래도 수정 2016-10-16
		$addCl = " or invoice_no like '".$ty.date("y")."%'";
	}
	//2016-04-18 : odr 테이블을 경우 odr_status=99 카운트에서 제외
	if($table == 'odr'){
		//$cnt = QRY_CNT($table,"and odr_status NOT IN(8,99) AND ($column like '".$ty.date("y")."%'".$addCl.")"); //JSJ : 수량으로 되어있어서 번호 늘지 않는다.
		//cnt 아닌 최대번호 가져오자. 2016-04-19
		$cut_bit = strlen($ty) + 6; //ty 문자열 길이에따라 자르는 시작 위치 바뀌어야 한다.
		$odr_no_cnt = QRY_CNT("odr","and ($column like '".$ty.date("y")."%'".$addCl.") and odr_idx = '".$odr_idx."' ");
		$cnt = get_any("odr","IFNULL(CAST(SUBSTR(MAX($column),$cut_bit,5) AS UNSIGNED),0)", "odr_status NOT IN(8,99) AND ($column like '".$ty.date("y")."%'".$addCl.")");
		if ($odr_no_cnt)
		{
			$result_value = $ty.date("y")."-PS".str_pad(fmod($cnt,99999),5,"0",STR_PAD_LEFT).chr(65+floor($cnt/99999));
		}
		else
		{
			$result_value = $ty.date("y")."-PS".str_pad(fmod($cnt,99999)+1,5,"0",STR_PAD_LEFT).chr(65+floor($cnt/99999));
		}
		
	}else{
		$cnt = QRY_CNT($table,"and ($column like '".$ty.date("y")."%'".$addCl.")");
		$result_value = $ty.date("y")."-PS".str_pad(fmod($cnt,99999)+1,5,"0",STR_PAD_LEFT).chr(65+floor($cnt/99999));
	}
	return $result_value;
}

function get_memfee_no($ty, $table, $column){     //memfee no
	$cnt = QRY_CNT($table,"and ($column like '".$ty.date("y")."%')");
	return $ty.date("y")."-PA".str_pad(fmod($cnt,99999)+1,5,"0",STR_PAD_LEFT).chr(65+floor($cnt/99999));
}

function get_variable_name($mem_type, $word){	
	switch ($mem_type) {
	   case "1":
	   case "2":
			$word = ($word == "학교") ? "회사" : $word;
	 	    $word = ($word == "학생") ? "직원" : $word;
			$word = ($word == "학과") ? "부서" : $word;
			$word = ($word == "학교 / 학과") ? "사무실/창고" : $word;						
		 break;	   
	   case "3":
		   $word = ($word == "회사") ? "학교" : $word;
		   $word = ($word == "직원") ? "학생" : $word;
		   $word = ($word == "부서") ? "학과" : $word;
		   $word = ($word == "사무실/창고") ? "학교 / 학과" : $word;		
		  break;
	 }
	 return $word;
}
function get_bank_info($row_parts, $nation){
				if ($nation == "1"){?>
				<strong>PARTStrike Bank Information</strong>
				<ul class="txt3">					
					<li>은행 : <?=$row_parts["bank_name"]?></li>
					<li>계좌번호 <?=$row_parts["bank_account"]?></li>
					<li><?=$row_parts["bank_user_name"]?></li>
				</ul>
				<?}else{?>				
				<strong>PARTStrike Bank Information</strong>
				<ul class="txt3">
					<li>Beneficiary Name : PARTStrike Co., Ltd.</li>
					<li>Bank Name : Inderstrial Bank of Korea</li>
					<li>Account No. 632-018768-56-00018</li>
					<li>Bank Address : EunSan Building, 8, Gyeonginro53gil, Guro-gu, Seoul, 152-864, Korea </li>
					<li>Bank Phone No. : +82-2-2672-7911</li>
					<li>Swift(BIC) Code : IBKOKRSEXXX</li>
				</ul>
			<?	}
}

function get_navermap_coods($p_str_addr="") { 
	$int_x = 0; 
	$int_y = 0; 


	$str_addr = str_replace(" ", "", $p_str_addr); 
	//$str_addr =$p_str_addr;

	// curl 이용해서 지도에 필요한 좌표를 취득 
	$dest_url  = "http://openapi.map.naver.com/api/geocode.php?key=8b4ec6ffcda7d1eb2978991cb7c80eba&encoding=utf-8&coord=LatLng&query=" .$str_addr; 

	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $dest_url); 
	curl_setopt($ch, CURLOPT_TIMEOUT, 30); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	$str_result = curl_exec($ch); 
	curl_close($ch); 

	$obj_xml = simplexml_load_string($str_result); 

	$int_x = $obj_xml->item->point->x; 
	$int_y = $obj_xml->item->point->y; 

	
	return array($int_x, $int_y); 
} 

//예전 버전.. 지워야 함.. 추후 필요할까봐 임시로 남겨 뒀음.
/*function GET_MENU_CNT($odr_status, $searchand=""){
	global $config_odr_sell_status;
	return QRY_CNT("odr", "and ((case when $config_odr_sell_status then sell_mem_idx='".$_SESSION["MEM_IDX"]."'						
						WHEN odr_status =4 THEN CASE WHEN sell_mem_idx = '".$_SESSION["MEM_IDX"]."' THEN sell_mem_idx = '".$_SESSION["MEM_IDX"]."' ELSE mem_idx = '".$_SESSION["MEM_IDX"]."'  and accept_yn is null END 
						when odr_status = 7 then case when sell_mem_idx = '".$_SESSION["MEM_IDX"]."' then sell_mem_idx = '".$_SESSION["MEM_IDX"]."' and status_edit_mem_idx <> '".$_SESSION["MEM_IDX"]."' else mem_idx = '".$_SESSION["MEM_IDX"]."' and status_edit_mem_idx <> '".$_SESSION["MEM_IDX"]."' end
						when odr_status = 8 then CASE WHEN sell_mem_idx = '".$_SESSION["MEM_IDX"]."' then sell_mem_idx = '".$_SESSION["MEM_IDX"]."' and cancel_accept_yn ='' else mem_idx = '".$_SESSION["MEM_IDX"]."'  end
					  else status_edit_mem_idx <> '".$_SESSION["MEM_IDX"]."' and  complete_yn='N' and (mem_idx ='".$_SESSION["MEM_IDX"]."' or sell_mem_idx= '".$_SESSION["MEM_IDX"]."') end)) and odr_status = $odr_status $searchand");
}*/

function GET_MENU_CNT($ty, $odr_status, $his_ty, $searchand=""){
	global $config_odr_sell_status;
	if ($odr_status =="5" ||$odr_status =="6" || $odr_status =="27") {
		$addCl = "";
	}elseif ($odr_status=="4"){
		if ($ty == "buy"){
			$addCl = " and fault_select is null ";
		}else{
			$addCl = " and fault_select is not null ";
		}
	}elseif($odr_status =="25"){
		$addCl = " and reason_ty !='6' and reg_mem_idx <>'".$_SESSION["MEM_IDX"]."'";
	}
	else{
		$addCl = " and reg_mem_idx <>'".$_SESSION["MEM_IDX"]."'";
	}


	if ($odr_status == "6") {    //6 : 수령 같은 경우는 한 odr당 수령이 5개 있어도 1로 친다. odr_history의 odr_idx별 distinct 개수. - JSJ
		//2016-05-23 : 수령이 구매자 반품 한것을 판매자가 수령하여 '구매자'에게 수령알림의 경우에는 제품 흐름이 판매자, 구매자가 반대다('buy_mem_idx' 나, 'sell_mem_idx' 로 조회는 오류가 있다)
		//$cnt = get_any($his_ty . "_history" , "count(distinct odr_idx)", "".$ty."_mem_idx = '".$_SESSION["MEM_IDX"]."' and status =$odr_status and confirm_yn = 'N'"); //JSJ
		//2016-05-23 : 구매자 입장에서 '수령' 알림은, 구매자는 '나' 이지만, 수령 작성자는 '나'가 아닌경우
		$cnt = get_any($his_ty . "_history" , "count(distinct odr_idx)", "".$ty."_mem_idx = '".$_SESSION["MEM_IDX"]."' and reg_mem_idx != '".$_SESSION["MEM_IDX"]."' and status =$odr_status and confirm_yn = 'N'"); 
	}else{
		$cnt = QRY_CNT($his_ty . "_history" , $searchand." and ".$ty."_mem_idx = '".$_SESSION["MEM_IDX"]."' and status = $odr_status ".$addCl." and confirm_yn = 'N' ");
	}
	return $cnt;
}

function GET_SAVE_CNT(){
	$cnt = QRY_CNT("odr","and mem_idx='".$_SESSION["MEM_IDX"]."' and save_yn = 'Y'");
	return $cnt;
}
function SumMyBank($mem_idx, $rel_idx){
	$com_idx = ($rel_idx ==0 ? $mem_idx : $rel_idx);
	
	$pay = get_any("mybank" ,"sum( charge_amt )", "(mem_idx =$com_idx or rel_idx =$com_idx) and (charge_method = 'MyBank' or invoice_no like 'CMBI%')");
	return number_format($pay,2);
}

//2016-05-27일 이후부터 아래 함수 사용(MyBank 테이블 설계변경)
function SumMyBank2($mem_idx, $rel_idx, $ty=2){
	$com_idx = ($rel_idx ==0 ? $mem_idx : $rel_idx);

	$pay = get_any("mybank" ,"sum( charge_amt )", "(mem_idx =$com_idx or rel_idx =$com_idx) and mybank_yn = 'Y'");
	if($ty>0){
		$pay_val = round_down($pay,4);
		$pay_val = number_format($pay,4);
		return $pay_val;
	}else{
		return $pay;
	}
}
//2016-05-27 : 예치금 합계
function SumBankHold($mem_idx, $rel_idx, $ty=2){
	$com_idx = ($rel_idx ==0 ? $mem_idx : $rel_idx);

	$pay = get_any("mybank" ,"sum(mybank_hold)", "(mem_idx =$com_idx or rel_idx =$com_idx) and mybank_yn = 'Y'");
	if($ty>0){
		$pay_val = round_down($pay,4);
		$pay_val = number_format($pay,4);
		return $pay_val;
	}else{
		return $pay;
	}
}

function GetDeposit($mem_idx, $rel_idx, $charge_type){
	$com_idx = ($rel_idx ==0 ? $mem_idx : $rel_idx);
	$pay = get_any("mybank" ,"sum( charge_amt )", "(mem_idx =$com_idx or rel_idx =$com_idx) and charge_type in ($charge_type)");
	return number_format(round_down(abs($pay),4),4);
}

function get_part($part_idx, $fields='*'){
	return sql_fetch("select $fields from part where part_idx = trim('$part_idx')");
}

function get_mybank($mybank_idx, $fields='*'){
	return sql_fetch("select $fields from mybank where mybank_idx = trim('$mybank_idx')");
}

function get_odr($odr_idx, $fields='*'){
		return sql_fetch("select $fields from odr where odr_idx = trim('$odr_idx')");
}

function get_mem($mem_idx, $fields='*'){
		return sql_fetch("select $fields from member where mem_idx = trim('$mem_idx')");
}

function get_delivery_addr($delivery_addr_idx, $fields='*'){
		return sql_fetch("select $fields from delivery_addr where delivery_addr_idx = trim('$delivery_addr_idx')");
}

//2016-11-06 선불 배송 정보
function get_delv_charge($mem_idx, $typ, $nation){
	$conn = dbconn();	
	$sql = "
			SELECT * FROM freight_charge
			WHERE
				rel_idx = $mem_idx AND trade_type = $typ
				AND (f_dest_idx = $nation or f_dest_idx LIKE '$nation,%' or f_dest_idx LIKE '%,$nation,%' or f_dest_idx LIKE ',%$nation')
			order by freight_idx ASC
			";
	//echo $sql;
	//mysql_query( "SET NAMES utf8");	
	//$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return sql_fetch($sql);
}

function stock_cnt($mem_idx, $rel_idx){
	$com_idx = ($rel_idx ==0 ? $mem_idx : $rel_idx);
	$sql = "select sum(quantity) sum from part where (mem_idx = $com_idx or rel_idx = $com_idx ) and part_type <> '2'";
	$result=mysql_query($sql);
	$row = mysql_fetch_array($result);
	$tot_cnt = $row["sum"];
	//송장 발주까지 처리 된 부품의 개수
	$sql = "select sum(a.odr_quantity) sum from odr_det a 
			left outer join part b on a.part_idx = b.part_idx 
			inner join odr_history c on a.odr_idx = c.odr_idx and c.status = 18
			where (b.mem_idx =  $com_idx or b.rel_idx =  $com_idx ) and a.part_type <> '2'";
	$result=mysql_query($sql);
	$row = mysql_fetch_array($result);
	$odr_cnt = $row["sum"];
	return number_format($tot_cnt - $odr_cnt);
}

function get_odr_det($odr_idx, $fields='*'){
		return sql_fetch("select $fields from odr_det where odr_idx = trim('$odr_idx')");
}

function get_odr_det_each($odr_det_idx, $fields='*'){
		return sql_fetch("select $fields from odr_det where odr_det_idx = trim('$odr_det_idx')");
}

function get_odr_history($odr_history_idx, $fields='*'){
		return sql_fetch("select $fields from odr_history where odr_history_idx = trim('$odr_history_idx')");
}

function get_odr_history2($odr_idx, $fields='*'){
		return sql_fetch("select $fields from odr_history where odr_idx = trim('$odr_idx') and status=5");
}

function get_ship($ship_idx, $fields='*'){
		return sql_fetch("select $fields from ship where ship_idx = trim('$ship_idx')");
}

function get_fty_history($fty_history_idx, $fields='*'){
		return sql_fetch("select $fields from fty_history where fty_history_idx = trim('$fty_history_idx')");
}

function get_invoice($invoice_no, $fields='*'){
		return sql_fetch("select $fields from invoice where invoice_no = trim('$invoice_no')");
}

// mysql_query 와 mysql_error 를 한꺼번에 처리
function sql_query($sql, $error=TRUE)
{
    // Blind SQL Injection 취약점 해결
    $sql = trim($sql);
    // union의 사용을 허락하지 않습니다.
    $sql = preg_replace("#^select.*from.*[^\'\"]union[^\'\"].*#i", "select 1", $sql);
    // `information_schema` DB로의 접근을 허락하지 않습니다.
    $sql = preg_replace("#^select.*from.*[^\'\"]`?information_schema`?[^\'\"].*#i", "select 1", $sql);

    if ($error)
        $result = @mysql_query($sql) or die("<p>$sql<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : $_SERVER[PHP_SELF]");
    else
        $result = @mysql_query($sql);
    return $result;
}

	

// 쿼리를 실행한 후 결과값에서 한행을 얻는다.
function sql_fetch($sql, $error=TRUE)
{
    $result = sql_query($sql, $error);
    //$row = @sql_fetch_array($result) or die("<p>$sql<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : $_SERVER[PHP_SELF]");
    $row = sql_fetch_array($result);
    return $row;
}


// 결과값에서 한행 연관배열(이름으로)로 얻는다.
function sql_fetch_array($result)
{
    $row = @mysql_fetch_assoc($result);
    return $row;
}


// $result에 대한 메모리(memory)에 있는 내용을 모두 제거한다.
// sql_free_result()는 결과로부터 얻은 질의 값이 커서 많은 메모리를 사용할 염려가 있을 때 사용된다.
// 단, 결과 값은 스크립트(script) 실행부가 종료되면서 메모리에서 자동적으로 지워진다.
function sql_free_result($result)
{
    return mysql_free_result($result);
}

//랜덤숫자문자 얻기
Function RndomString($cnt)  {
	$ran= "";

	for( $i=0; $i<$cnt; $i++) //7자리만 출력

	{

		 if( rand(0,1) ) $ran .= rand( 0, 9 ); //숫자

		 else $ran .= strtoupper(chr(rand( 97, 122 ))); //영어소문자

	}

	return $ran;

}
//랜덤숫자문자 얻기
Function RndomNum($cnt)  {
	$ran= "";

	for( $i=0; $i<$cnt; $i++) //7자리만 출력
	{
		 if( strlen($ran)<$cnt ) $ran .= rand( 0, 9 ); //숫자

	}

	return $ran;

}

function ordinal($num)
{
    // Special case "teenth"
    if ( ($num / 10) % 10 != 1 )
    {
        // Handle 1st, 2nd, 3rd
        switch( $num % 10 )
        {
            case 1: return $num . 'st';
            case 2: return $num . 'nd';
            case 3: return $num . 'rd';  
        }
    }
    // Everything else is "nth"
    return $num . 'th';
}

function get_deposit_yn($session_mem_idx)
{
	$cnt = QRY_CNT("mybank", "and charge_type = 8 and (mem_idx = $session_mem_idx or rel_idx = $session_mem_idx)");
	return $cnt == 0 ? "N" : "Y";
}

function insert_invoice($invoice_no, $invoice_type, $mem_idx, $rel_idx, $odr_idx,$odr_det_idx,$log_ip){
		$sql = "insert into invoice set 
			invoice_no = '$invoice_no'
			,invoice_type = '$invoice_type'
			,mem_idx = '$mem_idx'
			,rel_idx = '$rel_idx'			
			,odr_idx = '$odr_idx'
			,odr_det_idx = '$odr_det_idx'
			,reg_date = now()
			,reg_ip= '$log_ip'";
		$conn = dbconn();	
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		return $result;
}


function GET_WhatsNew($ty,$viewty){
			$notin = $ty == "buy" ? "1,2,3,11,15":"15,16,18,19,20,21,22,23,24,29";
			$sql ="select * from (select status ,sell_mem_idx , 'odr' as tb_type ,reg_date from odr_history where ".$ty."_mem_idx = ".$_SESSION["MEM_IDX"]." and confirm_yn ='N' and reg_mem_idx<>".$_SESSION["MEM_IDX"]."
				union all
				select status ,sell_mem_idx , 'fty' as tb_type  ,reg_date FROM fty_history WHERE ".$ty."_mem_idx = ".$_SESSION["MEM_IDX"]." and confirm_yn ='N' and reg_mem_idx<>".$_SESSION["MEM_IDX"].") a where status not in ($notin) order by reg_date desc
				limit 1
				";
				//echo $sql;
			$result=mysql_query($sql);
			$rowcnt = mysql_num_rows($result);
			if ($rowcnt > 0 ) {
				$row = mysql_fetch_array($result);
				$status= replace_out($row["status"]);
				$sell_mem_idx= replace_out($row["sell_mem_idx"]);
				$tb_type= replace_out($row["tb_type"]);
				if($viewty=="whatsnew"){
				?>
				<a href="javascript:goMenuJump('<?=$status?>:<?=$sell_mem_idx?>:<?=$tb_type?>:Y');"><img src="/kor/images/btn_new_new.gif" alt="What’s New"></a>	
			<?
				}else{
					echo $status.":".$sell_mem_idx.":".$tb_type.":Y";
				}
			}else{
				if ($viewty=="whatsnew"){
					?>
					<a ><img src="/kor/images/btn_new_1.gif" alt="What’s New"></a>
					<?}
				}

	}



function openSheet($status, $etc1, $odr_idx,$etc_change,$odr_history_idx=""){
	
		

	if ($etc_change)
	{

		switch ($status) {
		   case "2":  //발주서
			 //$return_val = "<a href='javascript:openCommLayer(\"layer5\",\"30_05\",\"?odr_idx=".$odr_idx."&forread=Y\")'>".$etc1."</a>"; //JSJ
			 $return_val = "<a style='color:#00759e;text-decoration:underline;' href='javascript:openCommLayer(\"layer5\",\"30_05\",\"?sheets_no=".$etc1."&odr_idx=".$odr_idx."&forread=Y\")'>".$etc1."</a>"; //2016-04-19
			 break;
		   case "3":  //수정발주서
			 //$return_val = "<a href='javascript:openCommLayer(\"layer5\",\"12_07\",\"?odr_idx=".$odr_idx."&forread=Y\")'>".$etc1."</a>"; //JSJ
			 $return_val = "<a style='color:#00759e;text-decoration:underline;' href='javascript:openCommLayer(\"layer5\",\"12_07\",\"?sheets_no=".$etc1."&odr_idx=".$odr_idx."&forread=Y\")'>".$etc1."</a>"; //2016-04-18
			 break;
			case "5":  //결제완료
			 //$return_val = "<a href='javascript:openCommLayer(\"layer5\",\"12_07\",\"?odr_idx=".$odr_idx."&forread=Y\")'>".$etc1."</a>"; //JSJ
			 $return_val = "<a style='color:#00759e;text-decoration:underline;' href='javascript:openCommLayer(\"layer6\",\"payment_ok\",\"?odr_idx=".$odr_idx."&odr_history_idx=".$odr_history_idx."\")'>".$etc1."</a>"; //2016-04-18
			 break;
		   case "18": //송장
			 //$return_val = "<a href='javascript:openCommLayer(\"layer5\",\"30_09\",\"?odr_idx=".$odr_idx."&forread=Y\")'>".$etc1."</a>";  //JSJ
			 $return_val = "<a style='color:#00759e !important;text-decoration:underline;' href='javascript:openCommLayer(\"layer5\",\"30_09\",\"?sheets_no=".$etc1."&odr_idx=".$odr_idx."&odr_history_idx=".$odr_history_idx."&forread=Y\")'>".$etc1."</a>";
			 break;
		   case "21": //선적
			 //$return_val = "<a href='javascript:openCommLayer(\"layer5\",\"30_09\",\"?odr_idx=".$odr_idx."&forread=Y\")'>".$etc1."</a>";  //JSJ
			
			if($etc1 == "DHL" || $etc1 == "UPS" || $etc1 == "Fedex" || $etc1 == "TNT")
			{			
				$change_val = "<img src='/kor/images/icon_".strtolower($etc1).".gif' height=15>";
			}
			else
			{
				$change_val = $etc1;
			}
			
			 $return_val = "<a style='color:#00759e;text-decoration:underline;' href='javascript:openCommLayer(\"layer6\",\"alert_invoice\",\"?odr_idx=".$odr_idx."\")'>".$change_val."</a>";
			 
			 break;
			default:
				$return_val = $etc1;
			break;
		 }
	}
	else
	{
		switch ($status) {		
			
		   case 2:  //발주서
		   
			 //$return_val = "<a href='javascript:openCommLayer(\"layer5\",\"30_05\",\"?odr_idx=".$odr_idx."&forread=Y\")'>".$etc1."</a>"; //JSJ
			 $return_val = "<a style='color:#000 !important;text-decoration:underline;' href='javascript:openCommLayer(\"layer5\",\"30_05\",\"?sheets_no=".$etc1."&odr_idx=".$odr_idx."&forread=Y\")'>".$etc1."</a>"; //2016-04-19
			 break;
		   case "3":  //수정발주서
			 //$return_val = "<a href='javascript:openCommLayer(\"layer5\",\"12_07\",\"?odr_idx=".$odr_idx."&forread=Y\")'>".$etc1."</a>"; //JSJ
			 $return_val = "<a style='color:#000 !important;text-decoration:underline;' href='javascript:openCommLayer(\"layer5\",\"12_07\",\"?sheets_no=".$etc1."&odr_idx=".$odr_idx."&forread=Y\")'>".$etc1."</a>"; //2016-04-18
			 break;
			case "5":  //결제완료
			 //$return_val = "<a href='javascript:openCommLayer(\"layer5\",\"12_07\",\"?odr_idx=".$odr_idx."&forread=Y\")'>".$etc1."</a>"; //JSJ
			 $return_val = "<a style='color:#000;text-decoration:underline;' href='javascript:openCommLayer(\"layer6\",\"payment_ok\",\"?odr_idx=".$odr_idx."&odr_history_idx=".$odr_history_idx."\")'>".$etc1."</a>"; //2016-04-18
			 break;
		   case "18": //송장		   
			 //$return_val = "<a href='javascript:openCommLayer(\"layer5\",\"30_09\",\"?odr_idx=".$odr_idx."&forread=Y\")'>".$etc1."</a>";  //JSJ
			 $return_val = "<a style='color:#000;text-decoration:underline;' href='javascript:openCommLayer(\"layer5\",\"30_09\",\"?sheets_no=".$etc1."&odr_idx=".$odr_idx."&odr_history_idx=".$odr_history_idx."&forread=Y\")'>".$etc1."</a>";
			 break;
		   case "21": //선적
			 //$return_val = "<a href='javascript:openCommLayer(\"layer5\",\"30_09\",\"?odr_idx=".$odr_idx."&forread=Y\")'>".$etc1."</a>";  //JSJ
			 if($etc1 == "DHL" || $etc1 == "UPS" || $etc1 == "Fedex" || $etc1 == "TNT")
			{			
				$change_val = "<img src='/kor/images/icon_".strtolower($etc1).".gif' height=15>";
			}
			else
			{
				$change_val = $etc1;
			}

			 $return_val = "<a style='color:#000 !important;text-decoration:underline;' href='javascript:openCommLayer(\"layer6\",\"alert_invoice\",\"?odr_idx=".$odr_idx."\")'>".$change_val."</a>";
			 break;
			default:

				$return_val = $etc1;
			break;
		 }
	}
	return $return_val;
 }

 //사본생성 : 품목 상태 기록(Log) 2016-04-15
 function CP_To_Log($odr_idx, $doc_no){
	//odr : odr_status='99'
	$sql = "INSERT INTO odr (odr_no, imsi_odr_no, invoice_no, amend_no, amend_date, mem_idx, rel_idx, sell_mem_idx, sell_rel_idx, period, odr_status, turnkey_idx, accept_yn, cancel_accept_yn, ship_idx, fault_delivery_no, buyer_delivery_fee, faulty_delivery_fee, memo, save_yn, reg_date, status_edit_mem_idx, complete_yn, reg_ip, doc_no)
			SELECT odr_no, imsi_odr_no, invoice_no, amend_no, amend_date, mem_idx, rel_idx, sell_mem_idx, sell_rel_idx, period, '99', turnkey_idx, accept_yn, cancel_accept_yn, ship_idx, fault_delivery_no, buyer_delivery_fee, faulty_delivery_fee, memo, save_yn, reg_date, status_edit_mem_idx, complete_yn, reg_ip, '$doc_no' FROM odr WHERE odr_idx = $odr_idx
			";
	$conn = dbconn();	
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	$log_idx = mysql_insert_id();
	//odr_det : odr_idx=$log_idx
	$sql = "INSERT INTO odr_det (odr_idx, part_idx, part_type, odr_quantity, odr_stock, odr_price, supply_quantity, add_capa_quantity, add_quantity, fault_quantity, fault_method, fault_part_condition, fault_pack_condition1, fault_pack_condition2, fault_dc, fault_memo, ship_idx, agreement_no, agreement_reg_date, rnd_yn, rework_invoice, rework_date, refund_invoice, refund_date, non_com_invoice, non_com_date, compensation_invoice, compensation_date, access_invoice, access_date, amend_invoice, amend_date, testS_invoice, testS_date, testB_invoice, testB_date, test_report_no, test_report_date, part_condition, pack_condition1, pack_condition2, memo, file1, file2, file3, period, amend_yn, odr_status, rel_det_idx)
			SELECT $log_idx, part_idx, part_type, odr_quantity, odr_stock, odr_price, supply_quantity, add_capa_quantity, add_quantity, fault_quantity, fault_method, fault_part_condition, fault_pack_condition1, fault_pack_condition2, fault_dc, fault_memo, ship_idx, agreement_no, agreement_reg_date, rnd_yn, rework_invoice, rework_date, refund_invoice, refund_date, non_com_invoice, non_com_date, compensation_invoice, compensation_date, access_invoice, access_date, amend_invoice, amend_date, testS_invoice, testS_date, testB_invoice, testB_date, test_report_no, test_report_date, part_condition, pack_condition1, pack_condition2, memo, file1, file2, file3, period, amend_yn, '99', rel_det_idx
			FROM odr_det WHERE odr_idx = $odr_idx ORDER BY odr_det_idx ASC
			";
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
 }

 //2016-08-16 이미지 사이즈 비율에 맞게 조정
function IMG_RESIZE_ONLY($path, $img, $maxwidth, $maxheight){
	if($img){
		//$img는 이미지 경로(예:../images/photo.gif)
		$imgsize = getimagesize($path.$img);
		//가로, 또는 세로 크기 확인
		if($imgsize[0]>$maxwidth || $imgsize[1]>$maxheight){
			//가로형 이미지
			if($imgsize[0]<$imgsize[1]){
				$sumw = (100 * $maxheight) / $imgsize[1];
				$img_width = ceil(($imgsize[0] * $sumw) / 100);
				$img_height = $maxheight;
			}else{
				$sumw = (100 * $maxwidth) / $imgsize[0];
				$img_height = ceil(($imgsize[1] * $sumw) / 100);
				$img_width = $maxwidth;
			}
		}else{ //크지 않을 경우 원본 그대로..
			$img_width = $imgsize[0];
			$img_height = $imgsize[1];
		}
		$imgsize[0] = $img_width;
		$imgsize[1] = $img_height;
	}else{ //$img 없어...
		$imgsize[0] = $maxwidth;
		$imgsize[1] = $maxheight;
	}

	return $imgsize;
}

function getExchangeRate(){
	return get_any("exchange","exchange_out","idx = (SELECT max(idx) FROM exchange)");
}

function get_manage_email($nation){
	$email = get_any("member" , "email", "mem_idx = (SELECT mem_idx FROM `manage` WHERE assign_nation = '$nation')");
	$email =  ($email =="") ? get_any("member", "email","mem_id = 'parts_admin'"):$email;
	return $email;
}

function get_manager($nation){
	$manager = get_any("member" , "concat(mem_nm_en,' / ',pos_nm_en)", "mem_idx = (SELECT mem_idx FROM `manage` WHERE assign_nation = '$nation')");
	return $manager;
}

//시작 금액 소수점 자리 절삭 시작
function round_down($val,$d)
{
	$re_price = str_replace("$","",$val);

	
	if (str_replace("$","",$val)==(int)str_replace("$","",$re_price))
	{
		
		$price= $re_price;
		
	}
	else
	{
		
		$val_explode = explode('.', $val);
		
		if (strlen($val_explode[1]) >=5)
		{				

			$price = $val;
			if ($d==4)
			{		
				$price_sosu = substr($val_explode[1],0,4);
				$price = $val_explode[0].".".$price_sosu;
			}			
			else
			{
				$price_sosu = substr($val_explode[1],0,2);
				$price = $val_explode[0].".".$price_sosu;
			}
		}
		else
		{		

			$price = $val * pow(10,4);

			if ($d==4)
			{

				$price_sosu = substr($val_explode[1],0,4);			
				$price = substr_replace($price,'.',-4,0);
			}
			else
			{
				$price = substr_replace($price,'.',-4,0);
				$price = substr($price,0,-2);
			}
		}
	}
	
		
	return $price;
}
//시작 금액 소수점 자리 절삭 끝

/********************************************************************************************************************
*** 2017-01-09 : odr_idx 를 받아와서 odr_det 테이블의 데이터를 '송장' Log의 데이터로 Update
********************************************************************************************************************/
function Update_Invoce_Data($odr_idx){
	$invoice_no = get_any("odr", "invoice_no", "odr_idx=$odr_idx");
	$invo_idx = get_any("odr", "odr_idx", "odr_status='99' and doc_no='$invoice_no'");

	$qry =QRY_ODR_DET_LIST(0," and a.odr_idx=$invo_idx",0,"","asc");
	while($row = mysql_fetch_array($qry)){
		$part_idx = replace_out($row["part_idx"]);
		$odr_stock = replace_out($row["odr_stock"]);
		$odr_quantity = replace_out($row["odr_quantity"]);
		$odr_price = replace_out($row["odr_price"]);

		$sql = "UPDATE odr_det  SET 
				odr_stock = $odr_stock,
				odr_quantity = $odr_quantity,
				odr_price = $odr_price 
				WHERE odr_idx = $odr_idx AND part_idx=$part_idx";
		$result=mysql_query($sql);
	}
}
?>