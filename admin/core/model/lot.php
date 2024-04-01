<?php
defined('AREA') or die('Oops!...');

class ModelLot extends Model {
	public function getLotList($params) {
		$page = isset($params['page']) ? $params['page'] : 1;
		$per_page = (int) $this->config->get('per_page');
		$limit = " ORDER BY lot_time DESC LIMIT ".$page*$per_page.",".$per_page;
		$condition = "1";
		if ($params['q']) {
			$condition .= " AND (lot_name LIKE '%".$this->db->escape($params['q'])."%' OR lot_descr LIKE '%".$this->db->escape($params['q'])."%')";
		}
		if ($params['status']) {
			$condition .= " AND status='".$params['status']."'";
		}
		$query = $this->db->query("SELECT * FROM `".DB_PREFIX."lot` WHERE ".$condition.$limit);
		$lots = $query->rows;
		if (!empty($lots)) {
			foreach ($lots as $k => $lot) {
				$lots[$k]['images'] = $this->getLotImages($lot['lot_id']);
			}
		}

		return $lots;
	}

	public function getLotPagination($params) {
		$per_page = (int) $this->config->get('per_page');
		$condition = "1";
		if ($params['q']) {
			$condition .= " AND (lot_name LIKE '%".$this->db->escape($params['q'])."%' OR lot_descr LIKE '%".$this->db->escape($params['q'])."%')";
		}
		if ($params['status']) {
			$condition .= " AND status='".$params['status']."'";
		}
		$query = $this->db->query("SELECT * FROM `".DB_PREFIX."lot` WHERE ".$condition);

		return ceil($query->num_rows / $per_page);
	}

	public function getBids($lot_ids) {
		$result = [];
		if (is_array($lot_ids) && !empty($lot_ids)) {
			$query = $this->db->query("SELECT lot_id, MAX(price) as max_price FROM `".DB_PREFIX."bid` WHERE lot_id IN (".implode(',', $lot_ids).") GROUP BY lot_id");
			if ($query->num_rows > 0) {
				foreach ($query->rows as $bid) {
					$result[$bid['lot_id']] = $bid['max_price'];
				}
			}
		}
		return $result;
	}

	public function getLot($lot_id) {
		$result = false;

		$query = $this->db->query("SELECT * FROM `".DB_PREFIX."lot` WHERE lot_id='".$this->db->escape($lot_id)."'");
		if ($query->num_rows > 0) {
			$result = $query->row;
			$bids = $this->db->query("SELECT * FROM `".DB_PREFIX."bid` WHERE lot_id='".$this->db->escape($lot_id)."'");
			$result['bids'] = $bids->num_rows;
		}

		if (!$result) {
			$_SESSION['error'][] = __('lot_not_found');
		} else {
			$result['images'] = $this->getLotImages($lot_id);
		}
		return $result;
	}

	public function updateLot($lot_data) {
		$result = false;
		foreach ($lot_data as $key => $value) {
			$lot_data[$key] = $this->db->escape($value);
		}

		if (!empty($lot_data['lot_id'])) {
			if (!empty($lot_data['lot_name']) && !empty($lot_data['lot_descr'])) {
				$query = $this->db->query("UPDATE `".DB_PREFIX."lot` SET 
					status = '".$lot_data['status']."',
					lot_name = '".$lot_data['lot_name']."', 
					lot_descr = '".$lot_data['lot_descr']."'
					WHERE lot_id='".$lot_data['lot_id']."'"
				);
				$_SESSION['success'][] = __('lot_updated');
				$this->uploadLotImage($lot_data['lot_id']);
				$this->deleteLotImage($lot_data['lot_id']);
			} else {
				$_SESSION['error'][] = __('fields_required');
				$_SESSION['error'][] = __('lot_updated_failed');
			}
			
			$result =  $lot_data['lot_id'];
		} else {
			$verification_failed = false;
			foreach ($lot_data as $key => $value) {
				if (in_array($key, ['lot_name', 'lot_descr', 'lot_day', 'min_price', 'man_price']) && empty($value)) {
					$verification_failed = true;
				}
			}
			if (!$verification_failed) {

				list($lot_data['year'], $lot_data['month'], $lot_data['day']) = explode('-', $lot_data['date']);
				$lot_data['lot_time'] = mktime($lot_data['hour'], $lot_data['minutes'], 0, $lot_data['month'], $lot_data['day'], $lot_data['year']);
				$query = $this->db->query("INSERT INTO `".DB_PREFIX."lot` 
					(lot_name, lot_descr, lot_time, min_price, max_price, lot_step)
					VALUES
					('".$lot_data['lot_name']."', '".$lot_data['lot_descr']."', '".$lot_data['lot_time']."', '".$lot_data['min_price']."', '".$lot_data['max_price']."', '".$lot_data['lot_step']."')"
				);
				$_SESSION['success'][] = __('lot_created');

				$result =  $this->db->getLastId();
				$this->uploadLotImage($result);
			} else {
				$_SESSION['error'][] = __('fields_required');
				$_SESSION['error'][] = __('lot_created_failed');
			}
		}
		return $result;
	}

