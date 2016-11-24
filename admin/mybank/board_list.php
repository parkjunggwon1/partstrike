<?
$mode = $_REQUEST['mode'];
$page = $_REQUEST['page'];
$search = $_REQUEST['search'];
$strsearch = $_REQUEST['strsearch'];


include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";
if ($strsearch){
	$searchand = " and $search like '%$strsearch%'";
}

switch ($cate) {
	//게시판
	case "1";
		$remit_ty="W";
		$searchand .= " and charge_type =14 ";
	break;
	case "2";
		$remit_ty="W";
		$searchand .= " and charge_type =8 ";
	break;
	case "3";
		$remit_ty = "C";
		$searchand .= " and (charge_type = '1' or charge_type <> 9 and charge_method = 'MyBank') ";	
	break;
	case "4";
		$remit_ty="W";
		$searchand .= " and charge_type =9 and mybank_yn = 'Y' and charge_amt!=0 ";
	break;
}

	$addtbl = " mybank a ";


$cnt = QRY_CNT(" $addtbl left outer join member b on a.mem_idx = b.mem_idx ",$searchand);
$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);

$c = "mybank_idx, charge_type,DATE_FORMAT(a.reg_date, '%Y년 %m월 %d일') reg_date, mem_id, case when b.rel_idx = 0 then mem_nm else concat(mem_nm,'/',pos_nm) end as mem_nm, 
				case when charge_method = 1 then '신용카드' else '은행송금' end as charge_method,invoice_no , charge_amt, put_money_yn, (SELECT sum(charge_amt) remain FROM mybank WHERE (mem_idx =a.mem_idx or rel_idx = a.mem_idx) and reg_date <a.reg_date) as remain";

$result =QRY_C_LIST($c, " $addtbl left outer join member b on a.mem_idx = b.mem_idx ",$recordcnt,$page,$searchand," a.mybank_idx DESC");


