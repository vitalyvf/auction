<?php
defined('AREA') or die('Oops!...');

/**
* Configuration
*/
class Config {
	protected array $vars;

	public function __construct($db) {
		$query = $db->query("SELECT * FROM `".DB_PREFIX."setting`");
		$this->vars = [];
		if ($query->num_rows) {
			foreach ($query->rows as $setting) {
				$this->vars[$setting['code']] = $setting['value'];
			}

		}
	}

	public function get($code) {
		return isset($this->vars[$code]) ? $this->vars[$code] : '';
	}
}
