<?php
	class NetIDReturn {
		const	LOGIN_OK = 1;
		const	ALREADY_LOGIN_AS = 2;
		const	LOGIN_FAILED = 3;
		const	CANCELED_AUTHENTICATION = 4;
		const	ACCOUNT_NOT_ACCEPTABLE = 5;
		const	ROLE_NOT_ACCEPTABLE = 6;
		const	ERROR_EXCEPTION = 7;
		const	REDIRECT_REQUEST = 8;
		public		$account;
		public		$returnCode;
		public		$roleList;
		public		$studentId;
		public		$leaveSemester;

		public function __construct($returnCode, $acct = null) {
			$this->account = $acct;
			$this->returnCode = $returnCode;
		}

		public function isLoginOk() {
			return $this->returnCode === NetIDReturn::LOGIN_OK ||
				$this->returnCode === NetIDReturn::ALREADY_LOGIN_AS;
		}

		public function isStudent() {
			return isset ($this->studentId);
		}

		public function setRoleList($roleList) {
			$this->roleList = $roleList;
		}

		public function setStudentId($studentId) {
			$this->studentId = $studentId;
		}

		public function setLeaveSemester($leaveSemester) {
			$this->leaveSemester = $leaveSemester;
		}

		public function setReturnCode($returnCode) {
			$this->returnCode = $returnCode;
		}
	}
?>
