<script type="text/javascript">
<!--
	function agent_sch(str){
		var f =  document.searchfrm;
		showajaxParam(".col-left", "agent", "strsearch1="+str);
	}
	function agent_basic_sch(){
		var f =  document.searchfrm;
		str = f.strsearch.value;
		showajaxParam(".col-left", "agent", "strsearch="+str);
	}
//-->
</script>
<section class="box-type5 srch1">
	<form name="searchfrm" id="searchfrm" method="post">
	<input type="hidden" name="strsearch1" value="">
		<table>
			<tbody>
				<tr>
					<th scope="row" class="t-rt" style="width:80px">제조회사</th>
					<td>
						<input type="text" style="width:205px;ime-mode:disabled"  onkeypress="check_key(agent_basic_sch);" name="strsearch" value="<?=$strsearch?>">
					</td>
					<td><button type="button" onclick="agent_basic_sch();"><img src="/kor/images/btn_srch.gif" alt="검색"></button></td>
				</tr>
			</tbody>
		</table>
	</form>
</section>		

<section class="navi1" lang="en">
	<a href="javascript:agent_sch('0')"  <?=$strsearch1=="0"?"class='current'":""?>>0</a>
	<a href="javascript:agent_sch('1')"  <?=$strsearch1=="1"?"class='current'":""?>>1</a>
	<a href="javascript:agent_sch('2')"  <?=$strsearch1=="2"?"class='current'":""?>>2</a>
	<a href="javascript:agent_sch('3')"  <?=$strsearch1=="3"?"class='current'":""?>>3</a>
	<a href="javascript:agent_sch('4')"  <?=$strsearch1=="4"?"class='current'":""?>>4</a>
	<a href="javascript:agent_sch('5')"  <?=$strsearch1=="5"?"class='current'":""?>>5</a>
	<a href="javascript:agent_sch('6')"  <?=$strsearch1=="6"?"class='current'":""?>>6</a>
	<a href="javascript:agent_sch('7')"  <?=$strsearch1=="7"?"class='current'":""?>>7</a>
	<a href="javascript:agent_sch('8')"  <?=$strsearch1=="8"?"class='current'":""?>>8</a>
	<a href="javascript:agent_sch('9')"  <?=$strsearch1=="9"?"class='current'":""?>>9</a>
	<a href="javascript:agent_sch('A')"  <?=$strsearch1=="A"?"class='current'":""?>>A</a>
	<a href="javascript:agent_sch('B')"  <?=$strsearch1=="B"?"class='current'":""?>>B</a>
	<a href="javascript:agent_sch('C')"  <?=$strsearch1=="C"?"class='current'":""?>>C</a>
	<a href="javascript:agent_sch('D')"  <?=$strsearch1=="D"?"class='current'":""?>>D</a>
	<a href="javascript:agent_sch('E')"  <?=$strsearch1=="E"?"class='current'":""?>>E</a>
	<a href="javascript:agent_sch('F')"  <?=$strsearch1=="F"?"class='current'":""?>>F</a>
	<a href="javascript:agent_sch('G')"  <?=$strsearch1=="G"?"class='current'":""?>>G</a>
	<a href="javascript:agent_sch('H')"  <?=$strsearch1=="H"?"class='current'":""?>>H</a>
	<a href="javascript:agent_sch('I')"  <?=$strsearch1=="I"?"class='current'":""?>>I</a>
	<a href="javascript:agent_sch('J')"  <?=$strsearch1=="J"?"class='current'":""?>>J</a>
	<a href="javascript:agent_sch('K')"  <?=$strsearch1=="K"?"class='current'":""?>>K</a>
	<a href="javascript:agent_sch('L')"  <?=$strsearch1=="L"?"class='current'":""?>>L</a>
	<a href="javascript:agent_sch('M')"  <?=$strsearch1=="M"?"class='current'":""?>>M</a>
	<a href="javascript:agent_sch('N')"  <?=$strsearch1=="N"?"class='current'":""?>>N</a>
	<a href="javascript:agent_sch('O')"  <?=$strsearch1=="O"?"class='current'":""?>>O</a>
	<a href="javascript:agent_sch('P')"  <?=$strsearch1=="P"?"class='current'":""?>>P</a>
	<a href="javascript:agent_sch('Q')"  <?=$strsearch1=="Q"?"class='current'":""?>>Q</a>
	<a href="javascript:agent_sch('R')"  <?=$strsearch1=="R"?"class='current'":""?>>R</a>
	<a href="javascript:agent_sch('S')"  <?=$strsearch1=="S"?"class='current'":""?>>S</a>
	<a href="javascript:agent_sch('T')"  <?=$strsearch1=="T"?"class='current'":""?>>T</a>
	<a href="javascript:agent_sch('U')"  <?=$strsearch1=="U"?"class='current'":""?>>U</a>
	<a href="javascript:agent_sch('V')"  <?=$strsearch1=="V"?"class='current'":""?>>V</a>
	<a href="javascript:agent_sch('W')"  <?=$strsearch1=="W"?"class='current'":""?>>W</a>
	<a href="javascript:agent_sch('X')"  <?=$strsearch1=="X"?"class='current'":""?>>X</a>
	<a href="javascript:agent_sch('Y')"  <?=$strsearch1=="Y"?"class='current'":""?>>Y</a>
	<a href="javascript:agent_sch('Z')"  <?=$strsearch1=="Z"?"class='current'":""?>>Z</a>
