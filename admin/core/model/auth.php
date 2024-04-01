<?php
defined('AREA') or die('Oops!...');

class ModelAuth extends Model {
	public function login($data) {
		if (isset($data['login']) && isset($data['pass'])) {
			$query = $this->db->query("SELECT * FROM `".DB_PREFIX."user` WHERE login = '".$data['login']."' AND password = '".md5($data['pass'])."'");
			if ($query->num_rows) {
				$user = $query->row;
				$_SESSION['auth'] = $user;
				$this->loginSuccess();
			} else {
				$this->loginFailed();
				$_SESSION['auth'] = [];
			}
		} else {
			$this->loginFailed();
			$_SESSION['auth'] = [];
		}
	}

	public function logout() {
		$_SESSION['auth'] = [];
	}

	public function loginFailed() {
		if (isset($_SESSION['login_failed'])) {
			$_SESSION['login_failed']++;
		} else {
			$_SESSION['login_failed'] = 1;
		}
	}

	public function loginSuccess() {
		unset($_SESSION['login_failed']);
	}
}
