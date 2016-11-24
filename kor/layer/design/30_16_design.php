<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function shipping(){
		var f =  document.f;
		if (nullchk(f.delivery_no,"운송장 번호를 입력해주세요.")== false) return ;			
		 f.target = "proc";
		 f.action = "/kor/proc/odr_proc.php";
		 f.submit();		
	}
//-->
</SCRIPT>

<div class="layer-hd">
	<h1>선적</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
		<form name="f" id="f"  method="post" enctype="multipart/form-data">
		<input type="hidden" name="typ" id="typ" value="shipping">
		<input type="hidden" name="odr_idx" id="odr_idx" value="<?=$odr_idx?>">		
		<!-- layer-file -->
		<div class="layer-file">
			<table>
				<tbody>
					<tr>
						<td class="company"><img src="/kor/images/nation_title_uk.png" alt="United Kingdom"> <span class="name">DigitalDream Co., Ltd</span></td>
						<td class="c-red2 t-rt">운송회사 : <div class="select type4" lang="en" style="width:70px">
							<label class="c-blue">FEDEX</label>
							<select>
								<option>FEDEX</option>
								<option>FEDEX</option>
							</select>
						</div><img src="/kor/images/icon_dhl.gif" alt=""> &nbsp;&nbsp;&nbsp;운송장번호: <input type="text" class="i-txt2 c-blue" name="delivery_no" value="" style="width:96px"></td>
					</tr>
					<tr>
						<td><div class="re-select"><strong>선택</strong><em>교환</em></div></td>
						<td class="c-red2 t-rt">선적서류 <span lang="en"><!--Download--></span> : <a href="#" class="btn-view-sheet-3011" for_readonly="Y"><img src="/kor/images/btn_commercial_invoice.gif" alt="Commercial Invoice"></a> <a href="#" class="btn-pop-3018"><img src="/kor/images/btn_packing_list.gif" alt="Packing List"></a></td>
					</tr>
				</tbody>
			</table>
		</div>
		<!-- //layer-file -->
		
		<div class="layer-data">
			<table class="stock-list-table">
				<thead>
					<tr>
						<th scope="col">No. </th>
						<th scope="col">Part No.</th>
						<th scope="col">Manufacture</th>
						<th scope="col">Package</th>
						<th scope="col">D/C</th>
						<th scope="col">RoHS</th>
						<th scope="col">O'ty</th>
						<th scope="col">Unit Price</th>
						<th scope="col" lang="ko">발주수량</th>
						<th scope="col" lang="ko">공급수량</th>
						<th scope="col" lang="ko">납기</th>
					</tr>
				</thead>
				<?	for ($i = 1; $i<=6; $i++){
						echo GET_ODR_DET_LIST("18R_06",$i," and odr_idx=$odr_idx ");
				}?>
				<tbody>
					<tr>
						<td colspan="11" class="title-box first">
							<h3 class="title"><img src="/kor/images/stock_title01.gif" alt="Special Price Stock"></h3>
						</td>
					</tr>
					<tr>
						<td>1</td>
						<td>123456789123456789123456789123</td>
						<td>ManuManuManuManuManu</td>
						<td>PackaPacka</td>
						<td>NEW</td>
						<td>RoHS</td>
						<td>1,000,000</td>
						<td>$10,000.00</td>
						<td class="c-blue">1,000,000</td>
						<td class="c-red2">1,000,000</td>
						<td>Stock</td>
					</tr>
					<tr class="bg-none">
						<td></td>
						<td colspan="10">
							<table class="detail-table">
								<tbody>
									<tr>
										<th scope="row" style="width:70px">부품 상태  : </th>
										<td><span lang="en">NEW &amp; Original</span></td>
										<th scope="row" style="width:70px">포장상태 : </th>
										<td><span lang="en">Original / Tape &amp; Reel</span></td>
										<td></td>
									</tr>
									<tr>
										<td colspan="4" class="img-cntrl-list">
											<strong class="c-red">라벨/부품사진:</strong>
											<div class="img-cntrl-wrap">
												<span class="img-wrap"><img alt="" src="/kor/images/file_pt.gif"></span>
												<button type="button"><img src="/kor/images/btn_img_edit.gif" alt="편집"></button>
												<button type="button"><img src="/kor/images/btn_img_del.gif" alt="삭제"></button>
											</div>
											<div class="img-cntrl-wrap">
												<span class="img-wrap"><img alt="" src="/kor/images/file_pt.gif"></span>
												<button type="button"><img src="/kor/images/btn_img_edit.gif" alt="편집"></button>
												<button type="button"><img src="/kor/images/btn_img_del.gif" alt="삭제"></button>
											</div>
											<div class="img-cntrl-wrap">
												<span class="img-wrap"><img alt="" src="/kor/images/file_pt.gif"></span>
												<button type="button"><img src="/kor/images/btn_img_edit.gif" alt="편집"></button>
												<button type="button"><img src="/kor/images/btn_img_del.gif" alt="삭제"></button>
											</div>
										</td>
										<td class="c-red2">라벨/부품 사진을 첨부해 주십시오.<br>분쟁 발생 시 보호받을 수 있습니다.</td>
									</tr>
									<tr>
										<td colspan="5" lang="en"><strong class="c-red">Memo: </strong>XXXXXXXXXXXXXXXXXXXX</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="btn-area t-rt">
			<button type="button" onclick="shipping();"><img src="/kor/images/btn_transmit.gif" alt="전송"></button>
		</div>
	</form>
</div>

