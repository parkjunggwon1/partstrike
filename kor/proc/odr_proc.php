<?
/**********************************************************************************************************************
*** 2016-04-02 :
    1. $typ=="periodreq" 시.. 납기받은 창($odr_status==16)에서만 번호 새로 따던것을 무조건 새로 따는 것으로 변경
    2. 납기제품 별도 odr 생성 시 발주창에 있는 품목의odr_det 에 rel_det_idx(납기확인 품목) 입력
***********************************************************************************************************************/
 ob_start();
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.odr.php";   //2016-12-06
include $_SERVER["DOCUMENT_ROOT"]."/include/fileuploader.php";

if (!$_SESSION["MEM_IDX"]){ReopenLayer("layer6","alert","?alert=sessionend");exit;}
$dir_dest = "../..".$file_path; //파일 저장 폴더 지정
/**************************************************************************************************************************************************************/
/********************************************************************** write / odredit / periodreq(납기확인) *************************************************/
/*************************************************************************************************************************************************************/
if ($typ=="write" || $typ=="odredit" ||$typ =="periodreq"){   //periodreq : 납기확인
    $odr_idx_yn = "N";
    /** 2016-03-25 아래로 합침
    if (!$odr_idx){  //ord_idx 있으면 -------------
            $part=get_part($part_idx);
            $sell_mem_idx = $part[mem_idx];
            $sell_rel_idx = $part[rel_idx];
            $part_type = $part[part_type];
            $odr=get_odr($odr_idx);
            $odr_status = $odr[odr_status];

        //1. 임시 odr_idx 를 구한다. 구하지 말고 우선 그냥 무조건 insert 시켜보자.
        //$odr_idx = get_any("odr a left outer join odr_det b ON a.odr_idx = b.odr_idx", "a.odr_idx", "part_idx = $part_idx and imsi_odr_no <> '' and mem_idx=".$_SESSION["MEM_IDX"]." and rel_idx=".$_SESSION["REL_IDX"]);
    }
    **/
    if($odr_idx){
        $odr=get_odr($odr_idx);
        $odr_status = $odr[odr_status];
        $odr_idx_yn = "Y";
    }

    if (!$odr_idx){   //odr idx가 없으면 odr_idx 생성--------------------------------
        $odr_idx_yn = "N";
        $part=get_part($part_idx);
        $sell_mem_idx = $part[mem_idx];
        $sell_rel_idx = $part[rel_idx];
        $part_type = $part[part_type];
        $price = $part[price];
        //1. odr 테이블 INSERT
        $sql = "insert into odr set
                imsi_odr_no = 'IM-".date("ymdhms").RndomNum(4)."'
                ,mem_idx = $session_mem_idx
                ,rel_idx = $session_rel_idx
                ,sell_mem_idx = $sell_mem_idx
                ,sell_rel_idx = $sell_rel_idx
                ,period = ''
                ,odr_status= '0'
                ,memo = '$memo'
                ,save_yn = '$save_yn'
                ,reg_date = now()
                ,reg_ip= '$log_ip'
            ";
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
        $odr_idx=mysql_insert_id(); //신규 생성 odr
        $new_odr_idx=mysql_insert_id(); //신규 생성 odr
        //2. 일반 배송으로 ship_info 하나 생성.
        $sql = "insert into ship set
                  ship_type = '1' ,
                  odr_idx  = '$odr_idx' ,
                  ship_info ='$ship_info',
                  ship_account_no = '$ship_account_no' ,
                  insur_yn ='$insur_yn',
                  reg_date =  now(),
                  reg_ip = '$log_ip'
        ";
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
        $new_ship_idx=mysql_insert_id();
        $sql = "update odr set ship_idx = $new_ship_idx where odr_idx = $odr_idx";
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());


    //  $sql = "update odr set odr_no = 'PO$part_ty-".$sell_mem_idx."-".$odr_idx."'
    //          where odr_idx = $odr_idx";

    //  $sql = "update odr set odr_no = '".get_odr_no("PO")."'
    //          where odr_idx = $odr_idx";
    //  $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

    }elseif($save_yn){ //-------------------- [저장] -------------------------------------------------
        $sql = "update odr set save_yn = '$save_yn' where odr_idx = $odr_idx";
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
        $sql = "update odr_det set amend_yn = 'N' where odr_idx = $odr_idx";
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
        //-- MyBox에 있을 시 삭제-----
        $mem_idx = get_any("odr", "mem_idx", "odr_idx = $odr_idx");
        $sql = "DELETE FROM mybox WHERE mem_idx=$mem_idx AND
                part_idx IN(SELECT b.part_idx FROM odr a INNER JOIN odr_det b ON(a.odr_idx=b.odr_idx) WHERE a.odr_idx=$odr_idx)
                ";
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
    } //end of - if (!$odr_idx) ----------------------------------------// odr_idx 없을 때(쌩짜)-------------------------------

    //Ship Update------------------------------------<<
    if ($odr_idx && $fromPage!="add"){
    //  elseif($memo || $ship_account_no || $delivery_addr_idx){   //memo 값이 들어있다는 얘기는 extra data가 넘어왔다는 뜻 안들어왔어도 update 하자. 썻다 지우고 싶을수도 있으니까.
        //2016-11-10 : 선불 배송비 관련 param 정리
        if($dlvr_adv=="Y"){ //선불 일경우..
            $ship_info = $dlvr_corp;
            $ship_account_no = $dlvr_acc;
            $shipping_charge = $dlvr_pay;
        }
        $sql = "update ship set
            ship_info = '$ship_info'
            ,delivery_addr_idx = '$delivery_addr_idx'
            ,ship_account_no = '$ship_account_no'
            ,insur_yn = '$insur_yn'
            ,memo = '$memo'";
        if($dlvr_adv=="Y"){ //선불 일경우..
            $sql .= ",shipping_charge = $shipping_charge";
        }
        $sql .= "
        where odr_idx = $odr_idx and ship_type = '1'
        ";
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
    }
    // end of 3개(write/odredit/periodreq)공통 ---------------------------------------------------------------------------
    /*******************************************************************
    ** 발주서 수정 외에 것들(write, peridoreq)
    ** //odredit일때는 odr_det는 안건드리고 odr 테이블만 업데이트 한다. - JSJ
    *******************************************************************/
    if ($typ !="odredit"){ //write, periodreq
        $cnt = get_any ("odr_det" , "count(*)", "odr_idx= $odr_idx and part_idx = $part_idx");
        if ($cnt > 0 ) { // 발주창에 있는 Parts---------
            ReopenLayer("layer3",$fromLoadPage,"?odr_idx=$odr_idx");
    //      Page_Parent_Msg_Url("이미 발주 또는 납기 확인요청이 들어간 부품입니다.","/kor/");
            $sql = "update odr_det set odr_quantity =  '$odr_quantity' where odr_idx = $odr_idx and part_idx = $part_idx";
            $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
            $odr_det_idx=get_any ("odr_det" , "odr_det_idx", "odr_idx= $odr_idx and part_idx = $part_idx");
        }else{ //-- 발주창에 없는 Parts-----------------
            if(!$part_type){
                $part_type = get_any("part", "part_type", "part_idx=$part_idx");
            }
            //odr_det에 insert
            if ($part_type==7){
                $odr_quantity = 1;
            }

            //$amend_yn = $fromLoadPage == "09_01" ? "Y":"N";//2016-03-25 아래로 변경
            if($fromLoadPage == "09_01" || $odr_status==16 || $fromPage=="add"){ //09_01:수정발주서창, 16:납기 받은거창
                $amend_yn = "Y";
            }else{
                $amend_yn = "N";
            }
            $det_odr_status = ($part_type ==2 || $part_type ==5 || $part_type ==6)? 1:0; //납기 받은거 창에 추가시
            //2016-05-27 : 단가 정보 추가
            $odr_price = get_any("part" , "price", "part_idx = $part_idx");
            //2016-06-28 : 재고 정보 추가
            $odr_stock = get_any("part" , "quantity", "part_idx = $part_idx");
            $sql = "insert into odr_det set
                    odr_idx = $odr_idx
                    ,odr_stock = $odr_stock
                    ,odr_price = $odr_price
                    ,part_idx =  '$part_idx'
                    ,part_type =  '$part_type'
                    ,odr_quantity =  '$odr_quantity'
                    ,period =  '$period'
                    ,amend_yn =  '$amend_yn'
                    ,odr_status =  '$det_odr_status'
            ";
    //      echo $sql;
            $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
            $odr_det_idx=mysql_insert_id(); //새로 추가(발주창)한 품목 odr_det_idx
        }
    }//end of - ($typ !="odredit")
    //로드페이지 값 없으면 05_04 -------------------------------------------------------------------------
    if (!$fromLoadPage){ $fromLoadPage="05_04";}      //기존 JSJ 화면
    //if (!$fromLoadPage){ $fromLoadPage="05_04_v";}      //신규 SKR 화면

    if ($typ =="periodreq") {  //납기 확인의 경우----------------------------------------------------------------------
        if($odr_idx_yn=="Y"){ //2016-04-05
            //----------------------------------- 발주창에서 납기품목 추가시 ----------------------------
            //1. insert odr
            $sql = "insert into odr set
                    imsi_odr_no = 'IM-".date("ymdhms").RndomNum(4)."'
                    ,mem_idx = $session_mem_idx
                    ,rel_idx = $session_rel_idx
                    ,sell_mem_idx = $sell_mem_idx
                    ,sell_rel_idx = $sell_rel_idx
                    ,period = ''
                    ,odr_status= '1'
                    ,memo = '$memo'
                    ,save_yn = 'N'
                    ,reg_date = now()
                    ,reg_ip= '$log_ip'
                ";
            $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
            $new_odr_idx=mysql_insert_id(); //신규 생성 odr
            //2. insert ship
            $sql = "insert into ship set
                      ship_type = '1' ,
                      odr_idx  = '$new_odr_idx' ,
                      ship_info ='$ship_info',
                      ship_account_no = '$ship_account_no' ,
                      insur_yn ='$insur_yn',
                      reg_date =  now(),
                      reg_ip = '$log_ip'
            ";
            $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
            $new_ship_idx=mysql_insert_id();
            $sql = "update odr set ship_idx = $new_ship_idx where odr_idx = $new_odr_idx";
            $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
            //3. insert odr_det 위에꺼() 복사해서..
            $sql = "INSERT INTO odr_det (odr_idx, part_idx, part_type, odr_stock, odr_quantity, odr_price, supply_quantity, fault_dc, rnd_yn, period)
                    SELECT $new_odr_idx, part_idx, part_type, odr_stock, odr_quantity, odr_price, supply_quantity, fault_dc, rnd_yn, period FROM odr_det WHERE odr_det_idx = $odr_det_idx ";
            $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
            $new_odr_det_idx=mysql_insert_id();
            //4. insert history
            $sql = "insert into odr_history set
                    odr_idx = '$new_odr_idx'
                    ,odr_det_idx = '$new_odr_det_idx'
                    ,status = 1
                    ,status_name = '납기'
                    ,etc1 = '확인'
                    ,sell_mem_idx = '$sell_mem_idx'
                    ,buy_mem_idx = '$session_mem_idx'
                    ,reg_mem_idx = '$session_mem_idx'
                    ,reg_date = now()";
            $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
            //5. 기존 odr_det 에 rel_det_idx 정보 Update .. 2016-04-02 주). 해보고 않되면 rel_odr_idx 도 만들자
            $sql = "update odr_det set rel_det_idx = $new_odr_det_idx where odr_det_idx = $odr_det_idx";
            $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
            //2016-04-02
        }else{ //창에서 요청한게 아닐경우(메인검색 단품)
            //------------------------------------ 기존 -----------------------------------------------------------------
            //1. status 변경
            $sql = "update odr set odr_status = 1 where odr_idx= $odr_idx";
            $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
            update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);

            $sql ="update odr_history set confirm_yn = 'Y' where odr_idx = $odr_idx and confirm_yn = 'N'";
            $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

            //2. history 등록
            $session_mem_idx = $_SESSION["MEM_IDX"];
            $sql = "insert into odr_history set
                    odr_idx = '$odr_idx'
                    ,odr_det_idx = '$odr_det_idx'
                    ,status = 1
                    ,status_name = '납기'
                    ,etc1 = '확인'
                    ,sell_mem_idx = '$sell_mem_idx'
                    ,buy_mem_idx = '$session_mem_idx'
                    ,reg_mem_idx = '$session_mem_idx'
                    ,reg_date = now()";
            //echo $sql;
            $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
            //납기요청 공통사항 : MyBox 체크하여 삭제 2016-04-07
            $mem_idx = get_any("odr a INNER JOIN odr_det b ON(a.odr_idx=b.odr_idx)", "a.mem_idx", "b.odr_det_idx = ".$odr_det_idx);
            $sql = "DELETE FROM mybox WHERE part_idx = (SELECT part_idx FROM odr_det WHERE odr_det_idx=$odr_det_idx) AND mem_idx = $mem_idx";
            $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
        }
        closeLayer("layer4"); //납기(확인바랍니다.) 창
        if ($fromPage=="add"){ //발주추가 검색 창에서 호출 한거면....
            ReopenLayer("layer3",$fromPage=="add"?"05_01":$fromLoadPage,"?odr_idx=$odr_idx".($fromPage=="add"?"&addsearch_part_no=$addsearch_part_no&fromLoadPage=$fromLoadPage&coo_yn=y":""));
        }else{
            Parent_Search_Refresh(); //2016-04-08
            closeLayer("layer3");

        }  //-------------------------------------------end if 납기확인-------------------------------------------------------------------
    }else{  //납기 확인이 아닐 경우(저장, 수정)------------------[Layer Open]------------------------------------------------------
        if($result){
            if ($save_yn == "Y"){
                //Page_Parent_Url("/kor/");
                //Parent_Refresh_Right(); //2016-03-31
                //ReopenLayer2(".col-right", "side_order");
                Parent_Search_Refresh();
                closeLayer("layer3");
            }else{
                if($fromLoadPage == "05_04_v"){ //2016-03-13 KSR
                    ReopenLayer("layer3",$fromPage=="add"?"05_01":$fromLoadPage,"?session_mem_idx=$session_mem_idx".($fromPage=="add"?"&addsearch_part_no=$addsearch_part_no&fromLoadPage=$fromLoadPage&coo_yn=y":""));
                } else{ //기존(JSJ)
                    ReopenLayer("layer3",$fromPage=="add"?"05_01":$fromLoadPage,"?odr_idx=$odr_idx&opnnerPage=".$opnnerPage.($fromPage=="add"?"&addsearch_part_no=$addsearch_part_no&fromLoadPage=$fromLoadPage&coo_yn=y":""));
                }
            }
            exit;
        }
    }    
}   //end of write / odredit / periodreq
/****************************************************************** 납기 받은거 저장 **********************************************************************
*** 2016-04-05 : 상태16 꺼 전체(odr, odr_det)를 복제, 기존 상태 16의 history 를 확인(confirm_yn='Y') 처리
***********************************************************************************************************************************************************/