</section>
<section class="box-type1" id="agentList">
	<div class="hd-type-wrap">
		<table class="stock-list-table">
			<thead>
				<tr>
					<th scope="col" lang="en" style="width:75px">Logo</th>
					<th scope="col" lang="ko" style="width:180px" class="t-lt">제조회사</th>
					<th scope="col" lang="ko">각 나라의 대리점</th>
				</tr>
			</thead>
			<tbody>
				<?
				if(!$page){$page=1;}
				$recordcnt=20;
				$viewpagecnt =	10;

				if ($strsearch!=""){
					$searchand = " and agency_name like '%$strsearch%'";
				}
				if ($strsearch1!=""){
					$searchand = " and agency_name like '$strsearch1%'";
				}
				$searchand = $searchand." and rel_idx='0'";	
				$cnt = QRY_CNT("agency",$searchand);
				$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
				$result =QRY_LIST("agency",$recordcnt,$page,$searchand," trim(agency_name) ASC ");
				
				$i=0;
				while($row = mysql_fetch_array($result)){
					$i=$i+1;
					$idx = replace_out($row["idx"]);
					$rel_idx = replace_out($row["rel_idx"]);
					$agency_idx = replace_out($row["agency_idx"]);
					$agency_name = replace_out($row["agency_name"]);
					$agency_file1 = replace_out($row["agency_file1"]);
					$agency_homepage = replace_out($row["agency_homepage"]);

					if ($bgcolor == "background-color:#f7f7f7;" || $bgcolor=="") { 
						$bgcolor="background-color:#ffffff;";
					}else{
						$bgcolor ="background-color:#f7f7f7;";
					}
					//이미지 크기조정 함수(75*18) : 사용여부 추후 결정..
					//$imgsize = IMG_RESIZE_ONLY("../upload/file/", $agency_file1, 75, 18);
				?>
				<tr style="<?=$bgcolor?>">
					<td><a href="<?=$agency_homepage?>" target="_new"><img src="/upload/file/<?=$agency_file1?>" width="75" height="18" alt=""></a></td>
					<td class="t-lt c-blue"><a href="<?=$agency_homepage?>" target="_new"><?=$agency_name?></a></td>
					<td class="t-lt">
						<ul class="nation-list">
							<?
							$k=0;
							$result_nation =QRY_C_LIST(" distinct(nation) ","agency","all",$page," and agency_idx='$idx'"," idx desc");
							while($row_nation = mysql_fetch_array($result_nation)){
								$k=$k+1;
								$nation = $row_nation["nation"];
								if($i==1 and $k==1){
									$idx_1=$idx;
									$nation_1=$nation;
								}
							?>
							<li><a href="javascript: agentview('<?=$idx?>','<?=$nation?>','<?=$strsearch?>')"><img src="/kor/images/nation_title2_<?=$nation?>.png"></a></li>
							<? 	} 	?>
						</ul>
					</td>
				</tr>
				<? 
				} 
				?>
			</tbody>
		</table>
	</div>
	<div class="pagination">
		<? include $_SERVER["DOCUMENT_ROOT"]."/include/paging2.php"; ?>									
	</div>
</section>
<script type="text/javascript">
<!--
	//showajaxParam(".col-right", "side_agency_info", "idx=<?=$idx_1?>&nat=<?=$nation_1?>");
//-->
</script>