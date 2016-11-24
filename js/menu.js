//company

function index() {location.href = "../main/main.php";}


function gnb_01() {location.href = "../product/product_ty.php";}
function gnb_02() {location.href = "../product/product_sch1.php";}
function gnb_03() {location.href = "../store/store.php";}
function gnb_04() {location.href = "../cs/faq_list.php";}
function gnb_05() {location.href = "../buy/buy_shop.php";}
function gnb_06() {location.href = "../company/company01.php";}


function snb0101() {location.href = "../product/product_ty.php?mode=BB001";}
function snb0102() {location.href = "../product/product_ty.php?mode=BB002";}
function snb0103() {location.href = "../product/product_ty.php?mode=BB003";}
function snb0104() {location.href = "../product/product_ty.php?mode=BB004";}
function snb0105() {location.href = "../product/product_ty.php?mode=BB005";}
function snb0106() {location.href = "../product/product_ty.php?mode=BB006";}
function snb0107() {location.href = "../product/product_ty.php?mode=BB007";}
function snb0108() {location.href = "../product/product_ty.php?mode=BB008";}


//function snb0105_() {snbPdList("BB005","","","","");}
//function snb0106_() {snbPdList("BB006","","","","");}
//function snb0107_() {snbPdList("BB007","","","","");}
//function snb0108_() {snbPdList("BB008","","","","");}

function snb0201() {location.href = "../product/product_sch1.php";}

function snb0301() {location.href = "../store/store.php?ty=bike";}
function snb0302() {location.href = "../store/store.php?ty=basic";}

function snb0401() {location.href = "../cs/faq_list.php";}
function snb0402() {location.href = "../cs/qna_list.php";}
function snb0403() {location.href = "../cs/support01.php";}
function snb0403_01() {location.href = "../cs/support01.php";}
function snb0403_02() {location.href = "../cs/support02.php";}
function snb0403_03() {location.href = "../cs/support03.php";}
function snb0403_04() {location.href = "../cs/support04.php";}
function snb0403_05() {location.href = "../cs/support05.php";}
function snb0403_06() {location.href = "../cs/support06.php";}
function snb0403_07() {location.href = "../cs/support07.php";}
function snb0404() {location.href = "../cs/gallery.php?ty=product";}
function snb0405() {location.href = "../cs/gallery.php?ty=set";}

function snb0501() {location.href = "../buy/buy_shop.php";}
function snb0502() {location.href = "../buy/buy_tel.php";}
function snb0503() {location.href = "../buy/buy_store.php";}

function snb0601() {location.href = "../company/company01.php";}
function snb0602() {location.href = "../company/company02.php";}
function snb0603() {location.href = "../company/company03.php";}
function snb0604() {location.href = "../company/company04.php";}
function snb0605() {location.href = "../company/company05.php";}

function snb0701() {location.href = "../member/personal.php";}
function snb0702() {location.href = "../member/email.php";}
function snb0703() {location.href = "../member/personal.html";}
function snb0704() {location.href = "../member/agreement.html";}
function snb0705() {location.href = "../member/email.html";}
function snb0706() {location.href = "../member/sitemap.html";}
/*mode : board_gubun , cate : 설치위치, rTy: roof type(지붕타입), pTy : product type(제품형태), OP : 옵션여부(부속품 여부)*/
function snbPdList(mode,cate,rTy,pTy,OP){   
	location.href = "../product/product_list.php?mode="+mode+"&cate="+cate+"&rTy="+rTy+"&pTy="+pTy+"&OP="+OP;
}

function snbPdConvList(mode,Ty){ 
	if (Ty == "OP")
	{
		url= "&OP=Y";
	}else{
		url = "&pIdx="+Ty;
	}
	location.href = "../product/product_list.php?mode="+mode+url;
}



/* 2depth //
function hd_01() {location.href = "../main/main.php";}
function hd_02() {location.href = "../company/company05.php";}
function hd_03() {location.href = "../company/company04.php";}


function sub_01_01() {location.href = "../about/about01.php";}
function sub_01_02() {location.href = "../about/about02.php";}
*/