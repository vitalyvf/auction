<?php
defined('AREA') or die('Oops!...');

class ModelIndex extends Model {
	public function getAuctionList() {
		$lot_list = [];
		$query = $this->db->query("SELECT * FROM `".DB_PREFIX."lot` WHERE lot_time>'".time()."' AND status='N' ORDER BY lot_time");
		if (!empty($query->rows)) {
			foreach ($query->rows as $lot) {
				$images = $this->getLotImages($lot['lot_id']);
				if (!empty($images)) {
					$image = reset($images);
					$lot['image'] = isset($image['file_name']) ? $image['file_name'] : false;
				}
				if ($lot['winner_bid']) {
					$winner = $this->db->query("SELECT * FROM `".DB_PREFIX."bid` WHERE bid_id='".$lot['winner_bid']."'")->row;
					$user_id = isset($_SESSION['auth']['user_id']) ? $_SESSION['auth']['user_id'] : false;
					$lot['bid'] = $winner['user_id'] == $user_id ? $winner['price'] : $winner['price'] + $lot['lot_step'];
					$lot['winner_user'] = $winner['user_id'];
				} else {
					$lot['bid'] = $lot['min_price'];
					$lot['winner_user'] = 0;
				}
				$lot_list[] = $lot;
			}
		}
		return $lot_list;
	}
	
	protected function getLotImage($lot_id) {
		$result = false;
		$query = $this->db->query("SELECT * FROM `".DB_PREFIX."image` 
			WHERE object='lot' AND object_id='".$lot_id."'"
		);
		if (!empty($query->rows)) {
			$result = $query->row;
		}
		return $result;
	}

	public function getLot($lot_id) {
		$result = false;
		$query = $this->db->query("SELECT * FROM `".DB_PREFIX."lot` WHERE lot_id='".$this->db->escape($lot_id)."'");
		if (!empty($query->rows)) {
			$lot = $query->row;
			$lot['images'] = $this->getLotImages($lot_id);
			if ($lot['winner_bid']) {
				$winner = $this->db->query("SELECT * FROM `".DB_PREFIX."bid` WHERE bid_id='".$lot['winner_bid']."'")->row;
				$user_id = isset($_SESSION['auth']['user_id']) ? $_SESSION['auth']['user_id'] : false;
				$lot['bid'] = $winner['user_id'] == $user_id ? $winner['price'] : $winner['price'] + $lot['lot_step'];
				$lot['winner_user'] = $winner['user_id'];
			} else {
				$lot['bid'] = $lot['min_price'];
				$lot['winner_user'] = 0;
			}
			$result = $lot;
		}
		return $result;
	}

	protected function getLotImages($lot_id) {
		$query = $this->db->query("SELECT * FROM `".DB_PREFIX."image` WHERE object='lot' AND object_id='".$lot_id."' ORDER BY image_id");
		return $query->rows;
	}

	public function makeBid($lot_id, $price) {
		$price = $this->db->escape($price);
		if ($lot_id && $price) {
			$query = $this->db->query("SELECT l.*, b.user_id, b.price as max_bid 
				FROM `".DB_PREFIX."lot` as l 
				LEFT JOIN `".DB_PREFIX."bid` as b ON b.bid_id = l.winner_bid
				WHERE l.lot_id='".$this->db->escape($lot_id)."'"
			);
			$lot = !empty($query->rows) ? $query->row : false;
			$max_bid = isset($lot['max_bid']) ? $lot['max_bid'] : 0;
			$user_id = isset($_SESSION['auth']['user_id']) ? $_SESSION['auth']['user_id'] : false;
			if ($lot && $lot['status'] == 'N' && $price > $max_bid && $user_id) {
				// Make bid
				$query = $this->db->query("INSERT INTO `".DB_PREFIX."bid` 
					(user_id, lot_id, bid_time, price)
					VALUES
					('".$user_id."', '".$lot_id."', '".time()."', '".$price."')"
				);
				$winner_bid =  $this->db->getLastId();
				$query = $this->db->query("UPDATE `".DB_PREFIX."lot` 
					SET winner_bid='".$winner_bid."'
					WHERE lot_id='".$lot_id."'"
				);
				
				$_SESSION['success'][] = __('bid_accepted');
			} else {
				$_SESSION['error'][] = __('bid_accepted_failed');
			}
		}
	}
	public function makeBuy($lot_id) {
		if ($lot_id) {
			$query = $this->db->query("SELECT * FROM `".DB_PREFIX."lot`
				WHERE lot_id='".$this->db->escape($lot_id)."'"
			);
			$lot = !empty($query->rows) ? $query->row : false;
			$user_id = isset($_SESSION['auth']['user_id']) ? $_SESSION['auth']['user_id'] : false;

			if ($lot && $lot['status'] == 'N' && $user_id) {
				// Make buy
				$price = $lot['max_price'];
				$query = $this->db->query("INSERT INTO `".DB_PREFIX."bid` 
					(user_id, lot_id, bid_time, price)
					VALUES
					('".$user_id."', '".$lot_id."', '".time()."', '".$price."')"
				);
				$winner_bid =  $this->db->getLastId();
				$lot_time = time() - 1;
				$query = $this->db->query("UPDATE `".DB_PREFIX."lot` 
					SET winner_bid='".$winner_bid."', lot_time='".$lot_time."'
					WHERE lot_id='".$lot_id."'"
				);
				
				$_SESSION['success'][] = __('buy_accepted');
			} else {
				$_SESSION['error'][] = __('buy_accepted_failed');
			}
		}
	}
}
