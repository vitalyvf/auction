<?php
defined('AREA') or die('Oops!...');

class ModelIndex extends Model {
	public function getUserStatistics() {
		$query = $this->db->query("SELECT * FROM `".DB_PREFIX."user`");
		$result = [
			'total' => 0,
			'active' => 0,
			'admin' => 0
		];
		foreach ($query->rows as $user) {
			$result['total']++;
			if ($user['status'] == 'A' && $user['user_type'] == 'C') {
				$result['active']++;
			}
			if ($user['user_type'] == 'A') {
				$result['admin']++;
			}
		}

		return $result;
	}

	public function getLotStatistics() {
		$query = $this->db->query("SELECT status FROM `".DB_PREFIX."lot`");
		$result['total'] = 0;
		foreach (LOT_STATUS as $status => $status_name) {
			$result[$status] = 0;
		}
		foreach ($query->rows as $lot) {
			$result['total']++;
			$result[$lot['status']]++;
		}
		return $result;
	}	
}