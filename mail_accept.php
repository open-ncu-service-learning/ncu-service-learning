<?php
// 建立 PHPMailer 物件及設定 SMTP 登入資訊
require_once("conn/mail.php");
 
// 執行 $mail->AddAddress() 加入收件者，可以多個收件者
$mail->AddAddress($row0['act_req_email'], "");
$mail->AddCC("ylhuang@cc.ncu.edu.tw", "");
 
$mail->WordWrap = 50; // set word wrap
//
//required from pass_toPost.php
//
$mail->CharSet = "utf-8";
// 電郵內容，以下為發送 HTML 格式的郵件
$mail->Subject = "核可郵件通知";
$mail->Body = "<li>服務學習：請於活動結束後五天內，將<u>個人心得</u>與<u>簽到單</u>一併交回。</li>
<li>生活知能：請於活動結束後五天內，依活動性質，將<u>反思紀錄表(輔/行訓)</u>、<u>會議紀錄(籌會)</u>與<u>簽到單</u>一併交回。</li>
<li>人文藝術：請於活動結束後五天內，將<u>簽到單</u>繳回。</li><br><br>
備註：<br>1.請於核可公告後一個禮拜內至服務學習辦公室領取「學生學習護照活動認證申請單回覆聯」；逾期者，為保護個資安全，將會進行銷毀，謝謝！
2.	活動請以線上方式申請，若無帳密，請至服務學習網表單下載，填寫後請送至本組。<br>
3.	簽到單請至服務學習網表單下載<font color='red'>本組所規定的專用簽到單</font>，並填上<u>活動編號</u>、<u>活動日期</u>及<u>活動名稱</u>。<br>
4.查詢活動編號及核可時數：<br>
(1)請至服務學習網( http://service-learning.ncu.edu.tw/ )<br>
(2)點選\"最新認證活動\"<br>
(3)點選\"活動類別\"<br>
(4)依據活動日期點選所申請的活動
5.	如有任何問題請至服務學習辦公室詢問，亦或撥分機57228（服務學習）57235（人文藝術）、57236（生活知能及國際視野）。";
//$mail->AltBody = "This is the text-only body";

if(!$mail->Send())
{
    echo "Message was not sent <p>";
    //echo "Mailer Error: " . $mail->ErrorInfo;
	echo
	"
		<script type=\"text/javascript\" charset=\"utf-8\">
			alert(\"信件發送失敗\");
			self.location.href='pass_activities_manage.php';
		</script>
	";

}
else{
	echo "Message has been sent";
	echo
		"
			<script type=\"text/javascript\" charset=\"utf-8\">
				alert(\"核可信件已發送\");
			</script>
		";
} 
//exit;