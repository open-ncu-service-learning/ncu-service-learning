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
	
	function judgePassport_3row($graduate, $advHour) {
		// 各30%
		$silver     = 30;
		$gold       = 60;

		if($graduate==1) {
			if($advHour[0] >= $silver && $advHour[1] >= $silver && $advHour[2] >= $silver && $advHour[0]+$advHour[1]+$advHour[2] >= 100) {
				if($advHour[0] >= $gold && $advHour[1] >= $gold && $advHour[2] >= $gold && $advHour[0]+$advHour[1]+$advHour[2] >= 200) {
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
	function judgePassport_4row($graduate, $advHour) {
		// 各25%
		$silver     = 25;
		$gold       = 50;

		if($graduate==1) {
			if($advHour[0] >= $silver && $advHour[1] >= $silver && $advHour[2] >= $silver && $advHour[3] >= $silver && $advHour[0]+$advHour[1]+$advHour[2]+$advHour[3] >= 100) {
				if($advHour[0] >= $gold && $advHour[1] >= $gold && $advHour[2] >= $gold && $advHour[3] >= $gold && $advHour[0]+$advHour[1]+$advHour[2]+$advHour[3] >= 200) {
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
	
	//計算學生時數
	function calHours($row)
	{
		$sub_notyet = 0;
		
		if($row['user_student']>950000000)
			$semester = floor($row['user_student']/10000000);
		else
			$semester = floor($row['user_student']/1000000);
		
		if($semester<=104){  //104 & before
			$q1=50;
			$q2=30;
			$q3=20;
			if($semester==104){
				$sub_notyet += max(4-$row['assembly_freshman'], 0)*2;
				$sub_notyet += max(2-$row['assembly_dep'], 0)*2;
			}

		}
		if($semester==105)  //105
		{
			$q1=40;
			$q2=40;
			$q3=20;
			$sub_notyet += max(4-$row['assembly_freshman'], 0)*2;
			$sub_notyet += max(2-$row['assembly_dep'], 0)*2;
			$sub_notyet += max(10-$row['career'], 0);
			$sub_notyet += max(5-$row['cpr'], 0);
			$sub_notyet += max(5-($row['basic_inter']+$row['advan_inter']), 0);
		}
		if($semester>=106)  //106 & after
		{
			$q1 = 40;
			$q2 = 35;
			$q3 = 20;
			$q4 = 5;
			$sub_notyet += max(4-$row['assembly_freshman'], 0)*2;
			$sub_notyet += max(2-$row['assembly_dep'], 0)*2;
			$sub_notyet += max(10-$row['career'], 0);
			$sub_notyet += max(5-$row['cpr'], 0);
		}

		//轉時數
		$b1=$row['basic_service'];		
		$b2=$row['basic_life'];				
		$b3=$row['basic_art'];	
		$b4=$row['basic_inter'];
		
		if($b1 > $q1){
			$b1 = $q1;
		}
		if($b2 > $q2 - $sub_notyet){
			$b2 = $q2 - $sub_notyet;
		}
		if($b3 > $q3){
			$b3 = $q3;
		}
		if($semester>=106 && $b4 > $q4){
			$b4 = $q4;
		}
		return array($b1, $b2, $b3, $b4, $q1, $q2, $q3, $q4);
	}
?>

