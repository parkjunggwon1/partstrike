<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/header.php"); ?>
	
	<!-- content -->
	<div id="partsContent" class="container">
		<div class="col-left">
		
			<section id="stockTop" class="box-type1">
				<form>
					<span><a href="#"><img src="/kor/images/btn_apply_form_down.gif" alt="등록 양식 Download"></a></span>
					<span class="op1"><label class="i-file">턴키 파일 <input type="file" onChange="javascript: document.getElementById('fileName').value = this.value"><input type="text" id="fileName" readonly><span></span></label></span>
					<span class="op4"><input type="text" class="i-txt2 c-red" value="Priice"> <button type="submit"><img src="/kor/images/btn_form_apply.gif" alt="등록"></button></span>
				</form>
			</section>
			
			<section id="turnkeyManageTop" class="box-type1">
				<form>
					<div class="box-top bg2">
						<h2>내 턴키 편집</h2>
					</div>
					<table class="stock-list-table">
						<thead>
							<tr>
								<th scope="col">No.</th>
								<th scope="col" class="t-lt">Title</th>
								<th scope="col" style="width:60px">Price</th>
								<th scope="col" style="width:50px"></th>
								<th scope="col" style="width:50px"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td class="t-lt">123456789123456789123456789123</td>
								<td><input type="text" class="i-txt2" style="width:76px" value="$10,000.00"></td>
								<td><button type="submit"><img src="/kor/images/btn_turn_del.gif" alt="삭제"></button></td>
								<td><button type="submit"><img src="/kor/images/btn_turn_save.gif" alt="저장"></button></td>
							</tr>
							<tr>
								<td></td>
								<td colspan="4">
									<table class="stock-list-table">
										<thead>
											<tr>
												<th scope="col">No. </th>
												<th scope="col">Part No.</th>
												<th scope="col">Manufacturer</th>
												<th scope="col">Package</th>
												<th scope="col">D/C</th>
												<th scope="col">RoHS</th>
												<th scope="col">O'ty</th>
												<th scope="col" lang="ko">제거</th>
												<th class="down"><a href="#"><img src="/kor/images/btn_stock_list_down.gif" alt=""></a></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
												<td><input type="text" class="i-txt2" style="width:150px" value="ManuManuManuManuManu"></td>
												<td><input type="text" class="i-txt2 w-50" style="width:65px" value="PackaPacka"></td>
												<td><input type="text" class="i-txt2" style="width:36px" value="254"></td>
												<td>
													<div class="select type4" lang="en" style="width:60px">
														<label>RoHS</label>
														<select>
															<option lang="en">RoHS</option>
															<option lang="en">RoHS</option>
														</select>
													</div>
												</td>
												<td><input type="text" class="i-txt2" style="width:58px" value="1,000,000"></td>
												<td><label class="ipt-chk chk3"><input type="checkbox"><span></span></label></td>
												<td></td>
											</tr>
											<tr>
												<td>2</td>
												<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
												<td><input type="text" class="i-txt2" style="width:150px" value="ManuManuManuManuManu"></td>
												<td><input type="text" class="i-txt2 w-50" style="width:65px" value="PackaPacka"></td>
												<td><input type="text" class="i-txt2" style="width:36px" value="254"></td>
												<td>
													<div class="select type4" lang="en" style="width:60px">
														<label>RoHS</label>
														<select>
															<option lang="en">RoHS</option>
															<option lang="en">RoHS</option>
														</select>
													</div>
												</td>
												<td><input type="text" class="i-txt2" style="width:58px" value="1,000,000"></td>
												<td><label class="ipt-chk chk3"><input type="checkbox"><span></span></label></td>
												<td></td>
											</tr>
											<tr>
												<td>3</td>
												<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
												<td><input type="text" class="i-txt2" style="width:150px" value="ManuManuManuManuManu"></td>
												<td><input type="text" class="i-txt2 w-50" style="width:65px" value="PackaPacka"></td>
												<td><input type="text" class="i-txt2" style="width:36px" value="254"></td>
												<td>
													<div class="select type4" lang="en" style="width:60px">
														<label>RoHS</label>
														<select>
															<option lang="en">RoHS</option>
															<option lang="en">RoHS</option>
														</select>
													</div>
												</td>
												<td><input type="text" class="i-txt2" style="width:58px" value="1,000,000"></td>
												<td><label class="ipt-chk chk3"><input type="checkbox"><span></span></label></td>
												<td></td>
											</tr>
											<tr>
												<td>4</td>
												<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
												<td><input type="text" class="i-txt2" style="width:150px" value="ManuManuManuManuManu"></td>
												<td><input type="text" class="i-txt2 w-50" style="width:65px" value="PackaPacka"></td>
												<td><input type="text" class="i-txt2" style="width:36px" value="254"></td>
												<td>
													<div class="select type4" lang="en" style="width:60px">
														<label>RoHS</label>
														<select>
															<option lang="en">RoHS</option>
															<option lang="en">RoHS</option>
														</select>
													</div>
												</td>
												<td><input type="text" class="i-txt2" style="width:58px" value="1,000,000"></td>
												<td><label class="ipt-chk chk3"><input type="checkbox"><span></span></label></td>
												<td></td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td>2</td>
								<td class="t-lt">123456789123456789123456789123</td>
								<td><input type="text" class="i-txt2" style="width:76px" value="$10,000.00"></td>
								<td><button type="submit"><img src="/kor/images/btn_turn_del.gif" alt="삭제"></button></td>
								<td><button type="submit"><img src="/kor/images/btn_turn_save.gif" alt="저장"></button></td>
							</tr>
							<tr>
								<td>3</td>
								<td class="t-lt">123456789123456789123456789123</td>
								<td><input type="text" class="i-txt2" style="width:76px" value="$10,000.00"></td>
								<td><button type="submit"><img src="/kor/images/btn_turn_del.gif" alt="삭제"></button></td>
								<td><button type="submit"><img src="/kor/images/btn_turn_save.gif" alt="저장"></button></td>
							</tr>
						</tbody>
					</table>
				</form>
			</section>
			
			<!-- stockManage -->
			<section id="stockManage" class="box-type1">
				<form>
					<div class="box-top srch-box bg2">
						<div class="srch-block1"><label lang="en">Part No. <input type="text"></label><button type="submit"><img src="/kor/images/btn_srch2.gif" alt="검색"></button></div>
						<h2 class="srch-block2">턴키 목록</h2>
					</div>
					<table class="stock-list-table">
						<thead>
							<tr>
								<th scope="col">No. </th>
								<th scope="col">Nation</th>
								<th scope="col" class="t-lt w60">Title</th>
								<th scope="col" style="width:110px">Price</th>
								<th scope="col">&nbsp;</th>
								<th scope="col" lang="ko">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td><img src="/kor/images/nation_title2_uk.png" alt=""/></td>
								<td class="t-lt">123456789123456789123456789123</td>
								<td>$10,000.00</td>
								<td class="delivery"><a href="#"><img src="/kor/images/btn_order.gif" alt="발주"></a></td>
								<td class="delivery"><a href="#"><img src="/kor/images/btn_mybox.gif" alt="My box"></a></td>
							</tr>
							<tr>
								<td>2</td>
								<td><img src="/kor/images/nation_title2_usa.png" alt=""/></td>
								<td class="t-lt">123456789123456789123456789123</td>
								<td>$10,000.00</td>
								<td class="delivery"><a href="#"><img src="/kor/images/btn_order.gif" alt="발주"></a></td>
								<td class="delivery"><a href="#"><img src="/kor/images/btn_mybox.gif" alt="My box"></a></td>
							</tr>
							<tr>
								<td>3</td>
								<td><img src="/kor/images/nation_title2_ch.png" alt=""/></td>
								<td class="t-lt">123456789123456789123456789123</td>
								<td>$10,000.00</td>
								<td class="delivery"><a href="#"><img src="/kor/images/btn_order.gif" alt="발주"></a></td>
								<td class="delivery"><a href="#"><img src="/kor/images/btn_mybox.gif" alt="My box"></a></td>
							</tr>
							<tr>
								<td>4</td>
								<td><img src="/kor/images/nation_title2_uk.png" alt=""/></td>
								<td class="t-lt">123456789123456789123456789123</td>
								<td>$10,000.00</td>
								<td class="delivery"><a href="#"><img src="/kor/images/btn_order.gif" alt="발주"></a></td>
								<td class="delivery"><a href="#"><img src="/kor/images/btn_mybox.gif" alt="My box"></a></td>
							</tr>
							<tr>
								<td>5</td>
								<td><img src="/kor/images/nation_title2_uk.png" alt=""/></td>
								<td class="t-lt">123456789123456789123456789123</td>
								<td>$10,000.00</td>
								<td class="delivery"><a href="#"><img src="/kor/images/btn_order.gif" alt="발주"></a></td>
								<td class="delivery"><a href="#"><img src="/kor/images/btn_mybox.gif" alt="My box"></a></td>
							</tr>
							<tr>
								<td>6</td>
								<td><img src="/kor/images/nation_title2_uk.png" alt=""/></td>
								<td class="t-lt">123456789123456789123456789123</td>
								<td>$10,000.00</td>
								<td class="delivery"><a href="#"><img src="/kor/images/btn_order.gif" alt="발주"></a></td>
								<td class="delivery"><a href="#"><img src="/kor/images/btn_mybox.gif" alt="My box"></a></td>
							</tr>
							<tr>
								<td>7</td>
								<td><img src="/kor/images/nation_title2_uk.png" alt=""/></td>
								<td class="t-lt">123456789123456789123456789123</td>
								<td>$10,000.00</td>
								<td class="delivery"><a href="#"><img src="/kor/images/btn_order.gif" alt="발주"></a></td>
								<td class="delivery"><a href="#"><img src="/kor/images/btn_mybox.gif" alt="My box"></a></td>
							</tr>
							<tr>
								<td>8</td>
								<td><img src="/kor/images/nation_title2_uk.png" alt=""/></td>
								<td class="t-lt">123456789123456789123456789123</td>
								<td>$10,000.00</td>
								<td class="delivery"><a href="#"><img src="/kor/images/btn_order.gif" alt="발주"></a></td>
								<td class="delivery"><a href="#"><img src="/kor/images/btn_mybox.gif" alt="My box"></a></td>
							</tr>
							<tr>
								<td>9</td>
								<td><img src="/kor/images/nation_title2_uk.png" alt=""/></td>
								<td class="t-lt">123456789123456789123456789123</td>
								<td>$10,000.00</td>
								<td class="delivery"><a href="#"><img src="/kor/images/btn_order.gif" alt="발주"></a></td>
								<td class="delivery"><a href="#"><img src="/kor/images/btn_mybox.gif" alt="My box"></a></td>
							</tr>
							<tr>
								<td>10</td>
								<td><img src="/kor/images/nation_title2_uk.png" alt=""/></td>
								<td class="t-lt">123456789123456789123456789123</td>
								<td>$10,000.00</td>
								<td class="delivery"><a href="#"><img src="/kor/images/btn_order.gif" alt="발주"></a></td>
								<td class="delivery"><a href="#"><img src="/kor/images/btn_mybox.gif" alt="My box"></a></td>
							</tr>
						</tbody>					
					</table>
					<div class="pagination">
						<ul>
							<li class="navi-prev"><a href="#">Prev</a></li>
							<li class="current"><a href="#">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">5</a></li>
							<li><a href="#">6</a></li>
							<li><a href="#">7</a></li>
							<li><a href="#">8</a></li>
							<li><a href="#">9</a></li>
							<li><a href="#">10</a></li>
							<li class="navi-next"><a href="#">Next</a></li>
						</ul>
					</div>
				</form>
			</section>
			<!--// stockManage -->
			
		</div>
		<div class="col-right">
			<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/side_turnkey.php"); ?>
		</div>
	</div>
	<!-- //content -->
	
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/footer.php"); ?>
	
