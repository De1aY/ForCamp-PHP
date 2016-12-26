<?php
	  define("MYSQL_SERVER", "52.169.122.82");
	  define("MYSQL_LOGIN", "root");
	  define("MYSQL_PASSWORD", "5zaU2x8A");
	  define("MYSQL_DB", "camp");

	function db_connect(){
		$DB_connection = new mysqli(MYSQL_SERVER, MYSQL_LOGIN, MYSQL_PASSWORD, MYSQL_DB) or die("Connection error: ".mysql_error());
		return $DB_connection;
	}

	function table_count($DB, $Table, $Count, $Where, $Val){
		return mysqli_fetch_assoc($DB->query("SELECT COUNT($Count) FROM $Table WHERE $Where='".$DB->real_escape_string($Val)."'"))["COUNT($Count)"];
	}
?>