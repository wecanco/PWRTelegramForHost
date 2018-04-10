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
	
	if(!file_exists('.htaccess')){
		$htaccess = "
#AddHandler application/x-httpd-php71 .php .php5 .php4 .php3
Options -Indexes
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . /index.php [L]
</IfModule>

<IfModule php7_module>
   #php_flag display_errors Off
   #php_value max_execution_time 0
   #php_value max_input_time 600
   #php_value max_input_vars 5000
   #php_value memory_limit 512M
   #php_value session.gc_maxlifetime 1440
   #php_value session.save_path "/var/cpanel/php/sessions/ea-php70"
   #php_value upload_max_filesize 1024M
</IfModule>	
		";
		file_put_contents('.htaccess',$htaccess);
	}
				
	if(!file_exists('__conf.php')){
		header('location: /installer.php');
	}else{
		header('location: http://api.'.$_SERVER['HTTP_HOST']);
	}
