<?$part_type = $mode;?>
<script type="text/javascript">
<!--
	function asdf1(){
		showajax(".col-right", "side_order");
	}
	function asdf2(){
		var main="<?=$main?>";
		if (main=="y"){
			location.href = "/kor/";
		}
		showajax(".col-right", "side");
	}
//-->
</script>
<section id="board-con" class="box-type2">
	<div class="title-top">
		<h2>재고 등록/수정</h2>
	</div>
	<div class="title-blck first">
		<h3>방법</h3>		
		<a href="javascript:asdf1()"><img src="/kor/images/btn_oderform.gif" alt="발주서"></a>		
	</div>
	<div class="mr-tb15 mr-lr6 con-section" lang="ko">
		<div class="notice-pop">
		<ol class="dft-ol">


		<?if ($part_type =="turnkey"){?>
			
			<li>등록양식을 Download하여 해당 값 입력 후 저장합니다.
				<ul>
					<li>① <span class="fnt_blue">Part No.</span> – 영문 대소문자, 숫자, 특수문자 24자 또는 이상</li>
					<li>② <span class="fnt_blue">Manufacturer</span> - 영문 대소문자, 숫자, 특수문자 20자 또는 이상</li>
					<li>③ <span class="fnt_blue">Package</span> - 영문 대소문자, 숫자, 특수문자 10자</li>
					<li>④ <span class="fnt_blue">D/C</span> – <?if ($part_type=="2"){?>NEW(고정 값)<?}else{?>제조년 <span class="fnt_red">예) 2015, 2016<?}?></span></li>
					<li>⑤ <span class="fnt_blue">RoHS</span> – None(RoHS가 아니거나 모름), RoHS, HF(Halogen Free)중 선택</li>
					<li>⑥ <span class="fnt_blue">Q’ty</span> – <?if ($part_type=="2"){?>I(Infinity) (고정 값)<?}else{?>재고수량, 최대값 : 99,999,999<?}?>
					<p class="fnt_red" style="margin:0 15px">[ 본사에서 지정한 품질 보증기간은 180일입니다. 보증기간에 적합한 품목만 등록하시기 바랍니다.]</p>
					</li>
					
				</ul>        
			</li>
			<li>저장된 File을 불러온 후 Price 입력후 등록합니다.</li>
			<li>내 턴키 편집 : Price수정과 턴키 삭제가 가능하며, Title클릭 시 개별 품목에 대한 수정과 삭제가 가능합니다.
			</li>
		<?}else{?>
			<li>6가지의 카테고리 별로 부품을 구분하여 각각 등록해야 합니다.</li>
			<li>등록양식을 Download하여 해당 값 입력 후 저장합니다.
				<ul>
					<li>① <span class="fnt_blue">Part No.</span> – 영문 대소문자, 숫자, 특수문자 24자 또는 이상</li>
					<li>② <span class="fnt_blue">Manufacturer</span> - 영문 대소문자, 숫자, 특수문자 20자 또는 이상</li>
					<li>③ <span class="fnt_blue">Package</span> - 영문 대소문자, 숫자, 특수문자 10자</li>
					<li>④ <span class="fnt_blue">D/C</span> – <?if ($part_type=="2"){?>NEW(고정 값)<?}else{?>제조년 <span class="fnt_red">예) 2015, 2016<?}?></span></li>
					<li>⑤ <span class="fnt_blue">RoHS</span> – None(RoHS가 아니거나 모름), RoHS, HF(Halogen Free)중 선택</li>
					<li>⑥ <span class="fnt_blue">Q’ty</span> – <?if ($part_type=="2"){?>I(Infinity) (고정 값)<?}else{?>재고수량, 최대값 : 99,999,999<?}?></li>
					<li>⑦ <span class="fnt_blue">Unit Price</span> – 최대값 : $9,999,999
						<p class="fnt_red" style="margin:0 15px">[ 본사에서 지정한 품질 보증기간은 180일입니다. 보증기간에 적합한 품목만 등록하시기 바랍니다.]</p>

					</li>
				</ul>                                                                                                                             
				
			</li>
			<li>저장된 File을 불러온 후 등록합니다.
				<ul>
					<li>① <span class="fnt_blue">덮어쓰기</span> – 기존에 등록된 재고를 모두 삭제한 후 재 등록 됨</li>
					<li>② <span class="fnt_blue">추가등록</span> – 기존에 등록된 재고는 변경 없이 추가로 등록 됨</li>
				</ul>			
			</li>
			<li>재고추가 : 한 품목씩 등록</li>
			<li>재고편집 : 등록한 품목의 수정과 삭제
				<p class="fnt_blue" style="margin-left:65px">Part No. , Manufacturer는 변경이 불가합니다. 변경을 원할 시 삭제 후 재등록 바랍니다.</p>

			</li>
		<?}?>

		</ol>
		
		<h2 class="txt_c fnt_red">- 재고 등록 시 유의사항  –</h2>
		<ul class="dft-ul">
		<li><span class="fnt_purple">회사 <strong>Main</strong>에서 등록 시</span> : 회사와 직원은 재고관리와 판매에 대해 똑같이 공유할 수 있습니다.</li>
		<li><span class="fnt_purple">개별 직원 별로 등록 시</span> : 직원 별로 재고관리와 판매를 각각 할 수 있습니다. <span class="fnt_blue">(재고 품목이 많은 회사에 유리)</span> – 회사 <strong>Main</strong>에서는 직원 별로 등록한 모든 재고와 판매 정보를 공유할 수 있습니다.</li>
		</ul>
	</div>
	</div>	
</section>
