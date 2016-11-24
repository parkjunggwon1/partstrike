<?

 ob_start();
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/fileuploader.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/class/class.meminfo.php";

$mem_email_yn = r_null($mem_email_yn,"N");

$dir_dest = "../..".$file_path; //파일 저장 폴더 지정
$mem_birth = $mem_birth1."-".$mem_birth2."-".$mem_birth3;

if ($nation =="1"){
	$dositxt =  '';
	$dositxt_en =  '';
}

if ($typ=="write"){
	if(!$nation){
		$nation = get_any("member", "nation","mem_idx='$rel_idx'");
		$rel_id = get_any("member", "mem_id","mem_idx='$rel_idx'");
	}

	//아이디 중복확인
	$use_email=get_want("member","mem_id"," and mem_id = '$mem_id' and rel_idx = '$rel_idx'");
	if ($use_email) {
		Page_Msg1("\'$mem_id\' 은(는) 이미 다른분이 사용중인 아이디이므로 사용이 불가합니다.");
		exit;
	}
	/** 파일 업로드 ******************************************/
	For ($i=1;$i<=1;$i++){
		$query_name = "file".$i; //input 파라메터 이름
		
		if($_FILES[$query_name]) {
			$FILE_1			= RequestFile("file".$i);
			
			$FILE_1_size	= $FILE_1[size];
			$maxSize = '5242880'; //5mb, 파일 용량 제한
			${"filename".$i} = uploadProc( $query_name, $dir_dest, $maxSize);
			
		}
	}
	//비밀번호 암호화작업
	$mem_pwd=md5($mem_pwd);

	if ($mem_type == "1" || $mem_type == "2" || $mem_type == "3"){ //개인/학생이 아니면 필요 없는 변수들
		$rel_nm="";
		$depart_nm="";
		$homepage_rel="";
		$birthday ="";
	}
	
	/*******************************************************/
	$sql = " insert into member set 
			mem_type =  '$mem_type'
			,mem_id =  '$mem_id'
			,mem_pwd =  '$mem_pwd'
			,nation =  '$nation'			
			,mem_nm =  '$mem_nm'
			,mem_nm_en =  '$mem_nm_en'
			,pos_nm =  '$pos_nm'
			,pos_nm_en =  '$pos_nm_en'
			,depart_nm =  '$depart_nm'
			,depart_nm_en =  '$depart_nm_en'
			,rel_nm =  '$rel_nm'
			,rel_nm_en =  '$rel_nm_en'
			,birthday =  '$birthday'
			,tel =  '$nation_nm$tel'
			,fax =  '$nation_nm$fax'			
			,hp =  '$nation_nm$hp'	
			,zipcode =  '$zipcode'	
			,dosi =  '$dosi'
			,dosi_en =  '$dosi_en'
			,dositxt =  '$dositxt'
			,dositxt_en =  '$dositxt_en'
			,sigungu =  '$sigungu'
			,sigungu_en =  '$sigungu_en'
			,addr =  '$addr'
			,addr_en =  '$addr_en'
			,addr_det =  '$addr_det'
			,addr_det_en =  '$addr_det_en'
			,email =  '$email'
			,homepage =  '$homepage'
			,homepage_rel =  '$homepage_rel'
			,skypeId =  '$skypeId'
			,rel_idx =  '$rel_idx'
			,rel_id =  '$rel_id'
			,reg_date =  '$log_date'
			,reg_ip =  '$log_ip'				
		";

		
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	if($result){
		$idx=mysql_insert_id(); 
		echo "SUCCESS:$idx";
		exit;
	}

}
if ($typ == "edit"){

			if ($mem_type ==0 && $show_assign_nation=="Y"){   //admin일 경우 nation 설정
				$sql = "delete from manage where mem_idx = ".$idx;
				$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
				$assign_nation = $_GET['assign_nation'];   
				if ($assign_nation){
					foreach($assign_nation as $value) {
					  $sql = "insert into manage set 
							  mem_idx =  '$idx'
							  ,assign_nation = '$value'
							  ,reg_date =  '$log_date'
							  ";
					  $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
					}
				}
			}
			if(!$nation){
				$nation = get_any("member", "nation","mem_idx=$rel_idx");
				$rel_id = get_any("member", "mem_id","mem_idx=$rel_idx");
			}

			if ($mem_pwd){
				//암호화 작업
				$mem_pwd=md5($mem_pwd);
				$pwd_param = ",mem_pwd =  '$mem_pwd'";
			}


	//	}
		/** 파일 업로드 ******************************************/
		For ($i=1;$i<=1;$i++){
			if (${"file".$i}){
				$query_name = "file".$i; //input 파라메터 이름
				
				if($_FILES[$query_name]) {
					$FILE_1			= RequestFile("file".$i);
					
					$FILE_1_size	= $FILE_1[size];
					$maxSize = '5242880'; //5mb, 파일 용량 제한
					${"filename".$i} = uploadProc( $query_name, $dir_dest, $maxSize);
					//echo $filename1;
				}

				if(${"file_o".$i}){
					$old_file=${"file_o".$i};
					if(file_exists("$file_path/$old_file")){
						unlink("$file_path/$old_file");
					}
				}
			}else{
				${"filename".$i} = ${"file_o".$i};
			}
		}
		/*******************************************************/
		if($mem_id =="parts_admin"){
			$mem_type = "0";
		}

		$sql="
			UPDATE
				member
			SET
				 mem_type =  '$mem_type'
				$pwd_param
				,nation =  '$nation'			
				,mem_nm =  '$mem_nm'
				,mem_nm_en =  '$mem_nm_en'
				,pos_nm =  '$pos_nm'
				,pos_nm_en =  '$pos_nm_en'
				,depart_nm =  '$depart_nm'
				,depart_nm_en =  '$depart_nm_en'
				,rel_nm =  '$rel_nm'
				,rel_nm_en =  '$rel_nm_en'
				,birthday =  '$birthday'
				,tel =  '$nation_nm$tel'
				,fax =  '$nation_nm$fax'			
				,hp =  '$nation_nm$hp'	
				,zipcode =  '$zipcode'	
				,dosi =  '$dosi'
				,dosi_en =  '$dosi_en'
				,dositxt =  '$dositxt'
				,dositxt_en =  '$dositxt_en'
				,sigungu =  '$sigungu'
				,sigungu_en =  '$sigungu_en'
				,addr =  '$addr'
				,addr_en =  '$addr_en'
				,addr_det =  '$addr_det'
				,addr_det_en =  '$addr_det_en'
				,email =  '$email'
				,homepage =  '$homepage'
				,homepage_rel =  '$homepage_rel'
				,skypeId =  '$skypeId'
				,rel_idx =  '$rel_idx'
				,rel_id =  '$rel_id'
			WHERE
				mem_idx='$idx'
		";

		$sql_part_nation="
			UPDATE
				part
			SET
				nation = '$nation'
			where 
				mem_idx='$idx'
		";
//echo $sql;
//exit;
		if ($rel_idx ==""){
			update_val("member","mem_type",$mem_type, "rel_idx", $idx);	
		}

		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		$result_part_nation = mysql_query($sql_part_nation,$conn) or die ("SQL Error : ". mysql_error());


		
		if($result){
			echo "SUCCESS:$idx";
			exit;
		}
	//}else{
	//	Page_Msg_Back("현재 비밀번호를 확인하세요");
	//}
}

