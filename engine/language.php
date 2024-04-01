<?php
defined('AREA') or die('Oops!...');

/**
* Language variables management
*/
class Language {
	protected $vars;

	public function __construct($language, $controller) {
		if (AREA == ADMIN_AREA) {
            $language_path = DIR_ADMIN.'core/language/';
        } else {
            $language_path = DIR_ENGINE.'language/';
        }
		require_once($language_path.$language.'/common.file.php');
		if (is_file($language_path.$language.'/'.$controller.'.php')) {
			require_once($language_path.$language.'/'.$controller.'.php');
		}
		
		$this->vars = $_;
	}

	public function get($key, $replace = []) {
		if (isset($this->vars[$key])) {
			$return = $this->vars[$key];
			if (is_array($replace) && !empty($replace)) {
				foreach ($replace as $k => $v) {
					$return = str_replace($k, $v, $return);
				}
			}
		} else {
			$return = '__'.$key;
		}
		return $return;
	}
}
