<?php
	require_once("function_lib.php");
	
	function rule103($bsc_serv, $bsc_life, $bsc_art,
					$adv_serv, $adv_life, $adv_art, 
					$totalHour, $qualify)
	{
		$qual_serv=50;
		$qual_life=30;
		$qual_art=20;
		
		if($bsc_serv > $qual_serv){
			$adv_serv += $bsc_serv - $qual_serv;
			$bsc_serv = $qual_serv;
		}
		if($bsc_life > $qual_life){
			$adv_life += $bsc_life - $qual_life;
			$bsc_life = $qual_life;
		}
		if($bsc_art > $qual_art){
			$adv_art += $bsc_art - $qual_art;
			$bsc_art = $qual_art;
		}		
				
		$basicHour = $bsc_serv + $bsc_life + $bsc_art;
		$advanHour = $adv_serv + $adv_life + $adv_art;
		
		$serviceHour = array($adv_serv, $adv_life, $adv_art);
		$passportType = judgePassport_3row($qualify, $serviceHour);
			
		$string = "";
		switch($passportType) {
			case 0:
				$string = "尚未通過畢審門檻!";
				break;
			case 1:
				$string = "<img src='images/basic.png' alt='基本' style='width: 150px; float: left;' />";
				break;
			case 2:
				$string = "<img src='images/silver.png' alt='銀質獎' style='width: 150px; float: left;' />";
				break;
			case 3:
				$string = "<img src='images/gold.png' alt='金質獎' style='width: 150px; float: left;' />";
				break;
		}
?>
	<br />
	<p>
		<span style="color: #FF0022;">總時數: <?=$totalHour?></span>
		<span style="color: #002DFF;">基本: <?=$basicHour?></span>
		<span style="color: #FF7A0F;">高階: <?=$advanHour?></span>
	</p>
	<?=$string?>
	<table width="700" border="1" cellpadding="0" cellspacing="0">
		<tr align="center">
			<td width="140"><span style="color: #0F50FF; font-size: 18pt;">總時數</span></td>
			<td width="140"><span style="color: #0F50FF; font-size: 18pt;">服務學習</span></td>
			<td width="140"><span style="color: #0F50FF; font-size: 18pt;">生活知能</span></td>
			<td width="140"><span style="color: #0F50FF; font-size: 18pt;">人文藝術</span></td>
		</tr>
		<tr>
			<td align="center" style="color: #FF0022;">畢業門檻</td>
			<td align="center" style="color: #FF0022;"><?=$qual_serv?></td>
			<td align="center" style="color: #FF0022;"><?=$qual_life?></td>
			<td align="center" style="color: #FF0022;"><?=$qual_art?></td>
		</tr>
		<tr>
			<td align="center">基本時數</td>
			<td align="center"><?=$bsc_serv?><font color="red"> / <?=$qual_serv?></font></td>
			<td align="center"><?=$bsc_life?><font color="red"> / <?=$qual_life?></font></td>
			<td align="center"><?=$bsc_art?><font color="red"> / <?=$qual_art?></font></td>
		</tr>
		<tr>
			<td align="center">高階時數</td>
			<td align="center"><?=$adv_serv?></td>
			<td align="center"><?=$adv_life?></td>
			<td align="center"><?=$adv_art?></td>
		</tr>
	</table>

<?php		
	}
?>