if($typ == "persave"){
    //1. INSERT odr
    $sql = "insert into odr set
            imsi_odr_no = 'IM-".date("ymdhms").RndomNum(4)."'
            ,mem_idx = $session_mem_idx
            ,rel_idx = $session_rel_idx
            ,sell_mem_idx = $sell_mem_idx
            ,sell_rel_idx = $sell_rel_idx
            ,period = ''
            ,odr_status= '0'
            ,memo = '$memo'
            ,save_yn = 'Y'
            ,reg_date = now()
            ,reg_ip= '$log_ip'
        ";
    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
    $save_odr_idx=mysql_insert_id(); //신규 생성 odr
    //2. 상태16의 모든 odr_det 복제(일반:det 상태 16이 아닌거)
    $sql = "INSERT INTO odr_det (odr_idx, part_idx, part_type, odr_quantity, odr_price, supply_quantity, fault_dc, rnd_yn, period, odr_status, rel_det_idx)
                SELECT $save_odr_idx, part_idx, part_type, odr_quantity, odr_price, supply_quantity, fault_dc, rnd_yn, period, odr_status, rel_det_idx FROM odr_det WHERE odr_idx = $odr_idx AND odr_status NOT IN(16) ";
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
    //2-1. 상태 16인건 별도로 rel_det_idx 따주자.
    $sql = "INSERT INTO odr_det (odr_idx, part_idx, part_type, odr_quantity, odr_price, supply_quantity, fault_dc, rnd_yn, period, odr_status, rel_det_idx)
                SELECT $save_odr_idx, part_idx, part_type, odr_quantity, odr_price, supply_quantity, fault_dc, rnd_yn, period, odr_status, odr_det_idx FROM odr_det WHERE odr_idx = $odr_idx AND odr_status IN(16) ";
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
    //3. 상태16의 amend Data 삭제
    $sql = "DELETE FROM odr_det WHERE odr_idx = $odr_idx AND amend_yn='Y' ";
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
    //4. 상태16 '확인' 처리 (What's New 비 노출)
    $his_idx = get_any("odr_history", "max(odr_history_idx)", "odr_idx=$odr_idx");
    update_val("odr_history","confirm_yn","Y", "odr_history_idx", $his_idx);
    //5. INSERT Ship
    $sql = "insert into ship set
              ship_type = '1' ,
              odr_idx  = '$new_odr_idx' ,
              ship_info ='$ship_info',
              ship_account_no = '$ship_account_no' ,
              insur_yn ='$insur_yn',
              reg_date =  now(),
              reg_ip = '$log_ip'
    ";
    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
    $new_ship_idx=mysql_insert_id();
    $sql = "update odr set ship_idx = $new_ship_idx where odr_idx = $save_odr_idx";
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
    //6. 창 처리(05_04닫고, Whats'New 닫고, 우측 새로고침)
    ReopenLayer2(".col-right", "side_order");
    closeLayer("layer3"); //05_04
    closeLayer("layer"); //What's New
}
/*************************************************************************************************************************************************************/
/********************************************************************** edit *********************************************************************************/
/***********************************************************************************************************************************************************/
if ($typ == "edit"){
     $no = $_POST[delchk];
     $ary_part_idx = $_POST[mod_part_idx];
     $ary_part_no = $_POST[mod_part_no];
     $ary_manufacturer = $_POST[mod_manufacturer];
     $ary_package = $_POST[mod_package];
     $ary_dc = $_POST[mod_dc];
     $ary_rhtype = $_POST[mod_rhtype];
     $ary_quantity = $_POST[mod_quantity];

     if ($part_type =="7"){
        $sql = "update turnkey set price = '".$price."' where turnkey_idx = $turnkey_idx";
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
//      echo $sql;
     }


     for ($j = 0 ; $j<count($ary_part_idx); $j++){

          if ($part_type== "2"){
            $option = ", price = '".$ary_price[$j]."'";
          }elseif($part_type =="7"){ //turnkey
            $option = ", quantity = '".$ary_quantity[$j]."'";
            if ($i <=4){
            }
          }else{
            $option = ", quantity       = '".$ary_quantity[$j]."'
                       , price          = '".$ary_price[$j]."' ";
          }


            $sql = "update part set
                mem_idx ='".$_SESSION["MEM_IDX"]."'
                ,rel_idx='".$_SESSION["REL_IDX"]."'
                , part_no       = '".$ary_part_no[$j]."'
                , manufacturer  = '".$ary_manufacturer[$j]."'
                , package       = '".$ary_package[$j]."'
                ,  dc           = '".$ary_dc[$j]."'
                , rhtype        = '".$ary_rhtype[$j]."'
                $option
                where part_idx = $ary_part_idx[$j]";

                //echo $sql."<BR>";
                $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

     }
    if($result){
        PageReLoad("저장되었습니다.",$part_type);
    }
}

if ($typ =="invreg"){   //송장 정보 등록(30_09내용) ----------------------------------------------------------------------------------------------------------------------------

    $ary_part_idx = $_POST[part_idx];       //턴키
    $ary_odr_det_idx = $_POST[odr_det_idx];
    $ary_supply_quantity= $_POST[supply_quantity];
    $ary_part_condition = $_POST[part_condition];
    $ary_pack_condition1 = $_POST[pack_condition1];
    $ary_pack_condition2 = $_POST[pack_condition2];
    $ary_part_no = $_POST[part_no];
    $ary_manufacturer = $_POST[manufacturer];
    $ary_package = $_POST[package];
    $ary_rosh = $_POST[rosh];
    $ary_rhtype = $_POST[rhtype];
    $ary_memo = $_POST[memo];
    $ary_part_type = $_POST[part_type];
    $part_type_chk = "";
    

    if($turnkey_cnt>0){
        echo "TURNKEY~<br>";
        for ($j = 0 ; $j<count($ary_part_idx); $j++){
            $part_idx = $ary_part_idx[$j];
            echo $ary_pack_condition2[$j]."<br>";
            //1. odr_det_turnkey 테이블에 자료 존재여부 체크 후 INSERT or UPDATE
            $det_turnkey_cnt = QRY_CNT("odr_det_turnkey"," and odr_idx=$odr_idx and part_idx=$part_idx ");
                $sql = " part_condition            = '".$ary_part_condition[$j]."'
                    , pack_condition1           = '".$ary_pack_condition1[$j]."'
                    , pack_condition2           = '".$ary_pack_condition2[$j]."'
                    , memo                      = '".$ary_memo[$j]."'";
             if($det_turnkey_cnt>0){    //------------ UPDATE
                $sql = "update odr_det_turnkey set ".$sql." where odr_idx=$odr_idx and part_idx=$part_idx";
             }else{     //--------------------------------INSERT
                 $sql = "INSERT INTO odr_det_turnkey set odr_idx=$odr_idx, part_idx=$part_idx, ".$sql;
             }
             $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
        }
    }else{
        //턴키가 아닐 경우 odr_det 정보 업데이트
         for ($j = 0 ; $j<count($ary_odr_det_idx); $j++){

            if ($ary_part_type[$j]=="2" && $j==0)
            {                
                $part_type_chk ="1";
            }
            else
            {
                $part_type_chk ="0";
            }
            /*$sql = "update odr_det_temp set
                 supply_quantity            = '".$ary_supply_quantity[$j]."'
                , part_condition            = '".$ary_part_condition[$j]."'
                , pack_condition1           = '".$ary_pack_condition1[$j]."'
                , pack_condition2           = '".$ary_pack_condition2[$j]."'
                , memo                      = '".$ary_memo[$j]."'
                where odr_det_idx = $ary_odr_det_idx[$j]";
                //echo $sql."<BR>";
                $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());*/

                //임시테이블에 데이터 존재여부
                $odr_det_temp_idx = get_any("odr_det_temp", "odr_det_idx", "odr_det_idx=$ary_odr_det_idx[$j]");
                //$supply_quantity = str_replace(",","",$ary_supply_quantity[$j]);

                if($odr_det_temp_idx>0){
                    $sql = "update odr_det_temp set 
                        supply_quantity = '$ary_supply_quantity[$j]',
                        part_condition = '$ary_part_condition[$j]',
                        pack_condition1 = '$ary_pack_condition1[$j]',
                        pack_condition2 = '$ary_pack_condition2[$j]',
                        memo = '$ary_memo[$j]' 
                        where odr_det_idx ='$ary_odr_det_idx[$j]'";                     
                }else{
                    $sql = "insert odr_det_temp set 
                        supply_quantity = '$ary_supply_quantity[$j]',
                        part_condition = '$ary_part_condition[$j]',
                        pack_condition1 = '$ary_pack_condition1[$j]',
                        pack_condition2 = '$ary_pack_condition2[$j]',
                        memo = '$ary_memo[$j]' ,
                        odr_det_idx = '$ary_odr_det_idx[$j]'";
                }
              
                $ship_result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());  

                //송장에서도 개별 파트정보 업데이트 가능
                $part_idx =get_any("odr_det", "part_idx" ,"odr_det_idx=$ary_odr_det_idx[$j]");
                $part_inv_chk =get_any("part", "part_idx" ,"invreg_chk = 0 and part_idx=$part_idx");

                /**
                2017-01-18 : 여기서 Update하지 않고, 임시테이블에 저장
                $sql = "update part set part_no = '".$ary_part_no[$j]."',
                        manufacturer = '".$ary_manufacturer[$j]."',
                        package= '".$ary_package[$j]."',
                        dc= '".$ary_rosh[$j]."',
                        rhtype= '".$ary_rhtype[$j]."'
                        where part_idx = ".$part_idx."";
                $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
                **/
                //2017-01-18

                if ($part_inv_chk)
                {
                    $temp_cnt = QRY_CNT("part_temp"," and odr_idx=$odr_idx and odr_det_idx=$ary_odr_det_idx[$j] and part_idx=$part_idx and type='after'");
                    if($temp_cnt>0){    //임시테이블에 Data 있다(Update)
                        $sql = "update part_temp set part_no = '".$ary_part_no[$j]."',
                                manufacturer = '".$ary_manufacturer[$j]."',
                                package= '".$ary_package[$j]."',
                                dc= '".$ary_rosh[$j]."',
                                rhtype= '".$ary_rhtype[$j]."'
                                where part_idx = ".$part_idx." and type='after' and odr_idx=".$odr_idx." and odr_det_idx=".$ary_odr_det_idx[$j];
                    }else{  //임시테이블에 Data 없다(Insert)
                        //바뀌기전 파트정보를 먼저 입력한다.
                        $sql_before_sel = "SELECT part_idx,part_no,manufacturer,package,dc,rhtype FROM part WHERE part_idx = $part_idx";
                        $result=mysql_query($sql_before_sel,$conn) or die ("SQL ERROR : ".mysql_error());
                        while($row_before = mysql_fetch_array($result)){
                            $sql_before = "insert into part_temp set 
                                odr_idx = ".$odr_idx.", 
                                type= 'before',
                                odr_det_idx = ".$ary_odr_det_idx[$j].", 
                                part_idx = ".$part_idx.", 
                                part_no = '".$row_before['part_no']."',
                                manufacturer = '".$row_before['manufacturer']."',
                                package= '".$row_before['package']."',
                                dc= '".$row_before['dc']."',
                                rhtype= '".$row_before['rhtype']."'";

                            $result=mysql_query($sql_before,$conn) or die ("SQL ERROR : ".mysql_error());
                        } //end while
                        

                        //바뀐후의 파트정보를 입력한다.
                        $sql = "insert into part_temp set 
                                odr_idx = ".$odr_idx.", 
                                type= 'after',
                                odr_det_idx = ".$ary_odr_det_idx[$j].", 
                                part_idx = ".$part_idx.", 
                                part_no = '".$ary_part_no[$j]."',
                                manufacturer = '".$ary_manufacturer[$j]."',
                                package= '".$ary_package[$j]."',
                                dc= '".$ary_rosh[$j]."',
                                rhtype= '".$ary_rhtype[$j]."'";
                    }
                    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
                }
         }//end of for
     }//end of 턴키 or else
echo $part_type_chk;
     //2016-04-18 송장번호 생성하자
    if ($part_type_chk==1)
    {
        $inv_no = get_auto_no("DPI", "odr", "invoice_no");
    }
    else
    {
        $inv_no = get_auto_no("EI", "odr", "invoice_no");
    }
   
    update_val("odr","invoice_no",$inv_no , "odr_idx", $odr_idx);
     //2016-11-11 : 아래.. 왜 하는지 모르겠으나, tax Update 제거
     //$sql = "update ship set appoint_yn = '$appoint_yn' , tax = '$tax' where odr_idx = $odr_idx";
     $sql = "update ship set appoint_yn = '$appoint_yn',tax = '$tax' where odr_idx = $odr_idx";
     $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());


    if($result){
        ReopenLayer("layer5","30_09","?odr_idx=$odr_idx&loadPage=$load_page");
    }

}

if($typ =="invconfirm"){ //-------------------------------------- 송장 확정:30_09 (Invoice) JSJ ---------------------------------------------------------------------------------------------------
 //1. status변경
    update_val("odr","odr_status","18", "odr_idx", $odr_idx);
    update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);

    //2. 송장 번호 등록
    $inv_no = get_auto_no("EI", "odr", "invoice_no");
    update_val("odr","invoice_no",$inv_no , "odr_idx", $odr_idx);
    $buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
    //3. histoy update(발주서를 확인 한 상태로 update)
    $odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and (status = 2 or status=3) and confirm_yn='N'");
    update_val("odr_history","confirm_yn","Y", "odr_history_idx", $odr_history_idx);
    //4. history 등록
    $session_mem_idx = $_SESSION["MEM_IDX"];
    $sql = "insert into odr_history set
            odr_idx = '$odr_idx'
            ,status = 18
            ,status_name = '송장'
            ,etc1 = '$inv_no'
            ,sell_mem_idx = '$sell_mem_idx'
            ,buy_mem_idx = '$buy_mem_idx'
            ,reg_mem_idx = '$session_mem_idx'
            ,reg_date = now()";
    //echo $sql;
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
    if($result){
            echo "SUCCESS";
            exit;
        }
}

