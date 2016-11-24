<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<div class="layer-hd">
	<h1>내 정보 수정 </h1>
	<a href="#" class="btn-close btn-invoice-3008" odr_idx="<?=$odr_idx?>"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form>
		<p class="txt-warning">작성하신 정보는 자동으로 갱신됩니다. 이후의 거래에서의 선적에서도 작성하신 정보를 사용하게 됩니다. </p>
		<table class="stock-list-table mr-tb15">
			<thead>
				<tr>
					<th scope="col" lang="ko">판매자 지정 운송회사</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="c-blue">
						<span lang="ko">운송회사</span>
						<div class="select type4" style="width:80px;">
							<label><?=($o_company_idx)?GF_Common_GetSingleList("DLVR",$o_company_idx):"선택";?></label>
							<?=GF_Common_SetComboList("o_company_idx$assign_type", "DLVR", "", 1, "True",  "선택", $o_company_idx , "");?>
						</div>
						<button type="button" class="btn-appoint_reg" odr_idx="<?=$odr_idx?>" loadPage="<?=$loadPage?>"><img src="/kor/images/btn_form_apply.gif" alt="등록"></button>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>

