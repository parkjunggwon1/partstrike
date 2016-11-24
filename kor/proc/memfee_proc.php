<?
 ob_start();
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
//$invoice_no=get_auto_no("MFI", "mybank" , "invoice_no");
$del_user_idx=$_SESSION["MEM_IDX"];
if (!$_SESSION["MEM_IDX"]){
	ReopenLayer("layer6","alert","?alert=sessionend");
	exit;
}

if ($typ=="temp_save"){
	QRY_DELETE("memfee_temp"," and del_user_idx='$del_user_idx' ");
	$memfee_id = date("ymdhms").RndomNum(4);
	$no = $_POST[mem_idx];
	for($i=0; $i<count($no); $i++){
		$rel_idx=0;
		$user_idx=0;
		if($_SESSION["MEM_IDX"]!=$no[$i]){ $rel_idx=$_SESSION["MEM_IDX"];}
		if($_SESSION["MEM_IDX"]==$no[$i]){ $user_idx=$_SESSION["MEM_IDX"];}
		//인서트 처리
		$sql = " insert into memfee_temp set 
			memfee_id =  '$memfee_id'
			,user_idx =  '".$_SESSION["MEM_IDX"]."'
			,rel_idx =  '$rel_idx' 
			,mem_idx =  '$no[$i]'
			,del_user_idx =  '$del_user_idx'
			,charge_type =  '14'			
			,reg_date =  '$log_date'
		";
		//echo $no[$i];
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	}

	if($result){
		//ReopenLayer("layer4","23_76","?memfee_id=$memfee_id");
		ReopenLayer("layer5","23_77","?memfee_id=$memfee_id");  //바로 인보이스로 건너 뛰라고 파츠에서 요청
	}
}
if ($typ=="temp_add"){
	if($_SESSION["REL_IDX"]==0){ 
		$mem_idx=$_SESSION["MEM_IDX"]; 
	}else{
		$mem_idx=$_SESSION["REL_IDX"]; 
	}
	//인서트 처리
	$sql = " insert into memfee_temp set 
		memfee_id =  '$memfee_id'
		,user_idx =  '".$_SESSION["MEM_IDX"]."'
		,rel_idx =  '0' 
		,mem_idx =  '$mem_idx'
		,del_user_idx =  '$del_user_idx'
		,charge_type =  '8'			
		,reg_date =  '$log_date'
	";
	//echo $no[$i];
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

	if($result){
		closeLayer("layer4");
		ReopenLayer("layer5","23_77","?memfee_id=$memfee_id");
	}
}
if ($typ=="write"){
	$invoice_no=get_auto_no("MFI", "mybank" , "invoice_no");
	$searchand = " and a.memfee_id='$memfee_id' and a.mem_idx=b.mem_idx";
	$result =QRY_LIST("memfee_temp a, member b","all",1,$searchand," charge_type ASC, a.mem_idx ASC");
	$tot = 0;

	while($row = mysql_fetch_array($result)){
		$i++;				
		$memfee_id= replace_out($row["a.part_idx"]);
		$user_idx= replace_out($row["user_idx"]);
		$rel_idx= replace_out($row["rel_idx"]);
		$mem_idx= replace_out($row["mem_idx"]);
		$charge_type= replace_out($row["charge_type"]);
		$reg_date= replace_out($row["reg_date"]);
		$mem_nm_en= replace_out($row["mem_nm_en"]);
		$pos_nm_en= replace_out($row["pos_nm_en"]);
		$mybank_idx = get_want("mybank","mybank_idx"," and mem_idx='$mem_idx' and charge_type='$charge_type' ");
		if(!$mybank_idx){
			if($rel_idx!="0"){
				$amount = get_want("mybank","charge_amt"," and mem_idx='$mem_idx' and charge_type='$charge_type'");
				$end_date = get_want("mybank","end_date"," and mem_idx='$rel_idx' and charge_type='$charge_type'");
				if($end_date){
					
					$nowdate = date("Y-m");	
					$end_date_m = substr($end_date,0,7);
					$real_end_date = $end_date;
					$a = substr($end_date_m,0,4)*12 + substr($end_date_m,5,2); 
					$b = substr($nowdate,0,4)*12 + substr($nowdate,5,2); 
					$c = ($b-$a)*(-1); 
				}else{
					$c=12;
					$real_end_date = date('Y-m-d', strtotime('1 years'));
				}
				if(!$amount){
					$amount= 10*$c;
					
				}
			}else{
				$amount = get_want("mybank","charge_amt"," and mem_idx='$mem_idx' and charge_type='$charge_type'");
				if(!$amount){
					$amount= "1000";	
					$real_end_date = date('Y-m-d', strtotime('1 years'));
				}
			}
			if($rel_idx=="0"){
				$com_idx = $mem_idx;
			}else{
				$com_idx = $rel_idx;
			}
			
			$sql1 = " insert into mybank set 
				mem_idx =  '$mem_idx'
				,rel_idx =  '$rel_idx'
				,user_idx =  '$user_idx' 
				,com_idx =  '$com_idx' 
				,charge_type =  '$charge_type'
				,charge_amt =  '$amount'
				,charge_method =  '$charge_method'			
				,invoice_no =  '$invoice_no'
				,end_date =  '$real_end_date'
				,reg_date =  '$log_date'
				,reg_ip =  '$log_ip'
			";
			//echo $no[$i];
			if($charge_type=="8"){
				update_want("member", " deposit='1' ", " and mem_idx='$mem_idx' ");
			}
			if($charge_type=="14"){
				update_want("member", " memfee='1' ", " and mem_idx='$mem_idx' ");
			}
			$result1=mysql_query($sql1,$conn) or die ("SQL ERROR : ".mysql_error());			
		}
	}
	if($result){
		//closeLayer("layer4");
		//closeLayer("layer5");
		//ReopenLayer2("#memfeeleftTop", "memfee1", "");
		//ReopenLayer2("#memfeeleftBottom", "memfee2", "");
		echo "SUCCESS";
		exit;
	}
}
?>