<?php
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
header( "Content-type: application/vnd.ms-excel" );   
header( "Content-type: application/vnd.ms-excel; charset=utf-8");  
header( "Content-Disposition: attachment; filename = PartsList_".date("Y-m-d").".xls" );   
header( "Content-Description: PHP4 Generated Data" );   
?>
<meta content=\"application/vnd.ms-excel; charset=UTF-8\" name=\"Content-type\">
<style type="text/css">
*[lang="en"]{font-family:"Times New Roman", serif !important; line-height:0.9}
*[lang="ko"]{font-family:"굴림", sans-serif !important; line-height:1.2}
</style>
<?

include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.part.php";
$searchand .= "and mem_idx = ".$_SESSION["MEM_IDX"]." and rel_idx = ".$_SESSION["REL_IDX"]." and part_type =$part_type "; 
if ($part_no){
	$searchand .= "and part_no like '%$part_no%' ";
}
if ($turnkey_idx){
	$searchand .= "and turnkey_idx = $turnkey_idx ";
}
$cnt = QRY_CNT("part",$searchand);							
$result =QRY_PART_LIST(0,$searchand,$page,"part_idx");
$i = 0;

 



?>
<body style='font-family:"Times New Roman", serif !important;font-size:13px;'>
<table border='1' style='font-family:"Times New Roman", serif !important;font-size:13px;'>
<thead>
	<tr >
		<th height="23" bgcolor="#FFFF00">No</th>
		<th bgcolor="#FFFF00" style="width:220px;text-align:left">PartNo</th>
		<th bgcolor="#FFFF00" style="width:170px;text-align:left">Manufacturer</th>
		<th bgcolor="#FFFF00" style="width:80px;text-align:center">Package</th>
		<th bgcolor="#FFFF00" style="width:36px;text-align:center">D/C</th>
		<th bgcolor="#FFFF00" style="width:45px;text-align:center">RoHS</th>
<?		if ($part_type== "2"){
			echo "<th bgcolor='#FFFF00' style='width:61px;text-align:right'>Unit Price</th>";
	  }elseif($part_type =="7"){ //turnkey
		echo "<th bgcolor='#FFFF00' style='width:61px;text-align:right'>O'ty</th>";
	  }else{
		 echo "<th bgcolor='#FFFF00' style='width:61px;text-align:right'>O'ty</th>
			  <th bgcolor='#FFFF00' style='width:61px;text-align:right'>Unit Price</th>";
	  }
?>
	</tr>
</thead>
<tbody>
<?
if ($cnt > 0){
	while($row = mysql_fetch_array($result)){
		$i++;				
		$part_idx= replace_out($row["part_idx"]);
		$part_no= replace_out($row["part_no"]);
		$manufacturer= replace_out($row["manufacturer"]);
		$package= replace_out($row["package"]);
		$dc= replace_out($row["dc"]);
		$rhtype= replace_out($row["rhtype"]);
		$quantity= replace_out($row["quantity"]);
		$price= replace_out($row["price"]);
		$turnkey_idx= replace_out($row["turnkey_idx"]);
		
		if(strpos($price, ".") == false)  
		{
			$price_val= number_format($price,2);
		}
		else
		{
			$price_val= $price;
		}
		?>
	<tr>
		<td height="23"><?=$i?></td>
		<td style="text-align:left">="<?=$part_no?>"</td>
		<td style="text-align:left">="<?=$manufacturer?>"</td>
		<td style="text-align:center">="<?=$package?>"</td>
		<td style="text-align:center">="<?=$dc?>"</td>
		<td style="text-align:center">="<?=$rhtype?>"</td>
	 <?if ($part_type== "2"){
			echo "<td style='text-align:right'>=\"$$".$price_val."\"</td>";
	  }elseif($part_type =="7"){ //turnkey
		echo "<td style='text-align:right'>=\"".number_format($quantity)."\"</td>";
	  }else{
		 echo "<td style='text-align:right'>=\"".number_format($quantity)."\"</td>";
 		 echo "<td style='text-align:right'>=\"$".$price_val."\"</td>";
	  }
	  ?>
	</tr>	
	<?
		$ListNO--;	
	}
}else{
?><tr>
		<td colspan="9">검색된 데이터가 없습니다.</td>
  </tr>
<?}?>
</tbody>
</table>
</body>