<?php
	function rule104($bsc_serv, $bsc_life, $bsc_art,
					$adv_serv, $adv_life, $adv_art,
					$ass_fre, $ass_dep, $totalHour, $qualify)
	{
		$qual_serv=50;
		$qual_life=30;
		$qual_art=20;
		
		$qual_assFre=4;
		$qual_assDep=2;
		
		if($bsc_serv > $qual_serv){
			$adv_serv += $bsc_serv - $qual_serv;
			$bsc_serv = $qual_serv;
		}
		if($bsc_life > $qual_life){
			$adv_life += $bsc_life - $qual_life;
			$bsc_life = $qual_life;
		}
		if($bsc_art > $qual_art){
			$adv_art += $bsc_art - $qual_art;
			$bsc_art = $qual_art;
		}		
				
		$basicHour = $bsc_serv + $bsc_life + $bsc_art;
		$advanHour = $adv_serv + $adv_life + $adv_art;
		$serviceHour = array($adv_serv, $adv_life, $adv_art);
		
		$passportType = judgePassport_3row($qualify, $serviceHour);
			
		$string = "";
		switch($passportType) {
			case 0:
				$string = "尚未通過畢審門檻!";
				break;
			case 1:
				$string = "<img src='images/basic.png' alt='基本' style='width: 100px; float: left;' />";
				break;
			case 2:
				$string = "<img src='images/silver.png' alt='銀質獎' style='width: 150px; float: left;' />";
				break;
			case 3:
				$string = "<img src='images/gold.png' alt='金質獎' style='width: 150px; float: left;' />";
				break;
		}
?>
	<br />
	<p>
		<span style="color: #FF0022;">總時數: <?=$totalHour?></span>
		<span style="color: #002DFF;">基本: <?=$basicHour?></span>
		<span style="color: #FF7A0F;">高階: <?=$advanHour?></span>
	</p>
	<?=$string?>
	<table width="700" border="1" cellpadding="0" cellspacing="0">
		<tr align="center">
			<td width="140"><span style="color: #0F50FF; font-size: 18pt;">總時數</span></td>
			<td width="140"><span style="color: #0F50FF; font-size: 18pt;">服務學習</span></td>
			<td width="140"><span style="color: #0F50FF; font-size: 18pt;">生活知能</span></td>
			<td width="140"><span style="color: #0F50FF; font-size: 18pt;">人文藝術</span></td>
		</tr>
		<tr>
			<td align="center" style="color: #FF0022;">畢業門檻</td>
			<td align="center" style="color: #FF0022;"><?=$qual_serv?></td>
			<td align="center" style="color: #FF0022;"><?=$qual_life?></td>
			<td align="center" style="color: #FF0022;"><?=$qual_art?></td>
		</tr>
		<tr>
			<td align="center">基本時數</td>
			<td align="center"><?=$bsc_serv?><font color="red"> / <?=$qual_serv?></font></td>
			<td align="center"><?=$bsc_life?><font color="red"> / <?=$qual_life?></font></td>
			<td align="center"><?=$bsc_art?><font color="red"> / <?=$qual_art?></font></td>
		</tr>
		<tr>
			<td align="center">高階時數</td>
			<td align="center"><?=$adv_serv?></td>
			<td align="center"><?=$adv_life?></td>
			<td align="center"><?=$adv_art?></td>
		</tr>
	</table>
	<br />
	<table width="700" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td><span style="color: #0F50FF; font-size: 18pt;"></span></td>
			<td aligh="center" style="color: #FF0022;">門檻</td>
			<td aligh="center">已參加</td>
		</tr>
		<tr>
			<td><span style="color: #0F50FF; font-size: 14pt;">大一週會(次數)</span></td>
			<td aligh="center" style="color: #FF0022;"><?=$qual_assFre?></td>
			<td aligh="center"><?=$ass_fre?></td>
		</tr>
		<tr>
			<td><span style="color: #0F50FF; font-size: 14pt;">院週會(次數)</span></td>
			<td aligh="center" style="color: #FF0022;"><?=$qual_assDep?></td>
			<td aligh="center"><?=$ass_dep?></td>
		</tr>
	</table>
	
<?php	
	}
?>

