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
	//2016-12-20 : ������ ǰ���� ��� ��Ͽ��� �� ����(����=>del_chk:0)
	$sql = "
			SELECT * FROM 
				part	
			WHERE
				del_chk='1' $searchand
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

function QRY_PART_CHECK($part_idx)
{
	$conn = dbconn();
	$sql = "select price,quantity from part where part_idx = $part_idx";
			//echo $sql;
	mysql_query( "SET NAMES utf8");	

	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	$part_info = mysql_fetch_object($result);
	return $part_info;
}

?>
