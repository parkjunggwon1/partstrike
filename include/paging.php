
<?

$intpage="";
$LSP = (int)(($page - 1) / $viewpagecnt + 1);	
$startpage = ($LSP - 1) * $viewpagecnt + 1;
$endpage = $LSP * $viewpagecnt ;	 
if ($endpage > $totalpage) $endpage = $totalpage;	
//=============페이지수를 세어준다====
if ($cnt>0){
	//[이전글10개]나타내기
	$intTemp = (int)((($page - 1) / $viewpagecnt) * $viewpagecnt + 1);
	
//	$intpage .= "<a href='$pageurl?mode=$mode&cate=$cate&page=1&search=$search&strsearch=$strsearch$addpara'>처음</a> ";
	if ($page==1){
	  $intpage .= "<span><img src='/img/bbs/btn_p.jpg' alt='이전' /></span> ";
	} else {
	  $prev=$page-1;
	  $intpage .= "<span><a href='$pageurl?mode=$mode&cate=$cate&site=$site&page=$prev&search=$search&strsearch=$strsearch$addpara'><img src='/img/bbs/btn_p.jpg' alt='이전' /></a></span> ";	
	}
	
	//페이지수 뿌려주기
	 
	$intloop=1;
	for ($np=$startpage; $np<=$endpage; $np++) {
		if ($np ==$page) { 
			$intpage .= "<span class='numov'>$np</span> ";
		} else {
			$intpage .= "<span class='num'><a href='$pageurl?mode=$mode&cate=$cate&site=$site&page=$np&search=$search&strsearch=$strsearch$addpara'>$np</a></span> ";
		}
	}
	
	$next=$page+1;
	//[다음10개]페이지 보여주기
	 if ($intTemp<$totalpage){
		
	    $intpage .= "<span><a href='$pageurl?mode=$mode&cate=$cate&site=$site&page=$next&search=$search&strsearch=$strsearch$addpara'><img src='/img/bbs/btn_n.jpg' alt='다음' /></a></span> ";
	    
     } else {
		$intpage .= "<span><img src='/img/bbs/btn_n.jpg' alt='다음' /></span> ";
	 }
//	 $intpage .= "<a href='$pageurl?mode=$mode&cate=$cate&page=$totalpage&search=$search&strsearch=$strsearch$addpara'>끝</a> ";
	 
	 
	echo $intpage;
}
?>
