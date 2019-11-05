<?php
	if(!session_id())
	{
		session_start();
	}
	session_destroy();
	echo"<script>window.location.href='http://localhost:8080/Autoverte/index.php';</script>";
?>