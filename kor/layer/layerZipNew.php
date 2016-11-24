<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<?// 검색 타입에 따른 검색단어 설정
if($type == "old") { $addr1 = $addr4; }
if($type == "newdong") { $addr1 = $addr2." ".$addr3; }

if ($addr1) 
{

	// 신주소 소켓통신 요청
	function HTTP_Post($URL,$data) {
		$URL_Info=parse_url($URL);
		if(!empty($data)) foreach($data AS $k => $v) $str .= urlencode($k).'='.urlencode($v).'&';
		$path = $URL_Info["path"];
		$host = $URL_Info["host"];
		$port = $URL_Info["port"];
		if (empty($port)) $port=80;

		$result = "";
		$fp = fsockopen($host, $port, $errno, $errstr, 30);
		$http  = "POST $path HTTP/1.0\r\n";
		$http .= "Host: $host\r\n";
		$http .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$http .= "Content-length: " . strlen($str) . "\r\n";
		$http .= "Connection: close\r\n\r\n";
		$http .= $str . "\r\n\r\n";
		fwrite($fp, $http);
		while (!feof($fp)) { $result .= fgets($fp, 4096); }
		fclose($fp);
		return $result;
	}

	$url  = "http://post.phpschool.com/phps.kr"; // 신주소 api URL
	$data = array("addr"=>$addr1, "ipkey"=>"3369595", "charset"=>"UTF-8", "type"=>$type); // UTF-8일경우 "UTF-8" 로 기재

	$output = (HTTP_Post($url, $data));
	$output = substr($output, strpos($output,"\r\n\r\n")+4);

	$output = unserialize($output);
	$result = $output['result'];

	if ($result > 0) {
		$post_data = unserialize($output['post']);

		for ($i=0; $i<$result; $i++) {

			$list[$i][postnew] = $post_data[$i]['postnew'];              // 우편번호
			//$post_data[$i]['addr_1'];            // 시/도
			//$post_data[$i]['addr_2'];            // 구
			//$post_data[$i]['addr_3'];            // 도로명
			//$post_data[$i]['addr_4'];            // 동/건물
			//$list[$i][zip1] = substr($post_data[$i]['post'],0,3);
			//$list[$i][zip2] = substr($post_data[$i]['post'],3,3);
			$list[$i][addr] = $post_data[$i]['addr_1']." ".$post_data[$i]['addr_2']." ".$post_data[$i]['addr_3'];
			$list[$i][addr2] = $post_data[$i]['addr_4'];
			$list[$i][bunji] = "<span class='old'>[ 구주소 : ".$post_data[$i]['addr_5']." ]</span>";
			$list[$i][addr_eng] = $post_data[$i]['addr_eng'];
			
			$list[$i][encode_addr] = urlencode($list[$i][addr]);
		}
	} else if ($result == 0) {

		$result_msg = "찾으시는 주소가 없습니다.";

	} else if ($result < 0) {

		switch($result) {
			case "-1":
				$result_msg = "검색결과가 너무 많습니다. 2단어 이상 조합해 주세요.";
				break;
			case "-2":
				$result_msg = "미인증 IP입니다. http://post.phpschool.com/join.html에 접속하여 API를 신청해 주세요.";
				break;
			case "-3":
				$result_msg = "1일 조회 횟수가 초과되었습니다.";
				break;
			case "-4":
				$result_msg = "이메일 인증을 완료하지 않은 API 사용자입니다.";
				break;
		}
		
		// $result  "-1"  일경우 :  너무많은검색결과 1000건이상
		// $result  "-2"  일경우 :  서버 IP 미인증
		// $result  "-3"  일경우 :  조회횟수초과  
		// $result  "-4"  일경우 :  미인증 사용자
	}

	$search_count = $output[result];
}