if($typ =="invconfirm2"){ //-------------------------------------- 판매자 : 송장 확정2:30_09 (Invoice) 2016-04-15 ----------------------------------------
    //1. status변경
        
    /*update_val("odr","odr_status","18", "odr_idx", $odr_idx);
    update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);
    update_val("odr","invoice_no",$inv_no, "odr_idx", $odr_idx);    //invoice sheet(30_09)에서 가져온 $inv_no*/
    //2016-12-06 : 재고 Update (기존 'invreg' 에서 처리 하던 것을 여기서 처리) - ccolle
    $result =QRY_ODR_DET_LIST(0," and odr_idx=$odr_idx ",0,"","asc");
    while($row = mysql_fetch_array($result)){
        
        $part_type = get_any("odr_det", "part_type" , "odr_det_idx = ".$row['odr_det_idx']);

        $odr_det_temp_row = get_odr_det_temp($row['odr_det_idx']);

        $odr_det_temp_sql = "update odr_det set supply_quantity=".$odr_det_temp_row['supply_quantity'].", part_condition=".$odr_det_temp_row['part_condition'].", pack_condition1=".$odr_det_temp_row['pack_condition1'].", pack_condition2=".$odr_det_temp_row['pack_condition2'].", memo='".$odr_det_temp_row['memo']."' where odr_det_idx=".$row['odr_det_idx'];
        
        $odr_det_temp_result=mysql_query($odr_det_temp_sql,$conn) or die ("SQL ERROR : ".mysql_error());

        $part_idx = replace_out($row["part_idx"]);
        //$stock_qty = replace_out($row["quantity"]);
        $stock_qty = replace_out($row["part_stock"]);
        $odr_qty = replace_out($row["odr_quantity"]);
        //$supp_qty = replace_out($row["supply_quantity"]);
        $supp_qty = replace_out($odr_det_temp_row['supply_quantity']);
        $real_stock = $stock_qty + $odr_qty;    //공급 가능수량(실재고+발주수량)
        //2016-12-11 : 재고수량보다 공급수량이 클 경우 BACK!!
       
        if ($part_type != 2)
        {
                //2016-12-28 : 가격변동 체크
            $price_check = QRY_CNT_FLUC($row['odr_det_idx']);

            $part_chk = QRY_CNT_PART($part_idx);

            $safe_stock = QRY_STOCK_PART($part_idx);
      
            //2017-04-27 재고부족 파악 
            if($part_chk>0 && $real_stock < $supp_qty){ //-- 파트 존재 여부 -------------------------------------------------  
                echo "DELETE_".$part_idx;
                exit;
            } 
            elseif( ($real_stock < $supp_qty) && $_part_type !="2" ){ //-- 재고 부족 -------------------------------------------------
                echo "ERR_".$part_idx;
                exit;
            }
            /*else if($price_check>0 && ($_part_type !="2" && $_part_type !="5" && $_part_type !="6")){    //-- 가격 변동 -----
                echo "PRICE_".$part_idx;               
                exit;
            }*/



            /*if($real_stock < $supp_qty){
                echo "ERR";
                exit;
            }else{*/
                if($odr_qty < $supp_qty){   //공급 수량이 발주 수량보다 클 경우                    
                    $up_qty = $stock_qty - ($supp_qty - $odr_qty);
                    update_val("part","quantity", $up_qty, "part_idx", $part_idx);
                }else if($odr_qty > $supp_qty){ //공급 수량이 발주 수량보다 작을 경우
                    $up_qty = $stock_qty + ($odr_qty - $supp_qty);                   
                    update_val("part","quantity", $up_qty, "part_idx", $part_idx);
                }
           //}
        }
        else
        {
            $part_chk = QRY_CNT_PART($part_idx);

            //2017-04-27 재고부족 파악 
            if($part_chk>0 && $real_stock < $supp_qty){ //-- 파트 존재 여부 -------------------------------------------------  
                echo "DELETE_".$part_idx;
                exit;
            } 
        }

        //2017-01-19 : parts 정보Update(임시테이블에서 가져오기)
        $temp_cnt = QRY_CNT("part_temp"," and odr_idx=$odr_idx and part_idx=$part_idx and type='after'");
        if($temp_cnt>0){
            $sql = "
                    UPDATE part AS a
                        JOIN part_temp AS b
                            ON a.part_idx=b.part_idx
                    SET a.part_no = b.part_no,
                        a.manufacturer = b.manufacturer,
                        a.package = b.package,
                        a.dc = b.dc,
                        a.rhtype = b.rhtype
                    WHERE b.odr_idx=$odr_idx AND b.part_idx=$part_idx and type='after'
                    ";
            $result1=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
            $sql = "DELETE FROM part_temp WHERE odr_idx=$odr_idx AND part_idx=$part_idx and type='after'";
            $result2=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
        }
    }//end of while

    update_val("odr","odr_status","18", "odr_idx", $odr_idx);
    update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);
    update_val("odr","invoice_no",$inv_no, "odr_idx", $odr_idx);    //invoice sheet(30_09)에서 가져온 $inv_no
    //2016-12-06 : 재고 Update (기존 'invreg' 에서 처리 하던 것을 여기서 처리) - ccolle

    //2. 송장 번호 등록
    /** 2016-04-18 송장번호는 'invreg' 에서 처리
    $inv_no = get_auto_no("EI", "odr", "invoice_no");
    update_val("odr","invoice_no",$inv_no , "odr_idx", $odr_idx);
    **/
    //$inv_no = get_any("odr", "invoice_no" , "odr_idx = $odr_idx"); //2016-04-18 : 'invreg' 에서 만든 송장번호 가져온다. 2016-09-28 : sheet(30_09)에서 가져옴

    $buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
    //3. histoy update(발주서를 확인 한 상태로 update)
    $odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and (status = 2 or status=3) and confirm_yn='N'");
    update_val("odr_history","confirm_yn","Y", "odr_history_idx", $odr_history_idx);
    //4. history 등록
    $session_mem_idx = $_SESSION["MEM_IDX"];
    $sql = "insert into odr_history set
            odr_idx = '$odr_idx'
            ,status = 18
            ,status_name = '송장'
            ,etc1 = '$inv_no'
            ,sell_mem_idx = '$sell_mem_idx'
            ,buy_mem_idx = '$buy_mem_idx'
            ,reg_mem_idx = '$session_mem_idx'
            ,reg_date = now()";
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

    $sql = "update part set 
            invreg_chk = '1'
            where part_idx in (".$part_no_val.")";
    
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

    //사본 생성 2016-04-15
    $result = CP_To_Log($odr_idx, $inv_no);
    if($result){
            echo "SUCCESS";
            exit;
        }
}

if($typ =="del"){ //------------------------------------------------ [삭제] ------------------------------------------------------------------------------------------------------
    //Mybox에 있는지 체크하여 삭제한다. 아래 구성은 출신에 상관없이 무조건 삭제 2016-04-07
    $mem_idx = get_any("odr a INNER JOIN odr_det b ON(a.odr_idx=b.odr_idx)", "a.mem_idx", "b.odr_det_idx = ".$idx);
    $sql = "DELETE FROM mybox WHERE part_idx = (SELECT part_idx FROM odr_det WHERE odr_det_idx=$idx) AND mem_idx = $mem_idx";
    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
    //발주서 화면에서 삭제
    $sql = "delete from $tbl where ".($tbl=="member"?"mem":$tbl)."_idx = ".$idx;
    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
        if($result){
            echo "SUCCESS";
            exit;
        }
}
//2016-03-23(KSR) history 삭제하기 위해(납기 확인된 제품) -------------------------------------------------------------------------------------------------------
if($typ =="del2"){
    $sql = "delete from $tbl where ".$culm."_idx = ".$idx;
    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
        if($result){
            echo "SUCCESS";
            exit;
        }
}
//2016-03-23(KSR) 납기제품 구매자 삭제처리 -------------------------------------------------------------------------------------------------------
if($typ == "perioddel"){
    //마지막 history 가져와 복사하고, 상태만 바꾸자..
    //1. history 등록
    $session_mem_idx = $_SESSION["MEM_IDX"];
    $sql = "insert into odr_history set
            odr_idx = '$odr_idx'
            ,odr_det_idx = '$odr_det_idx'
            ,status = 1
            ,status_name = '납기'
            ,etc1 = '확인'
            ,sell_mem_idx = '$sell_mem_idx'
            ,buy_mem_idx = '$session_mem_idx'
            ,reg_mem_idx = '$session_mem_idx'
            ,reg_date = now()";
    //echo $sql;
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
        if($result){
            echo "SUCCESS";
            exit;
        }
}
//2016-03-23(KSR) : Part의 Stock 가감-----------------------------------------------------------------------------------------------------------------------------------
if ($typ =="upstock"){
    $sql = "UPDATE FROM part SET quantity = ".$up_qty." where part_idx = ".$idx;
    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
        if($result){
            echo "SUCCESS";
            exit;
        }
}

if ($typ =="odrconfirm"){   //------------ 확정 발주서 (from:30_05) JSJ ---------------------------------------------------------------------------------------------------
        //0. 만약에 odr_status가 납기 확인한 데이터가 있다면 그 테이터를 확인 한것으로 표시 (confirm_yn = Y')
        $odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and status = 16");
        if ($odr_history_idx){update_val("odr_history","confirm_yn","Y", "odr_history_idx", $odr_history_idx);}

        //1. odr_status 변경
        update_val("odr","odr_status","2", "odr_idx", $odr_idx);
        update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);
       
        $odr_no = get_any("odr", "odr_no", "odr_idx = $odr_idx");
        //2. history 등록
        $session_mem_idx = $_SESSION["MEM_IDX"];
        $sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
        $buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
        $sql = "insert into odr_history set
                odr_idx = '$odr_idx'
                ,status = 2
                ,status_name = '발주서'
                ,etc1 = '$odr_no'
                ,sell_mem_idx = '$sell_mem_idx'
                ,buy_mem_idx = '$buy_mem_idx'
                ,reg_mem_idx = '$session_mem_idx'
                ,reg_date = now()";
        //echo $sql;
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
        update_val("odr","save_yn","N", "odr_idx", $odr_idx);
        //MyBox에 해당 품목 있을 시 삭제 2016-04-04
        $sql = "DELETE FROM mybox WHERE mem_idx = '$buy_mem_idx' AND part_idx IN(SELECT part_idx FROM odr_det WHERE odr_idx = $odr_idx) ";
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

        if($result){
            echo "SUCCESS";
            exit;
        }
}
if ($typ =="odrconfirm2"){  //------------ 확정 발주서 (from:30_05) 2016-04-19 : log 기록(사본생성) --------------------------------------------------------------------
        //0. 만약에 odr_status가 납기 확인한 데이터가 있다면 그 테이터를 확인 한것으로 표시 (confirm_yn = Y')
        

        $odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and status = 16");
        if ($odr_history_idx){update_val("odr_history","confirm_yn","Y", "odr_history_idx", $odr_history_idx);}

        //저장된 히스토리 삭제
        $odr_history_save = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and status = 90");
        if ($odr_history_save)
        {
            $sql = "delete from odr_history where odr_history_idx = $odr_history_save";
            $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
        }

        //1. odr_status 변경
        update_val("odr","odr_status","2", "odr_idx", $odr_idx);
        update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);
        

        $odr_no = get_any("odr", "odr_no", "odr_idx = $odr_idx");
        //2016-11-29 : 중복저장 방지 - KSR
        $his_cnt = QRY_CNT("odr_history"," and odr_idx=$odr_idx and status=2 ");
        //if($his_cnt<1){  //증상 만들기 위해 잠시 주석처리...
            //2. history 등록
            $session_mem_idx = $_SESSION["MEM_IDX"];
            $sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
            $buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
            $sql = "insert into odr_history set
                    odr_idx = '$odr_idx'
                    ,status = 2
                    ,status_name = '발주서'
                    ,etc1 = '$odr_no'
                    ,sell_mem_idx = '$sell_mem_idx'
                    ,buy_mem_idx = '$buy_mem_idx'
                    ,reg_mem_idx = '$session_mem_idx'
                    ,reg_date = now()";
            //echo $sql;
            $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
        //}
        update_val("odr","save_yn","N", "odr_idx", $odr_idx);
        //MyBox에 해당 품목 있을 시 삭제 2016-04-04
        $sql = "DELETE FROM mybox WHERE mem_idx = '$buy_mem_idx' AND part_idx IN(SELECT part_idx FROM odr_det WHERE odr_idx = $odr_idx) ";
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
        //사본 생성 2016-04-15
        //odr : odr_status='99'
        $result = CP_To_Log($odr_idx, $odr_no);
        if($result){
            echo "SUCCESS";
            exit;
        }
}

if ($typ =="odramendconfirm"){ // 확정 발주서(P.O Amendment)12_07 처리 --------------------------------------------------------------------------------------------
        //0. 만약에 odr_status가  송장 또는 도착한 데이터가 있다면 그 테이터를 확인 한것으로 표시 (confirm_yn = Y')  왜냐면, 수정 발주서를 발행하는 시점은 처음 송장 받았거나, 물건이 도착 한 후에 할수 있으므로.

        $odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and (status = 18 or status = 19) and confirm_yn='N'");
        if ($odr_history_idx){update_val("odr_history","confirm_yn","Y", "odr_history_idx", $odr_history_idx);}

        //1. odr_status 변경
        update_val("odr","odr_status","3", "odr_idx", $odr_idx);
        update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);

        //$amend_no = get_any("odr", "amend_no", "odr_idx = $odr_idx"); //수정발주서 번호생성
        
        //2. history 등록
        $session_mem_idx = $_SESSION["MEM_IDX"];
        $sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
        $buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
        $sql = "insert into odr_history set
                odr_idx = '$odr_idx'
                ,status = 3
                ,status_name = '수정발주서'
                ,etc1 = '$amend_no'
                ,sell_mem_idx = '$sell_mem_idx'
                ,buy_mem_idx = '$buy_mem_idx'
                ,reg_mem_idx = '$session_mem_idx'
                ,reg_date = now()";
        //echo $sql;
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
        //update_val("odr","save_yn","N", "odr_idx", $odr_idx);
        if($result){
            echo "SUCCESS";
            exit;
        }
}

if ($typ =="odramendconfirm2"){ //구매자: 수정발주서(P.O Amendment)12_07 처리 / 2016-04-15 : Log 기록 -------------------------------------------------------------

        //$ship_idx = get_any("ship" , "ship_idx", "odr_idx= $odr_idx");

        //2017-01-10 : 임시테이블에서 ship 정보를 저장
        $sql = "insert into ship (ship_type,odr_idx,delivery_addr_idx,ship_info,ship_account_no,insur_yn,memo,reg_date) select '1',$odr_idx,delivery_addr_idx,ship_info,ship_account_no,insur_yn,memo,now() from ship_temp where odr_idx = $odr_idx ";

        /*$sql = "
                UPDATE ship AS a
                    JOIN ship_temp AS b
                        ON a.odr_idx=b.odr_idx
                SET a.ship_info = b.ship_info,
                    a.ship_account_no = b.ship_account_no,
                    a.memo = b.memo,
                    a.insur_yn = b.insur_yn,
                    a.delivery_addr_idx = b.delivery_addr_idx
                WHERE a.ship_idx=$ship_idx
                ";
        */

        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
        $ship_idx = mysql_insert_id();

        //2016-12-06 : 재고 UPDATE('UQ'에서 Upate 것을 여기서 Update) - ccolle
        $result =QRY_ODR_DET_LIST(0," and odr_idx=$odr_idx ",0,"","asc");
        while($row = mysql_fetch_array($result)){

            

            //임시 수량 실제 주문에 업데이트 2017-03-30 박정권
            $odr_qty_real = get_any("odr_det_temp", "odr_quantity" , "odr_det_idx =".$row['odr_det_idx']);
            $qty_sql = "update odr_det set odr_quantity=".$odr_qty_real." where odr_det_idx =".$row['odr_det_idx'];

            $qty_update_result=mysql_query($qty_sql,$conn) or die ("SQL ERROR : ".mysql_error());
           
            $part_idx = replace_out($row["part_idx"]);
            $stock_qty = replace_out($row["quantity"]);
            //$odr_qty = replace_out($row["odr_quantity"]);
            $odr_qty = $odr_qty_real;
            $supp_qty = replace_out($row["supply_quantity"]);
            $real_stock = $stock_qty + $supp_qty;

           
            if ($part_type != 2)
            {
                    //2016-12-28 : 가격변동 체크
                $price_check = QRY_CNT_FLUC($row['odr_det_idx']);

                $part_chk = QRY_CNT_PART($part_idx);

                $safe_stock = QRY_STOCK_PART($part_idx);
          
                //2017-04-27 재고부족 파악 
                if($part_chk>0 && $real_stock < $odr_qty){ //-- 파트 존재 여부 -------------------------------------------------  
                    echo "DELETE_".$part_idx;
                    exit;
                } 
                elseif( ($real_stock < $odr_qty) && $_part_type !="2" ){ //-- 재고 부족 -------------------------------------------------
                    echo "ERR_".$part_idx;
                    exit;
                }
                /*else if($price_check>0 && ($_part_type !="2" && $_part_type !="5" && $_part_type !="6")){    //-- 가격 변동 -----
                    echo "PRICE_".$part_idx;               
                    exit;
                }*/

            }
            else
            {
                $part_chk = QRY_CNT_PART($part_idx);

                //2017-04-27 재고부족 파악 
                if($part_chk>0 && $real_stock < $odr_qty){ //-- 파트 존재 여부 -------------------------------------------------  
                    echo "DELETE_".$part_idx;
                    exit;
                } 
            }
        }
        //0. 만약에 odr_status가  송장 또는 도착한 데이터가 있다면 그 테이터를 확인 한것으로 표시 (confirm_yn = Y')  왜냐면, 수정 발주서를 발행하는 시점은 처음 송장 받았거나, 물건이 도착 한 후에 할수 있으므로. JSJ
        $odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and (status = 18 or status = 19) and confirm_yn='N'");
        if ($odr_history_idx){update_val("odr_history","confirm_yn","Y", "odr_history_idx", $odr_history_idx);}

        //1. odr_status 변경
        update_val("odr","odr_status","3", "odr_idx", $odr_idx);
        update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);
        update_val("odr","amend_no",$poa_no, "odr_idx", $odr_idx); 
        update_val("odr","ship_idx",$ship_idx, "odr_idx", $odr_idx);     

        //수정발주서 번호 가져오기 - 이전 단계 Sheet(12_07)에서 생성하여 odr 테이블에 Update 했음.  2016-04-18 : Sheet 호출 전에 'poano'에서 번호 생성
        //$amend_no = get_any("odr", "amend_no", "odr_idx = $odr_idx");
        //2. 최근 History 읽음 처리 - (2016-04-15)
        $old_history_idx = get_any("odr_history" , "MAX(odr_history_idx)", "odr_idx= $odr_idx");
        update_val("odr_history","confirm_yn","Y", "odr_history_idx", $old_history_idx);
        //3. history 등록
        $session_mem_idx = $_SESSION["MEM_IDX"];
        $sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
        $buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
        $sql = "insert into odr_history set
                odr_idx = '$odr_idx'
                ,status = 3
                ,status_name = '수정발주서'
                ,etc1 = '$amend_no'
                ,sell_mem_idx = '$sell_mem_idx'
                ,buy_mem_idx = '$buy_mem_idx'
                ,reg_mem_idx = '$session_mem_idx'
                ,reg_date = now()";
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
        update_val("odr","save_yn","N", "odr_idx", $odr_idx);
        update_val("odr_det","amend_yn","N", "odr_idx", $odr_idx); //amend_yn='N' 기존꺼는 처리 없음
        //품목 복제(Log 기록) - (2016-04-15)
        $result = CP_To_Log($odr_idx, $amend_no);
        if($result){
            echo "SUCCESS";
            exit;
        }
}

