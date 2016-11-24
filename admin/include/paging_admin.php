<?

$intpage="";
$LSP = (int)(($page - 1) / $viewpagecnt + 1);	
$startpage = ($LSP - 1) * $viewpagecnt + 1;
$endpage = $LSP * $viewpagecnt ;	 
if ($endpage > $totalpage) $endpage = $totalpage;	
//=============페이지수를 세어준다====
	//[이전글10개]나타내기
	$intTemp = (int)((($page - 1) / $viewpagecnt) * $viewpagecnt + 1);
	

	if ($page==1){
	  $intpage .= "[이전]&nbsp;";
	} else {
	  $prev=$page-1;
	  $intpage .= "<a href='$pageurl?mode=$mode&cate=$cate&page=$prev&search=$search&strsearch=$strsearch$addpara'>[이전]</a>&nbsp;";	
	}

	
	//페이지수 뿌려주기
	 
	$intloop=1;
	for ($np=$startpage; $np<=$endpage; $np++) {
		if ($np ==$page) { 
			$intpage .= " <font size=3 color='#FF0000'><b>$np</b></font>&nbsp;";
		} else {
			$intpage .= "<a href='$pageurl?mode=$mode&cate=$cate&page=$np&search=$search&strsearch=$strsearch'>$np</a>&nbsp;";
		}
	}
	
	$next=$page+1;
	//[다음10개]페이지 보여주기
	 if ($intTemp<$totalpage){
		
	    $intpage .= "<a href='$pageurl?mode=$mode&cate=$cate&page=$next&search=$search&strsearch=$strsearch$addpara'>&nbsp;[다음]</a>";
	    
     } else {
		$intpage .= " &nbsp;[다음]";
	 }
	 
	 
	echo $intpage;
?>