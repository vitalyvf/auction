<?php
defined('AREA') or die('Oops!...');

class ModelSetting extends Model {
	public function getSettingList() {
		$query = $this->db->query("SELECT * FROM `".DB_PREFIX."setting`");

		return $query->rows;
	}

	public function update($settings) {
		if (is_array($settings)) {
			foreach ($settings as $setting_id => $value) {
				$this->setSetting($setting_id, $value);
			}
			$_SESSION['success'][] = __('txt_saved');
		}
	}
	public function setSetting($setting_id, $value) {
		if ($setting_id) {
			$this->db->query("UPDATE ".DB_PREFIX."setting SET value = '".$this->db->escape($value)."' WHERE setting_id = '".$setting_id."'");
		}
	}

	public function addSetting($params) {
		if (!empty($params['code']) && !empty($params['description'])) {
			$query = $this->db->query("SELECT * FROM `".DB_PREFIX."setting` WHERE code='".$params['code']."'");
			if (!$query->num_rows) {
				$variants = $params['setting_type'] == 'select' ? $this->parseVariants($params['value_select']) : '';
				$value = $params['setting_type'] == 'checkbox' ? $params['value_checkbox'] : $params['value_input'];
				$this->db->query("INSERT INTO `".DB_PREFIX."setting` (code, value, description, setting_type, variants) VALUES ('".$params['code']."', '".$value."', '".$params['description']."', '".$params['setting_type']."', '".$variants."')");
				$_SESSION['success'][] = __('txt_created');
			} else {
				$_SESSION['error'][] = __('txt_existing_code');
			}
		} else {
			$_SESSION['error'][] = __('txt_create_failed');
		}
	}

	private function parseVariants($raw_variants) {
		$result = [];
		$variants = explode(';', $raw_variants);
		foreach ($variants as $variant) {
			@list($variant_value, $variant_descr) = explode(',', trim($variant));
			if ($variant_value && $variant_descr) {
				$result[trim($variant_value)] = trim($variant_descr);
			}
		}
		return json_encode($result);
	}
}