if($typ=="join"){
		//가입시 기본 정보 등록
	$sql = "update member 
		set bank_user_name = '$bank_user_name'
		,bank_name = '$bank_name'
		,bank_account = '$bank_account'
		,bank_addr = '$bank_addr'
		,bank_tel = '$bank_tel'
		,swift_code = '$swift_code'
		,rout_no = '$rout_no'
		,iban_code = '$iban_code'
		,certi1open_yn = '$certi1open_yn'
		,certi2open_yn = '$certi2open_yn'
		where 
		mem_idx = '$rel_idx'";		
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

		//판매자 지정 운송 회사 저장
		
			$ass1_idx = get_any("assign", "assign_idx", "rel_idx=$rel_idx and assign_type = 1");
			if ($ass1_idx){ // update
				$sql = "update assign 
						set o_company_idx = '$o_company_idx1'
						, i_company_idx = '$i_company_idx1'
						where assign_idx = $ass1_idx";
			}else{ 
				if ($o_company_idx1 || $i_company_idx1){
				 //insert
				$sql = "insert into assign(rel_idx , assign_type ,  o_company_idx,  i_company_idx,  sort, reg_date )  
				values($rel_idx, 1 ,'o_company_idx1' , 'i_company_idx1' ,  1 , now())";	
				}
			}		
			$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		
		
		//지정 운임 저장		

		$asn_idx = $_POST[assign_idx];
		$o_idx = $_POST[o_company_idx2];
		$i_idx = $_POST[i_company_idx2];
		$o_co = $_POST[o_cost];
		$i_co = $_POST[i_cost];
		

			


		for($i=0; $i<count($asn_idx); $i++){	
			$nationVal = ($i == 0)? ", nation = '$nation'":"";
			$o_Val = ($o_idx[$i])? ",o_company_idx = $o_idx[$i], o_cost = '$o_co[$i]'":"";
			$i_Val = ($i_idx[$i])? ",i_company_idx = $i_idx[$i], i_cost = '$i_co[$i]'":"";
			if (trim($asn_idx[$i])!= ""){		//update		
				$sql = "update assign set 
						sort = ($i+1)
						$o_Val
						$i_Val						
						$nationVal						
						where assign_idx = $asn_idx[$i]";
						echo $sql;
			}else{   //insert				
				$sql = "insert into assign set 
						rel_idx =  '$rel_idx'
						,assign_type =  '2'
						$o_Val
						$i_Val						
						$nationVal	
						,sort =   ($i+1) 
						,reg_date =   now() ";				
			}
		//	echo $sql;
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());			
		 }

		if($result){
			if ($_SESSION["MEM_IDX"]) { 
				Page_Parent_Msg_Url1("정보 저장이 성공적으로 이루어 졌습니다.","/kor/");
			}else{
				Page_Parent_Msg_Url1("회원가입이 성공적으로 이루어 졌습니다. 로그인 후 서비스를 이용하세요.","/kor/");
			}
		}

}