/** 수정발주서(09_01) 에서 '발주서 확인' 클릭 시 처리 *****************************/
if($typ == "poano"){
    //2017-01-03 : 재고수량과 단가 체크
    $quantity_cnt = 0;
    $result =QRY_ODR_DET_LIST(0," and a.odr_idx=$odr_idx",0,"","asc");
    while($row = mysql_fetch_array($result)){
        $_det_idx = replace_out($row["odr_det_idx"]);
        $_quantity = replace_out($row["quantity"]);
        $_odr_stock = replace_out($row["odr_stock"]);
        $_odr_quantity = replace_out($row["odr_quantity"]);
        $_part_quantity = replace_out($row["part_stock"]);
        $_supp_quantity = replace_out($row["supply_quantity"]);
        $_part_price = replace_out($row["price"]);
        $_odr_price = replace_out($row["odr_price"]);
     
       // if(($_part_quantity)<$_odr_quantity) $quantity_cnt++;
        //if(($_part_quantity+$_supp_quantity)<$_odr_quantity) $quantity_cnt++;        
    }
   
    /*if($quantity_cnt>0){
        echo "STOCK";
    }else{*/
        $sql = "update odr set amend_no = '".get_auto_no("POA", "odr" , "amend_no")."', amend_date = now()  where odr_idx=".$odr_idx;
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
        /** 2017-01-10 : ship 정보를 임시 테이블에 저장 했다가, '확정발주' 시 ship에 복사
        $ship_sql = "update ship set ship_info = '".$ship_info."', ship_account_no = '".$ship_account_no."', memo = '".$memo."',insur_yn='".$insur_yn."',delivery_addr_idx='".$delivery_addr_idx."'  where odr_idx=".$odr_idx; 
        **/
        //임시테이블에 데이터 존재여부
        $ship_idx = get_any("ship_temp", "ship_idx", "odr_idx=$odr_idx");

        if($ship_idx>0){
            $ship_sql = "update ship_temp set ship_info = '".$ship_info."', ship_account_no = '".$ship_account_no."', memo = '".$memo."',insur_yn='".$insur_yn."',delivery_addr_idx='".$delivery_addr_idx."'  where ship_idx=".$ship_idx;
        }else{
            $ship_sql = "insert into ship_temp set ship_info = '".$ship_info."', ship_account_no = '".$ship_account_no."', memo = '".$memo."',insur_yn='".$insur_yn."',delivery_addr_idx='".$delivery_addr_idx."', odr_idx=".$odr_idx.", reg_date=now()";
        }
        $ship_result = mysql_query($ship_sql,$conn) or die ("SQL Error : ". mysql_error());

        if($result){
            echo "SUCCESS";
            exit;
        }else{
            echo $result;
            exit;
        }
    //}
}

if($typ =="chmybank"){  //--------------------------------------------------------------------------------------------------------------------------------------------------
//charge my bank 일 때에는
    $invoice_no = get_auto_no("CMBI", "mybank" , "invoice_no");
    $sql = "insert into mybank set
                mem_idx = '$mem_idx'
                ,rel_idx = '$rel_idx'
                ,charge_type = '1'
                ,charge_amt = '$tot_amt'
                ,invoice_no = '$invoice_no'
                ,charge_method = '$charge_method'
                ,deposit_yn = '$with_deposit'
                ,odr_idx = '$odr_idx'
                ,reg_date = now()
                ,reg_ip= '$log_ip'";
    //  echo $sql;
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
        insert_invoice($invoice_no, "CMBI", $mem_idx, $rel_idx, "","",$log_ip); //odr_idx, odr_det_idx
        if ($result){
            echo "SUCCESS";
            exit;
        }
}

//--- 결재 -----------------------------------------------------------------------------------------------------------
if ($typ == "pay"){

        if (QRY_CNT("odr_det", "and odr_idx = $odr_idx and part_type='2'")>0){$typ ="pay_jisok2";}
}

/**********************************************************************************************************************************************************/
function deposit_proc($mem_idx, $rel_idx, $tot_amt,$charge_method){
    if ($_SESSION["DEPOSIT"]=="N" && $tot_amt >= 1000){  //보증금을 내지 않았다면 보증금과 한번에 결제 된 것이므로 여기서 처리
        $invoice_no = get_auto_no("DI", "mybank" , "invoice_no");
        $sql = "insert into mybank set
        mem_idx = '$mem_idx'
            ,rel_idx = '$rel_idx'
            ,charge_type = '8'
            ,invoice_no = '$invoice_no'
            ,charge_amt = '-1000'
            ,charge_method = '$charge_method'
            ,reg_date = now()
            ,reg_ip= '$log_ip'";
        $conn = dbconn();
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
        $_SESSION["DEPOSIT"] = "Y";
        insert_invoice($invoice_no, "DI", $mem_idx, $rel_idx, "","",$log_ip); //odr_idx, odr_det_idx
        return $tot_amt - 1000;
    }else{
        return $tot_amt;
    }
}
/*************************************************************************************************************************************************************/
//결제 처리(신용카드/MyBank)---------------------------------------------------------------------------------------------------------------------------------------------
//2016-05-27 : Mybank 테이블 변경 적용하고, 예치금 개념 추가.
if ($typ == "pay"){
    // 보증금 확인 작업
    
    if ($_SESSION["MEM_IDX"] == $mem_idx){
        $remain_tot_amt = deposit_proc($mem_idx, $rel_idx, $tot_amt, $charge_method);
        if ($remain_tot_amt < $tot_amt){
            $with_deposit = "Y";
            $tot_amt = $remain_tot_amt;
        }
        $odr = get_odr($odr_idx);
        $mem_idx = $odr[mem_idx];
        $rel_idx = $odr[rel_idx];
        $sell_mem_idx = $odr[sell_mem_idx];
        $sell_rel_idx = $odr[sell_rel_idx];
        // 1. 지불기록(관리자페이지):구매자 ------------------------------------------
        $sql = "insert into mybank set
                mem_idx = '$mem_idx'
                ,rel_idx = '$rel_idx'
                ,charge_type = '3'
                ,charge_amt = '-$tot_amt'
                ,charge_method = '$charge_method'
                ,deposit_yn = '$with_deposit'
                ,odr_idx = '$odr_idx'
                ,reg_date = now()
                ,reg_ip= '$log_ip'";
        
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
        //2. MyBank 일 경우 - 구매자 예치금 처리 ---------------- MyBank Log--
        if($charge_method=="MyBank"){
            //2-1. mybank INSERT
            $sql = "insert into mybank set
                    mem_idx = '$mem_idx'
                    ,rel_idx = '$rel_idx'
                    ,mybank_yn = 'Y'
                    ,charge_type = '3'
                    ,charge_amt = '-$tot_amt'
                    ,charge_method = '0'
                    ,mybank_hold = '$tot_amt'
                    ,deposit_yn = '$with_deposit'
                    ,odr_idx = '$odr_idx'
                    ,reg_date = now()
                    ,reg_ip= '$log_ip'";
            $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
            $new_bank_idx=mysql_insert_id();
            //2-2. 잔액 Update
            update_val("mybank","mybank_amt",SumMyBank2($mem_idx, $rel_idx, 0), "mybank_idx", $new_bank_idx);
            //2-3. 예치금 합계 Update
            update_val("mybank","hold_amt",SumBankHold($mem_idx, $rel_idx, 0), "mybank_idx", $new_bank_idx);
        }

        //2. odr_status 변경
        update_val("odr","odr_status","5", "odr_idx", $odr_idx);
        update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);

        //3. histoy update(송장을 확인 한 상태로 update)
        $sql = "update odr_history set confirm_yn  = 'Y' where odr_idx = $odr_idx and status= 18 and confirm_yn = 'N'";
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
        $prt_method = $charge_method=="1" ? "신용카드" : ($charge_method=="2"?"은행송금":"My Bank");
        //4. history 등록
            $session_mem_idx = $_SESSION["MEM_IDX"];
            $buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
            $tot_amt = "$".$tot_amt;
            $sql = "insert into odr_history set
                    odr_idx = '$odr_idx'
                    ,status = 5
                    ,status_name = '결제완료'
                    ,etc1 = '$prt_method'
                    ,etc2 = '$tot_amt'
                    ,with_deposit = '$with_deposit'
                    ,sell_mem_idx = '$sell_mem_idx'
                    ,buy_mem_idx = '$mem_idx'
                    ,reg_mem_idx = '$mem_idx'
                    ,reg_date = now()";
            //echo $sql;
            $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
            if($result){
                echo "SUCCESS";
                exit;
            }
    }else{  //판매자가 결제 하는 경우 - Deposit
        $remain_tot_amt = deposit_proc($sell_mem_idx, $sell_rel_idx, $tot_amt,$charge_method);
        if($remain_tot_amt==0){
            echo "SUCCESS-Deposit";
            exit;
        }
    }

}//--------------------------------- End of pay -------------------------------------------------------------------------------------------------------------------------

//-- 기존 JSJ 의 '지속적....' 결재 사용하지 않고 새로 작성 2016-09-29 --------------------------------------------------------------------------------------------
if ($typ == "pay_jisok2"){
    $session_mem_idx = $_SESSION["MEM_IDX"];
    $odr = get_odr($odr_idx);
    $buy_mem_idx = $odr[mem_idx];
    $buy_rel_idx = $odr[rel_idx];
    $sell_mem_idx = $odr[sell_mem_idx];
    $sell_rel_idx = $odr[sell_rel_idx];
    $inv_no = $odr[invoice_no];
    $part_type = "2";

    $deposit_cnt = QRY_CNT("odr_history" , "and odr_idx=$odr_idx and (sell_mem_idx=".$_SESSION["MEM_IDX"]." or buy_mem_idx=".$_SESSION["MEM_IDX"].") and status_name = '송장'");

    if ($_SESSION["DEPOSIT"]=="N" && $deposit_cnt==1){
        
        $remain_tot_amt = deposit_proc($mem_idx, $rel_idx, $tot_amt, $charge_method);
        if ($remain_tot_amt < $tot_amt){
            $with_deposit = "Y";
            $tot_amt = $remain_tot_amt;
        }
    }

    $prt_method = $charge_method=="1" ? "신용카드" : ($charge_method=="2"?"은행송금":"My Bank");

    //1. 결재를 누가 하는가? (구매자 or 판매자)
    if ($_SESSION["MEM_IDX"] == $mem_idx){
        $pay_mem_idx = $mem_idx;    //구매자
        $pay_rel_idx = $buy_rel_idx;
        $confirm_yn = 'N';
    }else{
        $pay_mem_idx = $sell_mem_idx;   //판매자
        $pay_rel_idx = $sell_rel_idx;
        $confirm_yn = 'Y';
    }
    //2. 계약금 or 잔금
    if(QRY_CNT("odr_history", "AND odr_idx=$odr_idx AND reg_mem_idx=$pay_mem_idx AND status=5") > 0){
        $charge_type = '3'; //잔금
        $charge_ty = 'F';       //history에서 사용
        //현재의 Invoice No.로 사본 생성
        $result = CP_To_Log($odr_idx, $inv_no);
        //Invoice No. 신규 작성.
        $inv_no = get_auto_no("EI", "odr" , "invoice_no");
        //잔금(구매자) 송장(Invoice) 읽음 으로 Insert
        $sql = "insert into odr_history set
                odr_idx = '$odr_idx'
                ,status = 18
                ,status_name = '송장'
                ,etc1 = '$inv_no'
                ,sell_mem_idx = '$sell_mem_idx'
                ,buy_mem_idx = '$buy_mem_idx'
                ,reg_mem_idx = '$buy_mem_idx'
                ,confirm_yn = 'Y'
                ,reg_date = now()";
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
    }else{
        $charge_type = '2'; //계약금
        $charge_ty = 'D';   //history에서 사용
    }
    //add. 현재의 Invoice No.로 사본 생성
    //3. 지불기록(관리자페이지):구매자 ------------------------------------------
    $sql = "insert into mybank set
            mem_idx = '$pay_mem_idx'
            ,rel_idx = '$rel_idx'
            ,charge_type = '$charge_type'
            ,charge_amt = '-$tot_amt'
            ,charge_method = '$charge_method'
            ,invoice_no = '$inv_no'
            ,deposit_yn = 'N'
            ,odr_idx = '$odr_idx'
            ,reg_date = now()
            ,reg_ip= '$log_ip'";
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
    //4. 결재 수단이 MyBank 일경우 Log 기록--------------------------
    if($charge_method=='MyBank'){
        $sql = "insert into mybank set
                mem_idx = '$pay_mem_idx'
                ,rel_idx = '$rel_idx'
                ,mybank_yn = 'Y'
                ,charge_type = '$charge_type'
                ,charge_amt = '-$tot_amt'
                ,charge_method = '0'
                ,mybank_hold = '$tot_amt'
                ,invoice_no = '$inv_no'
                ,deposit_yn = 'N'
                ,odr_idx = '$odr_idx'
                ,reg_date = now()
                ,reg_ip= '$log_ip'";
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
        $new_bank_idx=mysql_insert_id();
        //4-2. 잔액 Update
        update_val("mybank","mybank_amt",SumMyBank2($pay_mem_idx,""), "mybank_idx", $new_bank_idx);
        //4-3. 예치금 합계 Update
        update_val("mybank","hold_amt",SumBankHold($pay_mem_idx,""), "mybank_idx", $new_bank_idx);
    }
    //5. 전 단계의 history(송장) '읽음' 처리...
    $sql = "update odr_history set confirm_yn  = 'Y' where odr_idx = $odr_idx and status= 18 and confirm_yn = 'N'";
    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
    //6. history 등록 --------------------------------------------
    $tot_amt = "$".$tot_amt;
    //6-1. 송장(판매자)
    if($pay_mem_idx == $sell_mem_idx){
        $chr = "DPI";
        $inv_no_new = str_replace("EI", $chr,  get_auto_no("EI", "odr" , "invoice_no"));

        //송장번호 가져오자
        $sql = "insert into odr_history set
                odr_idx = '$odr_idx'
                ,status = 18
                ,status_name = '송장'
                ,etc1 = '$inv_no_new'
                ,sell_mem_idx = '$sell_mem_idx'
                ,buy_mem_idx = '$buy_mem_idx'
                ,reg_mem_idx = '$buy_mem_idx'
                ,confirm_yn = 'Y'
                ,reg_date = now()";
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
    }

    //6-2. 결재완료
    $sql = "insert into odr_history set
            odr_idx = '$odr_idx'
            ,status = 5
            ,status_name = '결제완료'
            ,etc1 = '$prt_method'
            ,etc2 = '$tot_amt'
            ,charge_ty = '$charge_ty'
            ,sell_mem_idx = '$sell_mem_idx'
            ,buy_mem_idx = '$buy_mem_idx'
            ,reg_mem_idx = '$pay_mem_idx'
            ,confirm_yn = '$confirm_yn'
            ,reg_date = now()";
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
    //7. odr_status 변경
    update_val("odr","odr_status","5", "odr_idx", $odr_idx);
    update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);
    //8. 잔금(구매자) 일 경우------------
    if($charge_ty == 'F'){
        //8-1. odr 테이블 Invoice No. Udate
        update_val("odr","invoice_no",$inv_no, "odr_idx", $odr_idx);
        //8-2. history '도착' - '읽음' 처리
        $sql = "update odr_history set confirm_yn  = 'Y' where odr_idx = $odr_idx and status= 19 and confirm_yn = 'N'";
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
    }
    if($result){
        echo "SUCCESS";
        exit;
    }
}//-- End of 'pay_jisok2' ------------------------------------------------------------------------------------------------------------------------------------------------------

