<?
 ob_start();
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/fileuploader.php";
?>
<?
if (!$_SESSION["MEM_IDX"]){
	ReopenLayer("layer6","alert","?alert=sessionend");
	exit;
}
$dir_dest = "../..".$file_path; //파일 저장 폴더 지정
$content=replace_in(str_replace("\r\n", "<br/>" ,$content));

if ($typ=="write"){
	/** 파일 업로드 ******************************************/
	For ($i=1;$i<=5;$i++){
		$query_name = "file".$i; //input 파라메터 이름
		if($_FILES[$query_name]) {
			$FILE_1			= RequestFile("file".$i);
			
			$FILE_1_size	= $FILE_1[size];
			$maxSize = '5242880'; //5mb, 파일 용량 제한
			${"filename".$i} = uploadProc( $query_name, $dir_dest, $maxSize);
			//echo $filename1;
		}
	}
	/*******************************************************/
	// bd_send_idx : 쪽지를 받는 회원 idx  받는사람이 PARTStrike인경우(관리자) : 이 값이 0 ?
	// bd_address : PARTStrike관리자에게 반품 쪽지 보낼때 Invoice No를 따로 저장해야 해서 그 번호 저장소로 사용함.
	if (!$bd_send_idx){$bd_send_idx = 0;}
	$sql="
		INSERT INTO board set 
			bd_gubun ='".$mode."'
			, bd_mem_name ='".$_SESSION["MEM_NM"]."'
			, bd_mem_idx ='".$_SESSION["MEM_IDX"]."'
			, bd_mem_id='".$_SESSION["MEM_ID"]."' 
			, bd_mem_nation='".$_SESSION["NATION"]."' 
			, bd_send_idx='".$bd_send_idx."' 
			, bd_title		= '".$title."'
			, bd_content	= '".$content."'
			, bd_secret		= '".$secret."'
			, bd_address	= '".$address."'
			, reg_date		= '$log_date'
			, reg_ip		= '$log_ip'
		";
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		if($result){		
			$max_idx = mysql_insert_id();
			update_want("board", " bd_ref='$max_idx' ", " and bd_idx='$max_idx' ");	
			if($mode=="EE001"){
				//Page_Msg("전송되었습니다");
				//Page_Parent_Msg_Url("전송되었습니다","/kor/layer/message_03.php");
				if ($faultyYn){
					Page_Parent_Msg_Url1("‘PARTStrike’로 메모를 전송 하였습니다.","/kor/");
				}else{
					//ReopenLayer("layer3","message_03","");
					closeLayer("layer3");
				}
			}else{
				closeLayer("layer3");
			?>
				<script type="text/javascript">
				<!--
					parent.board("<?=$mode?>");
				//-->
				</script>
			<?
			}
		}


}
if ($typ=="edit"){
	$sql="
		UPDATE board set 
			bd_gubun ='".$mode."'
			, bd_mem_name ='".$_SESSION["MEM_NM"]."'
			, bd_mem_idx ='".$_SESSION["MEM_IDX"]."'
			, bd_mem_id='".$_SESSION["MEM_ID"]."' 
			, bd_mem_nation='".$_SESSION["NATION"]."' 
			, bd_title		= '".$title."'
			, bd_content	= '".$content."'
			, bd_secret		= '".$secret."'
			, bd_ref		= '$ref'
			, bd_lev		= '$lev'
			, reg_date		= '$log_date'
			, reg_ip		= '$log_ip'
		where bd_idx='$idx'
		";
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		if($result){		
			if($mode=="EE001"){
				//Page_Msg("전송되었습니다");
				//Page_Parent_Msg_Url("전송되었습니다","/kor/layer/message_03.php");
				
			}else{
			?>
				<script type="text/javascript">
				<!--
					parent.board("<?=$mode?>");
				//-->
				</script>
			<?
			}
		}


}
if($typ=="comm_write"){
	$lev = $lev+1;
	$step = $step+1;
	$upsql= "UPDATE board SET bd_lev = bd_lev+1 Where bd_ref ='$ref' and bd_lev >=$lev ";
	$upresult = mysql_query($upsql,$conn);
	$sql="
		INSERT board set  
			bd_gubun ='".$mode."'
			, bd_mem_name ='".$_SESSION["MEM_NM"]."'
			, bd_mem_idx ='".$_SESSION["MEM_IDX"]."'
			, bd_mem_id='".$_SESSION["MEM_ID"]."' 
			, bd_mem_nation='".$_SESSION["NATION"]."' 
			, bd_title= '$title'
			, bd_content= '$content'
			, bd_ref= '$ref'
			, bd_ref2= '$ref2'
			, bd_lev= '$lev'
			, bd_step= '$step'
			, reg_date= '$log_date'
			, reg_ip= '$log_ip'
		";

		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		if($result){
			plushit("board","bd_comment_num","bd_idx",$ref);			
			if ($mode =="AA002"){
				closeLayer("layer3");
				?>
					<script type="text/javascript">
					<!--
						parent.showajaxParam(".col-right", "side_board", "board_idx=<?=$ref?>");
						parent.board("<?=$mode?>");
					//-->
					</script>
				<?			
			}else{
				ReopenLayer("layer3","message_03","");
			}
		}

}

if($typ=="comm_edit"){
	$lev = $lev+1;
	$step = $step+1;
	$upsql= "UPDATE board SET bd_lev = bd_lev+1 Where bd_ref ='$ref' and bd_lev >=$lev ";
	$upresult = mysql_query($upsql,$conn);
	$sql="
		UPDATE board set 
			bd_gubun ='".$mode."'
			, bd_mem_name ='".$_SESSION["MEM_NM"]."'
			, bd_mem_idx ='".$_SESSION["MEM_IDX"]."'
			, bd_mem_id='".$_SESSION["MEM_ID"]."' 
			, bd_mem_nation='".$_SESSION["NATION"]."' 
			, bd_title= '$title'
			, bd_content= '$content'
			, bd_ref= '$ref'
			, bd_ref2= '$ref2'
			, bd_lev= '$lev'
			, bd_step= '$step'
			, reg_date= '$log_date'
			, reg_ip= '$log_ip'
		where bd_idx='$idx'
		";

		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		if($result){
			plushit("board","bd_comment_num","bd_idx",$ref);
			//Page_Msg("전송되었습니다");
		}

}

if ($typ=="imgfileup" || $typ =="imgfiledel"){
	$today = date("Y-m-d", strtotime($log_date." -2 day"));
	QRY_DELETE("board"," and bd_gubun is null and reg_date<'$today' ");
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
			}
		}		
		if(${"file_o".$i}){
			$old_file=${"file_o".$i};
			if(file_exists("$dir_dest/$old_file")){
				unlink("$dir_dest/$old_file");
			}
		}
		if($idx){
			 $sql = "UPDATE board set 
					bd_file$i = '$filename' 
					,reg_date = '$log_date'
					where bd_idx='$idx'
				";
				//echo $sql;
			$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		}else{
		
		 $sql = "INSERT INTO board set 
					bd_file$i = '$filename' 
					,reg_date = '$log_date'
				";
		//			echo $sql;
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		$idx = mysql_insert_id();
		}
		
		if($result){
			if ($typ=="imgfileup"){
				Page_ImgUpload_Board($idx, $no, $filename,$ref);
				exit;				
			}else{
				echo "SUCCESS";
				exit;
			}
		}
	?>
	
	<?
}
if ($typ=="send_result"){
	plushit("board","bd_hit","bd_idx",$idx);
	update_want("board", " bd_send_result='1' ", " and bd_idx='$idx' ");	
}


?>