if($typ=="login"){
	//로그인처리
	if ($mem_id){ //직원 또는 학생 id를 입력 한 사람이면 개인. 
		$sql = "select * from member where rel_id = '$rel_id' and mem_id = '$mem_id'";// and mem_type = '$mem_type'";
		echo $sql;
	}else{  //입력 안했으면 회사나 단체.		
		if ($rel_id =="parts_admin") { $top_mem_type ="0";}

		$sql = "select * from member where mem_id = '$rel_id' and mem_type = '$top_mem_type'";		
	}

	//	echo $sql;
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	$row=mysql_fetch_array($result);
	
	$real_mem_pwd = $row["mem_pwd"];
	$real_mem_idx = $row["mem_idx"];
	$real_mem_id = $row["mem_id"];
	$real_mem_type = $row["mem_type"];	
	$real_rel_idx = $row["rel_idx"];
	$real_mem_nm = $row["mem_nm"];	
	$real_pos_nm = $row["pos_nm"];
	$real_mem_nm_en = $row["mem_nm_en"];	
	$real_pos_nm_en = $row["pos_nm_en"];
	$real_nation = $row["nation"];
	$real_dosi = $row["dosi"];
	$real_del = $row["del"];
	
	if ($real_rel_idx > 0){
		$real_rel_nm = get_any("member", "mem_nm", "mem_idx = ".$row["rel_idx"]);
	}
	//비밀번호 암호화작업
	$mem_pwd_im = $mem_pwd;
	$mem_pwd=md5($mem_pwd);
	if($real_del =="1"){
		Page_Msg_Need1("탈퇴처리 된 회원입니다.");
	}elseif($real_mem_pwd==$mem_pwd){	
		setcookie("mem_type_savd", "",-1,"/");
	//	echo $real_mem_type;
	//	exit;
		if($rel_id_ck=="o"){
			setcookie("mem_type_savd", $real_mem_type, time() + (86400 * 3), "/");
			setcookie("Crel_idx", $rel_idx,-1,"/");
			setcookie("rel_id_savd", $rel_id, time() + (86400 * 3), "/");}else{setcookie("rel_id_savd","",time()-3600,"/");
		} // 쿠키삭제 // 86400 = 1 day
		if($mem_id_ck=="o"){setcookie("mem_id_savd", $mem_id, time() + (86400 * 3), "/"); }else{ setcookie("mem_id_savd","",time()-3600,"/");} // 86400 = 1 day
		if($mem_pwd_ck=="o"){setcookie("mem_pwd_savd", $mem_pwd_im, time() + (86400 * 3), "/"); }else{ setcookie("mem_pwd_savd","",time()-3600,"/");} // 86400 = 1 day
		
		// 쿠키 생성
		$_SESSION["MEM_IDX"]=$real_mem_idx;			
		$_SESSION["MEM_ID"]=$real_mem_id;		
		$_SESSION["MEM_TYPE"]=$real_mem_type;		
		$_SESSION["REL_IDX"]=$real_rel_idx;		
		$_SESSION["MEM_NM"]=$real_mem_nm;	
		$_SESSION["POS_NM"]=$real_pos_nm;		
		$_SESSION["MEM_NM_EN"]=$real_mem_nm_en;	
		$_SESSION["POS_NM_EN"]=$real_pos_nm_en;	
		$_SESSION["NATION"]=$real_nation;	
		$_SESSION["DOSI"]=$real_dosi;	
		$_SESSION["COM_IDX"]=$real_rel_idx=="0"?$real_mem_idx:$real_rel_idx;
		//보증금 납입 여부 session에 저장			
		$_SESSION["DEPOSIT"] = get_deposit_yn($real_rel_idx == 0 ? $real_mem_idx : $real_rel_idx);

		if ($_SESSION["MEM_ID"]){
			plushit("member","login_count","mem_idx",$real_mem_idx);
			update_want("member", "  login_date ='$log_date' "," and mem_idx='$real_mem_idx'");
			Page_Parent_Url("/kor/");
			exit;
		}
	}else {
		Page_Msg_Need1("아이디와 비밀번호를 정확하게 입력하세요.");
	}
}
if($typ=="sns_login"){
	//로그인처리
	$mem_id=$_SESSION['sns_email'];

	$sql = "SELECT * FROM member WHERE mem_email =  '$mem_id' ";
	//echo $sql;
	//exit;
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	$row=mysql_fetch_array($result);

	$real_mem_idx = $row["mem_idx"];
	$real_mem_id = $row["mem_email"];
	$real_mem_name = $row["mem_name"];
	
	if($real_mem_idx){
		// 쿠키 생성
		$_SESSION["MEM_IDX"]=$real_mem_idx;			
		$_SESSION["MEM_ID"]=$real_mem_id;
		$_SESSION["MEM_EMAIL"]=$real_mem_id;
		$_SESSION["MEM_NAME"]=$real_mem_name;				
		$_SESSION["MEM_LEVEL"]=	$real_mem_level;
		if ($_SESSION["MEM_ID"]){
			plushit("member","login_count","mem_idx",$real_mem_idx);
			Page_Parent_Msg_Url1("$real_mem_name님, 환영합니다!","/kor/");
			exit;
		}
		
		
	} else {
		Page_Msg_Url1("일치하는 정보가 없습니다.","/members/login.php");
	}
}

