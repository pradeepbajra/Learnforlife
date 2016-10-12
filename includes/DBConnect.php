<?php

class DBConnect
{
	private $conn;

	function __construct(){}

	public function Connect()
	{
		include_once '../includes/DBConfig.php';
		$this->conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		if($this->conn->connect_errno > 0)
		{
			trigger_error('DATABASE ERROR.
				ERROR TITLE: Connection Failed.
				ERROR DESCRIPTION: '.$this->conn->connect_error, E_USER_ERROR);
		}
		else
		{
			// echo 'Ok';
			return $this->conn;
		}
	}
}

?>