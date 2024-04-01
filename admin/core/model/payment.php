<?php
defined('AREA') or die('Oops!...');

class ModelPayment extends Model {
	public function getPaymentList($params) {
		$page = isset($params['page']) ? $this->db->escape($params['page']) : 1;
		$per_page = (int) $this->config->get('per_page');
		$limit = " LIMIT ".$page*$per_page.",".$per_page;
		$condition = "1";
		if ($params['lot_id']) {
			$condition .= " AND p.lot_id='".$this->db->escape($params['lot_id'])."'";
		}
		if ($params['payment_date'] && @list($year, $month, $day) = explode('-', $params['payment_date'])) {
			$condition .= " AND p.payment_time >= '".mktime(0,0,0, $month, $day, $year)."' AND  p.payment_time < '".mktime(0,0,0, $month, $day+1, $year)."'";
		}

		$query = $this->db->query("SELECT p.*, u.firstname, u.lastname, l.lot_name FROM ".DB_PREFIX."payment as p
			LEFT JOIN ".DB_PREFIX."user as u ON u.user_id=p.user_id
			LEFT JOIN ".DB_PREFIX."lot as l ON l.lot_id=p.lot_id
			WHERE ".$condition.$limit
		);

		return $query->rows;
	}

	public function getPaymentPagination($params) {
		$page = isset($params['page']) ? $this->db->escape($params['page']) : 1;
		$per_page = (int) $this->config->get('per_page');
		$condition = "1";
		if ($params['lot_id']) {
			$condition .= " AND lot_id='".$this->db->escape($params['lot_id'])."'";
		}
		if ($params['payment_date'] && @list($year, $month, $day) = explode('-', $params['payment_date'])) {
			$condition .= " AND payment_time >= '".mktime(0,0,0, $month, $day, $year)."' AND  payment_time < '".mktime(0,0,0, $month, $day+1, $year)."'";
		}

		$query = $this->db->query("SELECT * FROM `".DB_PREFIX."payment` WHERE ".$condition);

		return ceil($query->num_rows / $per_page);
	}
}