<?


header("Content-Type: text/html; charset=UTF-8");

function agency_won()
{

	$json_string = 'http://fx.keb.co.kr/FER1101M.web';

	$jsondata = file_get_contents($json_string);
	$jsondata  = iconv("euc-kr", "utf-8", $jsondata );



	$str = explode(" = ", $jsondata);


	$a = strstr($str[1], "리스트");


	$a = str_replace('"', '', $a);

	$a = str_replace(']', '', $a);

	$b = explode("[", $a);

	$c = explode("}", $b[1]);

	foreach($c as $k => $d){

		if($k != 0) {

			$l = strlen( $d );

			$d = substr($d, 1, $l);

		}

		

		$e = explode(",", $d);

		

		foreach($e as $key => $val){

			

			if($key == 0){

				$val = str_replace('{', '', $val);

				$f = explode(": ", $val);



				$g = explode(" ", $f[1]);

				$country[] = $g[0];

				$country_code[] = $g[1];

			}

			

			

			if($key == 1){

				$f = explode(":", $val);

				$cash_to_buy[] = $f[1];

			}

			

			if($key == 2){

				$f = explode(":", $val);

				$cash_to_sell[] = $f[1];

			}

			

			if($key == 3){

				$f = explode(":", $val);

				$remittance_send[] = $f[1];

			}

			

			if($key == 4){

				$f = explode(":", $val);

				$remittance_recive[] = $f[1];

			}

			

			if($key == 5){

				$f = explode(":", $val);

				$ms_rate[] = $f[1];

			}

			

		}

	}


	foreach($country as $k2 => $cn){

		if($cn != ''){

			$sql ="			

				나라 = '".$cn."',

				매매기준율= '".$ms_rate[$k2]."',

				송금_전신환 보낼때 = '".$remittance_send[$k2]."',

				현찰살때 = '".$cash_to_buy[$k2]."',

				현찰팔때 = '".$cash_to_sell[$k2]."',

				송금 전신환 받을때 = '".$remittance_recive[$k2]."',

				나라코드 = '".$country_code [$k2]."'

				<br>

			";

			if ($country_code [$k2]=="USD")
			{
				$won_change = $remittance_send[$k2];
			}
		}

	}

	
	return $won_change;
	exit;

}

?>
