<ul>
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
	
	//$intpage .= "<li><a href='$pageurl?mode=$mode&cate=$cate&page=1&search=$search&strsearch=$strsearch$addpara'>[처음]</a></span> ";
	if ($page==1){
	  $intpage .= "<li class='navi-prev'><a alt='Prev'>Prev</a></li>";
	} else {
	  $prev=$page-1;
	  $intpage .= "<li class='navi-prev'><a href='javascript:;' class='link' num='$prev' alt='Prev' >Prev</a></li> ";	
	}
	
	//페이지수 뿌려주기

	$intloop=1;
	for ($np=$startpage; $np<=$endpage; $np++) {
		if ($np ==$page) { 
			$intpage .= "<li class='current'><a>$np</a>";
		} else {
			$intpage .= "<li><a href='javascript:;' class='link' num='$np'>$np</a> ";
		}
	}
	$intpage .= "</li>";
	$next=$page+1;
	//[다음10개]페이지 보여주기
	 if ($intTemp<$totalpage){		
	    $intpage .= "<li class='navi-next'><a href='javascript:;' class='link' num ='$next' alt='Next' >Next</a></li> ";	    
     } else {
		$intpage .= "<li class='navi-next'><a alt='Next'>Next</a></li> ";
	 }
	
	 
	echo $intpage;
}
?>
</ul>