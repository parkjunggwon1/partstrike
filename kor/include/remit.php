<SCRIPT LANGUAGE="JavaScript">

	$(document).ready(function(){
		$(".myrecord").click(function(){
				var f = document.fr;
				var yr = $("#fr #yr option:selected").val();
				var mon = $("#mon option:selected").val();
				var remit_ty = $("#remit_ty").val();
				showajaxParam("#remitlist", "remitlist", "yr="+yr+"&mon="+mon+"&remit_ty="+remit_ty+"&page=1"); 
		});

		

	});
</SCRIPT>

<?
$remit_ty = $rel_idx;
if ($remit_ty == ""){$remit_ty ="C";}?>

			<!-- mybankSrch -->
			<section id="mybankSrch" class="box-type5">
				<form name="fr" id="fr" class="clear">				
				<input type="hidden" name="remit_ty"  id="remit_ty" value="<?=$remit_ty?>">
					<table>
						<tbody>
							<?if (!$yr){ $yr = "N/A";}
							 if (!$mon){ $mon = "N/A";}
							 ?>
							<tr>
								<th scope="row">년도</th>
								<td>
									<div class="select" lang="en">
										<label for="yr"><?=$yr?></label>
										<select  name="yr"  id="yr">
										<option lang='en' <?=($yr=="N/A"?"selected":"")?>>N/A</option>
											<?for ( $i = date("Y") ; $i >= 2015; $i -- ){
												echo "<option lang='en' ".(($i==$yr)?"selected":"").">$i</option>";
											}?>
										</select>
									</div>
								</td>
								<th scope="row">월</th>
								<td>
									<div class="select" lang="en">
										<label for="mon"><?=$mon=="N/A"?"N/A":$mon*1?></label>
										<select name="mon" id="mon">
											<option lang='en' <?=($mon=="N/A"?"selected":"")?>>N/A</option>
											<?for ( $i = 1 ; $i <= 12; $i ++ ){
												echo "<option lang='en' ".(($i==$mon)?"selected":"").">$i</option>";
											}?>
										</select>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					<button type="button" class="myrecord"><img src="/kor/images/btn_srch.gif" alt="검색"></button>
				</form>
				
			</section>
			<!-- //mybankSrch -->			
			<!-- 버튼 -->
		<!--	<div class="remit-btn">
				<img src="/kor/images/btn_mybank_chrg<?if ($remit_ty=="C"){echo "_1";}?>.gif" <?if ($remit_ty=="W"){?> style="cursor:pointer;" onclick="remit('C');"<?}?> alt="My Bank 충전"><!--class="btn-pop-0119"
				<img src="/kor/images/btn_mybank_draw<?if ($remit_ty=="W"){echo "_1";}?>.gif" <?if ($remit_ty=="C"){?>style="cursor:pointer;"  onclick="remit('W');"<?}?> alt="인출">
			</div>
			<!-- mybankTable -->
			<section id="mybankTable" class="box-type1">
				<div class="box-top">
					<h2><span lang="en">My Bank</span></h2>
				</div>
				<div  id="remitlist">
					<?=GF_GET_REMIT_LIST($yr=="N/A"?"":$yr,$mon=="N/A"?"":$mon,$remit_ty,$page);?>			
			    </div>
			</section>
			<!--// mybankTable -->