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


alertlist_to_dep_g4($mail);
echo"<br>";
alertlist_to_dep_g3($mail);


function alertlist_to_dep_g4($mail){
	$sql = "SELECT * FROM ncu_dept";
	if($ret = mysql_query($sql))
	{
		while($row = mysql_fetch_assoc($ret))
		{
			$mail->ClearAllRecipients( ); // clear all
			$dep = $row['Title'];			
			$list = "";
			$addr = $row['office_mail'];
			
			$year = date("Y");
			
			$sql_grade4 = 
			"SELECT user_student,user_name,user_dep,user_dep_id,user_email ".
			"FROM `all_user` WHERE ".
			"`user_student` LIKE '".($year-1915)."%' AND ".
			"`user_dep_id` LIKE '".$row['dep_id']. "' AND ".
			"`qualified` = 0 AND `user_del` = 0 ";
			
			if($ret2 = mysql_query($sql_grade4))
			{
				
				$row2 = mysql_fetch_assoc($ret2);				
				while($row2 = mysql_fetch_assoc($ret2)){
					$list = $list.$row2['user_student']." ".$row2['user_name']."<br>";
				}				
			}
			if ($list!="")
			{
				echo "<br>".$dep."<br>";
				echo $list;
				$subject = $dep." 大四預警名單";
				
				$mail->Subject = $subject; //設定郵件標題
				$mail->Body = "<div>".$list."</div>";
				$mail->AddAddress($addr, $dep);
				$mail->AddCC('sg123411@gmail.com', '服務學習辦公室'); // 副本
				
				if($mail->Send()) {   
					echo $dep." <B>信件已成功寄出!</B><BR>";
				}
				else{   
					echo " <B>發信失敗，錯誤訊息如下</B>: " . $mail->ErrorInfo."<BR>";	
				}
				
				
			}			
		}
	}
}

function alertlist_to_dep_g3($mail){
	$sql = "SELECT * FROM ncu_dept";
	if($ret = mysql_query($sql))
	{
		while($row = mysql_fetch_assoc($ret))
		{
			$mail->ClearAllRecipients( ); // clear all
			$dep = $row['Title'];			
			$list = "";
			$addr = $row['office_mail'];
			
			$year = date("Y");
			
			$sql_grade3 = 
			"SELECT user_student,user_name,user_dep,user_dep_id,user_email ".
			"FROM `all_user` WHERE ".
			"`user_student` LIKE '".($year-1914)."%' AND ".
			"`user_dep_id` LIKE '".$row['dep_id']. "' AND ".
			"`qualified` = 0 AND `user_del` = 0 ";
			
			if($ret2 = mysql_query($sql_grade3))
			{
				$row2 = mysql_fetch_assoc($ret2);				
				while($row2 = mysql_fetch_assoc($ret2)){
					$list = $list.$row2['user_student']." ".$row2['user_name']."<br>";
				}				
			}
			if ($list!="")
			{
				echo "<br>".$dep."<br>";
				echo $list;
				$subject = $dep." 大三預警名單";
				
				$mail->Subject = $subject; //設定郵件標題
				$mail->Body = "<div>".$list."</div>";
				$mail->AddAddress($addr, $dep);
				$mail->AddCC('sg123411@gmail.com', '服務學習辦公室'); // 副本
				
				if($mail->Send()) {   
					echo $dep." <B>信件已成功寄出!</B><BR>";
				}
				else{   
					echo " <B>發信失敗，錯誤訊息如下</B>: " . $mail->ErrorInfo."<BR>";	
				}
				
				
			}			
		}
	}
}


?>