//---- 결재 (지속적....) JSJ -----------------------------------------
if ($typ == "pay_jisok"){
    $session_mem_idx = $_SESSION["MEM_IDX"];
    $odr = get_odr($odr_idx);
    $buy_mem_idx = $odr[mem_idx];
    $buy_rel_idx = $odr[rel_idx];
    $sell_mem_idx = $odr[sell_mem_idx];
    $sell_rel_idx = $odr[sell_rel_idx];

    $sql = "update odr_history set confirm_yn  = 'Y' where odr_idx = $odr_idx and confirm_yn = 'N'";
    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

    if ($session_mem_idx == $sell_mem_idx) { // 판매자가 결제 하는 경우 : 계약금(부품총액의 10%)
        $charge_type = "2";
        $invoice_no = get_auto_no("DPI", "mybank", "invoice_no");
        //$tot_amt = $tot_amt / 10;
        $charge_ty = "D";
        //histoy update(결제를 확인한 상태로 update)
        $mem_idx = $sell_mem_idx;
        $rel_idx = $sell_rel_idx;
        $reg_mem_idx = $buy_mem_idx;
    }else{   //구매자가 결제 하는 경우 2가지 case : 계약금(총액의 10%), 나머지 금액 (총액의 90%)
        $reg_mem_idx = $session_mem_idx;
        $odr_pay_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and status = 5");
        $invoice_no = get_auto_no("EI", "odr", "invoice_no");
        if ($odr_pay_idx){   //결제 한 이력이 있으면 90% 결제할 차례
            $charge_type = "3";
        //  $tot_amt = $tot_amt - $tot_amt / 10;
            $charge_ty = "F";
            //도착한 메세지를 확인한 상태로 update

        }else{  //없으면 구매자가 계약금 결제 할 차례
            $invoice_no = get_auto_no("DPI", "mybank", "invoice_no");
            $charge_type = "2";
        //  $tot_amt = $tot_amt / 10;
            $charge_ty = "D";
            //3. histoy update(송장을 확인 한 상태로 update)

        }
    }

    // 1. mybank insert    //
    //charget_type = '2' 은 계약금 지불

    $sql = "insert into mybank set
            mem_idx = '$mem_idx'
            ,rel_idx = '$rel_idx'
            ,invoice_no = '$invoice_no'
            ,charge_type = '$charge_type'
            ,charge_amt = '-$tot_amt'
            ,charge_method = '$charge_method'
            ,odr_idx = '$odr_idx'
            ,reg_date = now()
            ,reg_ip= '$log_ip'";
//  echo $sql;
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
    //2. odr_status 변경
    update_val("odr","odr_status","5", "odr_idx", $odr_idx);
    update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);
    $prt_method = $charge_method=="1" ? "신용카드" : ($charge_method=="2"?"은행송금":"My Bank");
    //4. history 등록
        $tot_amt = "$".$tot_amt;
        $sql = "insert into odr_history set
                odr_idx = '$odr_idx'
                ,status = 5
                ,status_name = '결제완료'
                ,etc1 = '$prt_method'
                ,etc2 = '$tot_amt'
                ,charge_ty = '$charge_ty'
                ,sell_mem_idx = '$sell_mem_idx'
                ,buy_mem_idx = '$buy_mem_idx'
                ,reg_mem_idx = '$reg_mem_idx'
                ,reg_date = now()";
//      echo $sql;
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
        if($result){
            echo "SUCCESS";
            exit;
        }

}
/** 2016-05-27 주석처리
if ($typ == "pay"){  //결제 처리---------------------------------------------------------------------------------------------------------------------------------------------
    // 보증금 확인 작업
        if ($_SESSION["MEM_IDX"] == $mem_idx){
            $remain_tot_amt = deposit_proc($mem_idx, $rel_idx, $tot_amt, $charge_method);
            if ($remain_tot_amt < $tot_amt){
            $with_deposit = "Y";
            $tot_amt = $remain_tot_amt;
        }
        $odr = get_odr($odr_idx);
        $mem_idx = $odr[mem_idx];
        $rel_idx = $odr[rel_idx];
        $sell_mem_idx = $odr[sell_mem_idx];
        $sell_rel_idx = $odr[sell_rel_idx];
        // 1. mybank insert    //결제 관련 insert를 할 때에는 pair로 해야 한다. 판매자에게는 충전이 되고, 구매자에게는 차감해야 하기 때문에 .
        //먼저 구매자 지불 charget_type = '3' 은 물품 금액 지불
        $sql = "insert into mybank set
                mem_idx = '$mem_idx'
                ,rel_idx = '$rel_idx'
                ,charge_type = '3'
                ,charge_amt = '-$tot_amt'
                ,charge_method = '$charge_method'
                ,deposit_yn = '$with_deposit'
                ,odr_idx = '$odr_idx'
                ,reg_date = now()
                ,reg_ip= '$log_ip'";
        //echo $sql;
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
        // 판매자에게는 충전 charge_type = '4' : 물품 금액만큼 충전
        $sql = "insert into mybank set
                mem_idx = '$sell_mem_idx'
                ,rel_idx = '$sell_rel_idx'
                ,charge_type = '4'
                ,charge_amt = '$tot_amt'
                ,charge_method = '$charge_method'
                ,odr_idx = '$odr_idx'
                ,reg_date = now()
                ,reg_ip= '$log_ip'";
    //  echo $sql;
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
        //2. odr_status 변경
        update_val("odr","odr_status","5", "odr_idx", $odr_idx);
        update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);

        //3. histoy update(송장을 확인 한 상태로 update)
        $sql = "update odr_history set confirm_yn  = 'Y' where odr_idx = $odr_idx and status= 18 and confirm_yn = 'N'";
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
        $prt_method = $charge_method=="1" ? "신용카드" : ($charge_method=="2"?"입금":"My Bank");
        //4. history 등록
            $session_mem_idx = $_SESSION["MEM_IDX"];
            $buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
            $tot_amt = number_format($tot_amt,2);
            $sql = "insert into odr_history set
                    odr_idx = '$odr_idx'
                    ,status = 5
                    ,status_name = '결제완료'
                    ,etc1 = '$tot_amt $prt_method'
                    ,with_deposit = '$with_deposit'
                    ,sell_mem_idx = '$sell_mem_idx'
                    ,buy_mem_idx = '$mem_idx'
                    ,reg_mem_idx = '$mem_idx'
                    ,reg_date = now()";
            //echo $sql;
            $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
            if($result){
                echo "SUCCESS";
                exit;
            }
    }else{  //판매자가 결제 하는 경우 - Deposit
        $remain_tot_amt = deposit_proc($sell_mem_idx, $sell_rel_idx, $tot_amt,$charge_method);
        if($remain_tot_amt==0){
            echo "SUCCESS-Deposit";
            exit;
        }
    }

}
**/
if ($typ == "pay_access"){ //부대비용 지불------------------------------------------------------------------------------------------------------------
    $odr = get_odr($odr_idx);
    $mem_idx = $odr[mem_idx];
    $rel_idx = $odr[rel_idx];
    $sell_mem_idx = $odr[sell_mem_idx];
    $sell_rel_idx = $odr[sell_rel_idx];
    // 판매자에게는 지불 : 부대비용 금액만큼 지불
    $sql = "insert into mybank set
            mem_idx = '$sell_mem_idx'
            ,rel_idx = '$sell_rel_idx'
            ,charge_type = '13'
            ,charge_amt = '-$tot_amt'
            ,charge_method = '$charge_method'
            ,odr_idx = '$odr_idx'
            ,odr_det_idx = '$odr_det_idx'
            ,reg_date = now()
            ,reg_ip= '$log_ip'";
//  echo $sql;
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

// 1. mybank insert    //결제 관련 insert를 할 때에는 pair로 해야 한다.
    //구매자 충전
    $sql = "insert into mybank set
            mem_idx = '$mem_idx'
            ,rel_idx = '$rel_idx'
            ,charge_type = '13'
            ,charge_amt = '$tot_amt'
            ,charge_method = '$charge_method'
            ,odr_idx = '$odr_idx'
            ,odr_det_idx = '$odr_det_idx'
            ,reg_date = now()
            ,reg_ip= '$log_ip'";
//  echo $sql;
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
    //2. odr_status 변경
    update_val("odr","odr_status","5", "odr_idx", $odr_idx);
    update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);

    //3. histoy update(반품선적완료를 확인 한 상태로 update)
    $sql = "update odr_history set confirm_yn  = 'Y' where odr_idx = $odr_idx and  (status = 11 or status=18)  and confirm_yn = 'N'";
    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

    $prt_method = $charge_method=="1" ? "신용카드" : ($charge_method=="2"?"은행송금":"My Bank");
    //4. history 등록
        $session_mem_idx = $_SESSION["MEM_IDX"];
        $buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
        $tot_amt = "$".$tot_amt;
        $sql = "insert into odr_history set
                odr_idx = '$odr_idx'
                ,odr_det_idx = '$odr_det_idx'
                ,status = 5
                ,status_name = '결제완료'
                ,etc1 = '$prt_method'
                ,etc2 = '$tot_amt'
                ,sell_mem_idx = '$sell_mem_idx'
                ,buy_mem_idx = '$mem_idx'
                ,reg_mem_idx = '$session_mem_idx'
                ,reg_date = now()";
        //echo $sql;
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
        if($result){
            echo "SUCCESS";
            exit;
        }

}

if ($typ == "refund"){  //환불 처리 JSJ
    // 1. mybank insert    //결제 관련 insert를 할 때에는 pair로 해야 한다. 환불은 구매자에게는 충전이 되고, 판매자에게는 차감해야 하기 때문에 .
    //먼저 구매자에게 충전 charget_type = '10' 은 물품 금액 환불
    $sql = "insert into mybank set
            mem_idx = '$mem_idx'
            ,rel_idx = '$rel_idx'
            ,charge_type = '10'
            ,charge_amt = '$tot_amt'
            ,charge_method = '$charge_method'
            ,invoice_no = '$invoice_no'
            ,odr_idx = '$odr_idx'
            ,odr_det_idx = '$odr_det_idx'
            ,reg_date = now()
            ,reg_ip= '$log_ip'";
//  echo $sql;
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
    // 판매자에게는 차감 charge_type = '10' : 물품 금액만큼 차감
    $sql = "insert into mybank set
            mem_idx = '$sell_mem_idx'
            ,rel_idx = '$sell_rel_idx'
            ,charge_type = '10'
            ,charge_amt = '-$tot_amt'
            ,charge_method = '$charge_method'
            ,invoice_no = '$invoice_no'
            ,odr_idx = '$odr_idx'
            ,odr_det_idx = '$odr_det_idx'
            ,reg_date = now()
            ,reg_ip= '$log_ip'";
//  echo $sql;
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
    //2. odr_status 변경
    update_val("odr","odr_status","24", "odr_idx", $odr_idx);
    update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);

    //3. histoy update(환불 해달라는 history요청을 확인 한 상태로 update)    status = 10 인 경우도 환불 하지만, 5(결제완료)인 경우도 환불 하는경우가 있다. (18-2-15 상황)
    $odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and odr_det_idx = $odr_det_idx and (status = 10 or status= 5) and confirm_yn='N'");
    update_val("odr_history","confirm_yn","Y", "odr_history_idx", $odr_history_idx);
    $prt_method = $charge_method=="1" ? "신용카드" : ($charge_method=="2"?"은행송금":"My Bank");
    //4. history 등록
        $session_mem_idx = $_SESSION["MEM_IDX"];
        $buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
        $tot_amt = "$".$tot_amt;
        $sql = "insert into odr_history set
                odr_idx = '$odr_idx'
                ,odr_det_idx = '$odr_det_idx'
                ,status = 24
                ,status_name = '환불'
                ,etc1 = '$prt_method'
                ,etc2 = '$tot_amt'
                ,fault_select = '4'
                ,sell_mem_idx = '$sell_mem_idx'
                ,buy_mem_idx = '$mem_idx'
                ,reg_mem_idx = '$session_mem_idx'
                ,reg_date = now()";
        //echo $sql;
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
        if($result){
            echo "SUCCESS";
            exit;
        }
}

