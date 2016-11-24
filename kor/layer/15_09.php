<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<div class="layer-hd">
	<h1>내 정보 수정 </h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form>
		<table class="stock-list-table mr-b15">
			<thead>
				<tr>
					<th scope="col" colspan="3" lang="ko">수입 선적 정보</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="c-blue">
						<span lang="ko">선택</span> 
						<div class="select type4" style="width: 80px;" disabled>
							<label lang="en"><?=($o_company_idx)?GF_Common_GetSingleList("DLVR",$o_company_idx):"선택";?></label>
							<?=GF_Common_SetComboList("company_idx", "DLVR", "", 1, "True",  "운송회사", $o_company_idx , "");?>
						</div>
					</td>
					<td class="c-blue">
						<label>
							<span lang="en">Account No.</span>
							<input type="text" class="i-txt2" name="account_no" id="account_no"  value="<?=$account_no?>">
						</label>
					</td>
					<td><button type="button" class="btn-reg-my-impship"><img src="/kor/images/btn_form_apply.gif" alt="등록"></button></td>
				</tr>
			</tbody>
		</table>
	</form>
</div>

