<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.odr.php";

//이 페이지에서는 인출은 제외시키자
//2016-05-27 : mybank 별도 인자 추가(이 페이지는 입출금 내용만) - ccolle
$searchand = " and charge_type not in (9) and mybank_yn != 'Y' "; 

if ($strsearch){
	$searchand .= " and $search like '%$strsearch%'";
}


$c = "b.mem_idx, b.mem_nm, b.mem_nm_en ,b.nation, b.reg_date , case when c.mem_idx is null then b.mem_type else c.mem_type end as mem_type, b.memfee, c.mem_idx , c.rel_idx ,case when a.invoice_no is null then d.invoice_no else a.invoice_no end as invoice_no, e.code_desc,case when a.odr_idx is not null then (case when a.mem_idx=d.mem_idx then 'B' else 'S' end) else 'S' end as bs_type,a.mybank_idx, a.reg_date as pay_date, a.charge_method, a.charge_type, a.charge_amt,a.put_money_yn, a.file1 ";
$tbl = "mybank a
left outer join member b on a.mem_idx = b.mem_idx 
left outer join member c on b.rel_idx = c.mem_idx and c.rel_idx = 0
left outer join odr d on a.odr_idx = d.odr_idx
left outer join code_group_detail e on e.grp_idx =17 and a.charge_type = e.dtl_code
";

$cnt = QRY_CNT($tbl,$searchand);
$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);