<?php
	function rule105($bsc_serv, $bsc_life, $bsc_art, $bsc_inter,
					$adv_serv, $adv_life, $adv_art, $adv_inter,
					$ass_fre, $ass_dep, $cpr, $career, $totalHour, $qualify)
	{
		$qual_serv=40;
		$qual_life=40;
		$qual_art=20;
		
		$qual_inter=5;
		$qual_assFre=4;
		$qual_assDep=2;
		$qual_cpr=5;
		$qual_career=10;
		
		if($bsc_serv > $qual_serv){
			$adv_serv += $bsc_serv - $qual_serv;
			$bsc_serv = $qual_serv;
		}
		if($bsc_life > $qual_life){
			$adv_life += $bsc_life - $qual_life;
			$bsc_life = $qual_life;
		}
		if($bsc_art > $qual_art){
			$adv_art += $bsc_art - $qual_art;
			$bsc_art = $qual_art;
		}		
				
		$basicHour = $bsc_serv + $bsc_life + $bsc_art;
		$advanHour = $adv_serv + $adv_life + $adv_art;
		$serviceHour = array($adv_serv, $adv_life, $adv_art);
		$interTotal = $bsc_inter + $adv_inter;
		$passportType = judgePassport_3row($qualify, $serviceHour);
			
		$string = "";
		switch($passportType) {
			case 0:
				$string = "尚未通過畢審門檻!";
				break;
			case 1:
				$string = "<img src='images/basic.png' alt='基本' style='width: 150px; float: left;' />";
				break;
			case 2:
				$string = "<img src='images/silver.png' alt='銀質獎' style='width: 150px; float: left;' />";
				break;
			case 3:
				$string = "<img src='images/gold.png' alt='金質獎' style='width: 150px; float: left;' />";
				break;
		}
?>
	<br />
	<p>
		<span style="color: #FF0022;">總時數: <?=$totalHour?></span>
		<span style="color: #002DFF;">基本: <?=$basicHour?></span>
		<span style="color: #FF7A0F;">高階: <?=$advanHour?></span>
	</p>
	<?=$string?>
	<table width="700" border="1" cellpadding="0" cellspacing="0">
		<tr align="center">
			<td width="140"><span style="color: #0F50FF; font-size: 18pt;">總時數</span></td>
			<td width="140"><span style="color: #0F50FF; font-size: 18pt;">服務學習</span></td>
			<td width="140"><span style="color: #0F50FF; font-size: 18pt;">生活知能</span></td>
			<td width="140"><span style="color: #0F50FF; font-size: 18pt;">人文藝術</span></td>
		</tr>
		<tr>
			<td align="center" style="color: #FF0022;">畢業門檻</td>
			<td align="center" style="color: #FF0022;"><?=$qual_serv?></td>
			<td align="center" style="color: #FF0022;"><?=$qual_life?></td>
			<td align="center" style="color: #FF0022;"><?=$qual_art?></td>
		</tr>
		<tr>
			<td align="center">基本時數</td>
			<td align="center"><?=$bsc_serv?><font color="red"> / <?=$qual_serv?></font></td>
			<td align="center"><?=$bsc_life?><font color="red"> / <?=$qual_life?></font></td>
			<td align="center"><?=$bsc_art?><font color="red"> / <?=$qual_art?></font></td>
		</tr>
		<tr>
			<td align="center">高階時數</td>
			<td align="center"><?=$adv_serv?></td>
			<td align="center"><?=$adv_life?></td>
			<td align="center"><?=$adv_art?></td>
		</tr>
	</table>
	<br />
	<table width="700" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td><span style="color: #0F50FF; font-size: 18pt;"></span></td>
			<td aligh="center" style="color: #FF0022;">門檻</td>
			<td aligh="center">已參加</td>
		</tr>
		<tr>
			<td><span style="color: #0F50FF; font-size: 14pt;">大一週會(次數)</span></td>
			<td aligh="center" style="color: #FF0022;"><?=$qual_assFre?></td>
			<td aligh="center"><?=$ass_fre?></td>
		</tr>
		<tr>
			<td><span style="color: #0F50FF; font-size: 14pt;">院週會(次數)</span></td>
			<td aligh="center" style="color: #FF0022;"><?=$qual_assDep?></td>
			<td aligh="center"><?=$ass_dep?></td>
		</tr>
		<tr>
			<td><span style="color: #0F50FF; font-size: 14pt;">大一CPR(時數)</span></td>
			<td aligh="center" style="color: #FF0022;"><?=$qual_cpr?></td>
			<td aligh="center"><?=$cpr?></td>
		</tr>
		<tr>
			<td><span style="color: #0F50FF; font-size: 14pt;">自我探索與生涯規劃(時數)</span></td>
			<td aligh="center" style="color: #FF0022;"><?=$qual_career?></td>
			<td aligh="center"><?=$career?></td>
		</tr>
		<tr>
			<td><span style="color: #0F50FF; font-size: 14pt;">國際視野(時數)</span></td>
			<td aligh="center" style="color: #FF0022;"><?=$qual_inter?></td>
			<td aligh="center"><?=$interTotal?></td>
		</tr>
	</table>
<?php		
	}
?>

