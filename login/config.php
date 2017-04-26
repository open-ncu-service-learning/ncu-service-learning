<?php
session_start();
	//define ('HOSTDOMAIN', 'your.host.fqdn.or.ip.address');
	define ('HOSTDOMAIN', 'http://service-learning.ncu.edu.tw/');
	define ('NETIDPREFIX', 'https://portal.ncu.edu.tw/user/');

	$netidAllowedRoles = array (
		'ROLE_FACULTY', 'ROLE_STUDENT'
	);

	define ('BASEDIR', dirname (__FILE__));

	set_include_path(get_include_path() .
		PATH_SEPARATOR . BASEDIR . '/actions' .
		PATH_SEPARATOR . BASEDIR . '/classes' .
		PATH_SEPARATOR . BASEDIR . '/libs');
?>
