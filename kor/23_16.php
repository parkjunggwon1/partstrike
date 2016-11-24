<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/header.php"); ?>
	
	<!-- content -->
	<div id="partsContent" class="container">
		<div class="col-left">
			<section id="joinForm1" class="box-type1">
				<form>
					<div class="box-top option">
						<label class="ipt-chk chk4"><input type="checkbox"><span></span><em class="c-yellow">유통회사</em></label>
						<label class="ipt-chk chk4"><input type="checkbox"><span></span><em class="c-yellow">제조회사</em></label>
						<label class="ipt-chk chk4"><input type="checkbox"><span></span>교육기관</label>
						<label class="ipt-chk chk4"><input type="checkbox"><span></span>개인</label>
						<label class="ipt-chk chk4"><input type="checkbox"><span></span>학생</label>
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
								<th scope="row"><strong class="c-red">*</strong> 국가</th>
								<td>
									<div class="select type5" lang="en">
										<label>국가</label>
										<select>
											<option lang="en"></option>
											<option lang="en"></option>
										</select>
									</div>
								</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<th scope="row"><strong class="c-red">*</strong> 회사명</th>
								<td><input type="text" class="i-txt3" placeholder="English"></td>
								<td class="t-ct">/</td>
								<td><input type="text" class="i-txt3" placeholder="모국어" lang="ko"></td>
							</tr>
							<tr>
								<th scope="row"><strong class="c-red">*</strong> 대표자</th>
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
								<th scope="row"><strong class="c-red">*</strong> 우편번호</th>
								<td><input type="text" class="i-txt3"></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<th scope="row"><strong class="c-red">*</strong> 도/시</th>
								<td>
									<div class="select type5" lang="en">
										<label>English</label>
										<select>
											<option lang="en"></option>
											<option lang="en"></option>
										</select>
									</div></td>
								<td class="t-ct">/</td>
								<td><div class="select type5">
									<label>모국어</label>
									<select name="select">
										<option></option>
										<option></option>
									</select>
								</div></td>
							</tr>
							<tr>
								<th scope="row"><strong class="c-red">*</strong>  시/군/구</th>
								<td>
									<div class="select type5" lang="en">
										<label>English</label>
										<select>
											<option lang="en"></option>
											<option lang="en"></option>
										</select>
									</div></td>
								<td class="t-ct">/</td>
								<td><div class="select type5">
									<label>모국어</label>
									<select name="select">
										<option></option>
										<option></option>
									</select>
								</div></td>
							</tr>
							<tr>
								<th scope="row"><strong class="c-red">*</strong>  주소</th>
								<td><input type="text" class="i-txt3" placeholder="English"></td>
								<td class="t-ct">/</td>
								<td><input type="text" class="i-txt3" placeholder="모국어" lang="ko"></td>
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
						<button type="submit"><img src="/kor/images/btn_next_step.gif" alt="저장 후 다음단계"></button>
					</div>
				</form>
			</section>			
			
		</div>
		<div class="col-right">
			<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/side.php"); ?>
		</div>
	</div>
	<!-- //content -->
	
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/footer.php"); ?>
	
