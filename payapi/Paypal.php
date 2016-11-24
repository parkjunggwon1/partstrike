<?
   // PayPal Integrator Class v1.3
   // Developer: Chris Fleizach
   // chris@fleizach.com
   // http://apapi.sourceforge.net/
   //
   //  require_once('Paypal.php');
   //  $p = new Paypal();
   //  $p->SetEmail("person@email.com");
   //  $p->SetPassword("mypass");
   //  $p->SetCurrency("USD");  
   //
   //  $balance = $p->GetBalance();

class Paypal {

	var $email,$password,$pp0,$pp1,$curlsys,$results_data, $curlphp, $cookiefile, $useragent, $currency;
	function Paypal() {
		$this->pp0 = "https://www.paypal.com";
		$this->pp1 = "https://www.paypal.com/cgi-bin/webscr?cmd=_login-submit";
		$this->curlsys = exec("which curl");
		$this->cookiefile = ".paypal.cookies";
		$this->useragent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
	}

	function SetEmail($email) {
		$this->email = $email;
	}

	function SetCurrency($curr) {
		$this->currency = $curr;
	}

	function SetPassword($password) {
		$this->password = $password;
	}

	function GetTransactions() {
		$results = $this->ScreenScraper();
		$trs = split("<tr[^>.]*>",$results);
		
		$transactions = array();
		$timetoget = false;
		for ($k = 0; $k < sizeof($trs); $k++) {
			if ($timetoget == true) {
				if (preg_match("/File Selected Items/",$trs[$k]) ) {
					break;
				}
	            		else {
					$tds = preg_split("/<td[^>.]*>/",$trs[$k]);
					$temp = implode("~~~",$tds);
					$temp = strip_tags($temp);
					$tds = explode("~~~",$temp);
					$type = trim($tds[2]);
		   			$tofrom = trim($tds[3]);
		            		$nameemail = trim($tds[4]);
					$date = trim($tds[5]);
					$status = trim($tds[6]);
		            		$amount = trim($tds[9]);
		            		$fee = trim($tds[10]);
		            
		            	$array = array("type" => $this->utfize($type),
		                    "tofrom" =>  $this->utfize($tofrom),
		                    "nameemail" =>  $this->utfize($nameemail),
		                    "date" =>  $this->utfize($date),
		                    "status" =>  $this->utfize($status),
		                    "amount" =>  $this->utfize($amount),
		                    "fee" =>  $this->utfize($fee));
		            	array_push($transactions,$array);
	            		}
			}
	        	else {
				if (preg_match("/File/",$trs[$k]) && preg_match("/Type/",$trs[$k]) &&
					preg_match("/Details/",$trs[$k]) && preg_match("/Status/",$trs[$k])) {
					$timetoget = true;
				}
			}
		}
		return $transactions;
	}

	function RemoveInvalidCookies() {
		$fh = fopen($this->cookiefile,"r");
		$cookiedata = fread($fh,filesize($this->cookiefile)); $cookiedata = explode("\n",$cookiedata);
		fclose($fh);
		
		$fh = fopen($this->cookiefile,"w");
		foreach ($cookiedata as $line) {
			if (! preg_match("/feel_cookie/",$line) ) {
				fwrite($fh,$line . "\n");
			}
		}
		fclose($fh);
	}

