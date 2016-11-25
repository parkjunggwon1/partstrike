<!-- layer-tab -->
<div class="layer-tab">
	<ul>
		<li class="current"><a href="#" class="view-sell"><img src="/kor/images/layer_tab_sell_on.png" alt="판매"></a></li>
		<li><a href="#" class="view-buy"><img src="/kor/images/layer_tab_buy_off.png" alt="구매"></a></li>
	</ul>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<!-- //layer-tab -->

<!-- layer-left-menu -->
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/layer/sell_menu.php"); ?>
<!-- //layer-left-menu -->

<!-- layer-content -->
<div class="layer-content">
	<!-- layer-pagination -->
	<div class="layer-pagination">
		<ul>
			<li class="navi-prev"><a href="#"><img src="/kor/images/nav_btn_down.png" alt="prev"></a></li>
			<li><a href="#" class="sell-mn11">1</a></li>
			<li class="current"><a href="#" class="sell-mn11-18-1-10">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
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
			<li class="c1">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">수정 발주서</strong>
				<span class="etc">PO14-PS00001A</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">송장</strong>
				<span class="etc">EI14-PS00003A</span>
			</li>
			<li class="c1">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">결제완료</strong>
				<span class="etc">PO14-PS00001A</span>
				<span class="etc">My Bank</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">선적완료</strong>
				<span class="etc"><img src="/kor/images/icon_dhl.gif" alt="DHL"><br>-XXXXXXXXX XXXXXXXXX</span>
			</li>
			<li class="c2">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">거절</strong>
				<span class="etc">1st</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">거절</strong>
				<span class="etc">1st</span>
			</li>
			<li class="c2">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">거절</strong>
				<span class="etc">2nd</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">거절</strong>
				<span class="etc">2nd</span>
			</li>
			<li class="c2">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">거절</strong>
				<span class="etc">3rd-<span lang="ko">교환</span></span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">반품방법</strong>
				<span class="etc"><img src="/kor/images/icon_tnt.gif" alt="DHL"><br>
				- 0123ABCD</span>
			</li>
			<li class="c2">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">선적완료</strong>
				<span class="etc"><img src="/kor/images/icon_tnt.gif" alt="DHL"><br>
				-XXXXXXXXX</span>
			</li>
		</ol>
	</div>
	<!-- //layer-step -->
	
	<!-- layer-file -->
	<div class="layer-file">
		<table>
			<tbody>
				<tr>
					<td class="company"><img src="/kor/images/nation_title_uk.png" alt="United Kingdom"> <span class="name">DigitalDream Co., Ltd</span></td>
					<td class="c-red2 t-rt">운송회사 : <img alt="" src="/kor/images/icon_tnt.gif"> &nbsp;&nbsp;&nbsp;운송장번호: <span class="c-blue" lang="en">XXXXXXXXX</span></td>
				</tr>
				<tr>
					<td><div class="re-select"><strong>선택</strong><em>교환</em></div></td>
					<td class="c-red2 t-rt">반품 선적 서류 : <a href="#" class="btn-view-sheet-18-1-05"><img src="/kor/images/btn_none_commercial_invoice.gif" alt="Non-Commercial Invoice"></a> <a class="btn-pop-3018" href="#"><img alt="Packing List" src="/kor/images/btn_packing_list.gif"></a></td>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- //layer-file -->
	
	<form>
	<!-- layer-data -->
	<div class="layer-data">
		<table class="stock-list-table">
			<thead>
				<tr>
					<th scope="col" style="width:50px"><!--<span lang="ko">선적</span><br>-->Option</th>
					<th scope="col" style="width:40px">No.</th>
					<th scope="col">Part No.</th>
					<th scope="col">Manufacture</th>
					<th scope="col">Package</th>
					<th scope="col">D/C</th>
					<th scope="col">RoHS</th>
					<th scope="col">O'ty</th>
					<th scope="col">Unit Price</th>
					<th scope="col" class="delivery" lang="ko">발주수량</th>
					<th scope="col" lang="ko">공급수량</th>
					<th scope="col" lang="ko">납기</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="12" class="title-box first">
						<h3 class="title"><img src="/kor/images/stock_title01.gif" alt="Special Price Stock"></h3>
					</td>
				</tr>
				<tr>
					<td><label class="ipt-chk chk2"><input type="checkbox"><span></span></label></td>
					<td>377</td>
					<td>123456789123456789123456789123</td>
					<td>ManuManuManuManuManu</td>
					<td>PackaPacka</td>
					<td>NEW</td>
					<td>RoHS</td>
					<td>1,000,000</td>
					<td>$10,000.00</td>
					<td class="c-blue">1,000,000</td>
					<td class="c-red">1,000,000</td>
					<td>Stock</td>
				</tr>
				<tr class="bg-none">
					<td></td>
					<td></td>
					<td colspan="10">
						<table class="detail-table">
							<tbody>
								<tr>
									<th scope="row" style="width:70px">부품상태  : </th>
									<td>중고부품</td>
									<th scope="row" style="width:70px">포장상태 : </th>
									<td><span lang="en">Original / Tube</span></td>
								</tr>
								<tr>
									<td colspan="4" lang="en"><strong class="c-red">Memo: </strong>XXXXXXXXXXXXXXXXXXXX</td>
								</tr>
								<tr>
									<td colspan="4">
										<strong class="c-red">라벨/부품사진:</strong>
										<span class="img-wrap"><img src="/kor/images/file_pt.gif" alt=""></span>
										<span class="img-wrap"><img src="/kor/images/file_pt.gif" alt=""></span>
										<span class="img-wrap"><img src="/kor/images/file_pt.gif" alt=""></span>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- //layer-data -->
	
	<hr class="dashline2">
	
	<p class="c-red2 t-ct mr-tb15">
		<img src="/kor/images/btn_notice.gif" alt="공지"><br><br>
		문제가 있는/문제가 없는 제품의 체크박스를 선택하고 진행을 원하는 버튼을 선택하십시오.
	</p>
	
	<!-- layer-btn -->
	<div class="btn-area t-rt">
		<button type="button" class="f-lt btn-pop-18R20"><img src="/kor/images/btn_shipping.gif" alt="선적"></button>
		<button type="button" class="btn-pop-2001"><img src="/kor/images/btn_parts.gif" alt="PARTStrike"></button>
		<button type="button"><img src="/kor/images/btn_receipt.gif" alt="선적"></button>
	</div>
	<!-- //layer-btn -->
	</form>
	
</div>
<!-- //layer-content -->