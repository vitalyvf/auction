<?php
defined('AREA') or die('Oops!...');

/**
* Abstract model
*/
abstract class Model {
	protected db $db;
	protected config $config;

	public function __construct($db, $config) {
		$this->db = $db;
		$this->config = $config;
	}
}
