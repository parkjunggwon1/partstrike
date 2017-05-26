<?php
 // Test CVS
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/fileuploader.php";
?>

<?
require_once 'reader.php';

$dir_dest = "../upload/xls/"; //파일 저장 폴더 지정

	/** 파일 업로드 ******************************************/
	For ($i=0;$i<=5;$i++){
		$query_name = "file".$i; //input 파라메터 이름
		
		if($_FILES[$query_name]) {
			$FILE_1			= RequestFile("file".$i);
			
			$FILE_1_size	= $FILE_1[size];
			$maxSize = '5242880'; //5mb, 파일 용량 제한
			${"filename".$i} = uploadProc( $query_name, $dir_dest, $maxSize);
		}
		
	}
	/*******************************************************/
//$filename1 = "20150603164850_.xls";

 // ExcelFile($filename, $encoding);
//Comn 폴더의 파일 2개가 필요하다 OLERead.inc,reader.php
 //해당 파일은 첨부함(압축 파일을 풀면 나올 것이고
//그 파일들을 불러오는건 require_once 'Comn/reader.php'; 부분이다.

 $data = new Spreadsheet_Excel_Reader();

// Set output Encoding.
 $data->setOutputEncoding('utf-8');

//first row remove
 //$data->setRowColOffset(0);
 /***
 * if you want you can change 'iconv' to mb_convert_encoding:
 * $data->setUTFEncoder('mb');
 *
 **/
 /***
 * By default rows & cols indeces start with 1
 * For change initial index use:
 * $data->setRowColOffset(0);
 *
 **/

/***
 *  Some function for formatting output.
 * $data->setDefaultFormat('%.2f');
 * setDefaultFormat - set format for columns with unknown formatting
 *
 * $data->setColumnFormat(4, '%.3f');
 * setColumnFormat - set format for column (apply only to number fields)
 *
 **/
