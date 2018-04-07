<?php
/***************************************/
/***************************************/
// گروه نرم افزاری وی کن
// WeCan-Co.ir | @WeCanGP
// ربات هوشمند و بهینه تغییر نام کاری از گروه نرم افزاری وی کن
// از قابلیت های این ربات این است که تغییر کپشن را با هرحجمی در کسری از ثانیه انجام میدهد
/***************************************/
// سو استفاده از این فایل و تغییر به نام خود و نقض حق سازنده شرعا حرام و غیرقانونی و عملی غیرانسانی است
/***************************************/
	@ini_set('zlib.output_compression',0);
	@ini_set('implicit_flush',1);
	ini_set('max_execution_time', 0);
	@ob_end_clean();
	set_time_limit(0);
	require_once('../../__conf.php');
	define('BOTTOKEN',$bot_token);
	define('DOMAIN',$domain);
	define('PWRUSERTOKEN',$user_token);
	
	/*****************تعریف توابع************************/
	
	// تابع ارسال درخواست با ربات معمولی
	function BotCallMethod($method,$parms=array(),$timeout=120){
		$url = "https://api.telegram.org/bot".BOTTOKEN."/".$method;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, count($parms));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $parms);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt ($ch, CURLOPT_TIMEOUT, $timeout);
		$result = curl_exec($ch);
		curl_close($ch);
		if($result){
			return json_decode($result);
		}
		return false;
	}
	
	// تابع ارسال درخواست با ربات پاور
	function PWRBotCallMethod($method,$parms=array(),$timeout=120){
		$url = "http://api.".DOMAIN."/bot".BOTTOKEN."/".$method;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, count($parms));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $parms);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt ($ch, CURLOPT_TIMEOUT, $timeout);
		$result = curl_exec($ch);
		curl_close($ch);
		if($result){
			return json_decode($result);
		}
		return false;
	}
	
	// تابع ارسال درخواست با یوزر معمولی
	function PWRUserCallMethod($method,$parms=array(),$timeout=120){
		$url = "http://api.".DOMAIN."/user".PWRUSERTOKEN."/".$method;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, count($parms));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $parms);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt ($ch, CURLOPT_TIMEOUT, $timeout);
		$result = curl_exec($ch);
		curl_close($ch);
		if($result){
			return json_decode($result);
		}
		return false;
	}
	
	function get_file_type($filename){
		$filename = explode(".",$filename);
		$ex = strtolower($filename[sizeof($filename)-1]);
		$file_type='document';
		switch($ex){
				case "jpg":
				case "png":
				case "gif":
					$file_type="photo";
				break;
				
				case "mov":
				case "mp4":
				case "3gp":
					$file_type="video";
				break;
				
				case "mp3":
				case "wav":
					$file_type="sound";
				break;
				
				case "ogg":
					$file_type="voice";
				break;
				
				default:
					$file_type='document';
				break;
		}
		return ucfirst($file_type);
	}
	
	/***************بخش اصلی  ربات******************/
	$BOT_ADMINS = array("wecanco");
	$BOT_IS_ACTIVE = true;
	$BlackList=array("aknownstranger","34534665");

	
	if($BOT_IS_ACTIVE){
		
		$message= file_get_contents("php://input");
		//file_put_contents("message",$message);
		$up = json_decode($message);
		/**************تحلیل پیام دریافتی****************/
		$update_id = $up->update_id;
		$message_id = $up->message->message_id;
		$message_date = $up->message->date;
		$message_date = date('Y-m-d H:i:s', $message_date);
		if(isset($up->message->text)){
			$message_text = $up->message->text;
		}

		$from_id = $up->message->from->id;
		$from_first_name = $up->message->from->first_name;
		$from_last_name = $up->message->from->last_name;
		$from_username = $up->message->from->username;
		$from_language_code = $up->message->from->language_code;
		
		$chat_id = $up->message->chat->id;
		$chat_first_name = $up->message->chat->first_name;
		$chat_last_name = $up->message->chat->last_name;
		$chat_username = $up->message->chat->username;
		$chat_type = $up->message->chat->type;
		
		
		if(isset($up->message->caption)){
			$caption = $up->message->caption;
		}
		
		if(isset($up->message->document)){
			$file_name = $up->message->document->file_name;
			$mime_type = $up->message->document->mime_type;
			$file_id = $up->message->document->file_id;
			$file_size = $up->message->document->file_size;
		}
		
		if(isset($up->message->video)){
			$file_name = time().".mp4";
			$mime_type = $up->message->video->mime_type;
			$file_id = $up->message->video->file_id;
			$file_size = $up->message->video->file_size;
		}
		
		if(isset($up->message->audio)){
			$file_title = $up->message->audio->title;
			$file_name = $up->message->audio->performer.".mp3";
			$mime_type = $up->message->audio->mime_type;
			$file_id = $up->message->audio->file_id;
			$file_size = $up->message->audio->file_size;
		}
		
		if(isset($up->message->voice)){
			$file_id = $up->message->voice->file_id;
			$file_name = "VOICE_".$file_id.".Ogg"; 
			$mime_type = $up->message->voice->mime_type;
			$file_size = $up->message->voice->file_size;
		}
		
		if(isset($up->message->photo)){
			$file_name = time().".jpg";
			$lphoto = $up->message->photo;
			$lphoto = $lphoto[sizeof($lphoto)-1];
			//$mime_type = $lphoto->mime_type;
			$file_id = $lphoto->file_id;
			$file_size = $lphoto->file_size;
		}

		

		/****************پایان تحلیل پیام*******************/
		
		
		$last_name_path = "temp/".$chat_id."_last_name";
		$last_file_path = "temp/".$chat_id."_last_file";
		$next_step_path = "temp/".$chat_id."_last_step";
		$users_path ="users/".$from_id;
		$file = json_decode(json_encode(array('id'=>$file_id,'name'=>$file_name,'size'=>$file_size,'caption'=>$caption)));
	
		file_put_contents($users_path,""); // ذخیره کاربران
		$next_step=file_get_contents($next_step_path); // دریافت آخرین مرحله جاری
		
		if(!in_array($from_username,$BlackList) && !in_array($from_id,$BlackList)){ // اگر در بلک لیست نبود
			switch($message_text){
				case "/start":
					$text='1️⃣ سلام. من ربات تغییر نام و کپشن وی کن هستم. برای شروع فایل یا لینک را ارسال کنید.';
					$next_step='getname';
					unlink($last_name_path);
					unlink($last_file_path);
					file_put_contents($next_step_path,$next_step);
					BotCallMethod('sendMessage',array('chat_id'=>$chat_id,'text'=>$text,'reply_to_message_id'=>$message_id));
				break;
				
				case "/creator":
					unlink($last_name_path);
					unlink($last_file_path);
					unlink($next_step_path);
					$text='💝 طراجی شده توسط گروه نرم افزاری وی کن. 
💻 WeCan-Co.ir
🆔 @WeCanGP
';
					BotCallMethod('sendMessage',array('chat_id'=>$chat_id,'text'=>$text,'reply_to_message_id'=>$message_id));
				break;
				
				case "/support":
					unlink($last_name_path);
					unlink($last_file_path);
					unlink($next_step_path);
					$text='📨 در صورت مشاهده ایراد با آی دی @WeCanCo در ارتباط باشید.';
					BotCallMethod('sendMessage',array('chat_id'=>$chat_id,'text'=>$text,'reply_to_message_id'=>$message_id));
				break;
				
				case "/users":
					unlink($last_name_path);
					unlink($last_file_path);
					unlink($next_step_path);
					$directory = "users/";
					$files = scandir($directory);
					unset($files[0]);
					unset($files[1]);
					$num_files = count($files);
					$text='👤 تعداد کاربران ربات: '.$num_files." کاربر

🔖 لیست کاربران:
".implode("
",$files)."
";
					BotCallMethod('sendMessage',array('chat_id'=>$chat_id,'text'=>$text,'reply_to_message_id'=>$message_id));
				break;
				
				default: // اگر پیامی غیر از دستورات تعریف شده بود
					switch($next_step){
						case "getname":
							if(isset($file->id) ){
								$next_step='getcaption';
								file_put_contents($next_step_path,$next_step);
								file_put_contents($last_file_path,json_encode($file));
								$text='2️⃣ نام جدید فایل را همراه با پسوند آن وارد نمایید:(برای عدم تغییر 0 وارد نمایید)';
								
							}else if(strpos('http',$message_text) >=0){
								$next_step='getcaption';
								file_put_contents($next_step_path,$next_step);
								$file->id = $message_text;
								file_put_contents($last_file_path,json_encode($file));
								$text='2️⃣ نام جدید فایل را همراه با پسوند آن وارد نمایید:(برای عدم تغییر 0 وارد نمایید)';
							}else{
								$text='میگم بنظرت اینی که فرستادی فایله یا لینک؟!
دوباره /start بزن.';
								unlink($last_name_path);
								unlink($last_file_path);
								unlink($next_step_path);
							}
							
							BotCallMethod('sendMessage',array('chat_id'=>$chat_id,'text'=>$text,'reply_to_message_id'=>$message_id));
						break;
						
						case "getcaption":
							$next_step='doit';
							file_put_contents($next_step_path,$next_step);
							file_put_contents($last_name_path,$message_text);
							$text='3️⃣ کپشن فایل را وارد نمایید:(برای عدم تغییر 0 را وارد نمایید)';
							BotCallMethod('sendMessage',array('chat_id'=>$chat_id,'text'=>$text,'reply_to_message_id'=>$message_id));
						break;
						
						case "doit":
							$name=file_get_contents($last_name_path); // دریافت آخرین پیام کاربر
							$file=json_decode(file_get_contents($last_file_path)); // مشخصات آخرین فایل ارسالی کاربر
							$caption = $message_text;
							$norename=false;
							if($name=='' || $name=='0'){
								$name = $file->name;
								$norename=true;
							}
							
							if($caption=='' || $caption=='0'){
								$caption = $file->caption;
							}
							
						
							$text='⏳ در حال تغییر نام...
📝 نام جدید: '.$name.'
📌 کپشن: '.$caption.'

---------
کانال ما: @wecangp
';
							

							if($norename){
								$file_type = get_file_type($name);
								BotCallMethod('send'.$file_type,array('chat_id'=>$chat_id,strtolower($file_type)=>$file->id,'caption'=>$caption));
							}else{
								BotCallMethod('sendMessage',array('chat_id'=>$chat_id,'text'=>$text,'reply_to_message_id'=>$message_id));
								PWRBotCallMethod('sendFile',array('chat_id'=>$chat_id,'file'=>$file->id,'caption'=>$caption,'name'=>$name),0);
							}
							
							unlink($last_name_path);
							unlink($last_file_path);
							unlink($next_step_path);
						
						break;
						
						default:
							unlink($last_name_path);
							unlink($last_file_path);
							unlink($next_step_path);
						break;
					}
				break;
			}
		}else{
			// اگر کاربر استفاده کننده در بلک لیست بود
			exit();
		}

		
	}else{
		// اگر ربات غیرفعال بود
		exit();
	}