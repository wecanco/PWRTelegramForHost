<?php
	if(!file_exists('__conf.php')){
		header('location: /installer.php');
	}else{
		header('location: http://api.'.$_SERVER['HTTP_HOST']);
	}
