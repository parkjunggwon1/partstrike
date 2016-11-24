<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/header.php"); ?>
	
	<!-- content -->
	<div id="partsContent" class="container">
		<div class="col-left">
			
			<form>
			<!-- form1 -->
			<section id="joinForm2" class="box-type1">
				<div class="box-top">
					<h2>직원</h2>
				</div>
				<table class="join-form-table">
					<colgroup>
						<col style="width:141px">
						<col style="width:215px">
						<col style="width:25px">
						<col style="width:215px">
					</colgroup>
					<tbody>
						<tr>
							<th scope="row"><strong class="c-red">*</strong> 회사 <span lang="en">ID</span></th>
							<td><input type="text" class="i-txt3"></td>
							<td>&nbsp;</td>
							<td><button type="button"><img src="/kor/images/btn_id_check.gif" alt="id 중복검사"></button></td>
						</tr>
						<tr>
							<th scope="row"><strong class="c-red">*</strong> <span lang="en">Password</span></th>
							<td><input type="password" class="i-txt3"></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<th scope="row"><strong class="c-red">*</strong> <span lang="en">Password</span> 재 입력</th>
							<td><input type="password" class="i-txt3"></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<th scope="row"><strong class="c-red">*</strong> 성명</th>
							<td><input type="text" class="i-txt3" placeholder="English"></td>
							<td class="t-ct">/</td>
							<td><input type="text" class="i-txt3" placeholder="모국어" lang="ko"></td>
						</tr>
						<tr>
							<th scope="row"><strong class="c-red">*</strong> 직책</th>
							<td><input type="text" class="i-txt3" placeholder="English"></td>
							<td class="t-ct">/</td>
							<td><input type="text" class="i-txt3" placeholder="모국어" lang="ko"></td>
						</tr>
						<tr>
							<th scope="row"><strong class="c-red">*</strong> 부서</th>
							<td><input type="text" class="i-txt3" placeholder="English"></td>
							<td class="t-ct">/</td>
							<td><input type="text" class="i-txt3" placeholder="모국어" lang="ko"></td>
						</tr>
						<tr>
							<th scope="row"><strong class="c-red">*</strong> <span lang="en">Tel</span></th>
							<td><input type="text" class="i-txt3"></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<th scope="row"><span lang="en">Fax</span></th>
							<td><input type="text" class="i-txt3"></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<th scope="row">휴대전화</th>
							<td><input type="text" class="i-txt3"></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<th scope="row"><strong class="c-red">*</strong> <span lang="en">E-mail</span></th>
							<td><input type="text" class="i-txt3"></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<th scope="row">홈페이지</th>
							<td><input type="text" class="i-txt3"></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<th scope="row"><span lang="en">Skype ID</span></th>
							<td><input type="text" class="i-txt3"></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</tbody>
				</table>
				<div class="btn-area t-rt">
					<button type="submit"><img src="/kor/images/btn_turn_save.gif" alt="저장"></button>
				</div>
				<hr class="dashline">
				<table class="stock-list-table bgno">
					<thead>
						<tr>
							<th scope="col" class="th2">No.</th>
							<th scope="col" class="th2"><span lang="ko">직원</span> ID</th>
							<th scope="col" class="th2"><span lang="ko">직원  성명/직책</span></th>
							<th scope="col" class="th2" style="width:51px"></th>
							<th scope="col" class="th2" style="width:51px"></th>
						</tr>
					</thead>
					<tbody class="tp15">
						<tr>
							<td>1</td>
							<td>irim84</td>
							<td>SEOK Jinyong/Assistance Manager</td>
							<td><button type="submit"><img src="/kor/images/btn_delete.gif" alt="삭제"></button></td>
							<td class="pd-r0"><button type="submit"><img src="/kor/images/btn_edit.gif" alt="편집"></button></td>
						</tr>
						<tr>
							<td>2</td>
							<td>irim93</td>
							<td>Hwang Soonhae/Assistance Manager</td>
							<td><button type="submit"><img src="/kor/images/btn_delete.gif" alt="삭제"></button></td>
							<td class="pd-r0"><button type="submit"><img src="/kor/images/btn_edit.gif" alt="편집"></button></td>
						</tr>
						<tr>
							<td>3</td>
							<td>irim45</td>
							<td>Choi Jungbong/Assistance Manager</td>
							<td><button type="submit"><img src="/kor/images/btn_delete.gif" alt="삭제"></button></td>
							<td class="pd-r0"><button type="submit"><img src="/kor/images/btn_edit.gif" alt="편집"></button></td>
						</tr>
						<tr>
							<td>4</td>
							<td>irim50</td>
							<td>Seo Donghyuk/Assistance Manager</td>
							<td><button type="submit"><img src="/kor/images/btn_delete.gif" alt="삭제"></button></td>
							<td class="pd-r0"><button type="submit"><img src="/kor/images/btn_edit.gif" alt="편집"></button></td>
						</tr>
					</tbody>
				</table>
			</section>
			<!-- //form1 -->
			
			<!-- form2 -->
			<section class="box-type1">
				<div class="box-top">
					<h2>수입 선적 정보</h2>
				</div>
				<table class="option-table">
					<tbody>
						<tr>
							<th scope="row" style="width:168px">운송회사</th>
							<td style="width:142px">
								<div class="select type5" lang="en" style="width:100px">
									<label class="c-red">DHL</label>
									<select>
										<option>DHL</option>
										<option>DHL</option>
									</select>
								</div>
							</td>
							<th scope="row" style="width:110px"><span lang="en">Account No.</span></th>
							<td><input type="text" class="i-txt3 c-blue" value="123255" style="width:162px"></td>
							<td style="width:51px"><button type="submit"><img src="/kor/images/btn_turn_save.gif" alt="저장"></button></td>
						</tr>
					</tbody>
				</table>
				<hr class="dashline">
				<table class="stock-list-table bgno">
					<thead>
						<tr>
							<th scope="col" class="th2">No.</th>
							<th scope="col" class="th2"><span lang="ko">운송회사</span></th>
							<th scope="col" class="th2">Account No.</th>
							<th scope="col" class="th2" style="width:51px"></th>
							<th scope="col" class="th2" style="width:51px"></th>
						</tr>
					</thead>
					<tbody class="tp15">
						<tr>
							<td>1</td>
							<td><img src="/kor/images/delivery_bn1.gif" alt=""/></td>
							<td class="c-blue">12345678921</td>
							<td><button type="submit"><img src="/kor/images/btn_delete.gif" alt="삭제"></button></td>
							<td class="pd-r0"><button type="submit"><img src="/kor/images/btn_edit.gif" alt="편집"></button></td>
						</tr>
						<tr>
							<td>2</td>
							<td><img src="/kor/images/delivery_bn2.gif" alt=""/></td>
							<td class="c-blue">12345678921</td>
							<td><button type="submit"><img src="/kor/images/btn_delete.gif" alt="삭제"></button></td>
							<td class="pd-r0"><button type="submit"><img src="/kor/images/btn_edit.gif" alt="편집"></button></td>
						</tr>
						<tr>
							<td>3</td>
							<td><img src="/kor/images/delivery_bn3.gif" alt=""/></td>
							<td class="c-blue">12345678921</td>
							<td><button type="submit"><img src="/kor/images/btn_delete.gif" alt="삭제"></button></td>
							<td class="pd-r0"><button type="submit"><img src="/kor/images/btn_edit.gif" alt="편집"></button></td>
						</tr>
						<tr>
							<td>4</td>
							<td><img src="/kor/images/delivery_bn4.gif" alt=""/></td>
							<td class="c-blue">12345678921</td>
							<td><button type="submit"><img src="/kor/images/btn_delete.gif" alt="삭제"></button></td>
							<td class="pd-r0"><button type="submit"><img src="/kor/images/btn_edit.gif" alt="편집"></button></td>
						</tr>
					</tbody>
				</table>
			</section>
			<!-- //form2 -->
			
			<!-- form3 -->
			<section class="box-type1">
				<div class="box-top">
					<h2>대리점</h2>
				</div>
				<table class="option-table">
					<tbody>
						<tr>
							<th scope="row" style="width:168px">제조회사</th>
							<td style="width:142px"><input type="text" class="i-txt3 c-blue" value="NXP Semiconductors" style="width:142px"></td>
							<th scope="row" style="width:110px">직원<span lang="en">ID</span> (담당자)</th>
							<td>
								<div class="select type5" lang="en" style="width:142px">
									<label class="c-blue">irim84</label>
									<select>
										<option lang="en">irim84</option>
										<option lang="en">irim84</option>
									</select>
								</div>
							</td>
							<td style="width:51px"><button type="submit"><img src="/kor/images/btn_turn_save.gif" alt="저장"></button></td>
						</tr>
					</tbody>
				</table>
				<hr class="dashline">
				<table class="stock-list-table bgno">
					<thead>
						<tr>
							<th scope="col" class="th2">No.</th>
							<th scope="col" class="th2"><span lang="ko">제조회사</span></th>
							<th scope="col" class="th2"><span lang="ko">직원</span> ID</th>
							<th scope="col" class="th2"><span lang="ko">직원 성명/직책</span></th>
							<th scope="col" class="th2" style="width:51px"></th>
							<th scope="col" class="th2" style="width:51px"></th>
						</tr>
					</thead>
					<tbody class="tp15">
						<tr>
							<td>1</td>
							<td class="c-blue">NXP Semiconductors</td>
							<td>irim84</td>
							<td class="c-blue">SEOK Jinyong/Assistance Manager</td>
							<td><button type="submit"><img src="/kor/images/btn_delete.gif" alt="삭제"></button></td>
							<td class="pd-r0"><button type="submit"><img src="/kor/images/btn_edit.gif" alt="편집"></button></td>
						</tr>
						<tr>
							<td>2</td>
							<td class="c-blue">MCC Commercial Component</td>
							<td>irim84</td>
							<td class="c-blue">Hwang Soonhae/Assistance Manager</td>
							<td><button type="submit"><img src="/kor/images/btn_delete.gif" alt="삭제"></button></td>
							<td class="pd-r0"><button type="submit"><img src="/kor/images/btn_edit.gif" alt="편집"></button></td>
						</tr>
					</tbody>
				</table>
			</section>
			<!-- //form3 -->
			
			
			<!-- form4 -->
			<section id="bank-info" class="box-type1">
				<div class="box-top">
					<h2>은행정보</h2>
				</div>
				<table>
					<tbody>
						<tr>
							<th scope="row">수취인 성명</th>
							<td><input type="text" class="i-txt3" value="(주)디지털 드림" lang="ko"></td>
						</tr>
						<tr>
							<th scope="row">은행명</th>
							<td><input type="text" class="i-txt3" value="기업은행" lang="ko"></td>
						</tr>
						<tr>
							<th scope="row">계좌번호</th>
							<td><input type="text" class="i-txt3 c-blue" value="632-018768-56-00018"></td>
						</tr>
					</tbody>
				</table>
			</section>
			<!-- //form4 -->
			
			<!-- form5 -->
			<section id="relatedCheck" class="box-type1">
				<div class="box-top bg2">
					<h2><label class="ipt-chk chk4 c-yellow"><input type="checkbox"><span></span>관련회사만 기입</label></h2>
				</div>
				<table class="stock-list-table bgno">
					<thead>
						<tr>
							<th scope="col" colspan="2"><label class="ipt-chk chk4 c-yellow" lang="ko"><input type="checkbox"><span></span>판매자 지정 운송회사</label></th>
						</tr>
						<tr>
							<th scope="col" class="th2 c-grey"><span lang="ko">국제 무역</span></th>
							<th scope="col" class="th2 c-grey line-lt"><span lang="ko">국내거래</span></th>
						</tr>
					</thead>
					<tbody class="tp15">
						<tr>
							<td><span lang="ko">운송회사</span>
								<div class="select type5" lang="en" style="width:142px">
									<label>운송회사</label>
									<select>
										<option lang="en">운송회사</option>
										<option lang="en">운송회사</option>
									</select>
								</div>
							</td>
							<td class="line-lt"><span lang="ko">운송회사</span>
								<div class="select type5" lang="en" style="width:142px">
									<label>운송회사</label>
									<select>
										<option lang="en">운송회사</option>
										<option lang="en">운송회사</option>
									</select>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<table class="stock-list-table bgno">
					<thead>
						<tr>
							<th scope="col" colspan="5"><label class="ipt-chk chk4 c-yellow" lang="ko"><input type="checkbox"><span></span>판매자 지정 운임</label></th>
						</tr>
						<tr>
							<th scope="col" class="th2" colspan="3"><span lang="ko">국제 무역</span></th>
							<th scope="col" class="th2 line-lt" colspan="2"><span lang="ko">국내거래</span></th>
						</tr>
						<tr>
							<th scope="col" class="th3" style="width:20%"><span lang="ko">국가</span></th>
							<th scope="col" class="th3" style="width:15%"><span lang="ko">운송회사</span></th>
							<th scope="col" class="th3" style="width:15%"><span lang="ko">운임</span></th>
							<th scope="col" class="th3 line-lt" style="width:25%"><span lang="ko">운송회사</span></th>
							<th scope="col" class="th3" style="width:25%"><span lang="ko">운임</span></th>
						</tr>
					</thead>
					<tbody class="tp15">
						<tr>
							<td>
								<div class="select type5" lang="en" style="width:122px">
									<label class="c-red">United Kingdong</label>
									<select>
										<option lang="en"></option>
										<option lang="en"></option>
									</select>
								</div>
							</td>
							<td>
								<div class="select type5" lang="en" style="width:92px">
									<label class="c-red">UPS</label>
									<select>
										<option lang="en">UPS</option>
										<option lang="en">UPS</option>
									</select>
								</div>
							</td>
							<td class="c-red">US $ <input type="text" class="i-txt3 c-red" value="00.00" style="width:48px"></td>
							<td class="line-lt">
								<div class="select type5" lang="en" style="width:92px">
									<label class="c-red">UPS</label>
									<select>
										<option lang="en">UPS</option>
										<option lang="en">UPS</option>
									</select>
								</div>
							</td>
							<td class="c-red">US $ <input type="text" class="i-txt3 c-red" value="00.00" style="width:48px"></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<div class="select type5" lang="en" style="width:92px">
									<label class="c-red">DHL</label>
									<select>
										<option lang="en">DHL</option>
										<option lang="en">DHL</option>
									</select>
								</div>
							</td>
							<td class="c-red">US $ <input type="text" class="i-txt3 c-red" value="00.00" style="width:48px"></td>
							<td class="line-lt">
								<div class="select type5" lang="en" style="width:92px">
									<label class="c-red">DHL</label>
									<select>
										<option lang="en">DHL</option>
										<option lang="en">DHL</option>
									</select>
								</div>
							</td>
							<td class="c-red">US $ <input type="text" class="i-txt3 c-red" value="00.00" style="width:48px"></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<div class="select type5" lang="en" style="width:92px">
									<label class="c-red">Fedex</label>
									<select>
										<option lang="en">Fedex</option>
										<option lang="en">Fedex</option>
									</select>
								</div>
							</td>
							<td class="c-red">US $ <input type="text" class="i-txt3 c-red" value="00.00" style="width:48px"></td>
							<td class="line-lt">
								<div class="select type5" lang="en" style="width:92px">
									<label class="c-red">Fedex</label>
									<select>
										<option lang="en">Fedex</option>
										<option lang="en">Fedex</option>
									</select>
								</div>
							</td>
							<td class="c-red">US $ <input type="text" class="i-txt3 c-red" value="00.00" style="width:48px"></td>
						</tr>
					</tbody>
				</table>
			</section>
			<!-- //form5 -->
			
			
			<!-- form6 -->
			<section class="box-type1">
				<div class="box-top">
					<h2>회사정보 첨부</h2>
				</div>
				
				<table class="company-info-img">
					<tbody>
						<tr>
							<th scope="row">회사 <span lang="en">Logo</span></th>
							<td>
								<div class="img-cntrl-wrap">
									<span class="img-wrap"><img alt="" src="/kor/images/file_pt.gif"></span>
									<button type="button"><img src="/kor/images/btn_img_edit.gif" alt="편집"></button>
									<button type="button"><img src="/kor/images/btn_img_del.gif" alt="삭제"></button>
								</div>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<th scope="row">사인(대표자)</th>
							<td>
								<div class="img-cntrl-wrap">
									<span class="img-wrap"><img alt="" src="/kor/images/file_pt.gif"></span>
									<button type="button"><img src="/kor/images/btn_img_edit.gif" alt="편집"></button>
									<button type="button"><img src="/kor/images/btn_img_del.gif" alt="삭제"></button>
								</div>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<th scope="row">사업자등록증</th>
							<td>
								<div class="img-cntrl-wrap">
									<span class="img-wrap"><img alt="" src="/kor/images/file_pt.gif"></span>
									<button type="button"><img src="/kor/images/btn_img_edit.gif" alt="편집"></button>
									<button type="button"><img src="/kor/images/btn_img_del.gif" alt="삭제"></button>
								</div>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<th scope="row">증명서</th>
							<td colspan="2">
								<div class="img-cntrl-wrap">
									<span class="img-wrap"><img alt="" src="/kor/images/file_pt.gif"></span>
									<button type="button"><img src="/kor/images/btn_img_edit.gif" alt="편집"></button>
									<button type="button"><img src="/kor/images/btn_img_del.gif" alt="삭제"></button>
								</div>
								<label class="ipt-chk chk2"><input type="checkbox"><span></span>비공개</label>
							</td>
							<td colspan="2">
								<div class="img-cntrl-wrap">
									<span class="img-wrap"><img alt="" src="/kor/images/file_pt.gif"></span>
									<button type="button"><img src="/kor/images/btn_img_edit.gif" alt="편집"></button>
									<button type="button"><img src="/kor/images/btn_img_del.gif" alt="삭제"></button>
								</div>
								<label class="ipt-chk chk2"><input type="checkbox"><span></span>비공개</label>
							</td>
						</tr>
						<tr>
							<th scope="row">사무실/창고</th>
							<td>
								<div class="img-cntrl-wrap">
									<span class="img-wrap"><img alt="" src="/kor/images/file_pt.gif"></span>
									<button type="button"><img src="/kor/images/btn_img_edit.gif" alt="편집"></button>
									<button type="button"><img src="/kor/images/btn_img_del.gif" alt="삭제"></button>
								</div>
							</td>
							<td>
								<div class="img-cntrl-wrap">
									<span class="img-wrap"><img alt="" src="/kor/images/file_pt.gif"></span>
									<button type="button"><img src="/kor/images/btn_img_edit.gif" alt="편집"></button>
									<button type="button"><img src="/kor/images/btn_img_del.gif" alt="삭제"></button>
								</div>
							</td>
							<td>
								<div class="img-cntrl-wrap">
									<span class="img-wrap"><img alt="" src="/kor/images/file_pt.gif"></span>
									<button type="button"><img src="/kor/images/btn_img_edit.gif" alt="편집"></button>
									<button type="button"><img src="/kor/images/btn_img_del.gif" alt="삭제"></button>
								</div>
							</td>
							<td>
								<div class="img-cntrl-wrap">
									<span class="img-wrap"><img alt="" src="/kor/images/file_pt.gif"></span>
									<button type="button"><img src="/kor/images/btn_img_edit.gif" alt="편집"></button>
									<button type="button"><img src="/kor/images/btn_img_del.gif" alt="삭제"></button>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="btn-area t-rt">
					<button type="submit"><img src="/kor/images/btn_join.gif" alt="가입"></button>
				</div>
			</section>
			<!-- //form6 -->
			</form>
			
		</div>
		<div class="col-right">
			<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/side.php"); ?>
		</div>
	</div>
	<!-- //content -->
	
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/footer.php"); ?>
	
