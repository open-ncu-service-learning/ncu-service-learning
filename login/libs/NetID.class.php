<?php
	include_once 'openid.php';
	include_once 'NetIDReturn.class.php';

	class NetID {
		private	$hostdomain;
		private	$netidprefix;
		private	$allowedRoles;

		public function __construct($hostdomain, $netidprefix, $allowedRoles) {
			$this->hostdomain = $hostdomain;
			$this->netidprefix = $netidprefix;
			$this->allowedRoles = $allowedRoles;
		}

		public function doLogin($user = null) {
			try {
				$openid = new LightOpenID($this->hostdomain);

				# echo '<pre>'; print_r ($openid); echo '</pre>';

				if (! $openid->mode) {
					$openid->identity = $this->netidprefix;

					$openid->required = array(
						'user/roles'
					);

					$openid->optional = array(
						'contact/email',
						'contact/name',
						'contact/ename',
						'student/id',
						'alunmi/leaveSem'
					);

					header('Location: ' . $openid->authUrl());

					return new NetIDReturn(NetIDReturn::REDIRECT_REQUEST);
				} else if ($openid->mode == 'cancel') {
					echo 'User has canceled authentication!';
					return new NetIDReturn(NetIDReturn::CANCELED_AUTHENTICATION);
				} else if ($openid->validate()) {
					$acct = substr ($openid->identity, strlen($this->netidprefix));

					if ($this->startsWith($openid->identity, $this->netidprefix)) {
						if (preg_match ('/^@?[-_a-zA-Z0-9]+$/', $acct)) {
							return $this->checkUserRole($acct, $openid);
						} else if (preg_match ('/^[-_a-zA-Z0-9]+@[-\.a-zA-Z0-9]+/', $acct)) {
							return $this->checkUserRole($acct, $openid);
						}
					}

					return new NetIDReturn(NetIDReturn::ACCOUNT_NOT_ACCEPTABLE);
				}
			} catch (ErrorException $e) {
				return new NetIDReturn(NetIDReturn::ERROR_EXCEPTION);
			}

			return new NetIDReturn(NetIDReturn::CANCELED_AUTHENTICATION);
		}
	
		private function checkUserRole($acct, $openid) {
			$retval = new NetIDReturn(NetIDReturn::LOGIN_OK, $acct);

			$rolelist = json_decode (
				$openid->data['openid_ext1_value_user_roles']
			);

			$retval->setRoleList ($rolelist);
		
			$allowed = false;

			foreach ($rolelist as $role) {
				if (in_array ($role, $this->allowedRoles)) {
					$allowed = true;
				}
				if ($role == 'ROLE_ANY_STUDENT') {
					$retval->setStudentId(
						$openid->data['openid_ext1_value_student_id']
					);
				} else if ($role == 'ROLE_ALUMNI') {
					$retval->setLeaveSemester(
						$openid->data['openid_ext1_value_alunmi_leaveSem']
					);
				} else if ($role == 'ROLE_STUDENT') {
				} else if ($role == 'ROLE_SUSPENSION') {
				} else if ($role == 'ROLE_FACULTY') {
				}
			}

			if (! $allowed) {
				$retval->setReturnCode(NetIDReturn::ROLE_NOT_ACCEPTABLE);
			}

			return $retval;
		}

		public function startsWith($haystack, $needle) {
			$length = strlen($needle);
			return (substr($haystack, 0, $length) === $needle);
		}
	}
?>
