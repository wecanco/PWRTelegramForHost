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
	
	
	if(phpversion() >= 7){
		$rate++;
	}else{
		$er .= "نسخه پی اچ پی هاست باید حداقل 7 باشد.<br>";
	}
	
	if(function_exists('shell_exec')){
		$rate++;	
	}else{
		$er .= "هاست توابع مورد نیاز را پشتیبانی نمیکند. (shell_exec)<br>";
	}
	
	if(function_exists('symlink')){
		$file = "TestFile.txt";
		file_put_contents($file,"@WeCanGP");
		symlink($file,'link');
		$rate++;	
	}else{
		$er .= "هاست توابع مورد نیاز را پشتیبانی نمیکند. (symlink)<br>";
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
<br>
'.$er.'
		</span>';
		$can_install =false;
		return false;
	}
}


check_host();