<?php
	function rule106($bsc_serv, $bsc_life, $bsc_art, $bsc_inter,
					$adv_serv, $adv_life, $adv_art, $adv_inter, 
					$ass_fre, $ass_dep, $cpr, $career, $totalHour, $qualify)
	{
		$qual_serv=40;
		$qual_life=35;
		$qual_art=20;
		$qual_inter=5;
		
		$qual_assFre=4;
		$qual_assDep=2;
		$qual_cpr=5;
		$qual_career=10;
		
		if($bsc_serv > $qual_serv){
			$adv_serv += $bsc_serv - $qual_serv;
			$bsc_serv = $qual_serv;
		}
		if($bsc_life > $qual_life){
			$adv_life += $bsc_life - $qual_life;
			$bsc_life = $qual_life;
		}
		if($bsc_art > $qual_art){
			$adv_art += $bsc_art - $qual_art;
			$bsc_art = $qual_art;
		}
		if($bsc_inter > $qual_inter){
			$adv_inter += $bsc_inter - $qual_inter;
			$bsc_inter = $qual_inter;
		}		
				
		$basicHour = $bsc_serv + $bsc_life + $bsc_art + $bsc_inter;
		$advanHour = $adv_serv + $adv_life + $adv_art + $adv_inter;
	
		$serviceHour =array($adv_serv, $adv_life, $adv_art, $adv_inter);
		$passportType = judgePassport_4row($qualify, $serviceHour);
		
		$string = "";
		switch($passportType) {
			case 0:
				$string = "尚未通過畢審門檻!";
				break;
			case 1:
				$string = "<img src='images/basic.png' alt='基本' style='width: 150px; float: left;' />";
				break;
			case 2:
				$string = "<img src='images/silver.png' alt='銀質獎' style='width: 150px; float: left;' />";
				break;
			case 3:
				$string = "<img src='images/gold.png' alt='金質獎' style='width: 150px; float: left;' />";
				break;
		}
?>
	<br />
	<p>
		<span style="color: #FF0022;">總時數: <?=$totalHour?></span>
		<span style="color: #002DFF;">基本: <?=$basicHour?></span>
		<span style="color: #FF7A0F;">高階: <?=$advanHour?></span>
	</p>
	<?=$string?>
	<table width="700" border="1" cellpadding="0" cellspacing="0">
		<tr align="center">
			<td width="140"><span style="color: #0F50FF; font-size: 18pt;">總時數</span></td>
			<td width="140"><span style="color: #0F50FF; font-size: 18pt;">服務學習</span></td>
			<td width="140"><span style="color: #0F50FF; font-size: 18pt;">生活知能</span></td>
			<td width="140"><span style="color: #0F50FF; font-size: 18pt;">人文藝術</span></td>
			<td width="140"><span style="color: #0F50FF; font-size: 18pt;">國際視野</span></td>
		</tr>
		<tr>
			<td align="center" style="color: #FF0022;">畢業門檻</td>
			<td align="center" style="color: #FF0022;"><?=$qual_serv?></td>
			<td align="center" style="color: #FF0022;"><?=$qual_life?></td>
			<td align="center" style="color: #FF0022;"><?=$qual_art?></td>
			<td align="center" style="color: #FF0022;"><?=$qual_inter?></td>
		</tr>
		<tr>
			<td align="center">基本時數</td>
			<td align="center"><?=$bsc_serv?><font color="red"> / <?=$qual_serv?></font></td>
			<td align="center"><?=$bsc_life?><font color="red"> / <?=$qual_life?></font></td>
			<td align="center"><?=$bsc_art?><font color="red"> / <?=$qual_art?></font></td>
			<td align="center"><?=$bsc_inter?><font color="red"> / <?=$qual_inter?></font></td>
		</tr>
		<tr>
			<td align="center">高階時數</td>
			<td align="center"><?=$adv_serv?></td>
			<td align="center"><?=$adv_life?></td>
			<td align="center"><?=$adv_art?></td>
			<td align="center"><?=$adv_inter?></td>
		</tr>
	</table>
	<br />
	<table width="700" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td><span style="color: #0F50FF; font-size: 18pt;"></span></td>
			<td aligh="center" style="color: #FF0022;">門檻</td>
			<td aligh="center">已參加</td>
		</tr>
		<tr>
			<td><span style="color: #0F50FF; font-size: 14pt;">大一週會(次數)</span></td>
			<td aligh="center" style="color: #FF0022;"><?=$qual_assFre?></td>
			<td aligh="center"><?=$ass_fre?></td>
		</tr>
		<tr>
			<td><span style="color: #0F50FF; font-size: 14pt;">院週會(次數)</span></td>
			<td aligh="center" style="color: #FF0022;"><?=$qual_assDep?></td>
			<td aligh="center"><?=$ass_dep?></td>
		</tr>
		<tr>
			<td><span style="color: #0F50FF; font-size: 14pt;">大一CPR(時數)</span></td>
			<td aligh="center" style="color: #FF0022;"><?=$qual_cpr?></td>
			<td aligh="center"><?=$cpr?></td>
		</tr>
		<tr>
			<td><span style="color: #0F50FF; font-size: 14pt;">自我探索與生涯規劃(時數)</span></td>
			<td aligh="center" style="color: #FF0022;"><?=$qual_career?></td>
			<td aligh="center"><?=$career?></td>
		</tr>
	</table>
<?php		
	}
?>