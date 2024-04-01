<?php
defined('AREA') or die('Oops!...');

class ModelUpdateLots extends Model {

	public $mail;

	public function setMail($mail) {
		$this->mail = $mail;
	}

	public function updateLots() {
		$query = $this->db->query("SELECT * FROM `".DB_PREFIX."lot` 
			WHERE status='N' AND lot_time<'".time()."'"
		);
		if ($query->num_rows) {
			$update_lots = $query->rows;
			foreach ($update_lots as $k => $lot) {
				if ($lot['winner_bid'] != 0) {
					$bids = $this->db->query("SELECT b.*, u.email, u.firstname, u.lastname FROM `".DB_PREFIX."bid` as b
						LEFT JOIN `".DB_PREFIX."user` as u ON u.user_id = b.user_id
						WHERE lot_id='".$lot['lot_id']."'
						ORDER BY bid_id"
					)->rows;
					foreach ($bids as $b) {
						if ($b['email']) {
							$update_lots[$k]['mail_to'][$b['user_id']] = $b['email'];
						}
					}

					if ($this->config->get('mail_address_from')) {
						$update_lots[$k]['mail_to']['admin'] = $this->config->get('mail_address_from');
					}
					$update_lots[$k]['next_status'] = 'S';
				} else {
					$update_lots[$k]['mail_to'] = false;
					$update_lots[$k]['next_status'] = 'F';
				}
			}
		} else {
			$update_lots = false;
		}
		if ($update_lots) {
			foreach ($update_lots as $lot) {
				if ($lot['mail_to']) {
					foreach ($lot['mail_to'] as $send_to) {
						$subject = __('subject_auction_over', ['[lot_name]'=> $lot['lot_name']]);
						$web_dir = fn_get_web_dir($_SERVER['REQUEST_URI']);
						$lot_url = 'http://'.$_SERVER['HTTP_HOST'].$web_dir.'index.php?lindex.lot&lot_id='.$lot['lot_id'];
						$body = __('body_auction_over', ['[lot_url]'=> $lot_url]);
						$this->mail->setTo($send_to);
						$this->mail->setFrom($this->config->get('mail_address_from'));
						$this->mail->setSender($this->config->get('admin_title'));
						$this->mail->setSubject($subject);
						$this->mail->setText($body);
						$this->mail->send(); 
					}
				}
				$query = $this->db->query("UPDATE `".DB_PREFIX."lot` 
					SET status='".$lot['next_status']."'
					WHERE lot_id='".$lot['lot_id']."'"
				);
			}
		}
	}

	public function output() {
		echo '<html>
		<head>
		<meta http-equiv="refresh" content="60; url=update.php?cron='.CRON_PASSWORD.'" /> 
		</head>
		<body style="display:flex; align-items: center; justify-content: center">
		<h3>OK</h3>
		</body>
		</html>';
		die;
	}
}