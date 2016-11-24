<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
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
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/layer/buy_menu.php"); ?>z
<!-- //layer-left-menu -->

<!-- layer-content -->
<div class="layer-content">
	<!-- layer-pagination -->
	<div class="layer-pagination">
		<ul>
			<li class="navi-prev"><a href="#"><img src="/kor/images/nav_btn_down.png" alt="prev"></a></li>
			<li class="current"><a href="#" class="buy-mn12">1</a></li>
			<li><a href="#" class="buy-mn12-19-2-04">2</a></li>
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
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">납기</strong>
				<span class="etc"><span lang="ko">확인</span></span>
			</li>
			<li class="c1">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">납기 확인</strong>
				<span class="etc">4Days</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">수정 발주서</strong>
				<span class="etc">POA14-PS00002A</span>
			</li>
			<li class="c1">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">송장</strong>
				<span class="etc">EI14-PS00003A</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">결제완료</strong>
				<span class="etc">PO14-PS00001A</span>
				<span class="etc">My Bank</span>
			</li>
			<li class="c1">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">선적완료</strong>
				<span class="etc"><img src="/kor/images/icon_dhl.gif" alt="DHL"><br>-XXXXXXXXX</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">수량 부족</strong>
				<span class="etc">1st - 200EA</span>
			</li>
			<li class="c2">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">수량 부족</strong>
				<span class="etc">1st - 200EA</span>
			</li>
		</ol>
	</div>
	<!-- //layer-step -->
	
	<!-- layer-file -->
	<div class="layer-file">
		<table>
			<tbody>
				<tr>
					<td class="file" rowspan="2">
						<span class="c-blue" lang="ko">파일 / 사진 : </span>
						<a href="#">File1</a>, File2
						<span class="img-wrap"><img src="/kor/images/file_pt.gif" alt=""></span>
						<span class="img-wrap"><img src="/kor/images/file_pt.gif" alt=""></span>
					</td>
					<td class="t-rt">
						<div class="red-box"><span>부족 수량 개수 </span><strong lang="en">200</strong><span lang="en">EA</span></div>
					</td>
				</tr>
				<tr>
					<td class="file-memo">Memo: <strong>XXXXXXXXXXXXXXXXXXXX</strong></td>
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
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="13" class="title-box first">
						<h3 class="title"><img src="/kor/images/stock_title01.gif" alt="Special Price Stock"></h3>
					</td>
				</tr>
				<tr>
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
				</tr>
				<tr class="bg-none">
					<td></td>
					<td colspan="12">
						<table class="detail-table">
							<tbody>
								<tr>
									<th scope="row" style="width:70px">부품상태  : </th>
									<td>프로그램 삽입 부품 </td>
									<th scope="row" style="width:70px">포장상태 : </th>
									<td><span lang="ko">재포장</span> / <span lang="en">Tray</span></td>
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
	
	<!-- layer-btn -->
	<div class="btn-area t-rt">
		<a href="#" class="btn-dialog-18R09"><img src="/kor/images/btn_reply.gif" alt="답변서"></a>
	</div>
	<!-- //layer-btn -->
</div>
<!-- //layer-content -->