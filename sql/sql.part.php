<?
Function QRY_PART_LIST($recordcnt,$searchand,$page,$ord='price'){
	$conn = dbconn();	
	if ($recordcnt > 0) {  //$recordcnt�� �Ѿ���� �׸�ŭ�� ��� ����¡ ó��. recordcnt�� 0���� �Ѿ���� ��ü �� ��� �ϰڴٴ� �ǹ� (���� �ٿ�ε� ��� ����)
		$startno = ($page-1) * $recordcnt;
		$limit = "LIMIT $startno,$recordcnt";
	}else{
		$limit = "";
	}

	switch($ord){
		case "part_idx":
			$s_ord=" order by part_idx desc";
			break;
		default:
			$s_ord=" order by price";
			break;
	}

	$sql = "
			SELECT * FROM 
				part	
			WHERE
				1=1 $searchand
			$s_ord
			$limit
			";
	mysql_query( "SET NAMES utf8");	
	//echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

Function QRY_TURNKEY_LIST($recordcnt,$searchand,$page){
	$conn = dbconn();	
	if ($recordcnt > 0) {  //$recordcnt�� �Ѿ���� �׸�ŭ�� ��� ����¡ ó��. recordcnt�� 0���� �Ѿ���� ��ü �� ��� �ϰڴٴ� �ǹ� (���� �ٿ�ε� ��� ����)
		$startno = ($page-1) * $recordcnt;
		$limit = "LIMIT $startno,$recordcnt";
	}else{
		$limit = "";
	}

	$sql = "
			SELECT * FROM 
				part 
			WHERE
				1=1 $searchand
				order by part_idx desc
			$limit
			";
	mysql_query( "SET NAMES utf8");	
//echo "<tr><td>$sql</td></tr>";
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

?>
