
<!-- Sidebar -->
			<div id="sidebar">
				<div id="banner" style="margin-top: 15px;">
					
<!--在這裡加註解回去-->
				<!--	<a href="http://140.115.184.158/pass_news_content.php?news_id=290" title="綠色環保"><img src="images/banner/LOGO3.png" alt="綠色環保" width="160" /></a>	-->	
	
					<!--<a href="http://passport.ncu.edu.tw/pass_news_content.php?news_id=722" title="104學年度服務學習績優獎學金申請延期公告"><img src="images/banner/work_money.png" alt="104學年度服務學習績優獎學金申請延期公告" width="160" height="45" /></a><!--104學年度服務學習績優獎學金申請延期公告 work_money.png--><!--移除-->

					<!--	<a href="https://docs.google.com/forms/d/193rB81f4CGxRl9fDKU7bQNIORhAxyWauKWkYTuXcicE/viewform?c=0&w=1" title="國際服務學習種子報名表單"><img src="images/banner/interal_work.png" alt="國際服務學習種子報名表單" width="160" height="45" /></a>-->
					<!--國際服務學習種子報名表單<br>-->		
					<a href="http://140.115.185.138/weeklylearning/Learning/Learning_index.php" title="大一週會報名區"><img src="images/banner/ncu_banner3.png" alt="大一週會報名區" width="160" /></a><!--大一週會報名區<br> <font color="#ff0000" size="2">請於101年9月21日前完成報名</font></a>-->
					<!--http://www.cc.ncu.edu.tw/~ncu7221/Learning/Learning_index.php週會報名轉址用，拔除-->
					<a href="https://www.facebook.com/NCU.Seed.Volunteer" title="種子志工粉絲專頁"><img src="images/banner/seedfb.png" alt="種子志工粉絲專頁" width="160" /></a>
<!--				<a href="http://goo.gl/yr4Ilh" title="服務學習績優獎學金" ><img src="images/banner/abc.jpg" alt="服務學習績優獎學金" width="160"  height="45"/></a> -->
<!--在這裡加註解回去-->
				<!--	<a href="http://140.115.8.145/service/" title="服務學習成果觀摩展"><img src="images/banner/link.jpg" alt="服務學習成果觀摩展" width="160" /></a>   -->
				
				<!--	<a href="http://140.115.184.158/angel-1.php" title="天使護照"><img src="images/banner/ad1.jpg" alt="天使護照" width="160" /></a>    -->
					
							
			
				</div>
<?php
	// 學生
	if($_SESSION['valid_token'] == "1") {
?>
				<ul style="margin-top: 15px;">
					<li><a href="personal.php" title="活動記錄">活動記錄</a></li>
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
<!--					
					<li><a href="pass_news_manage.php" title="新增公告">管理公告</a></li>
					<li><a href="pass_post_archives.php" title="發佈認證成果">發佈認證成果</a></li>
-->
					<li><a href="pass_apply_activities.php" title="活動申請">活動申請</a></li>
					<li><a href="pass_activities_manage.php" title="活動管理">活動管理</a></li>
					<li><a href="pass_hour_admit.php" title="時數核可">時數核可</a></li>
					<li><a href="pass_service_hour_admit.php" title="時數核可">依服務時數核可</a></li>
					<li><a href="pass_apply_out_activity.php" title="活動申請">活動申請(個人)</a></li>
					<li><a href="pass_out_activities_manage.php" title="活動管理">活動管理(個人)</a></li>
					<li><a href="pass_out_hour_admit.php" title="時數核可">時數核可(個人)</a></li>
					<li><a href="pass_hour_query.php" title="時數查詢">時數查詢</a></li>
					<li><a href="pass_hour_query_dep.php" title="科系時數查詢">科系時數查詢</a></li>
					<li><a href="pass_main_print.php" title="列印報表">列印報表</a></li>
					<li><a href="pass_import.php" title="匯入畢審系統">匯入畢審系統</a></li>
<!--					
				    <li><a href="post_attach.php" title="管理下載專區">管理下載專區</a></li>

					<li><a href="move_db.php" title="資料庫移轉">資料庫移轉</a></li>
-->
				</ul>
<?php
	}	

	if($_SESSION['valid_token'] == "1" || $_SESSION['valid_token'] == "2") 
	{
		if($_SESSION['valid_token'] == "1")
		{
			echo "若使用公共電腦，請記得前往portal登出";
		}
		echo "<div align='center'><a href=\"send_logout.php\" onClick=\"return confirm('確定登出?');\"><img src=\"images/logout.jpg\" style=\"vertical-align: middle; margin: 10px auto; border: none; width: 40px;\" /> [登出服學網]</a></div>";
	}
	elseif($_SESSION['valid_token'] != "3")
	{
?>
				<a id="login_portal" href="login/sso.php">
					<img src="login/Login-icon.png" style="vertical-align: middle; width: 50px; margin: 10px 0 0 -15px;" /> 
					學生登入
				</a>
				<div id="login">
					<img src="images/login.jpg" style="vertical-align: middle; width: 50px; margin: 10px 0 0 -15px;" /> 
					社團登入
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
				<div id="banner" style="margin-top: 15px;">
				<a href="http://www.ncu.edu.tw/" title="國立中央大學"><img src="images/banner/ncu_banner.gif" alt="中央大學" /></a>
					<a href="http://osa.ncu.edu.tw/index.php" title="學生事務處"><img src="images/banner/osa.png" alt="學生事務處" width="160" /></a>
					<!--http://osa.adm.ncu.edu.tw/main.php 舊網址 2015/9/16更新-->
					<!--<a href="http://kslap.ncuksl.com/tw/edu/ncu/ksl/eportfolio/daily/index.jsp?USER=b9011137&ACTION=ARTICLELIST" title="服務學習分享 e-Portfolio"><img src="images/banner/e-Portfolio.png" alt="服務學習分享 e-Portfolio" width="160"/></a>-->
					<!--2015/9/16移除-->
<!--2016/4/6拔除惡意連結-->
				</div>
			</div>
