
<script type="text/javascript">
<!--
	function board_sch(){
		var f =  document.searchfrm;
		var recordcnt = document.getElementById("recordcnt").value;
		var mode = document.getElementById("mode").value
		showajaxParam("#boardleftTop", "boardlist", "page=1&wantcnt="+recordcnt+"&mode="+mode+"&strsearch="+encodeURIComponent(f.strsearch.value));
		ready();
		$(".pagination a.link").click(function(){
			showajaxParam("#boardleftTop", "boardlist", "page="+$(this).attr("num")+"&wantcnt="+recordcnt+"&mode="+mode+"&strsearch="+encodeURIComponent(f.strsearch.value));
		});
	}
	function board_det(board_idx){
		showajaxParam(".col-right", "side_board", "board_idx="+board_idx);
	}

	function board_write(mode,board_idx){
		showajaxParam("#boardleftTop", "boardlist", "page=1&wantcnt=10&mode="+mode);
		showajaxParam("#boardleftBottom", "boardwrite", "mode="+mode+"&board_idx="+board_idx);
	}

	

	function check_key_board(){
		if(window.event.keyCode==13){			
			board_sch();
		}
	}
//-->
</script>
<section id="boardleftTop" >				
</section>

<!-- stockManage -->
<section id="boardleftBottom" >				
</section>
<!--// stockManage -->
			
	