	function GetWebpage($url,$data,$type = '') {


		if ($this->curlsys ) {
			$server = $this->curlsys . " $type -A \"$this->useragent\"  -s -L -i -b " . $this->cookiefile . " -c " . $this->cookiefile . " -m 120 -d \"$data\" \"$url\"";
			exec($server,$return_message_array, $return_number);
		}
		else {
		        $this->curlphp = curl_init();
		        curl_setopt($this->curlphp, CURLOPT_URL, $url);
	        	curl_setopt($this->curlphp, CURLOPT_FOLLOWLOCATION, 1);
		        curl_setopt($this->curlphp, CURLOPT_COOKIEJAR, COOKIE_FILE_PATH);
		        curl_setopt($this->curlphp, CURLOPT_TIMEOUT, 120);
	       		curl_setopt($this->curlphp, CURLOPT_POST, 1);
		        curl_setopt($this->curlphp, CURLOPT_HEADER, 1);
		        curl_setopt($this->curlphp, CURLOPT_POSTFIELDS, $data);
	       		curl_setopt ($this->curlphp, CURLOPT_COOKIEFILE, COOKIE_FILE_PATH);
		        curl_setopt($this->curlphp, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($this->curlphp, CURLOPT_USERAGENT,$this->useragent);
		        $return_message_array = explode("\n",curl_exec($this->curlphp));
		        curl_close($this->curlphp);
		}
		$this->RemoveInvalidCookies();
		$results = join("\n",$return_message_array);
		return $results;
	}

	function ScreenScraper() {
		if ($this->results_data) {
			return $this->results_data;
		}

		// Step 0: get the dispatch code
		$results = $this->GetWebpage($this->pp0,"");
		preg_match("/name=\"login_form\"\s+action=(.*)dispatch=(.*)\">/",$results,$matches);
		$dispatch = $matches[2];		

		$this->pp1 .= "&dispatch=$dispatch";
		$data = "login_email=" . $this->email . "&login_password=" . $this->password . "&submit.x=Log%20In&form_charset=UTF-8";
		$results = $this->GetWebpage($this->pp1,$data);


	    	if (!file_exists($this->cookiefile) && $this->curlsys) {
			echo "Could not create cookie file. Please make sure your web server user
				can write to this folder or alternatively, make an empty file called
				'.paypal.cookies' and chmod it 777";
			exit();
	    	}
	
		$URLline = "";
		$return_message_array = explode("\n",$results);
		for ($k = 0; $k < sizeof($return_message_array); $k++) {
			$line = $return_message_array[$k];
			if (preg_match("/^Refresh:/",$line)) {
				$URLline = $line;
			}
		}

 	       $arr = split(";",$URLline);
        	$urldata = split("=",$arr[1],2);
        	$pp2 = $urldata[1];

		if ($pp2) {		
			$this->results_data = $this->GetWebpage($pp2,$data);
		}
		// delete the cookie		
            	$fh = fopen($this->cookiefile, 'w');
            	fclose($fh);

		return $this->results_data;
     }
                 
     function GetBalance() {
        $results = $this->ScreenScraper();
	$half = explode("javascript:openWindowQuestionAccountBalance();",$results);
	$half = explode($this->currency,$half[1]);

	$half = $half[0];
        $bal = explode("<td class=\"small\" align=\"center\">",$half);	
	$money = $bal[1];
       
        $money =  $this->utfize($money);
        return $money;
     }

                         
	function utfize($val) {
		return trim(preg_replace("/[^a-zA-Z0-9_\xC0-\xFF,.'~ -]/","",utf8_decode(strip_tags($val))));
	}
                 
     function GetMultipleBalances() {
		$results = $this->ScreenScraper();
		
		$trs = preg_split("/<tr.*>/",$results);
		
		$money = array();
		for ($k =0; $k < sizeof($trs); $k++) {
			if (preg_match("/Current Total/",$trs[$k])) {
				$lines = preg_split("/<td[^>.]*>/",$trs[$k]);
		        for ($j = 0; $j < sizeof($lines); $j++) {
					if ($lines[$j] == "") { next; }
					if (preg_match("/Current Total/",$lines[$j])) {
						$bal = explode("</td>",$lines[$j+1]);
						$bal = $bal[0];
						$items = explode(" ",$bal);
						$items[0] =   $this->utfize($items[0]);
						array_push($money,$items);
					}
				}
			}
		}                
        return $money;
	}                        
}
                        
                        
?>
                        
                        
                        
                                        
