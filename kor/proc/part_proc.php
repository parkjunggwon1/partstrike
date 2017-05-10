<?
 ob_start();
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/fileuploader.php";
if (!$_SESSION["MEM_IDX"]){
	ReopenLayer("layer6","alert","?alert=sessionend");
	exit;
}

$dir_dest = "../..".$file_path; //파일 저장 폴더 지정
if ($typ=="write"){
	//아이디 중복확인
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

	/*******************************************************/
		if(strlen($dc)=="2"){
			$dc = "20".$dc;
		}
		if ($part_type =="2"){
					$dc = "";
					$quantity="";
				}
		$sql="
		INSERT INTO part set 
			part_type ='".$part_type."'
			,mem_idx ='".$_SESSION["MEM_IDX"]."'
			,rel_idx='".$_SESSION["REL_IDX"]."' 
			,nation='".$_SESSION["NATION"]."' 
			,dosi='".$_SESSION["DOSI"]."' 
			, part_no		= '".$part_no."'
			, manufacturer	= '".$manufacturer."'
			, package		= '".$package."'
			,  dc			= '".$dc."'
			, rhtype		= '".$rhtype."'
			, quantity		= '".$quantity."'
			, price			= '".str_replace("$","",$price)."'
			, turnkey_idx	= '".$turnkey_idx."'
			, reg_date		= '$log_date'
			, reg_ip		= '$log_ip'
		";
		
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	if($result){
		$idx=mysql_insert_id(); 
		echo "SUCCESS:$idx";
		exit;
	}

}
if ($typ == "edit"){
	 $no = $_POST[delchk];
	 $ary_part_idx = $_POST[mod_part_idx];
	 $ary_part_no = $_POST[mod_part_no];
	 $ary_manufacturer = $_POST[mod_manufacturer];
	 $ary_package = $_POST[mod_package];
	 $ary_dc = $_POST[mod_dc];
	 $ary_rhtype = $_POST[mod_rhtype];
	 $ary_quantity = $_POST[mod_quantity];
	 $ary_price = $_POST[mod_price];
 	 
	 if ($part_type =="7"){
		$sql = "update part set price = '".str_replace("$","",$price)."' where turnkey_idx = 0 and part_idx = $turnkey_idx";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	//	echo $sql;
	 }

	
	 for ($j = 0 ; $j<count($ary_part_idx); $j++){

		  if ($part_type== "2"){
			$option = ", price = '".str_replace("$","",$ary_price[$j])."'";
		  }elseif($part_type =="7"){ //turnkey
			$option = ", quantity = '".$ary_quantity[$j]."'";
			if ($i <=4){
			}
		  }else{
			$option = ", quantity		= '".$ary_quantity[$j]."'
					   , price			= '".str_replace("$","",$ary_price[$j])."' ";
		  }

			if(strlen($ary_dc[$j])=="2"){
				$ary_dc[$j] = "20".$ary_dc[$j];
			}

			if ($part_type =="2"){
					$dc = "";
					$quantity="";
				}

			$sql = "update part set 
				mem_idx ='".$_SESSION["MEM_IDX"]."'
				,rel_idx='".$_SESSION["REL_IDX"]."' 
				, part_no		= '".$ary_part_no[$j]."'
				, manufacturer	= '".$ary_manufacturer[$j]."'
				, package		= '".$ary_package[$j]."'
				,  dc			= '".$ary_dc[$j]."'
				, rhtype		= '".$ary_rhtype[$j]."' 
				$option 			
				where part_idx = $ary_part_idx[$j]";

				//echo $sql."<BR>";
				$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		
	 }
	if($result){
		PageReLoad("저장되었습니다.",$part_type);
	}
}


if($typ =="del"){
	$sql = "delete from $tbl where ".($tbl=="member"?"mem":$tbl)."_idx = ".$idx;
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		if($result){
			echo "SUCCESS";
			exit;
		}
}

