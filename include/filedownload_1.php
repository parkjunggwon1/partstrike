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

<body style='font-family:"Times New Roman", serif !important;font-size:13px;'>
<table border='1' style='font-family:"Times New Roman", serif !important;font-size:13px;'>
<thead>
	<tr>
		<th height="23" style="text-align:center" bgcolor="#FFFF00">No</th>
		<th bgcolor="#FFFF00" style="width:220px;text-align:left">Part No.</th>
		<th bgcolor="#FFFF00" style="width:170px;text-align:left">Manufacturer</th>
		<th bgcolor="#FFFF00" style="width:80px;text-align:center">Package</th>
		<th bgcolor="#FFFF00" style="width:36px;text-align:center">D/C</th>
		<th bgcolor="#FFFF00" style="width:45px;text-align:center">RoHS</th>
		<th bgcolor='#FFFF00' style='width:61px;text-align:right'>O'ty</th>
		<th bgcolor='#FFFF00' style='width:61px;text-align:right'>Unit Price</th>
	</tr>
</thead>
<tbody>
	<tr>
		<td height="23" style="text-align:center">1</td>
		<td style="text-align:left">="AA000001"</td>
		<td style="text-align:left">="Samsung Elect1"</td>
		<td style="text-align:center">="box"</td>
		<td style="text-align:center">="2016"</td>
		<td style="text-align:center">="RoHs"</td>
		<td style="text-align:right">="1000"</td>
		<td style="text-align:right">="$5000.00"</td>	 
	</tr>	
</tbody>
</table>
</body>
