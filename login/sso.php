<?php
	session_start();	
	require_once('../conn/db.php');
	
	include_once 'config.php';
	include_once 'MyUser.class.php';
	include_once 'NetID.class.php';

	unset ($myuser);
	$userid = null;

	if (isset ($_SESSION['my-user'])) {
		echo '$_SESSION["my-user"] isset'.'<br>';
		$myuser = $_SESSION['my-user'];
		$userid = $myuser->account;
	}
	else {
		echo '$_SESSION["my-user"] is not set'.'<br>';
	}
	echo 'isset($myuser):'.(isset($myuser)? "true":"false").'<br>';
	echo 'isset($_GET["netid-user"]):'.(isset($_GET['netid-user'])? "true":"false").'<br>';
	echo '$myuser->account !== $GET["netid-user"]:'.($myuser->account !== $GET['netid-user']? "true":"false").'<br>';
	
	if (! isset($myuser) or 
	(isset ($_GET['netid-user']) and $myuser->account !== $GET['netid-user'])) {
		$netid = new NetID(HOSTDOMAIN, NETIDPREFIX, $netidAllowedRoles);
		echo '$userid:'.(isset($userid)? $userid:"not set").'<br>';
		$rc = $netid->doLogin($userid);
		echo 'is_object ($rc):'.(is_object ($rc)? "true":"false").'<br>';
		echo 'get_class ($rc) == \'NetIDReturn\':'.(get_class ($rc) == 'NetIDReturn' ? "true":"false").'<br>';
		
		if (is_object ($rc) and get_class ($rc) == 'NetIDReturn') {
			
			echo '$rc->returnCode == NetIDReturn::LOGIN_OK ?'.$rc->returnCode == NetIDReturn::LOGIN_OK.'<br>';
			if ($rc->returnCode == NetIDReturn::LOGIN_OK) {
				$myuser = $_SESSION['my-user'] = new MyUser($rc);
				$userid = $myuser->account;
				// 記錄session
				$_SESSION['valid_token']			= '1';						// token
				$_SESSION['valid_student_id']		= $userid;					// 學號
				$sql = "SELECT * FROM `all_user` WHERE user_student='$userid'";
				$ret = mysql_query($sql) or die(mysql_error());
				$row = mysql_fetch_assoc($ret);
				if($row = mysql_fetch_assoc($ret))
				{
																						echo '5'.'<br>';
					$_SESSION['valid_student_name']		= $row['user_name'];		// 姓名
					$sucess=true;
				}
																						echo '6'.'<br>';
				// FIXME
				//header ('location: /pass/index.php');
				echo
						"
							<script>
								alert(\'登入成功\');
								self.location.href='/personal.php';
							</script>
						";
				return;
			}
			else
			{
				echo '沒有成功登入'.'<br>';
			}
			echo '繼續執行'.'<br>';
		}
		echo '$rc->returnCode:'.$rc->returnCode .'<br>';
		switch ($rc->returnCode) { // FIXME
			case NetIDReturn::LOGIN_FAILED:
				echo 'LOGIN_FAILED'.'<br>';
				break;

			case NetIDReturn::CANCELED_AUTHENTICATION:
				echo 'canceled'.'<br>';
				// header('location: canceled.php');
				break;

			case NetIDReturn::ACCOUNT_NOT_ACCEPTABLE:	
				echo 'ACCOUNT_NOT_ACCEPTABLE'.'<br>';
				//header('location: index.php?action=accountNotAcceptable');
				break;

			case NetIDReturn::ROLE_NOT_ACCEPTABLE:
				echo 'ROLE_NOT_ACCEPTABLE'.'<br>';
				//header('location: index.php?action=roleNotAcceptable');
				break;

			case NetIDReturn::ERROR_EXCEPTION:
				echo 'ERROR_EXCEPTION'.'<br>';
				break;
			case NetIDReturn::REDIRECT_REQUEST:
				echo 'REDIRECT_REQUEST'.'<br>';
				break;
		}
		return;
	}

	// FIXME
	header('location: /index.php');
?>
