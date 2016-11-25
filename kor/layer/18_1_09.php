<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<?$row_odr_det = sql_fetch("select * from odr_det where ship_idx = trim('$ship_idx')");
  $result_odr = QRY_ODR_VIEW($row_odr_det[odr_idx]);    
  $row_odr = mysql_fetch_array($result_odr);
  $odr_idx = $row_odr_det[odr_idx];
  $result_buyer = QRY_ODR_MEMBER_VIEW($odr_idx,"idx",($row_odr["rel_idx"]==0?$row_odr["mem_idx"]:$row_odr["rel_idx"])); //사는 회사 정보
  $row_buyer = mysql_fetch_array($result_buyer);

  $result_seller = QRY_ODR_MEMBER_VIEW($odr_idx,"idx",($row_odr["sell_rel_idx"]==0?$row_odr["sell_mem_idx"]:$row_odr["sell_rel_idx"])); //파는 회사 정보
  $row_seller = mysql_fetch_array($result_seller);
  $row_ship = get_ship($ship_idx);
  if($row_ship[invoice_no]==""){
	  $sql = "update ship set invoice_no = '".get_auto_no("NCI","ship","invoice_no")."' where ship_idx=".$ship_idx;
	  $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
      $row_ship = get_ship($ship_idx);
  }
?>
<div class="sheet-img"><img src="/kor/images/sheet_bg.jpg" alt=""></div>
<div class="sheet-wrap">
	<div class="top-info">
		<ul class="company-info">
			<li>
				<span class="b1"><img src="/upload/file/<?=$row_buyer["filelogo"]?>" width="75" height="18" alt=""></span>
				<span class="b2" lang="en"><?=$row_buyer["mem_nm_en"]?></span>
			</li>
			<li>
				<span class="b1"><img src="/kor/images/nation_title_<?=$row_buyer["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_buyer["nation"])?>"></span>
				<span lang="en"><?=$row_buyer["homepage"]?></span>
			</li>
		</ul>
		<ul class="contact-info">
			<li><?=$row_buyer["addr_det_en"]?> <?=$row_buyer["addr_en"]?></li>
			<li><span class="tel">Tel : <?=$row_buyer["tel"]?></span>Fax : <?=$row_buyer["fax"]?> </li>
			<li><span class="tel">Contact : <?=$row_odr["rel_idx"]==0?$row_buyer["pos_nm_en"]:get_any("member", "mem_nm_en", "mem_idx=".$row_odr["mem_idx"])?> / <?=$row_odr["rel_idx"]==0?"CEO":get_any("member", "pos_nm_en", "mem_idx=".$row_odr["mem_idx"])?><br><?=get_any("member", "email", "mem_idx=".$row_odr["mem_idx"])?></li>
		</ul>
	</div>	
	
	<div class="order-info">
		<ul>
			<li class="b1"><strong>Reason of Return No.</strong><span><?=str_replace("NCI","RoR",$row_ship[invoice_no])?></span></li>
			<li class="b2"><strong>Date</strong><span><?= substr($row_odr_det[non_com_date],0,10);?></span></li>
			<li><strong>Page</strong><span>1</span></li>
		</ul>
		<ul>
			<li class="b3"><strong>Ship Via</strong><span><img src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$row_ship[ship_info]))?>.gif" alt="" height="10"></span></li>
			<li><strong>Account No.</strong><span><?=$row_ship[ship_account_no]?></span></li>
			<li class="b2"><strong>Transport insurance</strong><span><?=$row_ship[insur_yn]=="o"?"Yes":"No"?> </span></li>
		</ul>
		<ul>
			<li class="b1"><strong>Payment Term</strong><span>CBD</span></li>
			<li><img src="/kor/images/nation_title_<?=$row_buyer["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_buyer["nation"])?>" class="country"><strong>Incoterms</strong><span>EXW-</span></li>
		</ul>
	</div>
	
	<div class="return-info">
		<ul>
			<li><strong lang="ko">수신 : </strong><span><?=$row_ship[recv]?></span></li>
			<li><strong lang="ko">참조 : </strong><span><?=$row_ship[refer]?></span></li>
		</ul>
	</div>

	<!-- order-table -->
	<div class="order-table">
		<h2><img src="/kor/images/st_tit_return_statment.gif" alt="반품사유서"></h2>
		<table>
			<thead>
				<tr>
					<th scope="col"><span lang="ko">내용</span></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="t-lt c-blue"><?=$row_ship[content]?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- //order-table -->
	
	<div class="etc-info1">
		<div class="txt-area2-outer">
			<div class="inner">RMA No. : <strong class="c-red"><?=str_replace("NCI","RMA",$row_odr_det[non_com_invoice])?></strong></div>
		</div>
	</div>
	
	<div class="etc-info2">
		<ul class="sign-area">
			<li><span>By :</span><strong class="sign"><img src="/upload/file/<?=$row_buyer["filesign"]?>" height="21" alt=""></strong></li>
			<li><span>CEO : </span><strong><?=$row_buyer["pos_nm_en"]?></strong></li>
			<li><span>Tel : </span><strong><?=$row_buyer["tel"]?></strong><span class="fax">Fax : </span><strong><?=$row_buyer["fax"]?></strong></li>
		</ul>
	</div>
	
	<div class="btn-area">
		<button type="button" class="f-lt"><img src="/kor/images/btn_print.gif" alt="인쇄"></button>
	</div>
</div>