if($typ=="find"){
	//로그인처리
	$sql = "SELECT * FROM member WHERE mem_email = '$mem_email'";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	$cnt=mysql_num_rows($result);

	
	if ($cnt > 0 ) {
		include $_SERVER["DOCUMENT_ROOT"]."/include/mail_function.php";
		while($row = mysql_fetch_array($result)){
			$real_mem_pwd = $row["mem_pwd"];
			$real_mem_idx = $row["mem_idx"];
			$real_mem_id = $row["mem_id"];
			$real_mem_email = $row["mem_email"];
			$real_mem_name = $row["mem_name"];

			$tomail = $real_mem_email;
			$frommail = "info@paulnmark.com";  //보내는 사람 메일
			$subject = "[".$sitename."] ".$real_mem_name." 님의 회원정보입니다.";  //제목
			$bodyText = "&nbsp;";  //text용 본문 '"H" -> html발송 , 이외는 텍스트 발송
			
			include $_SERVER["DOCUMENT_ROOT"]."/include/mail_content.php";
			
			//보내는사람이름,보내는사람이메일,받는사람이메일,제목,내용,1
			mailer('paulandmark', $frommail, $tomail, $subject, $mail_content, 1);
		}
		Page_Parent_Msg_Url1("이메일로 발송하였습니다","/kor/member/login.php?subNum=1");
		exit;

	}else{
			Page_Msg1("회원가입시 이메일을 정확하게 입력하세요.");
	}
}
if ($typ=="impship"){
	if($idx){	//impship_idx가 존재하면 update
		$sql = "update impship set
				company_idx =  '$company_idx'
				,account_no =  '$account_no'					
				where impship_idx= $idx
				";
	}else{  //없으면 insert
		$sql = " insert into impship set 
				rel_idx =  '$rel_idx'
				,company_idx =  '$company_idx'
				,account_no =  '$account_no'					
			";			
	}	
	//echo $sql;
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		if($result){
			$idx=mysql_insert_id(); 
			echo "SUCCESS:$idx";
			exit;
		}

}

if ($typ=="agency"){

	$agency_idx = get_want("agency","idx"," and agency_idx='0' and agency_name='$agency_name'");
	if(!$agency_idx){	
		if($idx){
				$sql = "update agency set
					mem_idx =  '$mem_idx'
					,agency_idx =  '$agency_idx'
					,agency_name =  '$agency_name'					
					where idx= $idx 
					";

		}else{
			$sql = " insert into agency set 
						rel_idx =  '".$_SESSION["COM_IDX"]."'
						,mem_idx =  '$mem_idx'
						,nation =  '".$_SESSION["NATION"]."'
						,agency_idx =  '$agency_idx'
						,agency_name =  '$agency_name'					
					";		
		}
	}else{  //없으면 insert
		if($idx){	//agency_idx가 존재하면 update
			$sql = "update agency set
					mem_idx =  '$mem_idx'
					,agency_idx =  '$agency_idx'
					,agency_name =  '$agency_name'					
					where idx= $idx and agency_idx!='0'
					";
		}else{ 
			$sql = " insert into agency set 
					rel_idx =  '$rel_idx'
					,mem_idx =  '$mem_idx'
					,nation =  '".$_SESSION["NATION"]."'
					,agency_idx =  '$agency_idx'
					,agency_name =  '$agency_name'					
				";		
			
		}
	}	

	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		if($result){
			$idx=mysql_insert_id(); 
			echo "SUCCESS:$idx";
			exit;
		}
	
}

if($typ =="del"){
	if($tbl=="member"){
		$c="mem_";
	}else if($tbl=="agency"){
		$c="";
	}else{
		$c=$tbl."_";
	}
	$sql = "delete from $tbl where ".$c."idx = ".$idx;
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		if($result){
			echo "SUCCESS";
			exit;
		}
}

