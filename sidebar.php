<style>
div {
	font-family:Microsoft JhengHei;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
	$("#form").hide();
    $("#login").click(function(){
        $("#form").show();
    });
});
</script>
<!-- Sidebar -->
			<div id="sidebar" style="width:24%; margin-left:-3%;">
				<div id="banner" style="margin-top: 15px;">

					<!--<a href="http://140.115.185.138/weeklylearning/Learning/Learning_index.php" title="大一週會報名區"><img src="images/banner/ncu_banner3.png" alt="大一週會報名區" width="160" height="50px" /></a><!--大一週會報名區<br> <font color="#ff0000" size="2">請於101年9月21日前完成報名</font></a>-->
					<a href="https://goo.gl/forms/RzpC5Q3tIaWfUnC52" title="東南亞國際志工團隊報名">東南亞國際志工團隊報名<br></a>
					<a href="https://www.facebook.com/NCU.servicelearing/" title="NCU 學務處服務學習辦公室"><img src="images/banner/fb_ser.jpg" alt="NCU 學務處服務學習辦公室" width="160" /></a>
				</div>
<?php
	// 學生
	if($_SESSION['valid_token'] == "1") {
?>
				<ul style="margin-top: 15px;">
					<li><a href="personal.php" title="時數查詢">時數查詢</a></li>
					<li><a href="personal_activity.php" title="活動紀錄">活動紀錄</a></li>
					<li><a href="https://docs.google.com/forms/d/e/1FAIpQLScgsTss_qiCtV4pfKKwdIu983imi7zc-yxk12iSRtBv564qhQ/viewform?c=0&w=1" title="系統bug回報">系統bug回報</a></li>
				</ul>
<?php
	}
	// 活動單位
	elseif($_SESSION['valid_token'] == "2") {
?>
				<ul style="margin-top: 15px;">
					<li><a href="others.php" title="申請單位">申請單位</a></li>
					<li><a href="pass_apply_activities.php" title="活動申請">活動申請</a></li>
					<li><a href="history.php" title="申請記錄">申請記錄</a></li>
					<li><a href="https://docs.google.com/forms/d/e/1FAIpQLScgsTss_qiCtV4pfKKwdIu983imi7zc-yxk12iSRtBv564qhQ/viewform?c=0&w=1" title="系統bug回報">系統bug回報</a></li>
				</ul>
<?php
	}
	// 管理員
	elseif($_SESSION['valid_token'] == "3") {
?>
				<ul style="margin-top: 15px;">

					<li><a href="pass_admin.php" title="網站管理員">網站管理員</a></li>
					<li><a href="pass_post_news.php" title="新增公告">新增公告</a></li>
					<li><a href="pass_approver.php" title="工作查詢">工作查詢</a></li>
					<li><a href="pass_apply_activities.php" title="活動申請">活動申請</a></li>
					<li><a href="pass_activities_manage.php" title="活動管理">活動管理</a></li>
					<li><a href="pass_hour_admit.php" title="時數核可">時數核可</a></li>
					<li><a href="pass_service_hour_admit.php" title="時數核可">依服務時數核可</a></li>
					<li><a href="pass_apply_out_activity.php" title="活動申請">活動申請(個人)</a></li>
					<li><a href="pass_out_activities_manage.php" title="活動管理">活動管理(個人)</a></li>
					<li><a href="pass_out_hour_admit.php" title="時數核可">時數核可(個人)</a></li>
					<li><a href="pass_hour_query.php" title="時數查詢">時數查詢</a></li>
					<!--<li><a href="pass_hour_query_dep.php" title="科系時數查詢">科系時數查詢</a></li>-->
					<li><a href="pass_main_print.php" title="列印報表">列印報表</a></li>
					<li><a href="post_attach.php" title="上傳檔案">上傳檔案</a></li>
					<!--<li><a href="pass_import.php" title="匯入畢審系統">匯入畢審系統</a></li>-->
					<li><a href="https://docs.google.com/forms/d/e/1FAIpQLScgsTss_qiCtV4pfKKwdIu983imi7zc-yxk12iSRtBv564qhQ/viewform?c=0&w=1" target='_blank' title="系統bug回報">系統bug回報</a></li>

				</ul>
<?php
	}

	if($_SESSION['valid_token'] == "1" || $_SESSION['valid_token'] == "2")
	{
		if($_SESSION['valid_token'] == "1")
		{
			echo "若使用公共電腦，請記得<a href='https://portal.ncu.edu.tw'  target='_blank'>前往portal登出</a>";
		}
		echo "<div align='center'><a href=\"send_logout.php\" onClick=\"return confirm('確定登出?');\"><img src=\"images/logout.jpg\" style=\"vertical-align: middle; margin: 10px auto; border: none; width: 40px;\" /> [登出服學網]</a></div>";
	}
	elseif($_SESSION['valid_token'] != "3")
	{
?>

				<div id="login">
					<img src="images/login.jpg" style="vertical-align: middle; width: 50px; margin: 10px 0 0 -15px;" />
					組織單位由此登入
				</div>
				<form name="form" id="form" action="send_login.php" method="post">
				<ul class="list" style="margin-left: 0; font-size: 12pt; list-style-type: none;">
					<li>帳號 <input style="height: 16pt;" size="16" class="textstyle titleHintBox" title="電算中心SPARC帳號" type="text" name="name" id="name" /></li>
					<li>密碼 <input style="height: 16pt;" size="16" class="textstyle titleHintBox" title="電算中心SPARC密碼" type="password" name="pass" id="pass" /></li>
				</ul>
				<input type="submit" value="登入" /> <input type="reset" value="取消" />
				</form>


<?php
	}
?>


				<br />
				<!--<div id="banner" style="margin-top: 15px;">
				<a href="http://www.ncu.edu.tw/" title="國立中央大學"><img src="images/banner/ncu_banner.gif" alt="中央大學" /></a>
					<a href="http://osa.ncu.edu.tw/index.php" title="學生事務處"><img src="images/banner/osa.png" alt="學生事務處" width="160" /></a>

				</div>-->
<? if($_SESSION['valid_token'] != "1" && $_SESSION['valid_token'] != "2" && $_SESSION['valid_token'] != "3"){?>
				<a id="login_portal" href="login/sso.php">
					<img src="login/Login-icon.png" style="vertical-align: middle; width: 50px; margin: 10px 0 0 -15px;" />
					學生portal登入
				</a>
<?}?>
			</div>