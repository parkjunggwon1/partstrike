<?php
	include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
	/* Test 결제 */
	$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
	$business = "goodr00-facilitator@naver.com";			// 페이팔 사업자 계정
	/* Real 결제 */
	//$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
	//$business = "goodr00@naver.com";			// 페이팔 사업자 계정
	
	$item_number = "BUY-".date("YmdHis");				// 주문번호(고유값)
	$currency_code = "USD";						// 통화단위 ($)

	
	if ($charge_type=="14") {//가입비
		$item_name = "Membershipfee";
	}elseif ($charge_type=="1"){
		$item_name = "Charge My Bank";
	}else{ //일반 결제
		if ($odr_det_idx) { 
			$odr_det = get_odr_det_each($odr_det_idx);
		}else{
			$odr_det = get_odr_det($odr_idx);
			$cnt=QRY_CNT("odr_det" , "and odr_idx= $odr_idx");
			if ($cnt>1) { 
				$cnt_nm = "외 ".($cnt-1)."개";
			}
		}
		$part =get_part($odr_det[part_idx]);
		$item_name = $part[part_no].$cnt_nm;
		$sell_mem_idx = $part[mem_idx];
		$sell_rel_idx = $part[rel_idx];
	}
	

	$return_url = "http://evictor23.cafe24.com/paypal/paypopup.php?mode=return2&odr_idx=$odr_idx&odr_det_idx=$odr_det_idx&deposit_yn=$deposit_yn&charge_type=$charge_type&typ=$typ&fromLoadPage=$fromLoadPage&tot_amt=$tot_amt&sell_mem_idx=$sell_mem_idx&sell_rel_idx=$sell_rel_idx&memfee_id=$memfee_id";		// 리턴 URL
	$cancel_url = $_SERVER['HTTP_HOST'];		// 취소 URL
	$item_name = "";							// 상품명


	$creditcard_fee = get_any("tax" , "tax_percent", "tax_name='CCF'");
	$tot_amt_for_pay = $tot_amt + $tot_amt * $creditcard_fee / 100;
	
	$amount = number_format($tot_amt_for_pay,2); 						// 가격
	
	// Return Test
	if($mode=="return") {		
		$log = "";			
		define("DEBUG", 1);
		// Set to 0 once you're ready to go live
		//define("USE_SANDBOX", 1);
		//define("LOG_FILE", APP_DATA_ROOT."paylog/ipnnn.log");
		
		// Read POST data
		// reading posted data directly from $_POST causes serialization
		// issues with array data in POST. Reading raw POST data from input stream instead.
		$raw_post_data = file_get_contents('php://input');
		$raw_post_array = explode('&', $raw_post_data);
		
		$keyarray = array();
		foreach ($raw_post_array as $keyval) {
			$keyval = explode ('=', $keyval);
			if (count($keyval) == 2)
				$keyarray[$keyval[0]] = urldecode($keyval[1]);
		}
		
		
		$log .= "1. reading posted data ".date('[Y-m-d H:i:s e] ').": \n";
		$log .= print_r($keyarray, true);
		
		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		if(function_exists('get_magic_quotes_gpc')) {
			$get_magic_quotes_exists = true;
		}
		foreach ($keyarray as $key => $value) {
			if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
				$value = urlencode(stripslashes($value));
			} else {
				$value = urlencode($value);
			}
			$req .= "&".$key."=".$value;
		}
		
		
		$log .= "\n\n2. make request data ".date('[Y-m-d H:i:s e] ').": \n".$req."\n\n";
		
		// Post IPN data back to PayPal to validate the IPN data is genuine
		// Without this step anyone can fake IPN data
		
		$ch = curl_init($paypal_url);
		if ($ch == FALSE) {
			return FALSE;
		}
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		if(DEBUG == true) {
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
		}
		// CONFIG: Optional proxy configuration
		//curl_setopt($ch, CURLOPT_PROXY, $proxy);
		//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
		// Set TCP timeout to 30 seconds
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
		// CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
		// of the certificate as shown below. Ensure the file is readable by the webserver.
		// This is mandatory for some environments.
		//$cert = __DIR__ . "./cacert.pem";
		//curl_setopt($ch, CURLOPT_CAINFO, $cert);
		$res = curl_exec($ch);
		if (curl_errno($ch) != 0) // cURL error
			{
			if(DEBUG == true) {	
				//error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch). PHP_EOL, 3, LOG_FILE);
				$log .= "3. CURL ERROR ".date('[Y-m-d H:i:s e] ').": \nCan't connect to PayPal to validate IPN message: " . curl_error($ch)."\n\n";
			}
			curl_close($ch);
			exit;
		} else {
				// Log the entire HTTP response if debug is switched on.
				if(DEBUG == true) {						
					//error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req". PHP_EOL, 3, LOG_FILE);
									
					//error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);
					
					$log .= "3. CURL Request ".date('[Y-m-d H:i:s e] ').": \nHTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req"."\n\n";
					$log .= "4. CURL Response ".date('[Y-m-d H:i:s e] ').": \nHTTP response of validation request: $res"."\n\n";
					
					
				}
				curl_close($ch);
		}
		// Inspect IPN validation result and act accordingly
		// Split response headers and payload, a better way for strcmp
		$tokens = explode("\r\n\r\n", trim($res));
		$res = trim(end($tokens));
		if (strcmp ($res, "VERIFIED") == 0) {
			// check whether the payment_status is Completed
			// check that txn_id has not been previously processed
			// check that receiver_email is your PayPal email
			// check that payment_amount/payment_currency are correct
			// process payment and mark item as paid.
			// assign posted variables to local variables
			//$item_name = $_POST['item_name'];
			//$item_number = $_POST['item_number'];
			//$payment_status = $_POST['payment_status'];
			//$payment_amount = $_POST['mc_gross'];
			//$payment_currency = $_POST['mc_currency'];
			//$txn_id = $_POST['txn_id'];
			//$receiver_email = $_POST['receiver_email'];
			//$payer_email = $_POST['payer_email'];
			
			if(DEBUG == true) {					
				//error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, LOG_FILE);
				$log .= "5. Verified IPN ".date('[Y-m-d H:i:s e] ').": \n$req "."\n\n";
			}
			
			
		} else if (strcmp ($res, "INVALID") == 0) {
			// log for manual investigation
			// Add business logic here which deals with invalid IPN messages
			if(DEBUG == true) {
				//error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req". PHP_EOL, 3, LOG_FILE);
				$log .= "5. Invalid IPN ".date('[Y-m-d H:i:s e] ').": \n$req"."\n\n";
			}
		}
		
		$path = $_SERVER[DOCUMENT_ROOT]."/paypal/".date("Ymd")."/";
			
		if(!is_dir($path)) {
			@mkdir($path,0777,true);
		}
		
		$file_name = "payment_".date("His");
		
		file_put_contents($path.$file_name, $log);
		
		exit;
	}
	
	else if($mode == "return2") {?>
		<script src="/kor/js/jquery-1.11.3.min.js"></script>
		<script src="/kor/js/common.js"></script>
		<script src="/include/function.js"></script>

		<SCRIPT LANGUAGE="JavaScript">
		<!--

			function pay(){
				var f =  document.f;
				var formData = $("#f").serialize(); 
				$.ajax({
						url: "/kor/proc/odr_proc.php", 
						data: formData,
						encType:"multipart/form-data",
						success: function (data) {	
							//var splData = data.split(":");
							if (trim(data) == "SUCCESS"){			
								opener.location.href='/kor/';						
								window.close();
							}else{
								alert(data);
							}
						}
				});		

			}

			function pay2(){
				var f =  document.f;
				var formData = $("#f").serialize(); 
				
				$.ajax({
						url: "/kor/proc/memfee_proc.php", 
						data: formData,
						encType:"multipart/form-data",
						success: function (data) {	
							//var splData = data.split(":");
							if (trim(data) == "SUCCESS"){			
								opener.closeCommLayer("layer4")
								opener.closeCommLayer("layer5")
								opener.showajaxParam("#memfeeleftTop", "memfee1", "");
								opener.showajaxParam("#memfeeleftBottom", "memfee2", "");
								window.close();
							}else{
								alert(data);
							}
						}
				});		

			}
			
		//-->
		</SCRIPT>
		<body onload="pay<?=$charge_type=="14"?"2":""?>();">
		<form name="f" id="f">
			<!-- form1 -->
			<input type="hidden" name="typ" id="typ" value="<?=$typ?>">
			<input type="hidden" name="memfee_id" id="memfee_id" value="<?=$memfee_id?>">
			<input type="hidden" name="mem_idx" id="mem_idx" value="<?=$session_mem_idx?>">
			<input type="hidden" name="rel_idx" id="rel_idx" value="<?=$session_rel_idx?>">	
			<input type="hidden" name="tot_amt" id="tot_amt" value="<?=$tot_amt?>">		
			<input type="hidden" name="sell_mem_idx" id="sell_mem_idx" value="<?=$sell_mem_idx?>">		
			<input type="hidden" name="sell_rel_idx" id="sell_rel_idx" value="<?=$sell_rel_idx?>">		
			<input type="hidden" name="odr_idx" id="odr_idx" value="<?=$odr_idx?>">		
			<input type="hidden" name="odr_det_idx" id="odr_det_idx" value="<?=$odr_det_idx?>">		
			<input type="hidden" name="charge_method" id="charge_method" value="1">		
			<input type="hidden" name="charge_type" id="charge_type" value="<?=$charge_type?>">		
			
			<!-- //form1 -->
		</form>
		</body>

	<?
	exit;
	
	}
	
	
