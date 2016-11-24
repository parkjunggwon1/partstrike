<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?><!-- layer-tab -->
<div class="layer-tab">
	<ul>
		<li><a href="#" class="view-sell"><img src="/kor/images/layer_tab_sell_off.png" alt="판매"></a><a href="#" class="btn-close"><img src="/kor/images/btn_layer_close.png" alt="close"></a></li>
		<li class="current"><a href="#" class="view-buy"><img src="/kor/images/layer_tab_buy_on.png" alt="구매"></a></li>
	</ul>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close.png" alt="close"></a>
</div>
<!-- //layer-tab -->

<!-- layer-left-menu -->
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/layer/buy_menu.php"); ?>
<!-- //layer-left-menu -->

<!-- layer-content -->
<div class="layer-content">
	<!-- layer-pagination -->
	<div class="layer-pagination">
		<ul>
			<li class="navi-prev"><a href="#"><img src="/kor/images/nav_btn_down.png" alt="prev"></a></li>
			<li><a href="#" class="buy-mn02">1</a></li>
			<li><a href="#" class="buy-mn02-0513">2</a></li>
			<li class="current"><a href="#" class="buy-mn02-1206">3</a></li>
			<li><a href="#" class="buy-mn02-1101">4</a></li>
			<li><a href="#">5</a></li>
			<li><a href="#">6</a></li>
			<li><a href="#">7</a></li>
			<li><a href="#">8</a></li>
			<li><a href="#">9</a></li>
			<li><a href="#">10</a></li>
			<li><a href="#">11</a></li>
			<li><a href="#">12</a></li>
			<li><a href="#">13</a></li>
			<li><a href="#">14</a></li>
			<li><a href="#">15</a></li>
			<li><a href="#">16</a></li>
			<li><a href="#">17</a></li>
			<li><a href="#">18</a></li>
			<li><a href="#">19</a></li>
			<li><a href="#">20</a></li>
			<li class="navi-next"><a href="#"><img src="/kor/images/nav_btn_up.png" alt="next"></a></li>
		</ul>
	</div>
	<!-- //layer-pagination -->
	
	<!-- layer-step -->
	<div class="layer-step">
		<ol>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">납기</strong>
				<span class="etc">확인</span>
			</li>
			<li class="c1">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">납기확인</strong>
				<span class="etc">3Days</span>
			</li>
		</ol>
	</div>
	<!-- //layer-step -->
	
	<form>
	<!-- layer-data -->
	<div class="layer-data">
		<table class="stock-list-table bg-type2">
			<thead>
				<tr>
					<th scope="col" style="width:50px"><!--<span lang="ko">선적</span><br>-->Option</th>
					<th scope="col">No.</th>
					<th scope="col">Nation</th>
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
					<th scope="col">Company</th>
					<th scope="col">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="15" class="step-cell">
						<div class="layer-step" lang="ko">
							<ol>
								<li>
									<span class="date">Day, Month, 2014</span>
									<strong class="status">납기</strong>
									<span class="etc"><span lang="ko">확인</span></span>
								</li>
								<li class="c1">
									<span class="date">Day, Month, 2014</span>
									<strong class="status">납기확인</strong>
									<span class="etc">10WK</span>
								</li>
								<li>
									<span class="date">Day, Month, 2014</span>
									<strong class="status">발주서</strong>
									<span class="etc">PO14-PS00001A</span>
								</li>
								<li class="c1">
									<span class="date">Day, Month, 2014</span>
									<strong class="status">송장</strong>
									<span class="etc">PO14-PS00001A</span>
								</li>
								<li>
									<span class="date">Day, Month, 2014</span>
									<strong class="status">결제완료</strong>
									<span class="etc">PO14-PS00001A</span>
									<span class="etc">My Bank</span>
								</li>
								<li class="c1">
									<span class="date">Day, Month, 2014</span>
									<strong class="status">결제완료</strong>
									<span class="etc">PO14-PS00001A</span>
									<span class="etc"><span lang="ko">신용카드</span></span>
								</li>
								<li class="c1">
									<span class="date">Day, Month, 2014</span>
									<strong class="status">도착</strong>
									<span class="etc">XXXXX EA</span>
								</li>
							</ol>
						</div>
					</td>
				</tr>
			</tbody>
			<tbody>
				<tr>
					<td colspan="15" class="title-box first">
						<h3 class="title"><img src="/kor/images/stock_title01.gif" alt="Special Price Stock"></h3>
					</td>
				</tr>
				<tr>
					<td><label class="ipt-chk chk2"><input type="checkbox"><span></span></label></td>
					<td>377</td>
					<td><img src="/kor/images/nation_title2_uk.png" alt="United Kingdom"></td>
					<td>12345678912345678912<br>12345678912345678912</td>
					<td>ManuManuManuMan<br>ManuManuManuMan</td>
					<td>PackaPacka</td>
					<td>NEW</td>
					<td>RoHS</td>
					<td>1,000,000</td>
					<td>$10,000.00</td>
					<td class="c-blue">1,000,000</td>
					<td class="c-red">1,000,000</td>
					<td>Stock</td>
					<td class="c-blue">Abcdefghijklmno<br>12345678.co.Ltd </td>
					<td><button type="button"><img src="/kor/images/btn_cancel.gif" alt="취소"></button></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td colspan="13">
						<table class="detail-table">
							<tbody>
								<tr>
									<th scope="row" style="width:70px">부품상태  : </th>
									<td><span lang="en">NEW &amp; Original </span></td>
									<th scope="row" style="width:70px">포장상태 : </th>
									<td><span lang="en">Original / Tube</span></td>
								</tr>
								<tr>
									<td colspan="4" lang="en"><strong class="c-red">Memo: </strong>XXXXXXXXXXXXXXXXXXXX</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="15" class="title-box">
						<h3 class="title"><img src="/kor/images/stock_title01.gif" alt="Special Price Stock"></h3>
					</td>
				</tr>
				<tr>
					<td><label class="ipt-chk chk2"><input type="checkbox"><span></span></label></td>
					<td>377</td>
					<td><img src="/kor/images/nation_title2_uk.png" alt="United Kingdom"></td>
					<td>12345678912345678912<br>12345678912345678912</td>
					<td>ManuManuManuMan<br>ManuManuManuMan</td>
					<td>PackaPacka</td>
					<td>NEW</td>
					<td>RoHS</td>
					<td>1,000,000</td>
					<td>$10,000.00</td>
					<td class="c-blue"><input class="i-txt2 c-blue t-ct" style="width: 62px;" type="text" value="1,000,000"></td>
					<td class="c-red">1,000,000</td>
					<td>Stock</td>
					<td class="c-blue">Abcdefghijklmno<br>12345678.co.Ltd </td>
					<td><button type="button"><img src="/kor/images/btn_delete3.gif" alt="삭제"></button></td>
				</tr>
			</tbody>
			<tbody>
				<tr>
					<td colspan="15" class="step-cell">
						<div class="layer-step" lang="ko">
							<ol>
								<li>
									<span class="date">Day, Month, 2014</span>
									<strong class="status">납기</strong>
									<span class="etc"><span lang="ko">확인</span></span>
								</li>
								<li class="c1">
									<span class="date">Day, Month, 2014</span>
									<strong class="status">납기확인</strong>
									<span class="etc">10WK</span>
								</li>
							</ol>
						</div>
					</td>
				</tr>
			</tbody>
			<tbody>
				<tr>
					<td colspan="15" class="title-box first">
						<h3 class="title"><img src="/kor/images/stock_title01.gif" alt="Special Price Stock"></h3>
					</td>
				</tr>
				<tr>
					<td><label class="ipt-chk chk2"><input type="checkbox"><span></span></label></td>
					<td>377</td>
					<td><img src="/kor/images/nation_title2_uk.png" alt="United Kingdom"></td>
					<td>12345678912345678912<br>12345678912345678912</td>
					<td>ManuManuManuMan<br>ManuManuManuMan</td>
					<td>PackaPacka</td>
					<td>NEW</td>
					<td>RoHS</td>
					<td>1,000,000</td>
					<td>$10,000.00</td>
					<td class="c-blue"><input class="i-txt2 c-blue t-ct" style="width: 62px;" type="text" value="1,000,000"></td>
					<td class="c-red">1,000,000</td>
					<td class="c-red">4Days</td>
					<td class="c-blue">Abcdefghijklmno<br>12345678.co.Ltd </td>
					<td><button type="button"><img src="/kor/images/btn_delete3.gif" alt="삭제"></button></td>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- //layer-data -->
	<hr class="dashline2 mr-t0">
	<table class="detail-table mr-t0 mr-l50">
		<tbody>
			<tr>
				<th scope="row">선적정보:</th>
				<td>
					<span class="c-grey2">운송회사</span>
					<div class="select type4" lang="en" style="width: 70px;">
						<label class="c-blue">DHL</label>
						<select>
							<option>DHL</option>
							<option>DHL</option>
						</select>
					</div>
				</td>
				<th scope="row"><span lang="en">Account No.</span></th>
				<td><input class="i-txt2 c-blue" style="width: 92px;" type="text" value="123456789"></td>
			</tr>
			<tr>
				<td lang="en" colspan="4"><strong class="c-red">Memo</strong> <input class="i-txt2 c-blue" style="width: 323px;" type="text" value="XXXXXXXXXXXXXXXXXXXX"></td>
			</tr>
			<tr>
				<td colspan="4"><label class="ipt-chk chk2"><input type="checkbox"><span></span> 운송보험</label></td>
			</tr>
			<tr>
				<td colspan="4"><label class="ipt-chk chk2 com-chck"><input type="checkbox" class="checked" checked><span></span> 배송지 변경</label></td>
			</tr>
		</tbody>
	</table>
	<!-- company-info-wrap -->
	<div class="company-info-wrap mr-l70">
		<table class="company-info-tb" style="width:745px">
			<tbody>
				<tr>
					<th scope="row" class="bg-wt"><label class="ipt-chk chk2 f-lt"><input type="checkbox"><span></span></label><strong class="c-red">*</strong> 회사 <span lang="en">ID</span></th>
					<td class="bg-wt" style="width:220px"><input class="i-txt2" type="text" style="width:215px"></td>
					<td class="bg-wt" style="width:60px"><button type="button"><img alt="검사" src="/kor/images/btn_srch3.gif"></button></td>
					<td><label class="ipt-chk chk2"><input type="checkbox"><span></span> 직접 입력</label></td>
				</tr>
			</tbody>
		</table>
		<table class="company-info-tb" style="width:745px">
			<tbody>
				<tr>
					<th scope="row"><strong class="c-red">*</strong> 국가</th>
					<td colspan="2">
						<div class="select type5 bd2" lang="en" style="width: 215px;">
							<label class="c-blue">KOREA</label>
							<select>
								<option>KOREA</option>
								<option>KOREA</option>
							</select>
						</div>
					</td>
				</tr>
				<tr>
					<th scope="row"><strong class="c-red">*</strong> 회사명</th>
					<td colspan="2"><input class="i-txt5 c-blue" type="text" style="width:215px" value="WXYZ Limited."></td>
				</tr>
				<tr>
					<th scope="row"><strong class="c-red">*</strong> 담당자</th>
					<td colspan="2"><input class="i-txt5 c-blue" type="text" style="width:215px"></td>
				</tr>
				<tr>
					<th scope="row"><strong class="c-red">*</strong> 직책</th>
					<td colspan="2"><input class="i-txt5 c-blue" type="text" style="width:215px"></td>
				</tr>
				<tr>
					<th scope="row"><strong class="c-red">*</strong> 부서</th>
					<td colspan="2"><input class="i-txt5 c-blue" type="text" style="width:215px"></td>
				</tr>
				<tr>
					<th scope="row"><strong class="c-red">*</strong> 회사구분</th>
					<td colspan="2">
						<div class="select type5 bd2" lang="en" style="width: 215px;">
							<label class="c-blue">회사구분</label>
							<select>
								<option>회사구분</option>
								<option>회사구분</option>
							</select>
						</div>
					</td>
				</tr>
				<tr>
					<th scope="row"><strong class="c-red">*</strong> <span lang="en">Tel</span></th>
					<td colspan="2"><input class="i-txt5 c-blue" type="text" style="width:215px"></td>
				</tr>
				<tr>
					<th scope="row"><strong class="c-red">*</strong> <span lang="en">Fax</span></th>
					<td colspan="2"><input class="i-txt5 c-blue" type="text" style="width:215px"></td>
				</tr>
				<tr>
					<th scope="row"><strong class="c-red">*</strong> 휴대전화</th>
					<td colspan="2"><input class="i-txt5 c-blue" type="text" style="width:215px"></td>
				</tr>
				<tr>
					<th scope="row"><strong class="c-red">*</strong> <span lang="en">E-mail</span></th>
					<td colspan="2"><input class="i-txt5 c-blue" type="text" style="width:215px" value="sales@wxyz.com"></td>
				</tr>
				<tr>
					<th scope="row"><strong class="c-red">*</strong> 홈페이지</th>
					<td colspan="2"><input class="i-txt5 c-blue" type="text" style="width:215px"></td>
				</tr>
				<tr>
					<th scope="row"><strong class="c-red">*</strong> 우편번호</th>
					<td colspan="2"><input class="i-txt5 c-blue" type="text" style="width:215px" value="123-456"></td>
				</tr>
				<tr>
					<th scope="row"><strong class="c-red">*</strong> 도/시</th>
					<td colspan="2">
						<div class="select type5 bd2" lang="en" style="width: 215px;">
							<label class="c-blue">XXXXX</label>
							<select>
								<option>XXXXX</option>
								<option>XXXXX</option>
							</select>
						</div>
					</td>
				</tr>
				<tr>
					<th scope="row"><strong class="c-red">*</strong> 시/군/구</th>
					<td colspan="2">
						<div class="select type5 bd2" lang="en" style="width: 215px;">
							<label class="c-blue">XXXXX</label>
							<select>
								<option>XXXXX</option>
								<option>XXXXX</option>
							</select>
						</div>
					</td>
				</tr>
				<tr>
					<th scope="row"><strong class="c-red">*</strong> 주소</th>
					<td><input class="i-txt5 c-blue w100" type="text" value="XXXXXXXXX, XXXX, KOREA "></td>
					<td style="width:120px"><button type="button"><img src="/kor/images/btn_save.gif" alt="저장"></button> <button type="button"><img src="/kor/images/btn_delete3.gif" alt="삭제"></button></td>
				</tr>
				<tr>
					<td colspan="3">
						<table class="company-rank">
							<thead>
								<tr>
									<th scope="col">No.</th>
									<th scope="col" lang="ko">회사명</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1.</td>
									<td>ABC Co., Ltd</td>
								</tr>
								<tr>
									<td>2.</td>
									<td>ABC Co., Ltd</td>
								</tr>
								<tr>
									<td>3.</td>
									<td>ABC Co., Ltd</td>
								</tr>
								<tr>
									<td>4.</td>
									<td>ABC Co., Ltd</td>
								</tr>
								<tr>
									<td>5.</td>
									<td>ABC Co., Ltd</td>
								</tr>
								<tr>
									<td>6.</td>
									<td>ABC Co., Ltd</td>
								</tr>
								<tr>
									<td>7.</td>
									<td>ABC Co., Ltd</td>
								</tr>
								<tr>
									<td>8.</td>
									<td>ABC Co., Ltd</td>
								</tr>
								<tr>
									<td>9.</td>
									<td>ABC Co., Ltd</td>
								</tr>
								<tr>
									<td>10.</td>
									<td>ABC Co., Ltd</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- //company-info-wrap -->
		
	<!-- layer-btn -->
	<div class="btn-area t-rt">
		<button type="button" class="btn-dialog-0501"><img src="/kor/images/btn_order_add.gif" alt="발주 추가"></button>
		<button type="button" class="btn-view-sheet-1207"><img src="/kor/images/btn_order_confirm.gif" alt="발주서 확인"></button>
		<button type="button"><img src="/kor/images/btn_order_save.gif" alt="저장"></button>
	</div>
	<!-- //layer-btn -->
	
	</form>
	
</div>
<!-- //layer-content -->