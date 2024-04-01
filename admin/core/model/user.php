<?php
defined('AREA') or die('Oops!...');

class ModelUser extends Model {
	public function getUserList($params) {
		$page = isset($params['page']) ? $params['page'] : 1;
		$per_page = (int) $this->config->get('per_page');
		$limit = " LIMIT ".$page*$per_page.",".$per_page;
		$condition = "1";
		if ($params['q']) {
			$condition .= " AND (firstname LIKE '%".$params['q']."%' OR lastname LIKE '%".$params['q']."%' OR  login LIKE '%".$params['q']."%')";
		}
		if ($params['status']) {
			$condition .= " AND status='".$params['status']."'";
		}
		if ($params['user_type']) {
			$condition .= " AND user_type='".$params['user_type']."'";
		}
		$query = $this->db->query("SELECT * FROM `".DB_PREFIX."user` WHERE ".$condition.$limit);

		return $query->rows;
	}

	public function getUserPagination($params) {
		$page = isset($params['page']) ? $params['page'] : 1;
		$per_page = (int) $this->config->get('per_page');
		$condition = "1";
		if ($params['q']) {
			$condition .= " AND (firstname LIKE '%".$params['q']."%' OR lastname LIKE '%".$params['q']."%' OR  login LIKE '%".$params['q']."%')";
		}
		if ($params['status']) {
			$condition .= " AND status='".$params['status']."'";
		}
		if ($params['user_type']) {
			$condition .= " AND user_type='".$params['user_type']."'";
		}
		$query = $this->db->query("SELECT * FROM `".DB_PREFIX."user` WHERE ".$condition);

		return ceil($query->num_rows / $per_page);
	}

	public function getUser($user_id) {
		$result = false;
		if ($user_id) {
			$query = $this->db->query("SELECT * FROM `".DB_PREFIX."user` WHERE user_id='".$this->db->escape($user_id)."'");
			if ($query->num_rows > 0) {
				$result = $query->row;
			}
		}
		if (!$result) {
			$_SESSION['error'][] = __('user_not_found');
		}
		return $result;
	}

	public function updateUser($user_data) {
		foreach ($user_data as $key => $value) {
			$user_data[$key] = $this->db->escape($value);
		}
		if (!empty($user_data['user_id'])) {
			if (!empty($user_data['firstname']) && !empty($user_data['lastname'])) {
				$query = $this->db->query("UPDATE `".DB_PREFIX."user` SET 
					user_type='".$user_data['user_type']."', 
					status = '".$user_data['status']."',
					firstname = '".$user_data['firstname']."', 
					lastname = '".$user_data['lastname']."',
					email = '".$user_data['email']."'
					WHERE user_id='".$user_data['user_id']."'"
				);
				$_SESSION['success'][] = __('user_updated');
			} else {
				$_SESSION['error'][] = __('fields_required');
				$_SESSION['error'][] = __('user_updated_failed');
			}
			return $user_data['user_id'];
		} else {
			if (!empty($user_data['firstname']) && !empty($user_data['lastname']) && !empty($user_data['login']) && !empty($user_data['password'])) {
				if ($this->loginExists($user_data['login'])) {
					$_SESSION['error'][] = __('user_login_exists');	
					$_SESSION['error'][] = __('user_created_failed');
					return false;
				} else {
					$query = $this->db->query("INSERT INTO `".DB_PREFIX."user` 
						(user_type, login, password, firstname, lastname, status, email)
						VALUES
						('".$user_data['user_type']."', '".$user_data['login']."', '".md5($user_data['password'])."', '".$user_data['firstname']."', '".$user_data['lastname']."', '".$user_data['status']."', '".$user_data['email']."')"
					);
					$_SESSION['success'][] = __('user_created');
					return $this->db->getLastId();
				}
			} else {
				$_SESSION['error'][] = __('fields_required');
				$_SESSION['error'][] = __('user_created_failed');
				return false;
			}
		}
	}

	public function deleteUser($user_id) {
		if ($user_id) {
			$query = $this->db->query("DELETE FROM `".DB_PREFIX."user` WHERE user_id='".$this->db->escape($user_id)."'");
			$_SESSION['success'][] = __('user_deleted');
		} else {
			$_SESSION['error'][] = __('user_deleted_failed');
		}
	}

	public function changePassword($user_id, $password) {
		if ($user_id && $password) {
			$query = $this->db->query("UPDATE `".DB_PREFIX."user` SET 
				password='".md5($password)."'
				WHERE user_id='".$user_id."'"
			);
			$_SESSION['success'][] = __('password_changed');
		} else {
			$_SESSION['error'][] = __('password_changed_failed');
		}
	}

	public function loginExists($login) {
		$query = $this->db->query("SELECT * FROM `".DB_PREFIX."user` WHERE login='".$this->db->escape($login)."'");
		return $query->num_rows > 0;
	}
	
}