$data->read($dir_dest.$filename1);
 /*

 $data->sheets[0]['numRows'] - count rows
  $data->sheets[0]['numCols'] - count columns
  $data->sheets[0]['cells'][$i][$j] - data from $i-row $j-column
  $data->sheets[0]['cellsInfo'][$i][$j] - extended info about cell
     
     $data->sheets[0]['cellsInfo'][$i][$j]['type'] = "date" | "number" | "unknown"
         if 'type' == "unknown" - use 'raw' value, because  cell contain value with format '0.00';
     $data->sheets[0]['cellsInfo'][$i][$j]['raw'] = value if cell without format 
     $data->sheets[0]['cellsInfo'][$i][$j]['colspan'] 
     $data->sheets[0]['cellsInfo'][$i][$j]['rowspan'] 
 */
 error_reporting(E_ALL ^ E_NOTICE);
  $connect = dbconn();

	if ($regtype=="1"){ //덮어쓰기이므로 odr에 포함되지 않은 모든 부품들은 다 삭제
		$sql = "delete FROM `part` WHERE mem_idx =".$_SESSION["MEM_IDX"]." and part_type =$part_type and part_idx not in (select part_idx from odr_det)";
		//echo $sql;
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	}

  $price = str_replace(",","",$price);
  $price = str_replace("$","",$price);
    $title ="";
	if ($part_type=="7"){
		
		$sql = "insert into part set 
			part_type='".$part_type."'
			,mem_idx ='".$_SESSION["MEM_IDX"]."'
			,rel_idx='".$_SESSION["REL_IDX"]."' 
			,part_no = ''
			,nation = '".$_SESSION["NATION"]."' 
			,dosi = '".$_SESSION["DOSI"]."' 
			,price = ".$price." ";
		//	echo $sql;
			
			$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
			if($result){
				$turnkey_idx=mysql_insert_id(); 
			}	
	}else{ $turnkey_idx = "";}

 for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
 //엑셀 첫 열이 데이터가 아니라 구분 이므로 0번째 index 를 건너뛰고 읽음
 if($i==1){
   continue;
  }      
	$firstCol = $data->sheets[0]['cells'][1][1];
	$dc = trim($data->sheets[0]['cells'][$i][4]);
	if(strlen($dc)=="2"){
		$dc = "20".$dc;
	}

  if ($firstCol == "PartNo" ) {  //insert	   첫번째 컬럼이 PartIdx이면 이미 등록된 적이 있으므로 update를 해야 한다는 의미이다. 첫번째 컬럼이 PartNo라면 기존에 등록된 적이 없으므로 insert!
	
	if ($part_type== "2"){
		$option = ", rhtype		= '".trim($data->sheets[0]['cells'][$i][4])."'
					, price = '".trim($data->sheets[0]['cells'][$i][5])."'";
		$dc = "";
	}elseif($part_type =="7"){ //turnkey
		$option = ", rhtype		= '".trim($data->sheets[0]['cells'][$i][5])."'
					, quantity = '".trim($data->sheets[0]['cells'][$i][6])."'";
		if ($i <=4) {
			$title .= (($i==2)?"":" , ") .trim($data->sheets[0]['cells'][$i][1]);		
		}
	}else{

		$option = ", rhtype		= '".trim($data->sheets[0]['cells'][$i][5])."'
				, quantity		= '".trim($data->sheets[0]['cells'][$i][6])."'
				   , price			= '".trim($data->sheets[0]['cells'][$i][7])."' ";
	}
	//2017-05-21
	$sh_part_no = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "",trim($data->sheets[0]['cells'][$i][1]));

	$sql="
		INSERT INTO part set 
			part_type ='".$part_type."'
			,mem_idx ='".$_SESSION["MEM_IDX"]."'
			,rel_idx='".$_SESSION["REL_IDX"]."' 
			,nation='".$_SESSION["NATION"]."' 
			,dosi='".$_SESSION["DOSI"]."' 
			, part_no		= '".trim($data->sheets[0]['cells'][$i][1])."'
			, sh_part_no		= '".$sh_part_no."'
			, manufacturer	= '".trim($data->sheets[0]['cells'][$i][2])."'
			, package		= '".trim($data->sheets[0]['cells'][$i][3])."'
			,  dc			= '".$dc."'			
			$option
			, turnkey_idx	= '".$turnkey_idx."'
			, reg_date		= '$log_date'
			, reg_ip		= '$log_ip'
		";
		//echo $sql;

  }else { //update -> 이 기능 없어짐. 덮어씌기는 진짜 삭제 하고 덮어씌우기라고 update는 없댐.
	if ($part_type== "2"){
		$option = ", price = '".trim($data->sheets[0]['cells'][$i][7])."'";
	}elseif($part_type =="7"){ //turnkey
		$option = ", quantity = '".trim($data->sheets[0]['cells'][$i][7])."'";
		if ($i <=4) {
			$title .= (($i>=2)?"":" , ") .trim($data->sheets[0]['cells'][$i][2]);
		}
	}else{
		$option = ", quantity		= '".trim($data->sheets[0]['cells'][$i][7])."'
				   , price			= '".trim($data->sheets[0]['cells'][$i][8])."' ";
	}
		$sql = "
			UPDATE
					part
				SET
					part_type ='".$part_type."'
					, part_no		= '".trim($data->sheets[0]['cells'][$i][2])."'
					, manufacturer	= '".trim($data->sheets[0]['cells'][$i][3])."'
					, package		= '".trim($data->sheets[0]['cells'][$i][4])."'
					,  dc			= '".$dc."'
					, rhtype		= '".trim($data->sheets[0]['cells'][$i][6])."'
					$option
				WHERE
					part_idx = '".trim($data->sheets[0]['cells'][$i][1])."'					
			";
  }
	//echo $sql."<BR>";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
 }


 if ($part_type =="7"){
		if ($i > 5) {
			$title .= " (".($i-5)."more)";
		}	
		$sql = "update part set part_no = '$title' where part_idx = $turnkey_idx";
		echo $sql;
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	}

		if($result){
			PageReLoad("처리되었습니다.",$part_type);
		}
 //print_r($data);
 //print_r($data->formatRecords);
 ?>
 