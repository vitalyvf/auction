<?php
defined('AREA') or die('Oops!...');

class ModelProfile extends Model {

	public function createProfile($user_data) {
		$verified = true;
		$required_fields = ['use_as_login', 'password', 'firstname', 'lastname'];
		if (isset($user_data['use_as_login'])) {
			$required_fields[] = $user_data['use_as_login'];
		}
		foreach ($user_data as $key => $value) {
			$user_data[$key] = $this->db->escape($value);
		}
		foreach ($required_fields as $field) {
			if (!isset($user_data[$field]) || empty($user_data[$field])) {
				$verified = false;
			}
		}
		$user_data['phone'] = $this->stripNonDigits($user_data['phone']);

		if ($verified) {
			$user_data['login'] = $user_data[$user_data['use_as_login']];

			if ($this->loginExists($user_data['login'])) {
				$_SESSION['error'][] = __('user_login_exists');	
				return false;
			} else {
				$query = $this->db->query("INSERT INTO `".DB_PREFIX."user` 
					(user_type, login, password, firstname, lastname, email)
					VALUES
					('".CUSTOMER_AREA."', '".$user_data['login']."', '".md5($user_data['password'])."', '".$user_data['firstname']."', '".$user_data['lastname']."', '".$user_data['email']."')"
				);
				$_SESSION['auth'] = $user_data;
				$_SESSION['success'][] = __('user_created');
				return $this->db->getLastId();
			}
		} else {
			$_SESSION['error'][] = __('fields_required');
			return false;
		}
	}

	public function updateProfile($user_data) {
		if ($user_data['firstname'] && $user_data['lastname']) {
			foreach ($user_data as $key => $value) {
				$user_data[$key] = $this->db->escape($value);
			}
			$query = $this->db->query("UPDATE `".DB_PREFIX."user` 
				SET firstname='".$user_data['firstname']."', lastname='".$user_data['lastname']."', email='".$user_data['email']."'
				WHERE login='".$user_data['login']."'"
			);
			$_SESSION['auth']['firstname'] = $user_data['firstname'];
			$_SESSION['auth']['lastname'] = $user_data['lastname'];
			$_SESSION['auth']['email'] = $user_data['email'];
			$_SESSION['success'][] = __('user_updated');
		} else {
			$_SESSION['error'][] = __('fields_required');
		}
	}

	public function changePassword($user_data) {
		foreach ($user_data as $key => $value) {
			$user_data[$key] = $this->db->escape($value);
		}
		if ($user_data['password']) {
			$query = $this->db->query("UPDATE `".DB_PREFIX."user` 
				SET password='".md5($user_data['password'])."'
				WHERE login='".$user_data['login']."'"
			);
			$_SESSION['auth']['password'] = md5($user_data['password']);
			$_SESSION['success'][] = __('password_changed');
		} else {
			$_SESSION['error'][] = __('fields_required');
		}
	}

	public function loginExists($login) {
		$query = $this->db->query("SELECT * FROM `".DB_PREFIX."user` WHERE login='".$this->db->escape($login)."'");
		return $query->num_rows > 0;
	}

	public function login($user_data) {
		foreach ($user_data as $key => $value) {
			$user_data[$key] = $this->db->escape($value);
		}
		if (isset($user_data['login']) && isset($user_data['pass'])) {
			$user_data['phone'] = $this->stripNonDigits($user_data['login']);
			$query = $this->db->query("SELECT * FROM `".DB_PREFIX."user` WHERE (login = '".$user_data['login']."' OR login = '".$user_data['phone']."') AND password = '".md5($user_data['pass'])."'");
			if ($query->num_rows) {
				$user = $query->row;
				$_SESSION['auth'] = $user;
				unset($_SESSION['login_failed']);
			} else {
				$_SESSION['auth'] = [];
				$_SESSION['login_failed'] = true;
			}
		} else {
			$_SESSION['login_failed'] = true;
			$_SESSION['auth'] = [];
		}
	}

	public function logout() {
		$_SESSION['auth'] = [];
	}

	public function getPaymentList($user_id) {
		$result = [];
		if ($user_id) {
			$query = $this->db->query("SELECT p.*, l.lot_name FROM `".DB_PREFIX."payment` as p 
				LEFT JOIN `".DB_PREFIX."lot` as l ON l.lot_id=p.lot_id
				WHERE user_id='".$user_id."'"
			);
			if (!empty($query->num_rows)) {
				$result = $query->rows;
			}
		}
		return $result;
	}

	public function makePayment($lot_id) {
		$lot_id = $this->db->escape($lot_id);
		if ($lot_id) {
			// Check if lot winner is a current user
			$user_id = $_SESSION['auth']['user_id'];
			$lot = $this->db->query("SELECT l.*, b.user_id as winner_id, b.price FROM `".DB_PREFIX."lot` as l 
				LEFT JOIN `".DB_PREFIX."bid` as b ON b.bid_id = l.winner_bid
				WHERE l.lot_id = '".$lot_id."'"
			)->row;

			if (!empty($lot['winner_id']) && !empty($lot['price']) && $lot['winner_id'] == $user_id) {
				$this->db->query("INSERT INTO `".DB_PREFIX."payment`
					(user_id, lot_id, payment_time, price) 
					VALUES 
					('".$user_id."', '".$lot_id."', '".time()."', '".$lot['price']."')
					"
				);
				$this->db->query("UPDATE `".DB_PREFIX."lot` SET status='P' WHERE lot_id='".$lot_id."'");
				$_SESSION['success'][] = __('payment_accepted');
				$this->fakePaymet();
			} else {
				$_SESSION['error'][] = __('payment_failed');
			}
		}
	}

	public function getBidsHistory() {
		$result = [];
		$user_id = $_SESSION['auth']['user_id'];
		$query = $this->db->query("SELECT b.*, l.lot_name, l.winner_bid, l.status FROM `".DB_PREFIX."bid` as b 
			LEFT JOIN `".DB_PREFIX."lot` as l ON l.lot_id=b.lot_id
			WHERE user_id='".$user_id."'
			ORDER BY lot_id DESC, bid_id ASC"
		);
		if ($query->num_rows) {
			foreach ($query->rows as $bid) {
				$result[$bid['lot_id']]['lot_name'] = $bid['lot_name'];
				$result[$bid['lot_id']]['lot_id'] = $bid['lot_id'];
				$result[$bid['lot_id']]['status'] = $bid['status'];
				$result[$bid['lot_id']]['bids'][] = $bid;
			}
		}
		return $result;
	}

	protected function stripNonDigits($phone) {
		return preg_replace('~\D~', '', $phone);
	}

	protected function fakePaymet() {
		echo '<html>
		<head>
		<meta http-equiv="refresh" content="4; url=index.php?dispatch=profile.payment" /> 
		</head>
		<body style="display:flex; align-items: center; justify-content: center">
		<h3>'.__('payment_verification').'</h3>
		</body>
		</html>';
		die;
	}
}