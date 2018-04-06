<html dir='rtl'>
<meta charset="UTF-8">
<title>چک کننده هاست پاور - گروه نرم افزاری وی کن</title>
<?php
	/*
	error_reporting(E_ALL);
	$disabled_functions = ini_get('disable_functions');
	if ($disabled_functions!='')
	{
		$arr = explode(',', $disabled_functions);
		sort($arr);
		echo 'توابع غیرفعال:
		';
		for ($i=0; $i<count($arr); $i++)
		{
			echo $i.' - '.$arr[$i].'
			';
		}
	}
	else
	{
		echo 'بسیار عالی، هاست شما تابعی را غیرفعال نکرده است.';
	}	
	*/
$can_install=false;
function check_host(){
	global $can_install;
	$rate=0;
	$er='';
	$file = "TestFile.txt";
	file_put_contents($file,"@WeCanGP");
	symlink($file,'link');
	
	if(phpversion() >= 7){
		$rate++;
	}else{
		$er .= "نسخه پی اچ پی هاست باید حداقل 7 باشد.<br>";
	}
	
	if(function_exists('shell_exec')){
		$rate++;	
	}else{
		$er .= "هاست توابع مورد نیاز را پشتیبانی نمیکند.<br>";
	}
	
	//echo $er;
	if($er==''){
		$can_install =true;
	}
	
	if($can_install){
		echo '<span style="color:green">خیلی خوب. این هاست مناسب است.</span>';
		$can_install =true;
		return true;
	}else{
		echo '<span style="color:red">متاسفانه این هاست مناسب نصب پاور نیست!<br>
به هاستینگ خود بگویید که کد زیر را در بخش Custom Httpd Configurations برای دامنه شما قرار دهد:<br><br>
<code style="color:black">
&lt;FilesMatch "\.php$"&gt;
    AddHandler x-httpd-php71 .php
&lt;/FilesMatch&gt;
</code>

<br>
<br>

یا اگر هاست شما cpanel است. نسخه ی php هاست را روی نسخه 7 به بالا قرار دهید.
		</span>';
		$can_install =false;
		return false;
	}
}


check_host();