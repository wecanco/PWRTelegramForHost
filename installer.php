<html dir='rtl'>
	<meta charset="UTF-8">
	<title>نصب کننده هاست پاور - گروه نرم افزاری وی کن</title>
	<style>
		html,body{
			font-family:tahoma;
			width:90%;
			margin-left:auto;
			margin-right:auto;
			font-size:13px;
			line-height: 200%;
		}
		input{
			width: 50%;
			text-align:left;
			direction:ltr;
		}
		a {
			text-decoration: none;
			background-color: #06f;
			color: white;
			padding: 10px;
			border-radius: 10px;
		}
	</style>
	<?php
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ERROR);
		
		function db_connect($db_user,$db_pass,$db_name){		
			$con=mysqli_connect('localhost',$db_user,$db_pass,$db_name);
			if (mysqli_connect_errno()) {
				die("Connection failed: " . mysqli_connect_error());
				return false;
			}			
			mysqli_query($con,'SET NAMES \'utf8mb4\'');	
			return $con;
		}
		if(isset($_POST['finish'])){
			$conf = file_get_contents('__conf.php');
			$conf = str_replace("!USERTOKEN",trim($_POST['userhash']),$conf);
			file_put_contents("__conf.php",$conf);
			include('__conf.php');
			file_get_contents('http://api.'.$domain.'/bot'.$bot_token.'/setbackend?backend_token='.$user_token);
			echo '<span style="color:green"> تبریک! اسکریپت کاملا تنظیم شد و حالا میتونید ازش استفاده ببرید. آموزش در کانال:<br>
			<a href="http://t.me/wecangp"> @WeCanGP </a>
			<br>
			<br>
			برای تبدیل ربات خود به ربات تغییر نام فایل بر روی لینک زیر کلیک کنید:<br>
			<a href="https://api.telegram.org/bot'.$bot_token.'/setWebhook?url=https://'.$domain.'/bots/renamer/index.php" target="_new"> ست کردن ربات تغییر نام </a>
			<br>
			<br>
			<br>
			<br>
			برای تبدیل ربات خود به ربات آنتی اسپم ساز بر روی لینک زیر کلیک کنید:<br>
			<a href="https://api.telegram.org/bot'.$bot_token.'/setWebhook?url=https://'.$domain.'/bots/antispamsaz/index.php" target="_new"> ست کردن ربات آنتی اسپم ساز </a>
			<br>
			<br><br>
			<br>
			برای تبدیل ربات خود به ربات آب و هوا بر روی لینک زیر کلیک کنید:<br>
			<a href="https://api.telegram.org/bot'.$bot_token.'/setWebhook?url=https://'.$domain.'/bots/weather/index.php" target="_new"> ست کردن ربات آب و هوا </a>
			<br>
			<br>
			
			<br>
			بعد از ست شدن به ربات خودتون برید و دستور  /start رو بزنید.
			</span>
			<br>
			<span style="color:red">
				دقت کنید که جهت حفظ امنیت باید این فایل را حذف کنید یا تغییر نام دهید.
				</span>
			';
			exit();
		}
		
		if(isset($_POST['login'])){
			echo '<span>حالا روی لینک زیر کلیک کن و کد هشی کد بهت میده رو در کادر زیر وارد دکن و دکمه ثبت نهایی رو بزن:</span>
			<br>
			<br>
			<a href="http://api.'.trim($_POST['domain']).'/user'.trim($_POST['hash']).'/completephonelogin?code='.trim($_POST['code']).'" target="_blank"> تایید کد  </a>
			<br>
			<br>
			<form method="post" >
			<input type="text" name="userhash" value="" placeholder="کد هش..." required/><br><br>
			<input type="submit" name="finish" value="ثبت نهایی" />
			</form>
			';
			exit();
		}
		if(isset($_POST['submit'])){
			$con = db_connect($_POST['dbuser'],$_POST['dbpass'],$_POST['dbname']);
			
			$conf = file_get_contents('__config.sample');
			$conf = str_replace("!DOMAIN",trim($_POST['domain']),$conf);
			$conf = str_replace("!DBNAME",trim($_POST['dbname']),$conf);
			$conf = str_replace("!DDBNAME",trim($_POST['dbname']),$conf);
			$conf = str_replace("!DBUSER",trim($_POST['dbuser']),$conf);
			$conf = str_replace("!DBPASS",trim($_POST['dbpass']),$conf);
			$conf = str_replace("!BOTTOKEN",trim($_POST['token']),$conf);
			$conf = str_replace("!USERPHONE",trim($_POST['phone']),$conf);
			file_put_contents("__conf.php",$conf);
			
			
			$sql=' 
			
			
			DROP TABLE IF EXISTS `broadcast`;
			CREATE TABLE `broadcast` (
			`namespace` varchar(255) NOT NULL,
			`chat_id` varchar(255) NOT NULL,
			`subbed` tinyint(1) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;
			
			
			
			DROP TABLE IF EXISTS `dl`;
			CREATE TABLE `dl` (
			`file_id` varchar(255) DEFAULT NULL,
			`file_size` int(11) NOT NULL,
			`file_path` varchar(255) NOT NULL,
			`bot` varchar(255) NOT NULL,
			`location` mediumtext NOT NULL,
			`mime` varchar(255) NOT NULL,
			`backend` int(10) UNSIGNED NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
			
			
			
			DROP TABLE IF EXISTS `dl_new`;
			CREATE TABLE `dl_new` (
			`file_id` varchar(255) DEFAULT NULL,
			`file_size` int(11) NOT NULL,
			`file_path` varchar(255) NOT NULL,
			`bot` varchar(255) NOT NULL,
			`location` text NOT NULL,
			`mime` varchar(255) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;
			
			
			
			DROP TABLE IF EXISTS `dl_stats`;
			CREATE TABLE `dl_stats` (
			`ID` bigint(20) NOT NULL,
			`file` varchar(300) DEFAULT NULL,
			`count` bigint(20) DEFAULT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;
			
			
			DROP TABLE IF EXISTS `hooks`;
			CREATE TABLE `hooks` (
			`user` varchar(255) NOT NULL,
			`hash` varchar(255) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;
			
			DROP TABLE IF EXISTS `ul`;
			CREATE TABLE `ul` (
			`file_id` varchar(255) DEFAULT NULL,
			`file_size` int(11) NOT NULL,
			`file_hash` varchar(255) NOT NULL,
			`file_type` varchar(255) DEFAULT NULL,
			`bot` varchar(255) NOT NULL,
			`file_name` varchar(255) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
			
			
			ALTER TABLE `broadcast`
			ADD UNIQUE KEY `namespace` (`namespace`,`chat_id`,`subbed`);
			
			ALTER TABLE `dl`
			ADD UNIQUE KEY `file_id` (`file_id`,`file_size`,`file_path`,`bot`,`backend`);
			
			ALTER TABLE `dl_new`
			ADD UNIQUE KEY `file_id` (`file_id`,`file_size`,`file_path`,`bot`);
			
			
			ALTER TABLE `dl_stats`
			ADD PRIMARY KEY (`ID`);
			
			
			ALTER TABLE `hooks`
			ADD UNIQUE KEY `user` (`user`,`hash`);
			
			
			ALTER TABLE `ul`
			ADD UNIQUE KEY `file_id` (`file_id`,`file_hash`,`bot`);
			
			
			ALTER TABLE `dl_stats`
			MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15961;COMMIT;
			
			';
			$result = mysqli_multi_query($con,$sql);
			if($result){
				echo '<span style="color:green">اسکریپت با موفقیت نصب شد.
				<br>
				حالا وارد سی پنل یا دایرکت ادمین خود شوید و دو ساب دامین با نام های زیر بسازید:<br>
				api<br>
				storage<br>
				<br>
				<br>
				دقت کنید مسیر ساب دامین api باید به پوشه api اسکریپت اشاره کند و ساب دامین storage نیز به پوشه storage موجود.
				</span>
				<br>
				<br>
				
				<br>
				<br>
				<span>
				اگه کارهای بالا رو انجام دادی حالا نوبت به لاگین کردن میرسه.<br>
				برای اینکار اول <a href="http://api.'.trim($_POST['domain']).'/phonelogin?phone='.trim($_POST['phone']).'" target="_blank"> ایـــنجا </a> کلیک کن.<br>
				یه همچین چیزی بهت میده:<br>
				{"ok":true,"result":"s7b0nbq1PtLDPExnrogDlhKFwmLa6ce3rB9C73lQVNI"}<br>
				کالا کد هش شده ای که بهت داده ک توی مثال بالا s7b0nbq1PtLDPExnrogDlhKFwmLa6ce3rB9C73lQVNI هست رو در کادر زیر وارد کن و کدی هم که تلگرام واست فرستاده در کادر زیرش وارد کن و دکمه ثبت رو بزن:<br>
				<form method="post" >
				<input type="hidden" name="domain" value="'.$_SERVER['HTTP_HOST'].'" required/><br><br>
				<input type="text" name="hash" value="" placeholder="کد هش..." required/><br><br>
				<input type="text" name="code" placeholder="کد تایید تلگرام..." required/><br><br>
				<input type="submit" name="login" value="ثبت" />
				</form>
				
				</span>
				
				';
			}
			exit();
			
		}
		
	
	
	require_once('PWR_Host_Checker.php');
	global $can_install;
	if($can_install){
		echo '
		<div style="width:90%;margin-right:auto;margin-left:auto">
		<br>
		<span>در هاست خود یک دیتابیس ایجاد کرده و مشخصات آن را در زیر وارد نمایید:</span>
		
		<form method="post" >
		<input type="hidden" name="domain" value="'.$_SERVER['HTTP_HOST'].'" required/><br><br>
		<input type="text" name="dbname" value="" placeholder="نام دیتابیس..." required/><br><br>
		<input type="text" name="dbuser" placeholder="نام کاربری دیتابیس..." required/><br><br>
		<input type="password" name="dbpass" placeholder="رمز ورود دیتابیس..." required/><br><br>
		<input type="text" name="token" placeholder="توکن ربات تلگرامی شما..." required/><br><br>
		<input type="text" name="phone" placeholder="شماره موبایل: +989357973301" required/><br><br>
		<input type="submit" name="submit" value="نصب اسکریپت پاور" />
		</form>
		
		<br>
		<br>
		<span style="font-size:11px;">
		آماده سازی توسط: <a href="http://wecan-co.ir">گروه نرم افزاری وی کن</a>
		<span>
		</div>
		
		';
	}		