?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="30" background="/admin/img/now_bg.gif" style="padding-left: 20px" class="now"><img src="/admin/img/icon.gif" width="9" height="7" /> HOME &gt; 사이트관리</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="208" valign="top"><!--메뉴-->
		<?
		  include $_SERVER["DOCUMENT_ROOT"]."/admin/include/lm.php";
		?>

		</td>
		<td valign="top">
		<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#8e9194">
			<tr>
				<td align="center" bgcolor="#63676a">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="6" valign="top"><img src="/admin/img/t_01.gif" width="6" height="6" /></td>
						<td background="/admin/img/t_05.gif"></td>
						<td width="6" align="right" valign="top"><img src="/admin/img/t_02.gif" width="6" height="6" /></td>
					</tr>
					<tr>
						<td background="/admin/img/t_07.gif"></td>
						<td align="center" valign="top" bgcolor="#FFFFFF">
						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" />   <?=$title_text?></td>
								<td width="100" height="35" class="rtitle01" align="center"><p class="tblue">검색건수 : &nbsp;<?=$cnt?>&#13;</p></td>
								<!--<td align="right" class="btitle02" width="100">								
								<a href="javascript:down_excel('excel')"><span class="btn">엑셀 파일</span></a>
								</td>-->
							</tr>
						</table>
						<!--오른쪽 시작-->
						<form name="f" method="post">
						<input type="hidden" name="typ" value="<?=$typ?>">
						<input type="hidden" name="typaaa" value="한글">
						<table width="99%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/boardbar_bg.gif">
							<tr>
								<!--<td width="60" height="27" align="center" class="btitle01" ><input type="checkbox" name="alldelchk" onclick="alldel_chk(this.checked);" ></td>	-->
								<td width="60" height="27" align="center" class="btitle01" >번호</td>
								<th width="120" scope="col" class="btitle01" lang="ko">날짜</th>
								<th  width="120" scope="col" width="100" class="btitle01">User ID</th>
								<th scope="col" class="btitle01" lang="ko">성명/직함</th>				
								<?if ($remit_ty=="C"){?>
								<th  width="120" scope="col" class="btitle01" lang="ko">방법</th>
								<th  width="120" scope="col" class="btitle01">Invoice No.</th>
								<th  width="120" scope="col" class="btitle01">충전/사용내역</th>
								<th  width="120" scope="col" class="btitle01" lang="ko">충전/사용금액</th>
								<th  width="120" scope="col" class="btitle01">My Bank</th>
								<?}else{?>								
								<th  width="120" scope="col" class="btitle01">Invoice No.</th>
								<th  width="120" scope="col" class="btitle01" lang="ko">금액</th>
									<?if ($cate=="4"){?>
									<th  width="120" scope="col" class="btitle01">Escrow Fee</th>
									<th  width="120" scope="col" class="btitle01">실 인출액</th>	
									<th  width="120" scope="col" class="btitle01">MyBank잔액</th>	
									<th  width="120" scope="col" class="btitle01">인출현황</th>
									<?}?>
								<?}?>
							</tr>
						</table>
						<!--일반게시글 시작-->
						<?
						if ($cnt==0){
						?>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="50" align="center">등록 된 자료가 없습니다</td>
							</tr>
							<tr>
								<td height="1" colspan="9" bgcolor="#dcd8d6"></td>
							</tr>
						</table>
						<?
						}
						$ListNO=$cnt-(($page-1)*$recordcnt);


						while($row = mysql_fetch_array($result)){
							$idx = replace_out($row["mybank_idx"]);
							$mem_id = replace_out($row["mem_id"]);
							$mem_nm = replace_out($row["mem_nm"]);
							$charge_method = replace_out($row["charge_method"]);
							$charge_type = replace_out($row["charge_type"]);
							$invoice_no = replace_out($row["invoice_no"]);
							$charge_amt = replace_out($row["charge_amt"]);
							$put_money_yn = replace_out($row["put_money_yn"]);
							$log_date = replace_out($row["reg_date"]);
							$remain = replace_out($row["remain"]);
							
							
						?>
						<a href="board_view.php?<?=$param?>&idx=<?=$idx?>" id="go_<?=$idx?>"></a>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<!--<td width="60" height="27" align="center"><input type="checkbox" name="delchk[]" value="<?=$idx?>"></td>-->
								<td width="60"  height="27" align="center"><?=$ListNO?></td>	
								<td width="120" align="center"><?=$log_date?></td>
								<td  width="120" align="center"><a href="javascript:setVal('<?=$mem_id?>');"><?=$mem_id?></a></td>
								<td align="center"><?=$mem_nm?></td>
								<?if ($remit_ty =="C"){?>
								<td  width="120" align="center"><?=$charge_method?></td>
								<td  width="120"  align="center"><?=$invoice_no?></td>
								<td  width="120" align="center"><?=GF_Common_GetSingleList("MYBK",$charge_type)?></td>
								<td  width="120" align="center">$<?=number_format($charge_amt,2)?></td>
								<td  width="120" align="center"><?=number_format($remain+$charge_amt,2)?></td>
								<?}else{?>								
								<td  width="120"  align="center"><?=$invoice_no?></td>								
								<td  width="120" align="center">$<?=number_format(abs($charge_amt),2)?></td>
									<?if ($cate=="4"){?>
									<td  width="120" align="center">$<?=number_format(abs($charge_amt)*0.01,2)?></td>
									<td  width="120" align="center">$<?=number_format(abs($charge_amt)*0.99,2)?></td>
									<td  width="120" align="center">$<?=number_format($remain+$charge_amt,2)?></td>
									<td  width="120" align="center">
									<?
									if($put_money_yn=="Y") { 
										  echo "인출완료";
									  }else{
										  	  echo "<input type='hidden' name='put_money_yn' value='$put_money_yn'><select id='depo_$idx' onchange='changeVal(this , $idx)'><option value=''>인출대기중</option><option value='Y'>인출완료</option></select>";
									  }	
									?></td>
									<?}?>
								<?}?>
							</tr>
							<tr>
								<td height="1" colspan="15" bgcolor="#dcd8d6"></td>
							</tr>
						</table>
						<? 
							$ListNO--;
						} 
						?>
						</form>
						<br>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<Td width=120>&nbsp;</td>
								<td height="40" align="center">
								<?
								$addpara = "";
								$pageurl = "board_list.php";

								include $_SERVER["DOCUMENT_ROOT"]."/admin/include/paging_admin.php";

								?>
								</td>
								<!--<td width="120" align="right"><span class="btn1"><a href="board_write.php?mode=<?=$mode?>&page=<?=$page?>">등록</a></span>
								<span class="btn1"><a href="javascript:del();">삭제</a></span>&nbsp; <!-- <?=$mode?><?=$page?><?=$cnt?> -->
								</td>
							</tr>
						</table>
						<br />
						<form name="searchfrm" method="post" action="board_list.php">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="cate" value="<?=$cate?>">
						<table width="99%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f0f0f0">
							<tr>
								<td height="40" align="center">
								<select name="search">								
								<option value="b.mem_id" <?If ($search=="b.mem_id") {?> selected <? } ?>>User ID</option>
								<option value="b.mem_nm" <?If ($search=="b.mem_nm") {?> selected <? } ?>>성명/직함</option>
								
								</select>
								<input type='text' name="strsearch" size='30' maxlength ='20' value="<?=$strsearch?>" onKeyPress="check_key(check_search);" style="font-size:9pt;height:21px;">	
								<span class="btn1"><a href="javascript:check_search();">SEARCH</a></span>
								</td>
							</tr>
						</table>
						</form>
						<br />
						<br />
						<br />
						<br />
						<!--오른쪽 끝-->


						</td>
						<td background="/admin/img/t_08.gif"></td>
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
		</td>
	</tr>
</table>
<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/footer.php";
?>
<script type="text/javascript">
<!--
	function del(){
		if (confirm("삭제하시겠습니까?")==true){
			document.f.typ.value = "alldel";
			document.f.action = "board_proc.php?<?=$param?>";
			document.f.encoding = "multipart/form-data";
			document.f.submit();			
		}
	}

		function changeVal(obj ,mybank_idx){
		if (obj.value=="Y")
		{
			
			if(confirm("인출 완료 처리 하시겠습니까?")){
				$.ajax({
					url: "/ajax/proc_ajax.php", 
					data: { actty : "PMWI", //Put money withdrawal
					mybank_idx : mybank_idx
					},
					dataType : "html" ,
					async : false ,
					success: function(data){ 
						check_search();
					}
				});								
			}else{
				$("#depo_"+mybank_idx+" option:eq(0)").attr("selected",true);
			}
		}
		
	}


//-->
</script>
