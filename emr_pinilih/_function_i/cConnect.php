<?php
class cConnect
{
	
	private $dbHost  = "localhost";
	private $dbUser  = "root";
	private $dbPass  = "";
	private $dbName  = "emr";


	function goConnect()
	{
		$conn = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName);
		$GLOBALS["conn"] = $conn;
		if (mysqli_connect_error()) {
			die("error connection : " . mysqli_connect_error());
		}
		// return $conn;
		// 
	}
}