if ($typ =="delturnkey"){
	$sql = "delete from part where part_idx = '$turnkey_idx'";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	$sql = "delete from part where turnkey_idx ='$turnkey_idx'";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	PageReLoad("삭제되었습니다.","7");

}

/*********************************************** 여러개 삭제 *************************************************************/
//2016-12-20 : 삭제 개념(del_chk컬럼)이 반영되지 않아 수정 - ccolle
if($typ=="alldel"){
	 $no = $_POST[delchk];
	 $no_pt =0;
	 $ary_part_idx = $_POST[mod_part_idx];
	 $ary_part_no = $_POST[mod_part_no];
	 $ary_manufacturer = $_POST[mod_manufacturer];
	 $ary_package = $_POST[mod_package];
	 $ary_dc = $_POST[mod_dc];
	 $ary_rhtype = $_POST[mod_rhtype];
	 $ary_quantity = $_POST[mod_quantity];
	 $ary_price = $_POST[mod_price];
 	
	 
	//일단 전체 UPDATE --------------------------------------------- 기존 JSJ
	for ($j = 0 ; $j<count($ary_part_idx); $j++){
		if ($part_type== "2"){
			$option = ", price = '".str_replace("$","",$ary_price[$j])."'";
		}elseif($part_type =="7"){ //turnkey
			$option = ", quantity = '".$ary_quantity[$j]."'";
			if ($i <=4){
			}
		}else{
			$option = ", quantity		= '".$ary_quantity[$j]."'
			, price			= '".str_replace("$","",$ary_price[$j])."' ";
		}
		if(strlen($ary_dc[$j])=="2"){
			$ary_dc[$j] = "20".$ary_dc[$j];
		}
		if ($part_type =="2"){
			$dc = "";
			$quantity="";
		}
		$sql = "update part set 
		mem_idx ='".$_SESSION["MEM_IDX"]."'
		,rel_idx='".$_SESSION["REL_IDX"]."' 
		, part_no		= '".$ary_part_no[$j]."'
		, manufacturer	= '".$ary_manufacturer[$j]."'
		, package		= '".$ary_package[$j]."'
		,  dc			= '".$ary_dc[$j]."'
		, rhtype		= '".$ary_rhtype[$j]."' 
		$option			 
		where part_idx = $ary_part_idx[$j]";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	}

	 if ($part_type =="7"){		
		$turnkey_cnt = QRY_CNT("part","and turnkey_idx = $turnkey_idx");
		$column = "GROUP_CONCAT(part_no  ORDER BY part_idx  SEPARATOR ' , ') ";
		if ($turnkey_cnt>3){
			$cnt = $turnkey_cnt - 3;
			$column = "concat(".$column.", ' (','".$cnt."','more)')";			
		}
		$turnkey_title = get_any("(select  part_no , part_idx from part where turnkey_idx = $turnkey_idx order by part_idx limit 3) aa ", $column,"1=1");

		$sql = "update part set part_no = '$turnkey_title' , price = '".str_replace("$","",$price)."' where part_idx = $turnkey_idx";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

	 }
	 //2016-12-20 : 거래가 없는 품목은 DB 레코드 삭제, 거래가 있는 품목은 del_chk='0'
	 //1. 삭제 선택된 만큼 반복
	 for ($i = 0 ; $i<count($no); $i++){
		$del_part_idx = $no[$i];
		$det_cnt = QRY_CNT("odr_det"," and part_idx=$del_part_idx ");
		if($det_cnt>0){	//--- 거래 있다.(del_chk='0')
			update_val("part","del_chk",'0', "part_idx", $del_part_idx);
			//2017-05-10 대표님 요청
			update_val("part","quantity",'0', "part_idx", $del_part_idx);
		}else{	//--------------- 거래 없다.(실제 레코드 삭제)
			update_val("part","del_chk",'0', "part_idx", $del_part_idx);
			update_val("part","quantity",'0', "part_idx", $del_part_idx);
			//$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		}
	 }

	if($result){
		PageReLoad("저장되었습니다.",$part_type);
	}
}

?>