$result =QRY_C_LIST($c,$tbl,$recordcnt,$page,$searchand," a.mybank_idx DESC");
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="30" background="/admin/img/now_bg.gif" style="padding-left: 20px" class="now"><img src="/admin/img/icon.gif" width="9" height="7" /> HOME &gt; <?=$title_menu?>  </td>
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
								<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" /> <?=$title_text?></td>
								<td width="100" height="35" class="rtitle01" align="center"><p class="tblue">검색건수 : &nbsp;<?=$cnt?>&#13;</p></td>
								<!--<td align="right" class="btitle02" width="100">								
								<a href="javascript:down_excel('excel')"><span class="btn">엑셀 파일</span></a>
								</td>-->
							</tr>
						</table>
						<!--오른쪽 시작-->
						<form name="f" method="post">
						<input type="hidden" name="typ" value="<?=$typ?>">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<table width="99%" border="0" cellspacing="0" cellpadding="0"  background="/admin/img/boardbar_bg.gif">
							<tr>
								<td width="60" height="27" align="center" class="btitle01" ><input type="checkbox" name="alldelchk" onclick="alldel_chk(this.checked);" ></td>
								<td width="60"  height="27" align="center" class="btitle01" >번호</td>
								<td width="100"  align="center" class="btitle01">국가</td>
								<td width="100"  align="center" class="btitle01">회원명</td>
								<td width="100"  align="center" class="btitle01">가입일</td>
								<td width="100"  align="center" class="btitle01">회사구분</td>
								<td width="100"  align="center" class="btitle01">회사등급</td>
									<td width="150"  align="center" class="btitle01">INV-NO</td>
								<td width="150" align="center" class="btitle01">결제일</td>								
								<td   align="center" class="btitle01">결제금액</td>
								
								<td width="150" align="center" class="btitle01">결제내역</td>	
								<td width="150"  align="center" class="btitle01">결제방법</td>
								<td width="150"  align="center" class="btitle01">결제상태</td>								
							</tr>
						</table>

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
							$mybank_idx = replace_out($row["mybank_idx"]);
							$mem_idx = replace_out($row["mem_idx"]);
							$rel_idx = replace_out($row["rel_idx"]);
							$mem_nm = replace_out($row["mem_nm"]);
							$nation = replace_out($row["nation"]);
							$mem_nm_en = replace_out($row["mem_nm_en"]);
							$reg_date = substr(replace_out($row["reg_date"]),0,10);
							$pay_date = substr(replace_out($row["pay_date"]),0,10);
							$mem_type = replace_out($row["mem_type"]);
							$charge_method = replace_out($row["charge_method"]);
							$charge_type = replace_out($row["charge_type"]);
							$charge_amt = replace_out($row["charge_amt"]);
							$memfee = replace_out($row["memfee"]);
							$code_desc = replace_out($row["code_desc"]);
							$bs_type = replace_out($row["bs_type"]);
							$invoice_no = replace_out($row["invoice_no"]);
							$put_money_yn = replace_out($row["put_money_yn"]);
							$file1 = replace_out($row["file1"]);
							echo $charge_tyep;
							if ($charge_type =="10" ||$charge_type =="11" ||$charge_type =="12" ||$charge_type =="13" ||$charge_type =="15" ||$charge_type =="16"){
								$odr_ty = "fty";
							}
							
							
						?>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<a href="member_view.php?<?=$param?>&idx=<?=$idx?>" id="go_<?=$idx?>"></a>
							<tr>
								<td width="60"  height="27" align="center"><input type="checkbox" name="delchk[]" value="<?=$idx?>"></td>
								<td width="60" height="27" align="center"><?=$ListNO?></td>
								<td width="100" align="center"><?=$idx?><img src="/kor/images/nation_title<?=$bs_type=="S"?"2":""?>_<?=$nation?>.png"></td>
								<td width="100" align="center"><?=$mem_nm_en?><?if ($rel_idx!=0){echo " [".get_any("member", "mem_nm_en","mem_idx=$rel_idx")."]";}?></td>
								<td width="100" align="center"><?=$reg_date?></td>
								<td width="100" align="center"><?=GF_Common_GetSingleList("MEM",$mem_type)?></td>
								<td width="100" align="center"><?=$memfee==0?"무료":"유료"?></td>
								<td width="150" align="center"><?=$invoice_no?>
								<td width="150" align="center"  ><?=$pay_date?></td>
								
								<td  align="center" class="<?=$charge_amt>0?"tblue":"tred"?>" >$<?=number_format(abs($charge_amt),2)?></td>
								
								<td width="150" align="center"  ><?=$code_desc?></td>
								<td width="150" align="center"><?=$charge_method=="1"?"신용카드":($charge_method=="2"?"무통장입금":$charge_method)?></td>
								<td width="150" align="center">
								<?
								echo $charge_method == "1"? "":($charge_method=="2"?"<a href='/upload/file/$file1' target='_blank'>입금</a>":$charge_method)." / ";
								  if ($charge_method == "2") {
									  if($put_money_yn=="Y") { 
										  echo "입금 완료";
									  }else{
										  echo "<input type='hidden' name='put_money_yn' value='$put_money_yn'><select id='depo_$mybank_idx' onchange=\"changeVal(this , $mybank_idx , '$odr_ty')\"><option value=''>입금확인중</option><option value='Y'>입금완료</option></select>";
									  }
								  }else{
									  echo "결제 완료";
								  }
							  ?>
								</td>
									
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

								include $_SERVER["DOCUMENT_ROOT"]."/admin/include/paging_admin.php";

								?>
								</td>
								<td width="120" align="right">
								<!--<span class="btn1"><a href="member_write.php?<?=$param?>">등록</a></span> -->
								<span class="btn1"><a href="javascript:del();">삭제</a></span>&nbsp;
								</td>
							</tr>
						</table>
						<br />
						<form name="searchfrm" method="post" >
						<input type="hidden" name="page" value="<?=$page?>">
						<table width="99%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f0f0f0">
							<tr>
								<td height="40" align="center">
								<select name="search">								
								<option value="(a.invoice_no or d.invoice_no)" <?If ($search=="(a.invoice_no or d.invoice_no)") {?> selected <? } ?>>INV NO</option>
								<option value="b.mem_nm_en" <?If ($search=="b.mem_nm_en") {?> selected <? } ?>>회원명</option>
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
			document.f.typ.value = "alldelmybank";
			document.f.action = "odr_proc.php?<?=$param?>";
			document.f.encoding = "multipart/form-data";
			document.f.submit();			
		}
	}

function changeVal(obj ,mybank_idx,odr_ty){
		if (obj.value=="Y")
		{
			
			if(confirm("정말 입금 처리 하시겠습니까?")){
				$.ajax({
					url: "/ajax/proc_ajax.php", 
					data: { actty : (odr_ty=="fty"?"PMIF":"PMI"), //Put money in (입금 : deposit(보증금)이랑 헷갈릴까봐.)
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

