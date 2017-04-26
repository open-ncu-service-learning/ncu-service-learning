<?php
	class MyUser {
		public	$account;
		public	$roles;
		public	$studentId;
		public	$leaveSeme;

		public function __construct(NetIDReturn $netid) {
			$this->account = $netid->account;
			$this->roles = $netid->roleList;
			$this->studentId = $netid->studentId;
			$this->leaveSeme = $netid->leaveSemester;
		}
	}
?>
