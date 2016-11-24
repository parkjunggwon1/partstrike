<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
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
			<li class="current"><a href="#" class="sell-mn03">1</a></li>
			<li><a href="#" class="sell-mn03-1208">2</a></li>
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
				<strong class="status">납기</strong>
				<span class="etc"><span lang="ko">확인</span></span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">납기 확인</strong>
				<span class="etc">10WK</span>
			</li>
			<li class="c1">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">발주서</strong>
				<span class="etc">PO14-PS00001A</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">송장</strong>
				<span class="etc">PO14-PS00001A</span>
			</li>
			<li class="c1">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">결제완료</strong>
				<span class="etc">US$0,000.00</span>
				<span class="etc">My Bank</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">결제완료</strong>
				<span class="etc">US$0,000.00</span>
				<span class="etc"><span lang="ko">신용카드</span></span>
			</li>
			<li class="c1">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">도착</strong>
				<span class="etc">XXXXX EA</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">수정 발주서</strong>
				<span class="etc">POA14-PS00001</span>
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
					<td class="c-red2 w100 t-ct">수정 발주서가 도착했습니다. </td>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- //layer-file -->
	
	<!-- layer-data -->
	<div class="layer-data">
		<table class="stock-list-table">
			<thead>
				<tr>
					<th scope="col" style="width:40px">No.</th>
					<th scope="col">Part No.</th>
					<th scope="col">Manufacture</th>
					<th scope="col">Package</th>
					<th scope="col">D/C</th>
					<th scope="col">RoHS</th>
					<th scope="col">Unit Price</th>
					<th scope="col" class="delivery" lang="ko">발주수량</th>
					<th scope="col" lang="ko">공급수량 </th>
					<th scope="col" lang="ko">납기</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="10" class="title-box first">
						<h3 class="title"><img src="/kor/images/stock_title01.gif" alt="Special Price Stock"></h3>
					</td>
				</tr>
				<tr>
					<td>377</td>
					<td>123456789123456789123456789123</td>
					<td>ManuManuManuManuManu</td>
					<td>PackaPacka</td>
					<td>NEW</td>
					<td>RoHS</td>
					<td>$10,000.00</td>
					<td class="c-blue">1,000,000</td>
					<td class="c-red">1,000,000</td>
					<td>Stock</td>
				</tr>
				<tr class="bg-none">
					<td></td>
					<td colspan="9">
						<table class="detail-table">
							<tbody>
								<tr>
									<th style="width: 70px;" scope="row">부품상태  : </th>
									<td><span lang="en">NEW &amp; Original</span></td>
									<th style="width: 70px;" scope="row">포장상태 : </th>
									<td><span lang="en">Original / Tube</span></td>
								</tr>
								<tr>
									<td lang="en" colspan="4"><strong class="c-red">Memo: </strong>XXXXXXXXXXXXXXXXXXXX</td>
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
	<p class="t-ct"><img alt="배송지변경" src="/kor/images/btn_shipping_change.gif"></p>
	<table class="detail-table mr-l50">
		<tbody>
			<tr>
				<th scope="row" style="width:70px">선적정보 : </th>
				<td style="width:130px"><span class="c-grey2">운송회사</span> <img src="/kor/images/icon_dhl.gif" alt="" height="10"></td>
				<th scope="row" style="width:80px"><span lang="en">Account No : </span></th>
				<td style="width:130px"><span lang="en">123456789</span></td>
				<th scope="row">운송보험 : </th>
				<td lang="en">Yes</td>
			</tr>
			<tr>
				<td colspan="6" lang="en"><strong class="c-red">Memo: </strong>XXXXXXXXXXXXXXXXXXXX</td>
			</tr>
		</tbody>
	</table>
	<table class="company-info-tb" style="width:800px" align="center">
		<tbody>
			<tr>
				<th scope="row">국가</th>
				<td colspan="5"><span lang="en">U.S.A</span></td>
			</tr>
			<tr>
				<th scope="row">회사명</th>
				<td colspan="5"><span lang="en">ABC Co., Ltd.</span></td>
			</tr>
			<tr>
				<th scope="row">담당자</th>
				<td colspan="5">&nbsp;</td>
			</tr>
			<tr>
				<th scope="row">직책</th>
				<td colspan="5">&nbsp;</td>
			</tr>
			<tr>
				<th scope="row">부서</th>
				<td colspan="5">&nbsp;</td>
			</tr>
			<tr>
				<th scope="row">회사구분</th>
				<td colspan="5">&nbsp;</td>
			</tr>
			<tr>
				<th scope="row"><span lang="en">Tel</span></th>
				<td>&nbsp;</td>
				<th scope="row"><span lang="en">Fax</span></th>
				<td>&nbsp;</td>
				<th scope="row">휴대전화</th>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<th scope="row"><span lang="en">E-mail</span></th>
				<td colspan="5">&nbsp;</td>
			</tr>
			<tr>
				<th scope="row">홈페이지</th>
				<td colspan="5">&nbsp;</td>
			</tr>
			<tr>
				<th scope="row">주소</th>
				<td colspan="5"><span lang="en">XXXXXXXXX, XXXX, U.S.A (123-456)</span></td>
			</tr>
		</tbody>
	</table>
	
	<!-- layer-btn -->
	<div class="btn-area t-rt">
		<a href="#" class="btn-view-sheet-3007"><img src="/kor/images/btn_order_confirm.gif" alt="발주서 확인"></a>
		<a href="#" class="btn-pop-0601"><img src="/kor/images/btn_cancel.gif" alt="취소"></a>
	</div>
	<!-- //layer-btn -->
</div>
<!-- //layer-content -->