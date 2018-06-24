<?php
session_start();

// 身分驗證
if($_SESSION['valid_token'] != "3") {
	header('Location: index.php');
	exit;
}
set_time_limit(0);
require_once("conn/db.php");
require_once("function_lib.php");
require_once("conn/mail.php");

//接收變數
$subject=$_POST["subject"];
$recipient=$_POST["recipient"];
$content=nl2br($_POST["content"]);
//var_dump($recipient);
//echo "<BR>"; 

$mail->Subject = $subject; //設定郵件標題
$mail->Body = "<div style='border-style: dashed;'>".$content."</div>";  //設定郵件內容   
$record=array();
$record["count"]=0;
$record["success"]=array();
$record["failure"]=array();

$begin = cacutime();
ignore_user_abort();
send_to_all_recipient($db,$mail,$subject,$recipient,$content,$record);
send_record($db,$mail,$subject,$recipient,$content,$record);

$end = cacutime();
				
// 執行花費時間
$timediff = $end - $begin;
echo "<h2>費時 $timediff 秒</h2>";

function send_to_all_recipient($db,$mail,$subject,$recipient,$content,$record){
	// 取出資料
	$year = date("Y");
	if (in_array("grade_3_warning", $recipient)) {
		echo "grade_3_warning";
		$sql = 
			"SELECT user_student,user_name,user_dep,user_email ".
			"FROM `all_user` ".
			"WHERE ".
				"`user_student` LIKE ".($year-1914)."'%' AND ".
				"`qualified` = 0 AND ".
				"`user_del` = 0 ".
			"ORDER BY `user_dep_id` DESC ";
		$ret = mysql_query($sql, $db) or die(mysql_error());
		$count = mysql_num_rows($ret);
		echo $count;
		echo "<BR>"; 
		while($row = mysql_fetch_assoc($ret))
		{
			mail_handler($db,$mail,$subject,$recipient,$content,$record,$row);
		}
	}
	if (in_array("grade_4_warning", $recipient)) {
		echo "grade_4_warning";
		$sql = 
			"SELECT user_student,user_name,user_dep,user_email ".
			"FROM `all_user` ".
			"WHERE ".
				"`user_student` LIKE ".($year-1915)."'%' AND ".
				"`qualified` = 0 AND ".
				"`user_del` = 0 ".
			"ORDER BY `user_dep_id` DESC ";
		$ret = mysql_query($sql, $db) or die(mysql_error());
		$count = mysql_num_rows($ret);
		echo $count;
		echo "<BR>";
		while($row = mysql_fetch_assoc($ret))
		{
			mail_handler($db,$mail,$subject,$recipient,$content,$record,$row);
		}
	}
}

function alertlist_to_dep(){
	$sql_grade3 = 
			"SELECT user_student,user_name,user_dep,user_email ".
			"FROM `all_user` ".
			"WHERE ".
				"`user_student` LIKE ".($year-1914)."'%' AND ".
				"`qualified` = 0 AND ".
				"`user_del` = 0 ".
			"ORDER BY `user_dep_id` DESC ";
	$sql_grade4 = 
			"SELECT user_student,user_name,user_dep,user_email ".
			"FROM `all_user` ".
			"WHERE ".
				"`user_student` LIKE ".($year-1915)."'%' AND ".
				"`qualified` = 0 AND ".
				"`user_del` = 0 ".
			"ORDER BY `user_dep_id` DESC ";
}

function mail_handler($db,$mail,$subject,$recipient,$content,$record,$row){
	$record["count"]++;
	$mail->AddAddress($row["user_email"], $row["user_name"]); //設定收件者郵件及名稱	
	echo $row["user_dep"]." ".$row["user_student"]." ".$row["user_name"];
	send_mail($db,$mail,$subject,$recipient,$content,$record,$row);
	$mail->ClearAllRecipients( ); // clear all
	if($record["count"]%10==0){
		sleep(10);
	}
}

function send_mail($db,$mail,$subject,$recipient,$content,$record,$row){
	if($mail->Send()) {   
		echo " <B>信件已成功寄出!</B><BR>";  
		array_push($record["success"],$row);	
	}
	else{   
		echo " <B>發信失敗，錯誤訊息如下</B>: " . $mail->ErrorInfo."<BR>";
		array_push($row,$mail->ErrorInfo);
		array_push($record["failure"],$row);			
	}
}

function send_record($db,$mail,$subject,$recipient,$content,$record){
	sleep(30);
	$mail->AddAddress("sg123411@gmail.com", "網管"); //設定收件者郵件及名稱
	$mail->Subject ="發信紀錄-".$subject;
	
	$msg="<div style='border-style: dashed;'>".$content."</div>".
		"共".$record["count"]."封<br>".
		"成功：".count($record["success"])."封<br>".
		"失敗：".count($record["failure"])."封<br>".
		"成功名單：".var_dump($record["success"])."<br>".
		"失敗名單：".var_dump($record["failure"])."<br>";
	$mail->Body = $msg ;  //設定郵件內容
	
	if($mail->Send()) {   
		echo " <B>發信紀錄信件已成功寄出!</B><BR>";  	
	}
	else{   
		echo " <B>發信紀錄，發信失敗，錯誤訊息如下</B>: " . $mail->ErrorInfo."<BR>";		
	}
}

function cacutime()
	{	
		$time = explode(" ", microtime());
		$usec = (double)$time[0];
		$sec = (double)$time[1];
		
		return $sec + $usec; 
	}
?>