?>

<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>PARTStrike</title>

<body onload="document.payform.submit();">
<form name="payform" action="<?=$paypal_url?>" method="post">
	<!-- PAYPAL form list -->
	<input type="hidden" name="cmd" value="_xclick" />
	<input type="hidden" name="business" value="<?=$business?>" />
	<input type="hidden" name="invoice" value="<?=$item_number?>" />
	<input type="hidden" name="currency_code" value="<?=$currency_code?>" />
	<input type="hidden" name="return" value="<?=$return_url?>"/>
	<input type="hidden" name="cancel_return" value="<?=$cancel_url?>"/>
	<input type="hidden" name="lc" value="US" />
	<input type="hidden" name="charset" value="utf-8" />

	
	<!--<label for="item_name">상품명</label>--><input type="hidden" name="item_name" id="item_name" value="<?=$item_name?>" /><br />
	<!--<label for="amount">가격</label>--><input type="hidden" name="amount" id="amount" value="<?=$amount?>" /><br /><br />
</form>
<!--form name="payform">	
<table><tr><td>	odr_idx :</td><td> <input type="text" name="odr_idx" value="<?=$odr_idx?>"></td></tr>
	<tr><td>odr_det_idx :</td><td> <input type="text" name="odr_det_idx" value="<?=$odr_det_idx?>"></td></tr>
	<tr><td>tot_amt($) :</td><td> <input type="text" name="tot_amt" value="<?=$tot_amt?>"></td></tr>
	<tr><td>fromLoadPage : </td><td><input type="text" name="fromLoadPage" value="<?=$fromLoadPage?>"></td></tr>
	<tr><td>deposit_yn :</td><td> <input type="text" name="deposit_yn" value="<?=$deposit_yn?>"></td></tr>
	<tr><td>charge_type :</td><td> <input type="text" name="charge_type" value="<?=$charge_type?>"></td></tr>
	<tr><td><button type="button">PAY</button></td></tr>
	
</form-->
</body>

</html>