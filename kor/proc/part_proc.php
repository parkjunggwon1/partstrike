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
 	
	 if ($part_type =="7"){
		$sql = "update part set price = '".str_replace("$","",$price)."' where part_idx = $turnkey_idx";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	 }
	 
	 for ($j = 0 ; $j<count($ary_part_idx); $j++){
		if($ary_part_idx[$j] == $no[$no_pt]){
			    // part에서 제거 할때에는 기존에 해당 부품으로 결제가 이루어 진 적이 없는 것인 것만 제거가 가능하다.
				$sql="
				delete from part where part_idx in($no[$no_pt]) and part_idx not in (select part_idx from odr_det)
					";
					echo $sql."<BR>";
				$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
				if (count($no)>$no_pt) {$no_pt++;}
		}else{

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

				echo $sql."<BR>";
				$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		}
	 }
	if($result){
		PageReLoad("저장되었습니다.",$part_type);
	}
}

?>
