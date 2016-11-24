<? @header("Content-Type: text/html; charset=utf-8");
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
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/layer/buy_menu.php"); ?>
<!-- //layer-left-menu -->

<!-- layer-content -->
<div class="layer-content">
	<!-- layer-pagination -->
	<div class="layer-pagination">
		<ul>
			<li class="navi-prev"><a href="#"><img src="/kor/images/nav_btn_down.png" alt="prev"></a></li>
			<li class="current"><a href="#" class="buy-mn16">1</a></li>
			<li><a href="#" class="buy-mn16-19-1-06">2</a></li>
			<li><span>3</span></li>
			<li><span>4</span></li>
			<li><span>5</span></li>
			<li><span>6</span></li>
			<li><span>7</span></li>
			<li><span>8</span></li>
			<li><span>9</span></li>
			<li><span>10</span></li>
			<li><span>11</span></li>
			<li><span>12</span></li>
			<li><span>13</span></li>
			<li><span>14</span></li>
			<li><span>15</span></li>
			<li><span>16</span></li>
			<li><span>17</span></li>
			<li><span>18</span></li>
			<li><span>19</span></li>
			<li><span>20</span></li>
			<li class="navi-next"><a href="#"><img src="/kor/images/nav_btn_up.png" alt="next"></a></li>
		</ul>
	</div>
	<!-- //layer-pagination -->
	
	<!-- layer-step -->
	<div class="layer-step">
		<ol>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">발주서</strong>
				<span class="etc">PO14-PS00001A</span>
			</li>
			<li class="c1">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">송장</strong>
				<span class="etc">EI14-PS00003A</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">결제완료</strong>
				<span class="etc">US$0,000.00</span>
				<span class="etc"><span>My Bank</span></span>
			</li>
			<li class="c1">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">선적완료</strong>
				<span class="etc"><img src="/kor/images/icon_dhl.gif" alt="DHL"><br>-XXXXXXXXX</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">거절</strong>
				<span class="etc">1st</span>
			</li>
			<li class="c2">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">거절</strong>
				<span class="etc">1st</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">거절</strong>
				<span class="etc">2nd</span>
			</li>
			<li class="c2">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">거절</strong>
				<span class="etc">2nd</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">거절</strong>
				<span class="etc">3rd-<span lang="ko">반품</span></span>
			</li>
			<li class="c2">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">반품방법</strong>
				<span class="etc"><span lang="ko">반품포기</span></span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">반품<br>선적 완료</strong>
				<span class="etc"><span lang="ko">반품포기</span></span>
			</li>
			<li class="c2">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">결제완료</strong>
				<span class="etc">US$0,000.00</span>
				<span class="etc"><span>My Bank</span></span>
			</li>
			<li class="c2">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">환불</strong>
				<span class="etc">US$0,000.00</span>
				<span class="etc"><span>My Bank</span></span>
			</li>
		</ol>
	</div>
	<!-- //layer-step -->
	
	<!-- layer-file -->
	<div class="layer-file">
		<table>
			<tbody>
				<tr>
					<td><div class="re-select"><strong>선택</strong><em>반품</em></div></td>
					<td class="c-red2 w100 t-ct">환불 (<strong class="c-blue"><span lang="en">US$0,000.00 - My Bank</span></strong>) 완료되었습니다.</td>
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
					<th scope="col">Amount</th>
					<th scope="col">Company</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="11" class="title-box first">
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
					<td>$0,000.00</td>
					<td class="c-blue">Abcdefghijklmno<br>12345678.co.Ltd </td>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- //layer-data -->
	
	<!-- layer-btn -->
	<div class="btn-area t-rt">
		<a href="#"><img src="/kor/images/btn_ok.gif" alt="확인"></a>
	</div>
	<!-- //layer-btn -->
</div>
<!-- //layer-content -->