if ($typ == "refund2"){  //환불 처리2 2016-05-11
    //2016-06-01 : 예치금 개념 적용, 1.구매자:충전과 예치금 처리는 '환불(19_1_06)'에서, 2. 판매자 : 나머지 수량 '입금'처리(충전)
    //판매자 : 환불 나머지 수량에 대한 판매대금 입금 처리
    $odr_price = get_any("odr_det", "odr_price", "odr_det_idx=$odr_det_idx");
    $supply_qty = get_any("odr_det", "supply_quantity", "odr_det_idx=$odr_det_idx");
    $buy_amt = ($odr_price * $supply_qty) - $tot_amt;

    $vat_price = get_any("ship" ,"tax", "odr_idx=$odr_idx limit 1");    //부가세

    if($vat_price==0)
    {
        $vat_price = get_any("tax" ,"tax_percent", "nation=$ship_nation "); //부가세
    }
    //echo $vat_price."BBBBB";
    
    $vat_val = $vat_price/100;
    $vat_plus =  $buy_amt*$vat_val;         

    $buy_amt = $buy_amt + $vat_plus;
 
    $sql = "insert into mybank set
            mem_idx = '$sell_mem_idx'
            ,rel_idx = '$sell_rel_idx'
            ,mybank_yn = 'Y'
            ,charge_type = '4'
            ,charge_amt = '$buy_amt'
            ,charge_method = 'MyBank'
            ,odr_idx = '$odr_idx'
            ,odr_det_idx = '$odr_det_idx'
            ,reg_date = now()
            ,reg_ip= '$log_ip'";
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
    $sell_bank_idx=mysql_insert_id();
    //bank, hold 합계 Update
    update_val("mybank","mybank_amt", SumMyBank2($sell_mem_idx, $sell_rel_idx, 0), "mybank_idx", $sell_bank_idx);
    update_val("mybank","hold_amt", SumBankHold($sell_mem_idx, $sell_rel_idx, 0), "mybank_idx", $sell_bank_idx);
    /** 아래는 기존 직접 차감방식 2016-06-01 주석처리
    // 1. mybank insert
    //먼저 구매자에게 충전 charget_type = '10' 은 물품 금액 환불
    $sql = "insert into mybank set
            mem_idx = '$mem_idx'
            ,rel_idx = '$rel_idx'
            ,charge_type = '10'
            ,charge_amt = '$tot_amt'
            ,charge_method = '$charge_method'
            ,invoice_no = '$invoice_no'
            ,odr_idx = '$odr_idx'
            ,odr_det_idx = '$odr_det_idx'
            ,reg_date = now()
            ,reg_ip= '$log_ip'";
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
    $mybank_idx=mysql_insert_id();
    // 판매자에게는 차감 charge_type = '10' : 물품 금액만큼 차감
    $sql = "insert into mybank set
            mem_idx = '$sell_mem_idx'
            ,rel_idx = '$sell_rel_idx'
            ,charge_type = '10'
            ,charge_amt = '-$tot_amt'
            ,charge_method = '$charge_method'
            ,invoice_no = '$invoice_no'
            ,odr_idx = '$odr_idx'
            ,odr_det_idx = '$odr_det_idx'
            ,reg_date = now()
            ,reg_ip= '$log_ip'";
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
    **/
    //2. odr_status 변경
    update_val("odr","odr_status","24", "odr_idx", $odr_idx);
    update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);
    //3. histoy update
    update_val("odr_history","confirm_yn","Y", "odr_history_idx", $odr_history_idx);  //odr_history_idx => form으로 받았음
    //$prt_method = $charge_method=="1" ? "신용카드" : ($charge_method=="2"?"입금":"My Bank"); //JSJ
    $prt_method = "My Bank"; //무조건 마이뱅크
    //운임을 지불했는지 안했는지 확인하기위함
    $fault_odrno = get_any("odr", "odr_no", "odr_idx=$odr_idx");
    //4. history 등록
        $session_mem_idx = $_SESSION["MEM_IDX"];
        $buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
        $tot_amt = "$".$tot_amt;
        $sql = "insert into odr_history set
                odr_idx = '$odr_idx'
                ,odr_det_idx = '$odr_det_idx'
                ,status = 24
                ,status_name = '환불'
                ,etc1 = '$prt_method'
                ,etc2 = '$tot_amt'
                ,fault_select = '4'
                ,sell_mem_idx = '$sell_mem_idx'
                ,fault_odrno = '$fault_odrno'
                ,buy_mem_idx = '$mem_idx'
                ,reg_mem_idx = '$session_mem_idx'
                ,reg_date = now()";
        //echo $sql;
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
        if($result){
            echo "SUCCESS";
            exit;
        }
}



if($typ == "shipping"){  //------------------------------------------- 선적(전체) 처리(JSJ)--------------------------------------------------------------------------------------------------
    //1. 운송장 번호 update
    if($fault_yn=="Y"){  //------------ 교환 or 추가 선적 -------------
        update_val("odr","fault_delivery_no",$delivery_no, "odr_idx", $odr_idx);
            $sql = "update odr_det set
             fault_quantity         = '".$fault_quantity."'
            ,fault_method           = '".$fault_method."'
            , fault_part_condition          = '".$part_condition."'
            , fault_pack_condition1         = '".$pack_condition1."'
            , fault_pack_condition2         = '".$pack_condition2."'
            , fault_dc                          = '".$fault_dc."'
            , fault_memo                        = '".$memo."'
            , odr_status                        = '21'
            where odr_det_idx = $odr_det_idx";
            $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
            //echo $sql;
            //2. histoy update(반품선적 완료를 확인한 상태로 update)  수량 부족일 때에는 수량 부족을 확인 한 상태로 update
            if ($fault_method == "3"){ $prev_status = "10";} else{ $prev_status = "11";}
            $prev_odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and status = '$prev_status' and confirm_yn = 'N'");
            update_val("odr_history","confirm_yn","Y", "odr_history_idx", $prev_odr_history_idx);
    }else{ //----- 일반(교환 or 추가 선적이 아닌) -----------
        $fault_yn=="N"; //null값 처리 2016-05-20
        update_val("ship","delivery_no",$delivery_no, "odr_idx", $odr_idx);
        //2. histoy update(결제확인을 한 상태로 update)
        $prev_odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and status = 5 and confirm_yn = 'N'");
        update_val("odr_history","confirm_yn","Y", "odr_history_idx", $prev_odr_history_idx);
        //2-1. odr_det 의 odr_status=21 처리
        update_val("odr_det","odr_status","21", "odr_idx", $odr_idx);
    }

    //3. odr_status 변경
    update_val("odr","odr_status","21", "odr_idx", $odr_idx);
    update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);
    $ship_info_nm=GF_Common_GetSingleList("DLVR",$ship_info);
    if ($odr_history_idx) {

        if ($ship_info==5)
        {
            $ship_info_nm = $delivery_shop;
        }

        //4. history update
        $sql = "update odr_history
            set etc2 = '$etc2'
            ,odr_det_idx = '$odr_det_idx'
            ,etc1 = '$ship_info_nm $delivery_no'
            ,fault_select= '$fault_select'
            ,fault_yn = '$fault_yn'
            ,confirm_yn = 'N'
            where odr_history_idx = '$odr_history_idx'";
        //echo $sql;
    }else{
    //4. history 등록
        if ($ship_info==5)
        {
            $ship_info_nm = $delivery_shop;
        }
        $session_mem_idx = $_SESSION["MEM_IDX"];
        $buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
        $sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
        if ($session_mem_idx == $buy_mem_idx) {
        }
        $tot_amt = $tot_amt;
        $sql = "insert into odr_history set
                odr_idx = '$odr_idx'
                ,odr_det_idx = '$odr_det_idx'
                ,status = 21
                ,status_name = '선적완료'
                ,etc1 = '$delivery_no'
                ,etc2 = '$ship_info_nm'
                ,fault_yn = '$fault_yn'
                ,sell_mem_idx = '$sell_mem_idx'
                ,buy_mem_idx = '$buy_mem_idx'
                ,reg_mem_idx = '$session_mem_idx'
                ,reg_date = now()";
//      echo $sql;
    }
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

        if($result){
            //Page_Parent_Msg_Url1("선적 완료 메세지가 구매자에게 성공적으로 전달되었습니다.","/kor/");
            //사용자정의 창(타이틀,메세지,버튼) function.php
            //Page_Msg_Need2("선적","선적이 완료되었습니다.","btn_transmit");
            //header("Location: /kor/");
            die();
        }
}


if($typ == "shipping_ready"){  //------------------------------------------- 선적 처리전--------------------------------------------------------------------------------------------------
    Page_Msg_Need2("선적","선적이 완료되었습니다.","btn_transmit");
}

//------------------------------------------- 선적(fault) 처리(ccolle)--------------------------------------------------------------------------------------------------
// 2016-05-16 : fault(교환, 수량부족) 시 판매자 선적으로 사용하자
if($typ == "shipping2"){
    //echo "$odr_det_idx:".$odr_det_idx."<br>";
    //1. 운송장 번호 update

    update_val("odr","fault_delivery_no",$delivery_no, "odr_idx", $odr_idx);
    $sql = "update odr_det set
             fault_quantity                 = '".$fault_quantity."'
            ,fault_method                   = '".$fault_method."'
            , fault_part_condition          = '".$part_condition."'
            , fault_pack_condition1         = '".$pack_condition1."'
            , fault_pack_condition2         = '".$pack_condition2."'
            , fault_dc                          = '".$fault_dc."'
            , fault_memo                        = '".$memo."'
            where odr_det_idx = $odr_det_idx";
    //echo $sql;
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

    //2. histoy update(반품선적 완료를 확인한 상태로 update)  수량 부족일 때에는 수량 부족을 확인 한 상태로 update
    if($fault_method == "3"){   //fault_method : 3 => 추가선적(수량부족) / status => 10:수량부족, 9:거절
        $prev_status = 10;  //수량 부족
        $now_status = 23;
        $now_txt = "추가선적완료";
    }else{ //fault_method - 1:교환/2:반품
        $prev_status = "9,11";   //거절
        $now_status = 21;
        $now_txt = "선적완료";
    }
    $prev_odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and status in ($prev_status) and confirm_yn = 'N'");   
    update_val("odr_history","confirm_yn","Y", "odr_history_idx", $prev_odr_history_idx);

    //3. odr_status 변경
    update_val("odr","odr_status","21", "odr_idx", $odr_idx);
    update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);
    $ship_info_nm=GF_Common_GetSingleList("DLVR",$ship_info);

    //4. history 등록
    $session_mem_idx = $_SESSION["MEM_IDX"];
    $buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
    $sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
    $sql = "insert into odr_history set
            odr_idx = '$odr_idx'
            ,odr_det_idx = '$odr_det_idx'
            ,status = $now_status
            ,status_name = '$now_txt'
            ,etc1 = '$delivery_no'
            ,etc2 = '$ship_info_nm'
            ,fault_select = '$fault_select'
            ,fault_yn = '$fault_yn'
            ,sell_mem_idx = '$sell_mem_idx'
            ,buy_mem_idx = '$buy_mem_idx'
            ,reg_mem_idx = '$session_mem_idx'
            ,reg_date = now()";
    //echo $sql;
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

    //5. ship 등록 (2016-05-17)
    $sql = "insert into ship set
              ship_type = '5' ,
              odr_idx  = '$odr_idx' ,
              odr_det_idx = '$odr_det_idx' ,
              ship_info ='$ship_info',
              delivery_no = '$delivery_no' ,
              delivery_addr_idx = '$delivery_addr_idx' ,            
              memo =  '$memo',
              insur_yn ='$insur_yn',
              reg_date =  now(),
              reg_ip = '$log_ip'
    ";
   
    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
    $new_ship_idx=mysql_insert_id();

    update_val("odr","ship_idx",$new_ship_idx, "odr_idx", $odr_idx);

    if($result){
        //사용자정의 창(타이틀,메세지,버튼) function.php
        Page_Msg_Need2("선적","선적이 완료되었습니다.","btn_transmit");
    }
}

   //------------------------------------------ 2016-05-18 fault 수령 ------------------------------------------------------------
   //fault(교환, 수량부족) 수령은 det 개별 단위
if ($typ =="faultEnd"){
    $det_cnt = QRY_CNT("odr_det", "and odr_idx= $odr_idx");
    $session_mem_idx = $_SESSION["MEM_IDX"];
    $sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
    //1. history 등록
    //2016-05-23 : fault_select, fault_yn 필요
    $sql = "insert into odr_history set
            odr_idx     = '$odr_idx'
            ,odr_det_idx = '$odr_det_idx'
            ,status = 6
            ,status_name = '수령'
            ,etc1 = '종료'
            ,sell_mem_idx = '$sell_mem_idx'
            ,fault_select = '$fault_select'
            ,fault_yn = '$fault_yn'
            ,buy_mem_idx = '$session_mem_idx'
            ,reg_mem_idx = '$session_mem_idx'
            ,reg_date = now()";
    //echo $sql;
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

    //2. histoy update(선적을 확인한 상태로 update)
    update_val("odr_history","confirm_yn","Y", "odr_history_idx", $odr_history_idx);

    //3. odr_status 변경
    $his_cnt = get_any("odr_history","count( DISTINCT odr_det_idx, STATUS ) ", "odr_idx =$odr_idx AND STATUS = 6");
    if ($his_cnt >= $det_cnt) {
        update_val("odr","odr_status","6", "odr_idx", $odr_idx);
        update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);
    }
    if($result){
        Page_Parent_Msg_Url2("정상적으로 수령 및 종료 되었습니다.","/kor/");
    }
}
//------------------------------------------ 수령(odr 단위) 및 정상 종료 처리 ------------------------------------------------------------
//-- 2016-05-18 : 일부 수령일 일경우 det 단위 수령으로 사용
if ($typ =="succEnd"){
    
    $det_cnt = QRY_CNT("odr_det", "and odr_idx= $odr_idx");
    $arr = explode(",", $odr_det_idx );
    $session_mem_idx = $_SESSION["MEM_IDX"];
    $sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
    //1. det 단위 History 등록
    for ($j = 0 ; $j<count($arr); $j++){
        $ary_odr_det_idx  = $arr[$j];
        $sql = "insert into odr_history set
                odr_idx     = '$odr_idx'
                ,odr_det_idx = '$ary_odr_det_idx'
                ,status = 6
                ,status_name = '수령'
                ,etc1 = '종료'
                ,sell_mem_idx = '$sell_mem_idx'
                ,buy_mem_idx = '$session_mem_idx'
                ,reg_mem_idx = '$session_mem_idx'
                ,reg_date = now()";
        //echo $sql;
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
        //1-1. odr_det 상태 변경
        update_val("odr_det","odr_status","6", "odr_det_idx", $ary_odr_det_idx);
    }

    //2. odr_status 변경
    $his_cnt = get_any("odr_history","count( DISTINCT odr_det_idx, STATUS ) ", "odr_idx =$odr_idx AND STATUS IN ( 6, 9, 10 )");  //수령, 거절, 수량부족
    if ($his_cnt >= $det_cnt) { //-- det 수량만큼 체크 다 했으므로.....
        //2-1. histoy update(선적을 확인한 상태로 update)
        $sql = "update odr_history set confirm_yn  = 'Y' where odr_idx = $odr_idx and status= 21 and confirm_yn = 'N'";
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
        //2016-05-18 : odr 테이블의 상태는 일단 기존(JSJ)대로 놔두자...
        update_val("odr","odr_status","6", "odr_idx", $odr_idx); //JSJ
        update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);  //JSJ
    }
    if($result){
        Page_Parent_Msg_Url2("정상적으로 수령 및 종료 되었습니다.","/kor/");
    }
}
//------------------ 2016-04-24 : det에 각각 히스토리 등록하던것을 odr 단위로 등록 ------------------------------------------------------
//-- 2016-05-18 : 전체(odr) 수령으로 사용
if ($typ =="succEnd2"){
  
    $det_cnt = QRY_CNT("odr_det", "and odr_idx= $odr_idx");
    $session_mem_idx = $_SESSION["MEM_IDX"];
    $sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
    //2. history 등록
    $sql = "insert into odr_history set
            odr_idx     = '$odr_idx'
            ,status = 6
            ,status_name = '수령'
            ,etc1 = '종료'
            ,sell_mem_idx = '$sell_mem_idx'
            ,buy_mem_idx = '$session_mem_idx'
            ,reg_mem_idx = '$session_mem_idx'
            ,reg_date = now()";
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

    //3. odr 상태, histoy update(선적을 확인한 상태로 update)
    $sql = "update odr_history set confirm_yn  = 'Y' where odr_idx = $odr_idx AND status= 21 and confirm_yn = 'N'";
    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
    update_val("odr","odr_status","6", "odr_idx", $odr_idx);
    update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);
    update_val("odr_det","odr_status","6", "odr_idx", $odr_idx);

    if($result){
        Page_Parent_Msg_Url2("정상적으로 수령 및 종료 되었습니다.","/kor/");
    }
}
if($typ=="delay1"){
    $period = get_any("odr", "period" , "odr_idx = $odr_idx") + 1;
    update_val("odr","period","$period", "odr_idx", $odr_idx);
    update_val("odr_det","period",$period."WK", "odr_idx", $odr_idx);
    update_val("odr_history","confirm_yn","Y", "odr_history_idx", $history_idx);
    echo "SUCCESS";

}
if ($typ =="arrival"){   //물건 도착(지속적...) ---------------------------------------------------------------------------------------------------------------
  //1. odr_status 변경
    update_val("odr","odr_status","19", "odr_idx", $odr_idx);
    update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);
  //2. 추가 공급 가능 물량 및 부품,포장상태, 메모정보  update
    $sql = "update odr_det set
     add_capa_quantity          = '".$addcapa."'
    , part_condition            = '".$part_condition."'
    , pack_condition1           = '".$pack_condition1."'
    , pack_condition2           = '".$pack_condition2."'
    , memo                      = '".$memo."'
    , period                        = 'stock'
    where odr_idx = $odr_idx";
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

    $sql = "update ship set appoint_yn = '$appoint_yn' , tax = '$tax' where odr_idx = $odr_idx";
     $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

    //2. histoy update(결제를 확인한 상태로 update, 혹시 지연요청을 한적 있으면 그 지연 요청도 확인 한 상태로 update)
    $sql = "update odr_history set confirm_yn = 'Y' where odr_idx= $odr_idx and status in (4,5,20) and confirm_yn = 'N'";
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());


    //3. history 등록
        $session_mem_idx = $_SESSION["MEM_IDX"];
        $buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
        $sql = "insert into odr_history set
                odr_idx = '$odr_idx'
                ,status = 19
                ,status_name = '도착'
                ,etc1 = '$addcapa EA'
                ,sell_mem_idx = '$session_mem_idx'
                ,buy_mem_idx = '$buy_mem_idx'
                ,reg_mem_idx = '$session_mem_idx'
                ,reg_date = now()";
        //echo $sql;
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
        if($result){
            Page_Parent_Msg_Url1("구매자에게 도착 메세지를 보냈습니다.","/kor/");
        }
}

