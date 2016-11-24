<!-- layer-tab -->
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
			<li class="current"><a href="#" class="buy-mn02-0513">2</a></li>
			<li><a href="#" class="buy-mn02-1206">3</a></li>
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
		<table class="stock-list-table">
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
					<th scope="col">Q’ty</th>
					<th scope="col">Unit Price</th>
					<th scope="col" lang="ko">발주수량</th>
					<th scope="col" lang="ko">공급수량</th>
					<th scope="col" lang="ko">납기</th>
					<th scope="col" lang="ko">&nbsp;</th>
					</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="14" class="title-box first">
						<h3 class="title"><img src="/kor/images/stock_title06.gif" alt="해외 위탁판매 Stock"></h3>
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
					<td class="c-blue"><input type="text" class="i-txt2 c-blue t-ct" value="1,000,000" style="width:62px"></td>
					<td class="c-red">1,000,000</td>
					<td class="c-red">3Days</td>
					<td class="c-red"><button type="button"><img src="/kor/images/btn_delete2.gif" alt="삭제"></button></td>
				</tr>
				<tr class="bg-none">
					<td></td>
					<td></td>
					<td colspan="12">
						<table class="detail-table">
							<tbody>
								<tr>
									<th scope="row">선적정보:</th>
									<td>
										<span class="c-grey2">운송회사</span>
										<div class="select type4" lang="en" style="width:70px">
											<label class="c-blue">DHL</label>
											<select>
												<option>DHL</option>
												<option>DHL</option>
											</select>
										</div>
									</td>
									<th scope="row"><span lang="en">Account No.</span></th>
									<td><input type="text" class="i-txt2 c-blue" value="123456789" style="width:92px"></td>
								</tr>
								<tr>
									<td colspan="4" lang="en"><strong class="c-red">Memo</strong> <input type="text" class="i-txt2 c-blue" value="XXXXXXXXXXXXXXXXXXXX" style="width:323px"></td>
								</tr>
								<tr>
									<td colspan="4"><label class="ipt-chk chk2"><input type="checkbox"><span></span> 운송보험</label></td>
								</tr>
								<tr>
									<td colspan="4"><label class="ipt-chk chk2 com-chck"><input type="checkbox" class="checked" checked><span></span> 배송지 변경</label></td>
								</tr>
							</tbody>
						</table>
						<div class="company-info-wrap">
							<table class="company-info-tb">
								<tbody>
									<tr>
										<th scope="row"><label class="ipt-chk chk2 f-lt"><input type="checkbox"><span></span></label><strong class="c-red">*</strong> 회사 <span lang="en">ID</span></th>
										<td><input class="i-txt2" type="text" style="width:215px"></td>
										<td rowspan="2"><button type="button"><img alt="검사" src="/kor/images/btn_srch4.gif"></button></td>
										<td rowspan="2" class="bg-wt"><label class="ipt-chk chk2"><input type="checkbox"><span></span> 직접 입력</label></td>
									</tr>
									<tr>
										<th scope="row"><strong class="c-red">*</strong> 직원 <span lang="en">ID</span></th>
										<td><input class="i-txt2" type="text" style="width:215px"></td>
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
										<td style="width:60px"><button type="button"><img src="/kor/images/btn_save.gif" alt="저장"></button>									<button type="button"><img src="/kor/images/btn_delete3.gif" alt="삭제"></button></td>
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
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- //layer-data -->
	
	<!-- layer-btn -->
	<div class="btn-area t-rt">
		<button type="button" class="btn-dialog-0501"><img src="/kor/images/btn_order_add.gif" alt="발주 추가"></button>
		<button type="button" class="btn-order-confirm"><img src="/kor/images/btn_order_confirm.gif" alt="발주서 확인"></button>
		<button type="button"><img src="/kor/images/btn_order_save.gif" alt="저장"></button>
	</div>
	<!-- //layer-btn -->
	
	</form>
</div>
<!-- //layer-content -->