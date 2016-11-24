<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/header.php"); ?>
	
	<!-- content -->
	<div id="partsContent" class="container">
		<div class="col-left">
			<!-- mybankSrch -->
			<section id="mybankSrch" class="box-type5">
				<form class="clear">
					<table>
						<tbody>
							<tr>
								<th scope="row">년도</th>
								<td>
									<div class="select" lang="en">
										<label for="yr">N/A</label>
										<select id="yr">
											<option lang="en">1111</option>
											<option lang="en">222222222</option>
										</select>
									</div>
								</td>
								<th scope="row">월</th>
								<td>
									<div class="select" lang="en">
										<label for="yr">N/A</label>
										<select id="yr">
											<option lang="en">1111</option>
											<option lang="en">222222222</option>
										</select>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					<button type="submit"><img src="/kor/images/btn_srch.gif" alt="검색"></button>
				</form>
				<!-- 버튼 -->
				<div class="btns">
					<button type="submit"><img src="/kor/images/btn_mybank_chrg.gif" alt="My Bank 충전"></button>
					<button type="submit"><img src="/kor/images/btn_mybank_draw.gif" alt="인출"></button>
				</div>
			</section>
			<!-- //mybankSrch -->			
			
			<!-- mybankTable -->
			<section id="mybankTable" class="box-type1">
				<div class="box-top">
					<h2><span lang="en">My Bank</span> 충전</h2>
				</div>
				<table class="stock-list-table">
						<thead>
							<th scope="col" class="th2" lang="ko">날짜</th>
							<th scope="col" class="th2">User ID</th>
							<th scope="col" class="th2" lang="ko">성명/직함</th>
							<th scope="col" class="th2" lang="ko">방법</th>
							<th scope="col" class="th2">Invoice No.</th>
							<th scope="col" class="th2" lang="ko">충전금액</th>
							<th scope="col" class="th2">My Bank</th>
						</thead>
						<tbody>
							<tr>
								<td class="c-red2" lang="ko">2014년 10월 01일</td>
								<td>User ID</td>
								<td lang="ko">성명/직함</td>
								<td lang="ko">은행송금</td>
								<td class="c-purple">CMBI1405-PS00025A</td>
								<td class="c-blue2 t-rt">$1,200.00</td>
								<td class="t-rt">$1,678.49</td>
							</tr>
							<tr>
								<td class="c-red2" lang="ko">2014년 10월 01일</td>
								<td>User ID</td>
								<td lang="ko">성명/직함</td>
								<td lang="ko">신용카드</td>
								<td class="c-purple">CMBI1405-PS00025A</td>
								<td class="c-blue2 t-rt">$200.00</td>
								<td class="t-rt">$540.00</td>
							</tr>
							<tr>
								<td class="c-red2" lang="ko">2014년 10월 01일</td>
								<td>User ID</td>
								<td lang="ko">성명/직함</td>
								<td lang="ko">신용카드</td>
								<td class="c-purple">CMBI1405-PS00025A</td>
								<td class="c-blue2 t-rt">$1,200.00</td>
								<td class="t-rt">$1,200.00</td>
							</tr>
							<tr>
								<td class="c-red2" lang="ko">2014년 10월 01일</td>
								<td>User ID</td>
								<td lang="ko">성명/직함</td>
								<td lang="ko">신용카드</td>
								<td class="c-purple">CMBI1405-PS00025A</td>
								<td class="c-blue2 t-rt">$200.00</td>
								<td class="t-rt">$945.55</td>
							</tr>
						</tbody>					
					</table>
			</section>
			<!--// mybankTable -->
			
		</div>
		<div class="col-right">
			<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/side_order.php"); ?>
		</div>
	</div>
	<!-- //content -->
	
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/footer.php"); ?>
	