if ($typ =="updweight"){ //선적 중량 update ---------------------------------------------------------------------------------------
//  echo $odr_idx;
    $sql = "update ship set ship_weight = '$ship_weight' , weight_type = '$weight_type' where odr_idx = $odr_idx";
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
    if($result){
        echo "SUCCESS"; //JSJ 원본 --------------------------------------------------------------------------------------------------------
        //echo json_encode(array('data'=>'SUCCESS','s_weight'=>$ship_weight));
    }
}

if ($typ =="updbuyerdelifee"){ //구매자 운임 등록 -----------------------------------------------------------------------------------
    update_val("odr", "buyer_delivery_fee", "$buyer_delivery_fee", "odr_idx",$odr_idx);
    echo "SUCCESS";
}

if ($typ =="updfaultydelifee"){ //불량 운임 등록 ---------------------------------------------------------------------------------------------------
    update_val("odr", "faulty_delivery_fee", "$faulty_delivery_fee", "odr_idx",$odr_idx);
    echo "SUCCESS";
}

/**********************************************************************************************************************
 //납기기한 확인(판매자 답변) --------------------------------------------------------------------------------------------------------------
 **********************************************************************************************************************/
if ($typ =="periodcfrm"){
    //납기 확인 전에 개별 part 정보 update 할수 있게 수정.
    $part_idx =get_any("odr_det", "part_idx" ,"odr_det_idx=$odr_det_idx");
    $part_update_chk =get_any("part", "invreg_chk" ,"part_idx=$part_idx");

    if ($part_update_chk=="0")
    {
        $sql = "update part set part_no = '$part_no',
            manufacturer = '$manufacturer',
            package= '$package',
            dc = '$dc',
            rhtype = '$rhtype'
            where part_idx = $part_idx";
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
    }
   
    $sql = "update part set 
            invreg_chk = '1'
            where part_idx = $part_idx";
   
    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

    //이게 저장 Data에 있는지 여부 체크------------
    $save_cnt = QRY_CNT("odr a LEFT JOIN odr_det b ON(a.odr_idx=b.odr_idx)", " and b.rel_det_idx = $odr_det_idx AND a.save_yn = 'Y'");

    //정상 History Data -------------------------------
    update_val("odr_det" , "period", "$period$pkind", "odr_det_idx" , $odr_det_idx); //납기일
    update_val("odr_det" , "supply_quantity", "$supply_quantity", "odr_det_idx" , $odr_det_idx);  //수량
    update_val("odr_det" , "odr_status", 16, "odr_det_idx" , $odr_det_idx);  //2016-03-29 det_status Update
    if($save_cnt>0){ //2016-04-05
        //저장 Data-------------------------------- 2016-04-02
        update_val("odr_det" , "period", "$period$pkind", "rel_det_idx" , $odr_det_idx); //납기일
        update_val("odr_det" , "supply_quantity", "$supply_quantity", "rel_det_idx" , $odr_det_idx);  //수량
        update_val("odr_det" , "odr_status", 16, "rel_det_idx" , $odr_det_idx);
        $rel_odr = get_any("odr_det", "odr_idx" ,"rel_det_idx=$odr_det_idx");
        update_val("odr" , "period", "$period", "odr_idx" , $rel_odr); //납기일
        //저장 Data 중, 3주이상 부터는 삭제. 2016-09-09
        /**
        if ($pkind == "WK" && $period >2 ) {
            $saved_odr_idx = get_any("odr_det", "odr_idx", "rel_det_idx=$odr_det_idx"); //저장 DATA의 odr_idx
            $sql = "DELETE FROM odr_det WHERE rel_det_idx=$odr_det_idx";
            $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
            $saved_det_cnt = QRY_CNT("odr_det", " and odr_idx=$saved_odr_idx");
            if($saved_det_cnt==0){
                $sql = "DELETE FROM odr WHERE odr_idx=$saved_odr_idx";
                $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
            }
        }
        **/
    }

    $odr_idx = get_any("odr_det", "odr_idx" ,"odr_det_idx=$odr_det_idx");

    if (QRY_CNT("odr_history", "and  odr_idx = $odr_idx and status = 19 ")>0){   //물건 도착한 이후라면..
        if ($pkind == "WK" && $period >2 ) {  //period 값이 2주 이상이라면 odr를 분리 해야 한다.
            $mem_idx = get_any("odr", "mem_idx", "odr_idx  = $odr_idx");
            $odr_idx_im = get_any("odr", "odr_idx", "imsi_odr_no ='IM-".date("ymdhms").RndomNum(4)."'");
            $odr_idx_old = $odr_idx;
            if (!$odr_idx_im) {
                $sql = "insert into odr (imsi_odr_no, mem_idx, rel_idx, sell_mem_idx, sell_rel_idx, period, odr_status ,  memo, reg_date, reg_ip,status_edit_mem_idx)
                    select 'IM-".$session_mem_idx."-".$mem_idx."', mem_idx, rel_idx, sell_mem_idx, sell_rel_idx, period, odr_status , memo, now(), reg_ip, $session_mem_idx from odr where odr_idx = $odr_idx ";
                //  echo $sql;
                    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
                    $odr_idx=mysql_insert_id();
                    // 선적 정보도 분리한다.
                    $sql = "insert into ship (ship_type, odr_idx, delivery_addr_idx, ship_info, ship_account_no, insur_yn)
                    select ship_type, '$odr_idx', delivery_addr_idx, ship_info, ship_account_no, insur_yn from ship where odr_idx = $odr_idx_old and ship_type=1 ";
                    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
                    $new_ship_idx=mysql_insert_id();
                    $sql = "update odr set ship_idx = $new_ship_idx where odr_idx = $odr_idx";
                    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());



                    $sql = "update odr_det set odr_idx = $odr_idx where odr_det_idx = $odr_det_idx";
                    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
                    $sql = "update odr_history set odr_idx = $odr_idx where odr_det_idx = $odr_det_idx";
                    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

            }
        }
    }


    //1. histoy update(납기 확인한 상태로 update)
        $odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and odr_det_idx = $odr_det_idx and status = 1");
        update_val("odr_history","confirm_yn","Y", "odr_history_idx", $odr_history_idx);

    //2. history 등록
        $session_mem_idx = $_SESSION["MEM_IDX"];
        $sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
        $buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
        $sql = "insert into odr_history set
                odr_idx = '$odr_idx'
                ,odr_det_idx = '$odr_det_idx'
                ,status = 16
                ,status_name = '납기 확인'
                ,etc1 = '$period$pkind'
                ,sell_mem_idx = '$sell_mem_idx'
                ,buy_mem_idx = '$buy_mem_idx'
                ,reg_mem_idx = '$session_mem_idx'
                ,reg_date = now()";
        //echo $sql;
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
        $new_history_idx=mysql_insert_id();
    //저장 Data에 있을경우 history '확인' 처리. 단, 납기 3주 부터는 확인처리 없음
    if($save_cnt>0){
        update_val("odr_history", "confirm_yn", "Y", "odr_history_idx", $new_history_idx);
        /**
        if($pkind == "WK" && $period >2){
            update_val("odr_history", "confirm_yn", "N", "odr_history_idx", $new_history_idx);
        }
        **/
    }

    $cnt = QRY_CNT("odr_det" , "and odr_idx = $odr_idx and (part_type = '2' or part_type = '5' or part_type='6') and period =''");
    if ($cnt ==0){  //해당 odr_idx의 모든 납기 확인이 끝났을 때에야 odr_status 변경하고
        //0. period 등록 : 제일 긴 period로
        $max_period = get_any("odr_det" ,"period", "odr_idx =$odr_idx ORDER BY CASE WHEN instr( period, 'WK' ) >0 THEN period *7 ELSE period *1 END DESC LIMIT 0 , 1 ");
        update_val("odr", "period", $max_period, "odr_idx", $odr_idx);
        //1. odr_status 변경 : 납기 확인 으로.
        update_val("odr","odr_status","16", "odr_idx", $odr_idx);
        update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);
        echo "SUCCESS ALL";
    }else{
        echo "SUCCESS";
    }
}