?><div class="layer-hd">
	<h1>우편번호검색</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<div class="post_pop">
		<form name="fzip" id="fzip" method="get" autocomplete="off">
		
			<input type=hidden name=frm_name  value='<?=$frm_name?>'>
			<input type=hidden name=frm_zip1  value='<?=$frm_zip1?>'>
			<input type=hidden name=frm_zip2  value='<?=$frm_zip2?>'>
			<input type=hidden name=frm_addr1 value='<?=$frm_addr1?>'>
			<input type=hidden name=frm_addr2 value='<?=$frm_addr2?>'>
			<input type=hidden name=frm_addr_en value='<?=$frm_addr_en?>'>
			<div class="srch-type" style="display:none;">
				<dl>
					<dt>검색타입</dt>
					<dd>
						<label class="ipt-rd">
							<input type="radio" onclick="addr_change('new');"  <?=($type=="new")?"checked class='checked'":"";?> value="new" name="type" class="checked">
							<span></span>신주소</label>
					</dd>
					<dd>
						<label class="ipt-rd">
							<input type="radio" onclick="addr_change('newdong');" disabled readonly <?=($type=="newdong")?"checked class='checked'":"";?> value="newdong" name="type">
							<span></span>구주소(동,번지)</label>
					</dd>
					<dd>
						<label class="ipt-rd">
							<input type="radio" onclick="addr_change('old');" disabled  readonly <?=($type=="old")?"checked class='checked'":"";?> value="old" name="type">
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
					<span class="srchimg_1" style="display:<?if ( $addr1!=""){echo "none";}?>;"><img src="/kor/images/btn_srch7_1.gif" border=0 align=absmiddle alt="검색"></span>
					<button type="button" onclick="zip_sch();" class="srchimg" style="display:<?if ($addr1==""){echo "none";}?>;"><img src="/kor/images/btn_srch7.gif" border=0 align=absmiddle alt="검색"></button>
				</div>
			</div>
			<div class="addrs newdong" <?=($type=="newdong")?"":"style='display:none;'";?>>
				<div> 검색주소
					<input type=text name=addr2 lang="ko" value='<?=$addr2?>' placeholder="동" size=10>
					<input type=text name=addr3 lang="ko" value='<?=$addr3?>' placeholder="번지"  size=10>
					<span class="srchimg_1" style="display:<?if ( $addr2!="" &&$addr3!=""){echo "none";}?>;"><img src="/kor/images/btn_srch7_1.gif" border=0 align=absmiddle alt="검색"></span>
					<button type="button" onclick="zip_sch();" class="srchimg" style="display:<?if ($addr2=="" || $addr3 ==""){echo "none";}?>;"><img src="/kor/images/btn_srch7.gif" border=0 align=absmiddle alt="검색"></button>
				</div>
			</div>
			<div class="addrs old" <?=($type=="old")?"":"style='display:none;'";?>>
				<div> 검색주소
					<input type=text lang="ko" name=addr4 value='<?=$addr4?>' size=35>
					<span class="srchimg_1" style="display:<?if ( $addr4!=""){echo "none";}?>;"><img src="/kor/images/btn_srch7_1.gif" border=0 align=absmiddle alt="검색"></span>
					<button type="button" onclick="zip_sch();" class="srchimg" style="display:<?if ($addr4==""){echo "none";}?>;"><img src="/kor/images/btn_srch7.gif" border=0 align=absmiddle alt="검색"></button>
				</div>
			</div>
			
			<!-- 검색결과 여기서부터 --> 	
			
			<script type='text/javascript'>
				
				document.fzip.addr1.focus();
				addr_change('new');
				$("input[name=type]:eq(0)").click();
				
				function addr_change(addr_type) {
					$(".addrs").hide();
					$("."+addr_type).show();
				}

				function zip_sch(){
						var formData = $("#fzip").serialize(); 
						openCommLayer("layer4","layerZipNew","?"+formData);	
				}
				$("input[name=type]").click(function(e){
					if (($(this).val()=="new" && $("input[name=addr1]").val()!="") || ($(this).val()=="newdong" && $("input[name=addr2]").val()!="" && $("input[name=addr3]").val()!="") || ($(this).val()=="old" && $("input[name=addr4]").val()!=""))
					{
						$(".srchimg_1").hide();
						$(".srchimg").show();
					}else{
						$(".srchimg").hide();
						$(".srchimg_1").show();
					}
					
				});

				$(".addrs input[type=text]").keyup(function(){
					if (($(this).attr("name")=="addr1" && $("input[value=new]").prop("checked")==true) || ($(this).attr("name")=="addr2" && $("input[name=addr3]").val()!="") || ($(this).attr("name")=="addr3" && $("input[name=addr2]").val()!="") || ($(this).attr("name")=="addr4")){
						$(".srchimg_1").hide();
						$(".srchimg").show();
						if (window.event.keyCode==13){zip_sch();}						
					}else{
						$(".srchimg").hide();
						$(".srchimg_1").show();
					}
				});

			</script>
			<? if ($search_count > 0) { ?>

				<div class="result-list">
				<p class="total">총
									<?=$search_count?>
									건 가나다순 (검색시간 :
									<?=$output[time];?>
									초)</p>
				<ul>
				<?
					for ($i=0; $i<count($list); $i++) 
					{
							echo "<li><a href='javascript:;' onclick=\"find_zip('{$list[$i][postnew]}', '{$list[$i][addr]}','{$list[$i][addr_eng]}');\"><span class='new'>{$list[$i][postnew]} : {$list[$i][addr]}</span>\n";
							if($type != "old") echo $list[$i][bunji]."\n";
							echo "</a></li>\n";
					}
					?>
					
				</ul>
				
			</div>
			<!--<div class='pagination'>
				<ul>
					<li class='navi-prev'><a href='#'>Prev</a></li>
					<li class='current'><a href='#'>1</a></li>
					<li><a href='#'>2</a></li>
					<li><a href='#'>3</a></li>
					<li><a href='#'>4</a></li>
					<li class='navi-next'><a href='#'>Next</a></li>
				</ul>
			</div>-->

			<script type="text/javascript">
			
			function find_zip(postnew, addr1, addr_en, en_ok)
			{				
					var $of = $("#<?=$frm_name?>");
					var sigungu = addr1.split(" ");
					var sigungu_en_new = addr_en.split(" ");

					//한글주소-상세
					for(var i=0; i<sigungu.length; i++){
						if(i==2){
							var addr_det=sigungu[i];
						}else if(i>2){
							addr_det = addr_det + " " + sigungu[i];
						}
					}
					
					//영문주소-상세
					for(var i=0; i<sigungu_en_new.length; i++){
						if(i==0){
							var addr_det_en=sigungu_en_new[i];
						}else if(i<3){
							addr_det_en = addr_det_en + " " + sigungu_en_new[i];
						}
					}
					
					$of.find("input[name=<?=$frm_zip1?>]").val(postnew);
					
					$of.find("input[name=<?=$frm_addr1?>]").val("("+postnew+") "+addr1);
					$of.find("#sp_<?=$frm_addr1?> u").html("("+postnew+") "+addr1);					
					$of.find("#dositxt").val(sigungu[0]);	//도시
					$of.find("#sigungu").val(sigungu[1]);	//시군구
					$of.find("#addr_det").val(addr_det);	//상세주소
					$of.find("#addr_det_en").val(addr_det_en);	//상세주소(영문)
					//$of.find("#dosi").remove();	//상세주소(영문)									
									
					<?if ($frm_addr_en){?>					
						var sigungu_en = addr_en.split(" ");
						var nation = $("#nation").children("option:selected").text();
						$of.find("input[name=<?=$frm_addr_en?>]").val(addr_en+" "+postnew+" "+nation);
						$of.find("#sp_<?=$frm_addr_en?> u").html(addr_en+" "+postnew+" "+nation);
						$of.find("#sigungu_en").val(sigungu_en[sigungu_en.length-2]);
					<?}?>
					var code = GetdosiCode(addr1.substring(0,3));					
					$("#dosi").siblings("label").text($("#dosi option[value="+code+"]").html());
					$("#dosi_en").siblings("label").text($("#dosi_en option[value="+code+"]").html());
					$("#dosi option").attr("selected",false);
					$("#dosi option[value="+code+"]").attr("selected",true);
					$("#dosi_en option").attr("selected",false);
					$("#dosi_en option[value="+code+"]").attr("selected",true);
					$("#dositxt_en").val($("#dosi_en option[value="+code+"]").html());
					//$("#dositxt").val($("#dosi option[value="+code+"]").html());
					$("#sp_addr_en").siblings("span").show();					
					$("#real_doen_val").val($("#dosi_en option[value="+code+"]").html());
					$("#real_dokr_val").val($("#dosi option[value="+code+"]").html());
					
					$("#addr").val("["+postnew+"] "+addr1);
					$("#addr_en").val(addr_en+", "+postnew+" ,South Korea");

					$("#sp_addr").html("["+postnew+"] "+addr1);
					$("#sp_addr_en").html(addr_en+", "+postnew+" ,South Korea");
					

					$of.find("input[name=<?=$frm_addr2?>]").focus();
					<?if ($frm_name=="f"){?>
					if (MustChk() == true)
					{
						$("#f .info-btn-area span:eq(0)").hide();
						$("#f .info-btn-area button:eq(0)").show();
					}	
					<?}?>
					closeCommLayer("layer4");
			}

			function GetdosiCode(str){
				switch(trim(str)){
					case("서울"):return  "3";break;
					case("광주"):return "275";break;
					case("대구"):return "276";break;
					case("대전"):return "274";break;
					case("부산"):return "277";break;
					case("세종"):return "279";break;
					case("울산"):return "278";break;
					case("인천"):return "273";break;
					case("강원"):return "5";break;
					case("경기"):return "4";break;
					case("경남"):return "10";break;
					case("경북"):return "11";break;
					case("전남"):return "8";break;
					case("전북"):return "9";break;
					case("충남"):return "6";break;
					case("충북"):return "7";break;
					case("제주"):return "12";break;
				}
			}
			
			</script>
			<? }else{?>
			<div class="result-list">
				<p class="total">
					<?=$result_msg?>
					</p>
				<?
			}?>
		</form>
	</div>
</div>
