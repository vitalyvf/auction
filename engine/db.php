<?php
defined('AREA') or die('Oops!...');

class DB {
	private $connection;

	public function __construct($hostname, $username, $password, $database, $port = '3306') {
		$this->connection = new \mysqli($hostname, $username, $password, $database, $port);

		if ($this->connection->connect_error) {
			die('Error: '.$this->connection->connect_error);
		}

		$this->connection->set_charset("utf8");
		$this->connection->query("SET SQL_MODE = ''");
	}

	public function query($sql) {
		$query = $this->connection->query($sql);
		
		if (!$this->connection->connect_error) {
			if ($query instanceof \mysqli_result) {
				$data = array();

				while ($row = $query->fetch_assoc()) {
					$data[] = $row;
				}

				$result = new \stdClass();
				$result->num_rows = $query->num_rows;
				$result->row = isset($data[0]) ? $data[0] : array();
				$result->rows = $data;

				$query->close();

				return $result;
			} else if (!$query) {
				die('Incorrect MySQL request:<br>'.$sql);
			}
		} else {
			die('Error: '.$this->connection->error.'<br />Error No: '.$this->connection->errno.'<br />'.$sql);
		}
	}

	public function escape($value) {
		return $this->connection->real_escape_string(htmlspecialchars($value));
	}

	public function getLastId() {
		return $this->connection->insert_id;
	}
	
	public function __destruct() {
		$this->connection->close();
	}
}