	protected function uploadLotImage($lot_id) {
		$result = false;
		if (isset($_FILES["upload_icon"]["tmp_name"]) && !empty($_FILES["upload_icon"]["tmp_name"])) {
			$target_file = DIR_IMAGES.basename($_FILES["upload_icon"]["name"]);
			$verification_failed = false;
			$image_file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			// Check if it is real image
			$check = getimagesize($_FILES["upload_icon"]["tmp_name"]);
			if(!isset($check['mime'])) {
				$verification_failed = true;
			}

			// Check file formats
			if(!in_array($image_file_type, ['jpg', 'png', 'jpeg', 'gif'])) {
				$verification_failed = true;
			}

			if ($verification_failed) {
				$_SESSION['error'][] = __('lot_icon_upload_failed');
			} else {
				$new_file_name = time().'_'.md5(rand(1000, 1000000)).'.'.$image_file_type;
				$target_file = DIR_IMAGES.$new_file_name;
				if (move_uploaded_file($_FILES["upload_icon"]["tmp_name"], $target_file)) {
					$query = $this->db->query("INSERT INTO `".DB_PREFIX."image` 
						(object, object_id, file_name)
						VALUES
						('lot', '".$lot_id."', '".$new_file_name."')"
					);
					$result = $this->db->getLastId();
					$_SESSION['success'][] = __('lot_icon_upload_success');
				} else {
					$_SESSION['error'][] = __('lot_icon_upload_failed');
				}
			}
		}
		return $result;
	}
	protected function getLotImages($lot_id) {
		$query = $this->db->query("SELECT * FROM `".DB_PREFIX."image` WHERE object='lot' AND object_id='".$lot_id."'");
		return $query->rows;
	}

	public function deleteLotImage($lot_id) {
		if (isset($_POST['delete_image']) && !empty($_POST['delete_image'])) {
			$images = $this->getLotImages($lot_id);
			if (count($images) > count($_POST['delete_image'])) {
				foreach ($images as $img) {
					$image_file_name[$img['image_id']] = $img['file_name'];
				}
				foreach ($_POST['delete_image'] as $image_id) {
					unlink(DIR_IMAGES.$image_file_name[$image_id]);
					$this->db->query("DELETE FROM `".DB_PREFIX."image` WHERE image_id='".$image_id."'");

				}
				$_SESSION['success'][] = __('delete_icon_success');
			} else {
				$_SESSION['error'][] = __('delete_icon_failed');
			}
		}
	}

	public function deleteLot($lot_id) {
		if ($lot_id) {
			// Lot cannot be deleted after payment
			$query = $this->db->query("SELECT * FROM `".DB_PREFIX."lot` WHERE lot_id='".$lot_id."'");
			$lot = $query->row;
			if ($lot['status'] != 'P') {
				$images = $this->getLotImages($lot_id);
				if (is_array($images)) {
					foreach ($images as $img) {
						unlink(DIR_IMAGES.$img['file_name']);
					}
					$this->db->query("DELETE FROM `".DB_PREFIX."image` WHERE object='lot' AND object_id='".$lot_id."'");
				}
				$this->db->query("DELETE FROM `".DB_PREFIX."payment` WHERE lot_id='".$lot_id."'");
				$this->db->query("DELETE FROM `".DB_PREFIX."bid` WHERE lot_id='".$lot_id."'");
				$this->db->query("DELETE FROM `".DB_PREFIX."lot` WHERE lot_id='".$lot_id."'");
				$_SESSION['success'][] = __('lot_deleted');
			} else {
				$_SESSION['info'][] = __('cannot_deleted_lot');
			}
		} else {
			$_SESSION['error'][] = __('lot_deleted_failed');
		}
	}

	public function getLotBids($lot_id) {
		if ($lot_id) {
			$query = $this->db->query("SELECT b.*, u.firstname, u.lastname FROM ".DB_PREFIX."bid as b
				LEFT JOIN ".DB_PREFIX."user as u ON u.user_id=b.user_id
				WHERE lot_id='".$this->db->escape($lot_id)."'
				ORDER BY bid_time ASC"
			);

			return $query->rows;
		} else {
			return [];
		}

	}
}