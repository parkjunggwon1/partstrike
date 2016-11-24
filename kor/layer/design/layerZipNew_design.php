<div class="layer-hd">
	<h1>우편번호검색</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<div class="post_pop">
		<form name="fzip" method="get" autocomplete="off">
			<input type=hidden name=frm_name  value='<?=$frm_name?>'>
			<input type=hidden name=frm_zip1  value='<?=$frm_zip1?>'>
			<input type=hidden name=frm_zip2  value='<?=$frm_zip2?>'>
			<input type=hidden name=frm_addr1 value='<?=$frm_addr1?>'>
			<input type=hidden name=frm_addr2 value='<?=$frm_addr2?>'>
			<div class="srch-type">
				<dl>
					<dt>검색타입</dt>
					<dd>
						<label class="ipt-rd">
							<input type="radio" onclick="addr_change('new');" checked value="new" name="type">
							<span></span>신주소</label>
					</dd>
					<dd>
						<label class="ipt-rd">
							<input type="radio" onclick="addr_change('newdong');" <?=($type=="newdong")?"checked":"";?> value="newdong" name="type">
							<span></span>구주소(동,번지)</label>
					</dd>
					<dd>
						<label class="ipt-rd">
							<input type="radio" onclick="addr_change('old');" <?=($type=="old")?"checked":"";?> value="old" name="type">
							<span></span>구주소(동,읍/면/리)</label>
					</dd>
				</dl>
			</div>
			<div class="hr_body_shadow"></div>
			<div class="addrs new" <?=($type=="new" || $type=="")?"":"style='display:none;'";?>>
				<span>※ 찾고자 하시는 도로명 주소나 건물명을 한단어 또는 여러 단어로 입력하세요.</span></br>
				<span>예) 가산동 에이스하이엔드, 덕양구 행신동 햇빛마을, 한글비석로24</span>
			</div>
			<div class="addrs newdong" <?=($type=="newdong")?"":"style='display:none;'";?>>
				<span>※ 찾고자 하시는 구 주소지를 동과 번지로 구분하여 입력하세요.</span> </br>
				<span>예) 대치동 907, 상계5동 155-48, 가산동 371-50</span>
			</div>
			<div class="addrs old" <?=($type=="old")?"":"style='display:none;'";?>>
				<span>※ 찾고자 하시는 구 주소의 동(읍/면/리) 이름을 입력하세요.</span></br>
				<span>예) 가산동, 수유4동, 상계45동</span>
			</div>
			<div class="addrs new" <?=($type=="new" || $type=="")?"":"style='display:none;'";?>>
				<div> 검색주소
					<input type=text lang="ko" name=addr1 value='<?=$addr1?>' size=35>
					<input type=image src='<?php echo "/kor/images/"; ?>/btn_srch7.gif' border=0 align=absmiddle>
				</div>
			</div>
			<div class="addrs newdong" <?=($type=="newdong")?"":"style='display:none;'";?>>
				<div> 검색주소
					<input type=text name=addr2 lang="ko" value='<?=($addr2)?$addr2:"동";?>' onclick="if(this.value=='동'){this.value='';}"; size=10>
					<input type=text name=addr3 lang="ko" value='<?=($addr3)?$addr3:"번지";?>' onclick="if(this.value=='번지'){this.value='';}"; size=10>
					<input type=image src='<?php echo "/kor/images/"; ?>/btn_srch7.gif' border=0 align=absmiddle>
				</div>
			</div>
			<div class="addrs old" <?=($type=="old")?"":"style='display:none;'";?>>
				<div> 검색주소
					<input type=text lang="ko" name=addr4 value='<?=$addr4?>' size=35>
					<input type=image src='<?php echo "/kor/images/"; ?>/btn_srch7.gif' border=0 align=absmiddle>
				</div>
			</div>
			
			<!-- 검색결과 여기서부터 --> 
			
			<div class="result-list">
				<p class="total">총 96건 가나다순 (검색시간 : 0.205초) </p>
				<ul>
					<li><a href="#">
						<span class="new">415-060 : 경기 김포시 김포한강2로 100</span>
						<span class="old">[ 구주소 : 경기 김포시 장기동 2039-9 ]</span>
					</a></li>
					<li><a href="#">
						<span class="new">415-060 : 경기 김포시 김포한강2로 100</span>
						<span class="old">[ 구주소 : 경기 김포시 장기동 2039-9 ]</span>
					</a></li>
					<li><a href="#">
						<span class="new">415-060 : 경기 김포시 김포한강2로 100</span>
						<span class="old">[ 구주소 : 경기 김포시 장기동 2039-9 ]</span>
					</a></li>
					<li><a href="#">
						<span class="new">415-060 : 경기 김포시 김포한강2로 100</span>
						<span class="old">[ 구주소 : 경기 김포시 장기동 2039-9 ]</span>
					</a></li>
					<li><a href="#">
						<span class="new">415-060 : 경기 김포시 김포한강2로 100</span>
						<span class="old">[ 구주소 : 경기 김포시 장기동 2039-9 ]</span>
					</a></li>
				</ul>
			</div>
			<div class="pagination">
				<ul>
					<li class="navi-prev"><a href="#">Prev</a></li>
					<li class="current"><a href="#">1</a></li>
					<li><a href="#">2</a></li>
					<li><a href="#">3</a></li>
					<li><a href="#">4</a></li>
					<li class="navi-next"><a href="#">Next</a></li>
				</ul>
			</div>
			
			<script type='text/javascript'>
				document.fzip.addr1.focus();
				
				function addr_change(addr_type) {
					$(".addrs").hide();
					$("."+addr_type).show();
				}
			</script>
			<? if ($search_count > 0) { ?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:20px;">
				<!-- <tr> 
						<td height="1" colspan="2" background="<?=$g4[bbs_img_path]?>/post_dot_bg.gif"></td>
				</tr>
				<tr> 
						<td height="50" colspan="2"><img src="<?=$g4[bbs_img_path]?>/zip_img_03.gif" width="99" height="13"></td>
				</tr> -->
				<tr>
					<td width="10%"></td>
					<td width="90%">
						<table width=100% cellpadding=0 cellspacing=0 >
							<tr>
								<td height=23 valign=top>총
									<?=$search_count?>
									건 가나다순 (검색시간 :
									<?=$output[time];?>
									초)</td>
							</tr>
							<?
								for ($i=0; $i<count($list); $i++) 
								{
										echo "<tr><td height=19><a href='javascript:;' onclick=\"find_zip('{$list[$i][zip1]}', '{$list[$i][zip2]}', '{$list[$i][addr]}');\">{$list[$i][zip1]}-{$list[$i][zip2]} : {$list[$i][addr]}";
							if($type != "old") echo $list[$i][bunji];
							echo "</a></td></tr>\n";
								}
								?>
							<tr>
								<td height=23>[끝]</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<script type="text/javascript">
			function find_zip(zip1, zip2, addr1)
			{
					var of = opener.document.<?=$frm_name?>;
			
					of.<?=$frm_zip1?>.value  = zip1;
					of.<?=$frm_zip2?>.value  = zip2;
			
					of.<?=$frm_addr1?>.value = addr1;
			
					of.<?=$frm_addr2?>.focus();
					window.close();
					return false;
			}
			
			function addr_change(addr_type) {
				$(".addrs").hide();
				$("."+addr_type).show();
			}
			</script>
			<? } ?>
		</form>
	</div>
</div>
