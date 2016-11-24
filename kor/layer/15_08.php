<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<div class="layer-hd">
	<h1>공지</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
<?
	$account_no = get_any("impship", "account_no", "rel_idx = ".$com_idx." and company_idx=$o_company_idx");	
	$com_name= strtolower(GF_Common_GetSingleList("DLVR",$o_company_idx));

?>
	<form>
		<input type="hidden" name="account_no" id="account_no" value="<?=$account_no?>">
		<input type="hidden" name="company_idx" id="company_idx" value="<?=$o_company_idx?>">
		<p class="txt-warning">상대방이 지정운송 업체로만 선적이 가능합니다. 수정된 정보를 확인하시고 거래를 계속하시기 바랍니다. </p>
		<p class="t-ct"><?if ($account_no==""){?><a href="#" class="btn-pop-1509" o_company_idx="<?=$o_company_idx?>"><img src="/kor/images/icon_<?=$com_name?>.gif" alt="<?=$com_name?>"> <img src="/kor/images/btn_account_apply.gif" alt="Account No. 등록"></a><?}?></p>
		<br>
		<ul>
			<?if ($account_no!=""){?><li><label class="ipt-rd rd2 c-red"><input type="radio" name="appoint_account_yn" value="Y" class="checked" checked><span></span><img src="/kor/images/icon_<?=$com_name?>.gif" alt="<?=$com_name?>" height="15"> <span lang="en">Account No.</span> <span lang="ko">로 선적 : <?=$account_no?></span></label></li><?}?>
			<li><label class="ipt-rd rd2 c-red"><input type="radio" name="appoint_account_yn" value="N" <?if ($account_no==""){?>class="checked" checked<?}?>><span></span><img src="/kor/images/icon_<?=$com_name?>.gif" alt="<?=$com_name?>" height="15"> <span lang="en" class="c-grey2">Account No.</span> <span lang="ko">없이 ‘주소’로 선적</span></label></li>
		</ul>
		<div class="btn-area t-rt">
			<a class="account_upd_and_inv_confirm" href="#" for_readonly="" ship_idx="<?=$ship_idx?>"><img alt="송장 확인" src="/kor/images/btn_invoice_confirm.gif"></a><!--btn-view-sheet-3011-->
			
		</div>
	</form>
</div>


