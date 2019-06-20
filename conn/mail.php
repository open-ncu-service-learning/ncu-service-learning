<?php
//echo !extension_loaded('openssl')?"Not Available<br>":"Available<br>";
include("PHPMailer\PHPMailerAutoload.php"); //匯入PHPMailer類別  
$mail= new PHPMailer(); //建立新物件   
$mail->IsSMTP(); //設定使用SMTP方式寄信   
$mail->SMTPKeepAlive = true;
$mail->SMTPAuth = true; //設定SMTP需要驗證   
$mail->Host = "smtp.ncu.edu.tw"; //設定SMTP主機   
$mail->Port = 587; //設定SMTP埠位，預設為25埠  
$mail->CharSet = "utf-8"; //設定郵件編碼   
$mail->SMTPAutoTLS = false;
$mail->Username = "ncu57235@ncu.edu.tw"; //設定驗證帳號   
$mail->Password = "Sld57235"; //設定驗證密碼   
$mail->From = "ncu57235@ncu.edu.tw"; //設定寄件者信箱   
$mail->FromName = "服務學習網"; //設定寄件者姓名   
$mail->IsHTML(true); //設定郵件內容為HTML  
$mail->SMTPDebug = 0; 
?>