if ($typ=="bankfileup"){  //은행 송금 처리 ----------------------------------------------------------------------------------------------------------------------------
    $i = $no;
    /** 파일 업로드 ******************************************/
        $query_name = "file".$i; //input 파라메터 이름
        if($_FILES[$query_name]) {
            $FILE_1         = RequestFile("file".$i);
            $FILE_1_size    = $FILE_1[size];
            $maxSize = '5242880'; //5mb, 파일 용량 제한
            $filename = uploadProc( $query_name, $dir_dest, $maxSize);
        }

        if(${"file_o".$i}){
            $old_file=${"file_o".$i};
            if(file_exists("$dir_dest/$old_file")){
                unlink("$dir_dest/$old_file");
            }
        }

        if ($mybank_idx==""){
            $odr_history_idx = get_any("odr_history", "odr_history_idx", "odr_idx =$odr_idx and confirm_yn = 'N'");
            if ($deposit_yn=="Y") {   //송금액에 보증금도 포함되어 있다는 의미
                $invoice_no = get_auto_no("DI", "mybank", "invoice_no");        //보증금 : DI
                $sql = "insert into mybank set
                 mem_idx = '$mem_idx'
                ,rel_idx = '$rel_idx'
                ,charge_type = '8'
                ,charge_amt = '-1000'
                ,invoice_no = '$invoice_no'
                ,charge_method = '$charge_method'
                ,deposit_yn = '$deposit_yn'
                ,odr_idx = '$odr_idx'
                ,odr_det_idx = '$odr_det_idx'
                ,odr_history_idx = '$odr_history_idx'
                ,reg_date = now()
                ,reg_ip= '$log_ip'";
                //echo $sql;
                $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
                update_want("member", " deposit='1' ", " and mem_idx='$mem_idx' ");
                //구매자의 보증금은 냈다고 미리 처리 해주자. (단, 판매자는 미리 처리 해주면 안된다. 바로 선적 가능 해버리기 때문에. 구매자는 미리 해줘도 된다. 보증금 이외의 금액이 모두 입금 확인 되어야 그 다음 단계를 진행 할수 있기 때문에.)
                $odr = get_odr($odr_idx);
                if ($odr[mem_idx] == $mem_idx){
                    $_SESSION["DEPOSIT"] = "Y";
                }
                $tot_amt = $tot_amt - 1000;
            }
            if ($tot_amt > 0 ) {
                 if ($invoice_no ==""){
                     $invChr = get_any("code_group_detail", "dtl_code" , "grp_idx = 19 and code_desc_mt = '$charge_type'");
                     if ($charge_type=="3"){
                        $invoice_no = get_auto_no("EI", "odr", "invoice_no");
                     }elseif ($invChr){
                         $invoice_no = get_auto_no($invChr, "mybank", "invoice_no");
                     }
                 }
                 $sql = "insert into mybank set
                         mem_idx = '$mem_idx'
                        ,rel_idx = '$rel_idx'
                        ,charge_type = '$charge_type'
                        ,charge_amt = '".($charge_type=="1"?"":"-")."$tot_amt'
                        ,invoice_no = '$invoice_no'
                        ,charge_method = '$charge_method'
                        ,odr_idx = '$odr_idx'
                        ,odr_det_idx = '$odr_det_idx'
                        ,odr_history_idx = '$odr_history_idx'
                        ,deposit_yn = '$deposit_yn'
                        ,reg_date = now()
                        ,reg_ip= '$log_ip'";
                    $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
                    $mybank_idx=mysql_insert_id();
                    Page_Updval("mybank_idx",$mybank_idx);
            }else{
                $mybank_idx=mysql_insert_id();
            }

        }

        $sql = "update mybank set
        file1  = '$filename'
        where mybank_idx = $mybank_idx";
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
        Page_ImgUpload($no, $filename);
        exit;
}
//----------------------------------------------------------------------------------------------------------------------------------------------------------
if ($typ=="imgfileup" || $typ =="imgfiledel"){   //18R_21 에서 사용.
    $i = $no;
    $filename ="";
    if ($typ =="imgfileup"){
        /** 파일 업로드 ******************************************/
        $query_name = "file".$i; //input 파라메터 이름
        echo $query_name.":::::::".$dir_dest;
        //exit;

        if($_FILES[$query_name]) {
            $FILE_1         = RequestFile("file".$i);
            $FILE_1_size    = $FILE_1[size];
            $maxSize = '5242880'; //5mb, 파일 용량 제한
            $filename = uploadProc( $query_name, $dir_dest, $maxSize);
        }
    }
    if(${"file_o".$i}){
        $old_file=${"file_o".$i};
        if(file_exists("$dir_dest/$old_file")){
            unlink("$dir_dest/$old_file");
        }
    }

    $pos = strpos($i, "_");
    if ($pos==true){   //부품의 라벨/사진 정보 (odr_det에 저장)
        $arr = explode("_", $i);
        $odr_det_idx = $arr[0];
        $file_no = $arr[1];
        $sql = "update odr_det set file$file_no = '$filename'
        where odr_det_idx = $odr_det_idx";
    //  echo $sql;
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
        if($result){
            if ($typ=="imgfileup"){
                Page_ImgUpload($no, $filename);
                exit;
            }else{
                echo "SUCCESS";
                exit;
            }
        }
    }else{   //거절이나, 수량 부족시 사진 정보 (odr_history 에 저장)
        if ($odr_history_idx==""){
            $sql = "insert into odr_history set
                    odr_idx = '$odr_idx'
                    ,odr_det_idx = '$odr_det_idx'
                    ,status = $status
                    ,status_name = '$status_name'
                    ,etc1 = '$etc1'
                    ,confirm_yn  = 'F'
                    ,sell_mem_idx = '$sell_mem_idx'
                    ,buy_mem_idx = '$buy_mem_idx'
                    ,reg_mem_idx = '$session_mem_idx'
                    ,reg_date = now()";
        // echo $sql;
            $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
            $odr_history_idx=mysql_insert_id();
        }

        $sql = "update odr_history set
        file$i  = '$filename'
        where odr_history_idx = $odr_history_idx";
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

        if($result){
            if ($typ=="imgfileup"){
                Page_Updval("odr_history_idx",$odr_history_idx);
                Page_ImgUpload($no, $filename);
                exit;
            }else{
                echo "SUCCESS";
                exit;
            }
        }
    }
}
//----------------------------------------------------------------- 수량부족, 거절 : 18R_05 ---------------------------------------------------------------
if ($typ=="refuse"){

    //fault 수량 및 종휴 Update
    if($fault_quantity > 0){
        $sql = "update odr_det set fault_quantity = '$fault_quantity' , fault_method = '$fault_select' where odr_idx = $odr_idx and odr_det_idx = $odr_det_idx";
       
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
    }
  
    if ($fault_select==""){
        if (strpos($etc2,"EA")==0){ $etc2 = $etc2."EA";}        //몇개 부족인지
        switch($real_fault_select){
            case "1":
                $etc2= "교환";
            break;
            case "2":
                $etc2 = "반품";
            break;
            case "3" :
                $etc2 = "추가선적";
            break;
            case "4" :
                $etc2 = "환불";
            break;
        }
        $fault_select = $real_fault_select;
    }else{
        
        switch($fault_select){
            case "1":
                $etc2= "교환";
            break;
            case "2":
                $etc2 = "반품";
            break;
            case "3" :
                $etc2 = "추가선적";
            break;
            case "4" :
                $etc2 = "환불";
            break;
        }
       
    }


    //1. odr_status 변경 : 거절으로.
    update_val("odr","odr_status",$status, "odr_idx", $odr_idx);
    update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);

    //2. 부족 및 거절 수량 Update
    update_val("odr_det","fault_quantity",$fault_quantity, "odr_det_idx", $odr_det_idx);

    //3. history update (왔다 갔다 한게 1번 이상이면 거절/수량부족 확인 한 상태로)
    $sql = "update odr_history set confirm_yn  = 'Y' where odr_idx = $odr_idx and odr_det_idx = $odr_det_idx and status = $status and confirm_yn = 'N'";
    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

    if ($odr_history_idx){
        //4. history update
        $sql = "update odr_history
            set etc2 = '$etc2'
            ,etc1 = '$etc1'
            ,odr_det_idx = '$odr_det_idx'
            ,fault_select= '$fault_select'
            ,fault_yn = '$fault_yn'
            ,reason = '$memo'
            ,confirm_yn = 'N'
            where odr_history_idx = '$odr_history_idx'";
            //echo $sql;
    }else{
        //$fault_accept = ($fault_accept=='Y")? "Y":"N";
        $sql = "insert into odr_history set
            odr_idx = '$odr_idx'
            ,odr_det_idx = '$odr_det_idx'
            ,status = $status
            ,status_name = '$status_name'
            ,etc1 = '$etc1'
            ,etc2 = '$etc2'
            ,fault_select= '$fault_select'
            ,fault_yn = '$fault_yn'
            ,fault_accept = '$fault_accept'
            ,reason_title = '$title'
            ,reason = '$memo'
            ,confirm_yn  = 'N'
            ,sell_mem_idx = '$sell_mem_idx'
            ,buy_mem_idx = '$buy_mem_idx'
            ,reg_mem_idx = '$session_mem_idx'
            ,reg_date = now()";
    }
    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());


    $det_cnt = QRY_CNT("odr_det", "and odr_idx= $odr_idx");
    $his_cnt = get_any("odr_history","count( DISTINCT odr_det_idx, STATUS ) ", "odr_idx =$odr_idx AND STATUS IN ( 6, 9, 10 )");

    if ($his_cnt == $det_cnt) {
        //2. histoy update(선적 확인한 상태로 update : 개별 상품이 여러개라면.. 모든 상품이 (수량부족/거절/수령) 진행 중이어야 선적확인 완료 상태로 update 가능
        $pre_odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and status = 21");
        update_val("odr_history","confirm_yn","Y", "odr_history_idx", $pre_odr_history_idx);
    }


        echo "SUCCESS";
}
//----------------------------------------------------------------------------------------------------------------------------------------------
if ($typ=="notify"){
    //0. 불량통보일 때

    //1. odr_status 변경 : 거절으로.
    update_val("odr","odr_status",$status, "odr_idx", $odr_idx);
    update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);
    if ($odr_history_idx){
        //4. history update
        $sql = "update odr_history
            set etc2 = '$etc2'
            ,etc1 = '$etc1'
            ,fault_select= '$fault_select'
            ,fault_yn = '$fault_yn'
            ,reason = '$memo'
            ,confirm_yn = 'N'
            where odr_history_idx = '$odr_history_idx'";
            //echo $sql;
    }else{
        $sql = "insert into odr_history set
            odr_idx = '$odr_idx'
            ,status = $status
            ,status_name = '$status_name'
            ,etc1 = '$etc1'
            ,etc2 = '$etc2'
            ,fault_select= '$fault_select'
            ,fault_yn = '$fault_yn'
            ,reason = '$memo'
            ,confirm_yn  = 'N'
            ,sell_mem_idx = '$sell_mem_idx'
            ,buy_mem_idx = '$buy_mem_idx'
            ,reg_mem_idx = '$session_mem_idx'
            ,reg_date = now()";
    }
    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
        echo "SUCCESS";
}
//-------------------------------------------반품방법-------------------------------------------------------------------------------------------------------
if ($typ =="return_method"){

    //1. odr_status 변경 : 반품 방법으로
    update_val("odr","odr_status","22", "odr_idx", $odr_idx);
    update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);
    //2. history update (1번 이상이면 거절 확인 한 상태로), 2016-05-12 : Update 쿼리에 odr_det_idx 추가
    $sql = "update odr_history set confirm_yn  = 'Y' where odr_idx = $odr_idx AND odr_det_idx=$odr_det_idx AND status = 9 AND confirm_yn = 'N'";
    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
    $etc2 = $return_method == "1" ? "반품포기" : GF_Common_GetSingleList("DLVR",$ship_info);
    if ($return_method =="2") {
        $ship_type = $ship_type == "" ? "1" : $ship_type;
        $ship_idx = get_any("ship" , "ship_idx", "ship_type = $ship_type and odr_idx = $odr_idx and odr_det_idx = $odr_det_idx");
        if($ship_idx==""){
            $sql = "insert into ship set
                      ship_type = '$ship_type' ,
                      odr_idx  = '$odr_idx' ,
                      odr_det_idx  = '$odr_det_idx' ,
                      delivery_addr_idx = '$delivery_addr_idx' ,
                      ship_info ='$ship_info',
                      ship_account_no = '$ship_account_no' ,
                      delivery_no = '$delivery_no' ,
                      insur_yn ='$insur_yn',
                      memo ='$memo',
                      reg_date =  now()
            ";
            $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
            $ship_idx=mysql_insert_id();
        }
        $sql = "update odr_det set ship_idx = '$ship_idx' where odr_det_idx  = '$odr_det_idx'";
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
    }

    $sql = "insert into odr_history set
            odr_idx = '$odr_idx'
            ,odr_det_idx = '$odr_det_idx'
            ,status = $status
            ,status_name = '$status_name'
            ,etc1 = '$ship_account_no'
            ,etc2 = '$etc2'
            ,fault_select= '$fault_select'
            ,return_method = '$return_method'
            ,reason = '$memo'
            ,confirm_yn  = 'N'
            ,sell_mem_idx = '$sell_mem_idx'
            ,buy_mem_idx = '$buy_mem_idx'
            ,reg_mem_idx = '$session_mem_idx'
            ,reg_date = now()";
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
        echo "SUCCESS";
}
//////반품 선적시 etc2 : 반품 , fault_select : 2 , odr_det_idx :  세개 다 넘겨야 하는것 할 차례.
if ($typ =="return_submit"){
    //1. odr_status 변경 : 반품 선적 완료로
    update_val("odr","odr_status","11", "odr_idx", $odr_idx);
    update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);
    //2016-05-10 반품 수량 Update(odr_det)
    update_val("odr_det","fault_quantity",$fault_quantity, "odr_det_idx", $odr_det_idx);
    //2016-05-10 송장번호 Update(ship)
    update_val("ship","delivery_no",$delivery_no, "odr_det_idx", $odr_det_idx);
    //2. history update (반품 방법 확인한 상태로)
    $searchand = "odr_idx = $odr_idx AND odr_det_idx = $odr_det_idx AND status = 22 and confirm_yn = 'N'";
    $prev_odr_history_idx = get_any("odr_history" , "odr_history_idx", $searchand);
    if ($prev_odr_history_idx) {
        $odr_his = get_odr_history($prev_odr_history_idx);
        //$etc2 = $odr_his[etc2];
        $fault_select = $odr_his[fault_select];
        $return_method= $odr_his[return_method];
        $sql = "update odr_history set confirm_yn  = 'Y' where odr_history_idx = $prev_odr_history_idx";
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
    }
    $etc2 = $return_method == "1" ? "반품포기" : GF_Common_GetSingleList("DLVR",$ship_info);
    
    $sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
    $buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");

    $sql = "insert into odr_history set
            odr_idx = '$odr_idx'
            ,odr_det_idx = '$odr_det_idx'
            ,status = '11'
            ,status_name = '반품선적완료'
            ,etc1 = '$delivery_no'
            ,etc2 = '$etc2'
            ,fault_select= '$fault_select'
            ,return_method = '$return_method'
            ,confirm_yn  = 'N'
            ,sell_mem_idx = '$sell_mem_idx'
            ,buy_mem_idx = '$buy_mem_idx'
            ,reg_mem_idx = '$session_mem_idx'
            ,reg_date = now()";
    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
    if($result){
        if ($return_method == "1"){
            echo "SUCCESS";
        }else{
            Page_Parent_Msg_Url1("반품 선적 완료 메세지가 판매자에게 성공적으로 전달되었습니다.","/kor/");
        }
    }
}
//---------------------------------------------- [My Box 담기] ----------------------------------------------------------------------------
if($typ=="mybox_in"){
    $already_idx = get_want("mybox","idx"," and mem_idx = '$session_mem_idx' and part_idx = '$part_idx'");
    if($already_idx){
        $sql = "delete from mybox where idx='$already_idx'";
        $already="";
    }else{
        $sql = "insert into mybox set
                mem_idx = '$session_mem_idx'
                ,mem_id = '$session_mem_id'
                ,part_idx = '$part_idx'
                ,part_type = '$part_type'
                ,reg_date = '$log_date'
                ,reg_ip = '$log_ip'
                ";
        $already="1";
    }
    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
        Page_Chg_Mybox($already,$part_idx);
        if($work=="del"){
            ReopenLayer2(".col-left", "mybox");
        }
        ReopenLayer2(".col-right", "side_order");
        echo "SUCCESS";
}
//--------------------------------------------------------------------------------------------------------------------------------------
//-- 배송지변경 : 변경주소 저장
//--------------------------------------------------------------------------------------------------------------------------------------
if($typ=="delivery_save"){
    if($delivery_addr_idx && $delivery_addr_idx !="aaaa"){  //수정
            $sql = "update delivery_addr set
                    mem_idx = '$session_mem_idx'
                    ,save_yn = '$delivery_save_yn'
                    ,nation = '$nation'
                    ,com_name='$com_name'
                    ,manager= '$manager'
                    ,pos_nm = '$pos_nm'
                    ,depart_nm = '$depart_nm'
                    ,com_type = '$com_type'
                    ,tel = '$nation_nm$tel'
                    ,fax = '$nation_nm$fax'
                    ,hp = '$nation_nm$hp'
                    ,email = '$email'
                    ,homepage = '$homepage'
                    ,zipcode = '$zipcode'
                    ,dosi = '$dosi'
                    ,dositxt = '$dositxt'
                    ,sigungu = '$sigungu'
                    ,addr_det = '$addr_full'
                    ,addr = '$addr'
                    where delivery_addr_idx = $delivery_addr_idx
            ";
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
     
        echo $delivery_addr_idx;
    }else{  //추가
            $sql = "insert into delivery_addr set
                    mem_idx = '$session_mem_idx'
                    ,save_yn = '$delivery_save_yn'
                    ,nation = '$nation'
                    ,com_name='$com_name'
                    ,manager= '$manager'
                    ,pos_nm = '$pos_nm'
                    ,depart_nm = '$depart_nm'
                    ,com_type = '$com_type'
                    ,tel = '$nation_nm$tel'
                    ,fax = '$nation_nm$fax'
                    ,hp = '$nation_nm$hp'
                    ,email = '$email'
                    ,homepage = '$homepage'
                    ,zipcode = '$zipcode'
                    ,dosi = '$dosi'
                    ,dositxt = '$dositxt'
                    ,sigungu = '$sigungu'
                    ,addr_det = '$addr_full'
                    ,addr = '$addr'
                    ,reg_date = '$log_date'
                    ,reg_ip = '$log_ip'
                    ";
        $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
        //echo $sql;
        $delivery_addr_idx=mysql_insert_id();
        echo $delivery_addr_idx;
    }



}
//--------------------------------------------------------------------------------------------------------------------------
if($typ =="delivery_del"){
    $sql = "delete from delivery_addr where delivery_addr_idx = $delivery_addr_idx";
    $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
}

if($typ =="save_key"){
   
    $mem_session_idx = $_SESSION['MEM_IDX'];
    $cnt = get_any ("odr_history" , "count(*)", "odr_idx= $actidx and status=90");

    if ($cnt == 1)
    {
        $sql = "update odr_history set
            reg_date = now()
            where odr_idx = '$actidx'";
    
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
    }
    else
    {
        $sql = "insert into odr_history set
            odr_idx = '$actidx'
            ,status = 90
            ,status_name = '저장'
            ,reg_mem_idx = '$mem_session_idx'
            ,reg_date = now()";
    
        $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
    }
  
    exit;
    
}

if ($typ=="return_qty")
{
    $odr_det_sql = "select odr_det_idx from odr_det where odr_idx='".$odr_idx."'";
    //echo  $sql;
    $det_result = mysql_query($odr_det_sql,$conn) or die ("SQL Error : ". mysql_error());
    while($row = mysql_fetch_array($det_result)){
        $update_sql = "update odr_det set $qty_type ='0' where odr_det_idx='".$row['odr_det_idx']."'";

        $result = mysql_query($update_sql,$conn) or die ("SQL Error : ". mysql_error());
    }
}
?>
