<?php
	if(!file_exists('timeout')){
		mkdir('timeout');
	}
	if(!file_exists('users')){
		mkdir('users');
	}
	
	if(!file_exists('sessions')){
		mkdir('sessions');
	}
				
	if(!file_exists('__conf.php')){
		header('location: /installer.php');
	}else{
		header('location: http://api.'.$_SERVER['HTTP_HOST']);
	}
