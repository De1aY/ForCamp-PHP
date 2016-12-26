<?php
	session_start();

	session_unset();
	session_write_close();
	header("Location: authorization.php");
?>