if ($typ=="imgfileup" || $typ =="imgfiledel"){

	$i = $no;
	$filename ="";
		if ($typ =="imgfileup"){
			/** 파일 업로드 ******************************************/
			$query_name = "file".$i; //input 파라메터 이름		
			//echo $query_name.":::::::".$dir_dest;
			//exit;

			if($_FILES[$query_name]) {
				$FILE_1			= RequestFile("file".$i);			
				$FILE_1_size	= $FILE_1[size];
				$maxSize = '5242880'; //5mb, 파일 용량 제한
				$filename = uploadProc( $query_name, $dir_dest, $maxSize);		
				if ($i ==1 ) { //logo일 경우에는 thumnail 만들기
					make_thumbnail("../../upload/", $filename, "75", "18", "100");
				}

			}
		}		
		if(${"file_o".$i}){
			$old_file=${"file_o".$i};
			if(file_exists("$dir_dest/$old_file")){
				unlink("$dir_dest/$old_file");
			}
		}
		 $column_nm = getColumn_nm($i);	
		 $column_nm ="file".$column_nm;
		 $sql = "update member set 
					$column_nm = '$filename' 
					where mem_idx = $rel_idx";
	//				echo $sql;
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		if($result){
			if ($typ=="imgfileup"){
				Page_ImgUpload($no, $filename);
				exit;
			}else{
				echo "SUCCESS";
				exit;
			}
		}
}

//2016-06-20 : 국제배송 배송비 저장
if($typ=="inter_shipping"){

	$data = array();  //json

	$sql = " insert into freight_charge set
			rel_idx =  '$rel_idx'
			,trade_type =  '$trade_type'
			,f_dest_idx =  '$f_dest_idx'
			,t_company_idx =  '$t_company_idx'
			,f_charge =  '$f_charge'
		";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	$data["freight_idx"] = mysql_insert_id(); 
	if($result){
		$data["err"] = "OK";
	}else{
		$data["err"] = $result;
	}
	//json
	$output = json_encode($data);
	echo $output;
	exit;
}

if($typ=="freight_nation"){

	echo GF_GET_ASSIGN_DATA2($rel_idx,0); //class.meminfo.php

}

if($typ=="freight_citi"){

	echo GF_GET_ASSIGN_DATA2($rel_idx,1); //class.meminfo.php

}

if($typ=="nation_list"){
?>
	<tr>
		<td class="t-lt">
			<ul class="related-nation-list">
				<? //국가명 반복(추가된것 제외)
				$result = QRY_FREIGHT_NATION2($rel_idx);
				for ($i=0; $row = mysql_fetch_array($result); $i++) {
					$nation = $row["code_desc"];
					$na_code = $row["dtl_code"];
					$saved_cnt = QRY_CNT("freight_charge"," and (f_dest_idx='$na_code' or f_dest_idx LIKE '%,$na_code,%' or f_dest_idx LIKE '%,$na_code' or f_dest_idx LIKE '$na_code,%') ");  //기 등록여부
				?>
				<li>
					<label class="ipt-chk chk2" lang="en">
						<input name="nation[]" type="checkbox" value="<?=$na_code;?>" <?=$saved_cnt>0? "disabled":"";?> onClick="chk_nation();">
						<span></span><?=$nation;?>
					</label>
				</li>
				<? } ?>
			</ul>
		</td>
		<td id="DLVR_CO" colspan="2" class="t-lt">
			<div id="dlvr_co_first" style="width:220px; margin-left:30px;" class="t-lt">
			<div class="select type5" lang="en" style="width:120px">
				<label class="c-red"><?=($o_company_idx)?GF_Common_GetSingleList("DLVR",$o_company_idx):"";?></label>
				<?=GF_Common_SetComboList("t_company[]", "DLVR", "", 1, "True",  "", $o_company_idx , "");?>
			</div>&nbsp;
			$ <input type="text" name="n_charge[]" id="n_charge[]" class="i-txt3 c-red onlynum numfmt" value="<?=$o_cost?>" style="width:48px">
			<button type="button" name="add_ncharge" id="add_ncharge" class="c-red" style="margin-left:5px;" OnClick="add_dlvr();">+</button>
			</div>
		</td>
		<td>
			<img src="/kor/images/btn_add21.gif" id="nation_add">
		</td>
	</tr>

<?
}

