<ul>
<?
//layer pagination (판매/구매 layer)
$intpage="";
$LSP = (int)(($page - 1) / $viewpagecnt + 1);	
$startpage = ($LSP - 1) * $viewpagecnt + 1;
$endpage = $LSP * $viewpagecnt ;	 
if ($endpage > $totalpage) $endpage = $totalpage;	
//=============페이지수를 세어준다====
if ($cnt>0){
	//[이전글10개]나타내기
	$intTemp = (int)((($page - 1) / $viewpagecnt) * $viewpagecnt + 1);
	
	//$intpage .= "<li><a href='$pageurl?mode=$mode&cate=$cate&page=1&search=$search&strsearch=$strsearch$addpara'>[처음]</a></span> ";
	if ($page==1){
	  $intpage .= "<li class='navi-prev'><a alt='Prev'><img src='/kor/images/nav_btn_down.png' alt='prev'></a></li> ";
	} else {
	  $prev=$page-1;
	  $intpage .= "<li class='navi-prev'><a href='javascript:openCommLayer('$layerNum','$loadPage','$varNum&page=$prev');' num='$prev' alt='Prev'><img src='/kor/images/nav_btn_down.png' alt='prev'></a></li> ";	
	}
	//페이지수 뿌려주기
	$intloop=1;
	//$endpage;
	for ($np=$startpage; $np<=20; $np++) {
		if ($np ==$page) { 
			$intpage .= "<li class='current'><a>$np</a>";
		} else {
			if ($np <=$endpage){
			//design ==> 1: sell-mn02 , 2: sell-mn02-1601 , 3: sell-mn02-1701
			$intpage .= "<li lang=\"en\"><a href=\"javascript:openCommLayer('$layerNum','$loadPage','$varNum&page=$np');\" num=\"$np\">$np</a>";
			}else{
				$intpage .= "<li lang=\"en\"><span>$np</span>";
			}
		}
		$intpage .= "</li>\n";
	}
	
	$next=$page+1;
	//[다음10개]페이지 보여주기
	 if ($intTemp<$totalpage){		
	    $intpage .= "<li class='navi-next'><a href='javascript:openCommLayer('$layerNum','$loadPage','$varNum&page=$next');' class='link' num ='$next' alt='Next'><img src='/kor/images/nav_btn_up.png' alt='next'></a></li> ";	    
     } else {
		$intpage .= "<li class='navi-next'><a alt='Next'><img src='/kor/images/nav_btn_up.png' alt='next'></a></li> ";
	 }
	
	 
	echo $intpage;
}
?>
</ul>