<table width="200" border="0" cellspacing="1" cellpadding="4" bgcolor="#8e9194">
	<tr>
		<td align="center" bgcolor="#63676a">
		<table width="192" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td><img src="/admin/img/lt_main.gif" width="192" height="66" /></td>
			</tr>
		</table>
		<table width="192" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="6" background="/admin/img/t_07.gif"></td>
				<td align="center" bgcolor="#FFFFFF"><!--왼쪽메뉴시작-->
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="7"></td>
					</tr>
				</table>
				
				<?if(substr($mode,0,2)=="CC"){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/sub_t03.gif">
					<tr>
						<td width="6"><img src="/admin/img/sub_t01.gif" width="6" height="25" /></td>
						<td style="padding-left: 10px" class="left01">회원관리</td>
						<td width="6" align="right"><img src="/admin/img/sub_t02.gif" width="6" height="25" /></td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="7"></td>
					</tr>
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/member/member_list.php?mode=CC001">유통회사</a></td>
					</tr>  
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/member/member_list.php?mode=CC002">제조회사</a></td>
					</tr>   
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/member/member_list.php?mode=CC003">교육기관</a></td>
					</tr> 
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/member/member_list.php?mode=CC004">개인</a></td>
					</tr> 
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/member/member_list.php?mode=CC005">학생</a></td>
					</tr> 
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/member/member_list.php?mode=CC011">탈퇴회원</a></td>
					</tr> 
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/member/member_list.php?mode=CC012">블랙리스트</a></td>
					</tr> 
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/member/member_list.php?mode=CC000">(파츠 정보)</a></td>
					</tr> 
				</table>    
				<br />
				<?}?>
				<?if($mode=="ZZ001" ||$mode=="ZZ002" ||$mode=="ZZ011"||$mode=="ZZ012"||$mode=="ZZ013"||$mode=="ZZ014"){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/sub_t03.gif">
					<tr>
						<td width="6"><img src="/admin/img/sub_t01.gif" width="6" height="25" /></td>
						<td style="padding-left: 10px" class="left01">발주관리</td>
						<td width="6" align="right"><img src="/admin/img/sub_t02.gif" width="6" height="25" /></td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="7"></td>
					</tr>
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/odr/odr_list.php?mode=ZZ001">발주관리</a></td>
					</tr>  
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/odr/odr_history_list.php?mode=ZZ002">발주이력관리</a></td>
					</tr>   
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/odr/fty_history_list.php?mode=ZZ011">불량통보이력관리</a></td>
					</tr> 
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/odr/pay_list.php?mode=ZZ012">결제관리</a></td>
					</tr>
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/odr/rnd_list.php?mode=ZZ014">테스트의뢰 목록</a></td>
					</tr>
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/odr/fty_history_list.php?mode=ZZ013">PARTS 연구소</a></td>
					</tr> 
					
				</table>    
				<br />
				<?}?>
				<?if($mode=="ZZ003"){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/sub_t03.gif">
					<tr>
						<td width="6"><img src="/admin/img/sub_t01.gif" width="6" height="25" /></td>
						<td style="padding-left: 10px" class="left01">제품관리</td>
						<td width="6" align="right"><img src="/admin/img/sub_t02.gif" width="6" height="25" /></td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="7"></td>
					</tr>
					<!--<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/board/board_list.php?mode=ZZ003">주문관리</a></td>
					</tr>  -->
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/board/part_list.php?mode=ZZ003">재고등록현황</a></td>
					</tr>   
				</table>    
				<br />
				<?}?>
				<?if($mode=="ZZ004"){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/sub_t03.gif">
					<tr>
						<td width="6"><img src="/admin/img/sub_t01.gif" width="6" height="25" /></td>
						<td style="padding-left: 10px" class="left01">코드관리</td>
						<td width="6" align="right"><img src="/admin/img/sub_t02.gif" width="6" height="25" /></td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="7"></td>
					</tr>
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/board/board_list.php?mode=ZZ004">코드관리</a></td>
					</tr>  
				</table>    
				<br />
				<?}?>
				<?if($mode=="ZZ005" or substr($mode,0,2)=="AA"){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/sub_t03.gif">
					<tr>
						<td width="6"><img src="/admin/img/sub_t01.gif" width="6" height="25" /></td>
						<td style="padding-left: 10px" class="left01">개시판관리</td>
						<td width="6" align="right"><img src="/admin/img/sub_t02.gif" width="6" height="25" /></td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="7"></td>
					</tr>
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/board/board_list.php?mode=AA001">공지사항</a></td>
					</tr> 
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/board/board_list.php?mode=AA002">질의응답</a></td>
					</tr> 
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/board/board_list.php?mode=AA003">제안</a></td>
					</tr> 
				</table>    
				<br />
				<?}?>
				<?if(substr($mode,0,2)=="EE"){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/sub_t03.gif">
					<tr>
						<td width="6"><img src="/admin/img/sub_t01.gif" width="6" height="25" /></td>
						<td style="padding-left: 10px" class="left01">쪽지관리</td>
						<td width="6" align="right"><img src="/admin/img/sub_t02.gif" width="6" height="25" /></td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="7"></td>
					</tr>
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/board/board_list.php?mode=EE001">쪽지관리</a></td>
					</tr> 	
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/board/board_write.php?mode=EE003">전체쪽지발송</a></td>
					</tr> 									
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/board/board_list.php?mode=EE003">관리자발송쪽지관리</a></td>
					</tr> 
				</table>    
				<br />
				<?}?>
				<?if(substr($mode,0,2)=="XX"){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/sub_t03.gif">
					<tr>
						<td width="6"><img src="/admin/img/sub_t01.gif" width="6" height="25" /></td>
						<td style="padding-left: 10px" class="left01">운영자관리</td>
						<td width="6" align="right"><img src="/admin/img/sub_t02.gif" width="6" height="25" /></td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="7"></td>
					</tr>
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/member/admin_list.php?mode=XX001">사내 회원 관리</a></td>
					</tr> 
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/board/board_list.php?mode=XX002">사내게시판</a></td>
					</tr> 
				</table>    
				<br />
				<?}?>
				<?if($mode=="ZZ008"){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/sub_t03.gif">
					<tr>
						<td width="6"><img src="/admin/img/sub_t01.gif" width="6" height="25" /></td>
						<td style="padding-left: 10px" class="left01">정산관리</td>
						<td width="6" align="right"><img src="/admin/img/sub_t02.gif" width="6" height="25" /></td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="7"></td>
					</tr>
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/mybank/board_list.php?mode=ZZ008&&cate=1">회원가입비용</a></td>
					</tr> 
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/mybank/board_list.php?mode=ZZ008&cate=2">보증금</a></td>
					</tr> 
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/mybank/board_list.php?mode=ZZ008&cate=3">마이뱅크 충전/사용 내역</a></td>
					</tr> 
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/mybank/board_list.php?mode=ZZ008&cate=4">인출신청</a></td>
					</tr> 
				<!--	<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/mybank/board_list.php?mode=ZZ008&cate=5">거래대금</a></td>
					</tr> 					-->
				</table>    
				<br />
				<?}?>
				<?if($mode=="ZZ009"){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/sub_t03.gif">
					<tr>
						<td width="6"><img src="/admin/img/sub_t01.gif" width="6" height="25" /></td>
						<td style="padding-left: 10px" class="left01">기타관리</td>
						<td width="6" align="right"><img src="/admin/img/sub_t02.gif" width="6" height="25" /></td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="7"></td>
					</tr>
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/board/board_list.php?mode=ZZ009">오늘의 거래량</a></td>
					</tr> 
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/board/board_list.php?mode=ZZ009">전체거래량</a></td>
					</tr> 
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/board/board_list.php?mode=ZZ009">방문자수</a></td>
					</tr> 
				</table>    
				<br />
				<?}?>

				<?if($mode=="NN001" or $mode=="PP001" or substr($mode,0,2)=="DD" or substr($mode,0,2)=="BB"){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/sub_t03.gif">
					<tr>
						<td width="6"><img src="/admin/img/sub_t01.gif" width="6" height="25" /></td>
						<td style="padding-left: 10px" class="left01">사이트관리</td>
						<td width="6" align="right"><img src="/admin/img/sub_t02.gif" width="6" height="25" /></td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="7"></td>
					</tr>
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/cate/cate.php?mode=DD002">카테고리관리</a></td>
					</tr>  
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/other/banner_write.php?mode=NN001&idx=1">메인배너관리</a></td>
					</tr>   
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/other/popup_list.php?mode=PP001">팝업관리</a></td>
					</tr> 
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/board/policy_write.php?mode=BB001">이용약관</a></td>
					</tr> 
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/board/policy_write.php?mode=BB002">이용방법</a></td>
					</tr> 
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/agency/agency_list.php?mode=DD003">제조회사/대리점</a></td>
					</tr> 
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/agency/populpart_list.php?mode=DD004">인기부품 관리</a></td>
					</tr> 
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/agency/tax_list.php?mode=DD005">부과세 관리</a></td>
					</tr> 					
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/agency/exchange.php?mode=DD007">환율 관리</a></td>
					</tr> 
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/agency/idblock.php?mode=DD006">가입차단ID 관리</a></td>
					</tr> 
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/agency/headoffice.php?mode=DD008">연락처_본사 관리</a></td>
					</tr>
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/agency/research.php?mode=DD009">연락처_연구소 관리</a></td>
					</tr>
				</table>    
				<br />
				<? } ?>
				<br />
				<?if($mode=="ZZ010"){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/sub_t03.gif">
					<tr>
						<td width="6"><img src="/admin/img/sub_t01.gif" width="6" height="25" /></td>
						<td style="padding-left: 10px" class="left01">관리자 정보</td>
						<td width="6" align="right"><img src="/admin/img/sub_t02.gif" width="6" height="25" /></td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="7"></td>
					</tr>
					<tr>
						<td height="20" style="padding-left: 10px" ><img src="/admin/img/icon_01.gif" width="6" height="8" /> 
						<a href="/admin/change/change.php?mode=ZZ010">관리자 정보수정</a></td>
					</tr>  
				</table>    
				<br />
				<? } ?>
				<br />
				<!--왼쪽 끝-->
				</td>
				<td width="6" background="/admin/img/t_08.gif"></td>
			</tr>
			<tr>
				<td><img src="/admin/img/t_03.gif" width="6" height="6" /></td>
				<td background="/admin/img/t_06.gif"></td>
				<td align="right"><img src="/admin/img/t_04.gif" width="6" height="6" /></td>
			</tr>
		</table>
		</td>
	</tr>
</table>