if($typ=="citi_list"){
?>
						<tr>
							<td class="t-lt">
								<ul class="related-nation-list">
									<? //도시명 반복(추가된것 제외)
									$na_code = get_any("member", "nation","mem_idx='$rel_idx'");
									$result = QRY_FREIGHT_CITY2($rel_idx, $na_code);
									for ($i=0; $row = mysql_fetch_array($result); $i++) {
										$citi = $row["code_desc"];
										$ct_code = $row["dtl_code"];
										$saved_cnt = QRY_CNT("freight_charge"," and (f_dest_idx='$ct_code' or f_dest_idx LIKE '%,$ct_code,%' or f_dest_idx LIKE '%,$ct_code' or f_dest_idx LIKE '$ct_code,%') ");  //기 등록여부
									?>
									<li>
										<label class="ipt-chk chk2" lang="ko">
											<input name="citi[]" type="checkbox" value="<?=$ct_code;?>" <?=$saved_cnt>0? "disabled":"";?> onClick="chk_citi();">
											<span></span><?=$citi;?>
										</label>
									</li>
									<? } ?>
								</ul>
							</td>
							<td id="DLDO_CO" colspan="2" class="t-rt">
								<div id="dldo_co_first" style="width:220px; margin-left:30px;" class="t-lt">
									<div class="select type5" lang="en" style="width:142px">									
										<label class="c-red"><?=($i_company_idx)?GF_Common_GetSingleList("DLDO",$i_company_idx):"";?></label>
										<?=GF_Common_SetComboList("c_company[]", "DLDO", get_any("member", "nation", "mem_idx=$rel_idx"), 2, "True",  "", $i_company_idx , "");?>
									</div>
									$ <input type="text" name="c_charge[]" id="c_charge[]" class="i-txt3 c-red onlynum numfmt" value="<?=$o_cost?>" style="width:48px">
									&nbsp;<button type="button" name="add_ncharge" id="add_ncharge" class="c-red" OnClick="add_dldo(<?=get_any("member", "nation", "mem_idx=$rel_idx");?>);">+</button>
								</div>
							</td>
							<td>
								<img src="/kor/images/btn_stock_save_1.gif" id="citi_add">
							</td>
						</tr>
<!--
	<tr>
		<td class="t-lt">
			<ul class="related-nation-list">
				<? //도시명 반복(추가된것 제외)
				$na_code = get_any("member", "nation","mem_idx='$rel_idx'");
				$result = QRY_FREIGHT_CITY2($rel_idx, $na_code);
				for ($i=0; $row = mysql_fetch_array($result); $i++) {
					$citi = $row["code_desc"];
					$ct_code = $row["dtl_code"];
					$saved_cnt = QRY_CNT("freight_charge"," and (f_dest_idx='$ct_code' or f_dest_idx LIKE '%,$ct_code,%' or f_dest_idx LIKE '%,$ct_code' or f_dest_idx LIKE '$ct_code,%') ");  //기 등록여부
				?>
				<li>
					<label class="ipt-chk chk2" lang="ko">
						<input name="citi[]" type="checkbox" value="<?=$ct_code;?>" <?=$saved_cnt>0? "disabled":"";?> onClick="chk_citi();">
						<span></span><?=$citi;?>
					</label>
				</li>
				<? } ?>
			</ul>
		</td>
		<td id="DLDO_CO" class="t-rt">
			<div class="select type5" lang="en" style="width:142px">									
				<label class="c-red"><?=($i_company_idx)?GF_Common_GetSingleList("DLDO",$i_company_idx):"";?></label>
				<?=GF_Common_SetComboList("c_company[]", "DLDO", get_any("member", "nation", "mem_idx=$rel_idx"), 2, "True",  "", $i_company_idx , "");?>
			</div>
		</td>
		<td id="DLDO_CH" class="t-lt">
			$ <input type="text" name="c_charge[]" id="c_charge[]" class="i-txt3 c-red onlynum numfmt" value="<?=$o_cost?>" style="width:48px">
			&nbsp;<button type="button" name="add_ncharge" id="add_ncharge" class="c-red" OnClick="add_dldo(<?=get_any("member", "nation", "mem_idx=$rel_idx");?>);">+</button>
		</td>
		<td>
			<img src="/kor/images/btn_stock_save_1.gif" id="citi_add">
		</td>
	</tr>
	-->
<?
} //end of citi_list

if($typ=="dlvr_co"){
?>
	<div style="width:220px; margin-left:30px;" class="t-lt">
	<div class="select type5" lang="en" style="width:120px">
		<label class="c-red"><?=($o_company_idx)?GF_Common_GetSingleList("DLVR",$o_company_idx):"";?></label>
		<?=GF_Common_SetComboList("t_company[]", "DLVR", "", 1, "True",  "", $o_company_idx , "");?>
	</div>&nbsp;
	$ <input type="text" name="n_charge[]" id="n_charge[]" class="i-txt3 c-red onlynum numfmt" value="<?=$o_cost?>" style="width:48px">
	&nbsp<button type="button" name="remove_dlvr" id="remove_dlvr" class="c-red" style="margin-left:5px;">-</button>
	</div>
<?
}//end of dlvr_co

//국제배송비 등록 : 수정양식에서의 배송회사 추가
if($typ=="edlvr_co"){
?>
	<div style="width:220px; margin-left:30px;" class="t-lt">
	<div class="select type5" lang="en" style="width:120px">
		<label class="c-red"><?=($o_company_idx)?GF_Common_GetSingleList("DLVR",$o_company_idx):"";?></label>
		<?=GF_Common_SetComboList("e_company[]", "DLVR", "", 1, "True",  "", $o_company_idx , "");?>
	</div>&nbsp;
	$<input type="text" name="e_charge[]" id="e_charge[]" class="i-txt3 c-red onlynum numfmt" value="<?=$o_cost?>" style="width:48px">
	<button type="button" name="remove_edlvr" id="remove_edlvr" idx="<?=$idx;?>" class="c-red" style="margin-left:5px;">-</button>
	</div>
<?
}//end of edlvr_co

