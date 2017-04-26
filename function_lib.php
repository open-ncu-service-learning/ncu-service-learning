<?php
	// utf-8:$byte=3 | gb2312:$byte=2 | big5:$byte=2
	function bite_str($string, $start, $len, $byte=3)
	{
		$str     = "";
		$count   = 0;
		$str_len = strlen($string);
		for ($i=0; $i<$str_len; $i++) {
			if (($count+1-$start)>$len) {
				$str  .= "...";
				break;
			} elseif ((ord(substr($string,$i,1)) <= 128) && ($count < $start)) {
				$count++;
			} elseif ((ord(substr($string,$i,1)) > 128) && ($count < $start)) {
				$count = $count+2;
				$i     = $i+$byte-1;
			} elseif ((ord(substr($string,$i,1)) <= 128) && ($count >= $start)) {
				$str  .= substr($string,$i,1);
				$count++;
			} elseif ((ord(substr($string,$i,1)) > 128) && ($count >= $start)) {
				$str  .= substr($string,$i,$byte);
				$count = $count+2;
				$i     = $i+$byte-1;
			}
		}
		return $str;
	}

	function DateDiff($date1, $date2, $unit = "")
	{
		switch ($unit)
		{
			case 's':
				$dividend = 1;
				break;
			case 'i':
				$dividend = 60;
				break;
			case 'h':
				$dividend = 3600;
				break;
			case 'd':
				$dividend = 86400;
				break;
			default:
				$dividend = 86400;
		}
		$time1 = strtotime($date1);
		$time2 = strtotime($date2);
		if($time1 && $time2)
			return (float)($time1 - $time2) / $dividend;
		return false;
	}

	// 判斷護照類別
	function judgePassport($serviceHour) {
		// 規定
		$service	= 50;
		$life		= 30;
		$art		= 20;
		$silver     = 30;
		$gold       = 60;

		if($serviceHour[0] >= $service && $serviceHour[2] >= $life && $serviceHour[4] >= $art) {
			if($serviceHour[1] >= $silver && $serviceHour[3] >= $silver && $serviceHour[5] >= $silver && $serviceHour[1]+$serviceHour[3]+$serviceHour[5] >= 100) {
				if($serviceHour[1] >= $gold && $serviceHour[3] >= $gold && $serviceHour[5] >= $gold && $serviceHour[1]+$serviceHour[3]+$serviceHour[5] >= 200) {
					return 3; // gold
				}
				return 2; // silver
			}
			return 1; // basic
		}
		else {
			return 0;
		}
	}

	function judgePassport2($serviceHour) {
		// 規定
		$service	= 50;
		$life		= 30;
		$art		= 20;
		$silver     = 30;
		$gold       = 60;

		if($serviceHour[0] >= $service && $serviceHour[2] >= $life && $serviceHour[4] >= $art) {
			if($serviceHour[1] >= $silver && $serviceHour[3] >= $silver && $serviceHour[5] >= $silver && $serviceHour[1]+$serviceHour[3]+$serviceHour[5] >= 100) {
				if($serviceHour[1] >= $gold && $serviceHour[3] >= $gold && $serviceHour[5] >= $gold && $serviceHour[1]+$serviceHour[3]+$serviceHour[5] >= 200) {
					return 3; // gold
				}
				$sv=2;

				if(($serviceHour[1]-$silver)>=20) $sv+=0.2;
				if(($serviceHour[3]-$silver)>=20) $sv+=0.2;
				if(($serviceHour[5]-$silver)>=20) $sv+=0.2;
				if(($serviceHour[1]+$serviceHour[3]+$serviceHour[5]-100)>=900) $sv+=0.4;

				/*$sv+=(($serviceHour[1]-$silver)/30)*(1/4);
				$sv+=(($serviceHour[3]-$silver)/30)*(1/4);
				$sv+=(($serviceHour[5]-$silver)/30)*(1/4);
				$sv+=(($serviceHour[1]+$serviceHour[3]+$serviceHour[5]-100)/100)*(1/4);*/

				return $sv; // silver
			}
			return 1; // basic
		}
		else {
			return 0;
		}
	}

	function admit_hour_to_student($student,$in_or_out,$act_id){

	}
?>