//국내배송비 배송업체 추가
if($typ=="dldo_co"){
?>
	<div style="width:220px; margin-left:30px;" class="t-lt">
		<div class="select type5" lang="en" style="width:142px">									
			<label class="c-red"><?=($i_company_idx)?GF_Common_GetSingleList("DLDO",$i_company_idx):"";?></label>
			<?=GF_Common_SetComboList("c_company[]", "DLDO", get_any("member", "nation", "mem_idx=$rel_idx"), 2, "True",  "", $i_company_idx , "");?>
		</div>
		$ <input type="text" name="c_charge[]" id="c_charge[]" class="i-txt3 c-red onlynum numfmt" value="<?=$o_cost?>" style="width:48px">
		&nbsp;<button type="button" name="remove_dldo" id="remove_dldo" class="c-red">-</button>
	</div>
<?
}//end of dlvr_co

//국내배송비 수정폼 배송업체 추가
if($typ=="edldo_co"){
?>
	<div style="width:220px; margin-left:30px;" class="t-lt">
		<div class="select type5" lang="en" style="width:142px">									
			<label class="c-red"><?=($i_company_idx)?GF_Common_GetSingleList("DLDO",$i_company_idx):"";?></label>
			<?=GF_Common_SetComboList("d_company[]", "DLDO", get_any("member", "nation", "mem_idx=$rel_idx"), 2, "True",  "", $i_company_idx , "");?>
		</div>
		$ <input type="text" name="d_charge[]" id="d_charge[]" class="i-txt3 c-red onlynum numfmt" value="<?=$o_cost?>" style="width:48px">
		&nbsp;<button type="button" name="remove_dldo" id="remove_dldo" class="c-red">-</button>
	</div>
<?
}//end of dlvr_co

//2016-07-24 : 배송비 등록내용 삭제
if($typ=="del_freight"){

	$sql = "DELETE FROM freight_charge WHERE freight_idx=$idx";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

	echo GF_GET_ASSIGN_DATA2($rel_idx,$trade_type); //class.meminfo.php
}


//2016-07-24 : 배송비 등록내용 수정 폼***************************************************************************************************************************************
if($typ=="edit_freight"){
	if($trade_type==0){
		//국제 배송(국가)
		?>
		<td class="t-lt">
			<ul class="related-nation-list">
				<? //국가명 반복(추가된것 제외)
				$result = QRY_FREIGHT_NATION2($rel_idx);
				for ($i=0; $row = mysql_fetch_array($result); $i++) {
					$nation = $row["code_desc"];
					$na_code = $row["dtl_code"];
					$saved_cnt = QRY_CNT("freight_charge"," and freight_idx=$idx and (f_dest_idx='$na_code' or f_dest_idx LIKE '%,$na_code,%' or f_dest_idx LIKE '%,$na_code' or f_dest_idx LIKE '$na_code,%') ");  //현 레코드 등록여부
					$saved_cnt2 = QRY_CNT("freight_charge"," and freight_idx != $idx and (f_dest_idx='$na_code' or f_dest_idx LIKE '%,$na_code,%' or f_dest_idx LIKE '%,$na_code' or f_dest_idx LIKE '$na_code,%') ");  //타 레코드 등록여부
				?>
				<li>
					<label class="ipt-chk chk2" lang="en">
						<input name="e_nation[]" type="checkbox" value="<?=$na_code;?>" <?=$saved_cnt>0? "checked class='checked'":"";?> <?=$saved_cnt2>0? "disabled":"";?> onClick="chk_nation();">
						<span></span><?=$nation;?>
					</label>
				</li>
				<? }//end of for ?>
			</ul>
		</td>
		<?
		//운송비 등록정보
		$t_company_idx = get_any("freight_charge", "t_company_idx","freight_idx='$idx'");
		$f_charge =get_any("freight_charge", "f_charge","freight_idx='$idx'");
		$ex_company = explode(",", $t_company_idx);
		$ex_charge = explode(",", $f_charge);
		?>
		<td id="DLVR_CO_<?=$idx;?>" colspan="2" class="t-lt">
			<?
			//등록 배송비 반복
			$dlvr_len = count($ex_company);
			for($k=0; $ex_company[$k]; $k++){
			?>
			<div id="<?=($k==0)? "edlvr_co_first":"edlvr_co_".$idx;?>" style="width:220px; margin-left:30px;" class="t-lt">
				<div class="select type5" lang="en" style="width:120px">
					<label class="c-red"><?=GF_Common_GetSingleList("DLVR",$ex_company[$k]);?></label>
					<?=GF_Common_SetComboList("e_company[]", "DLVR", "", 1, "True",  "", $ex_company[$k] , "");?>
				</div>&nbsp;
				$<input type="text" name="e_charge[]" id="e_charge[]" class="i-txt3 c-red onlynum numfmt" value="<?=$ex_charge[$k];?>" style="width:48px">
				<?if($k==0 && $dlvr_len<4){?>
				&nbsp;<button type="button" name="add_echarge" id="add_echarge" class="c-red" OnClick="add_edlvr(<?=$idx;?>);">+</button>
				<?}elseif($k>0){?>
				&nbsp;<button type="button" name="remove_edlvr" id="remove_edlvr" idx="<?=$idx;?>" class="c-red">-</button>
				<?}?>
			</div>
			<?}//end of for?>
		</td>
		<td>
			<button type="button" class="edit_s" idx="<?=$idx;?>" trade_type="<?=$trade_type;?>"><img src="/kor/images/btn_stock_save.gif" alt="저장"></button>
		</td>
		<?
	}else{
		//국내 배송(도시) ---------------------------------------------------------------------------------------------------
	?>
		<td class="t-lt">
			<ul class="related-nation-list">
				<? //도시명 반복(추가된것 제외)
				$na_code = get_any("member", "nation","mem_idx='$rel_idx'");
				$result = QRY_FREIGHT_CITY2($rel_idx, $na_code);
				for ($i=0; $row = mysql_fetch_array($result); $i++) {
					$citi = $row["code_desc"];
					$ct_code = $row["dtl_code"];
					//현 레코드 등록여부
					$saved_cnt = QRY_CNT("freight_charge"," and freight_idx=$idx and (f_dest_idx='$ct_code' or f_dest_idx LIKE '%,$ct_code,%' or f_dest_idx LIKE '%,$ct_code' or f_dest_idx LIKE '$ct_code,%') ");
					//타 레코드 등록여부
					$saved_cnt2 = QRY_CNT("freight_charge"," and freight_idx!=$idx and (f_dest_idx='$ct_code' or f_dest_idx LIKE '%,$ct_code,%' or f_dest_idx LIKE '%,$ct_code' or f_dest_idx LIKE '$ct_code,%') ");
				?>
				<li>
					<label class="ipt-chk chk2" lang="ko">
						<input name="d_citi[]" type="checkbox" value="<?=$ct_code;?>" <?=$saved_cnt>0? "checked class='checked'":"";?> <?=$saved_cnt2>0? "disabled":"";?> onClick="chk_citi();">
						<span></span><?=$citi;?>
					</label>
				</li>
				<? } ?>
			</ul>
		</td>
		<?
		//운송비 등록정보
		$t_company_idx = get_any("freight_charge", "t_company_idx","freight_idx='$idx'");
		$f_charge =get_any("freight_charge", "f_charge","freight_idx='$idx'");
		$ex_company = explode(",", $t_company_idx);
		$ex_charge = explode(",", $f_charge);
		?>
		<td id="DLDO_CO_<?=$idx;?>" colspan="2" class="t-rt">
			<?
			//등록 배송비 반복
			$dlvr_len = count($ex_company);
			for($k=0; $ex_company[$k]; $k++){
			?>
				<div id="<?=($k==0)? "edldo_co_first":"edldo_co_".$idx;?>" style="width:220px; margin-left:30px;" class="t-lt">
					<div class="select type5" lang="en" style="width:142px">									
						<label class="c-red"><?=GF_Common_GetSingleList("DLDO",$ex_company[$k]);?></label>
						<?=GF_Common_SetComboList("d_company[]", "DLDO", get_any("member", "nation", "mem_idx=$rel_idx"), 2, "True",  "", $ex_company[$k] , "");?>
					</div>
					$ <input type="text" name="d_charge[]" id="d_charge[]" class="i-txt3 c-red onlynum numfmt" value="<?=$ex_charge[$k];?>" style="width:48px">
					<?if($k==0 && $dlvr_len<4){?>
					&nbsp;<button type="button" name="add_dcharge" id="add_dcharge" class="c-red" OnClick="add_edldo(<?=$idx;?>);">+</button>
					<?}elseif($k>0){?>
					&nbsp;<button type="button" name="remove_dldo" id="remove_dldo" idx="<?=$idx;?>" class="c-red">-</button>
					<?}?>
					<!--
					&nbsp;<button type="button" name="add_dcharge" id="add_dcharge" class="c-red" OnClick="add_dldo(<?=get_any("member", "nation", "mem_idx=$rel_idx");?>);">+</button>
					-->
				</div>
			<?}//등록배송비 반복 끝?>
		</td>
		<td>
			<button type="button" class="edit_sd" idx="<?=$idx;?>" trade_type="<?=$trade_type;?>"><img src="/kor/images/btn_stock_save.gif" alt="저장"></button>
		</td>
	<?
	}
}
//2016-07-24 : 배송비 수정내용 Update *************************************************************************************************************************
if($typ=="ud_freight"){

	$data = array();  //json

	$sql = " Update freight_charge set
			f_dest_idx =  '$f_dest_idx'
			,t_company_idx =  '$t_company_idx'
			,f_charge =  '$f_charge'
			WHERE freight_idx = $idx
		";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

	$data["idx"] = $idx;

	if($result){
		$data["err"] = "OK";
	}else{
		$data["err"] = $result;
	}
	//json
	$output = json_encode($data);
	echo $output;
	exit;
}
?>
