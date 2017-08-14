<?php 

function sentmail($email,$name,$subject,$body,$fromname='Sacoa TW',$webmaster_email = "kenandytw@gmail.com"){
	if (!class_exists('PHPMailer')) {
		require("phpmailer/class.phpmailer.php");
	}
	mb_internal_encoding('UTF-8');   
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true; // turn on SMTP authentication
	//這幾行是必須的
	$mail->SMTPSecure = "ssl";       // Gmail的SMTP主機需要使用SSL連線
	$mail->Host = "smtp.gmail.com";  //Gamil的SMTP主機
	$mail->Port = 465;               //Gamil的SMTP主機的SMTP埠位為465埠。
	$mail->CharSet = "utf-8";         //設定郵件編碼 
	$mail->Username = "kenandytw@gmail.com";
	$mail->Password = '這裡輸入應用程式密碼';
	/*
	$mail->Username = "kenandytw@gmail.com";
	//這邊是你的gmail帳號和密碼
*/
	$mail->FromName = $fromname;
	// 寄件者名稱(你自己要顯示的名稱)
	$webmaster_email = "kenandytw@gmail.com"; 
	//回覆信件至此信箱

	$mail->From = $webmaster_email;
	$mail->AddAddress($email,$name);
	//$mail->AddReplyTo($webmaster_email,"Squall.f");
	//這不用改

	//$mail->WordWrap = 50;
	//每50行斷一次行

	//$mail->AddAttachment("/XXX.rar");
	// 附加檔案可以用這種語法(記得把上一行的//去掉)

	$mail->IsHTML(true); // send as HTML
	$mail->Subject = iconv("big5","UTF-8",$subject);   
	// 信件標題
	$mail->Body = $body;
	//信件內容(html版，就是可以有html標籤的如粗體、斜體之類)
	$mail->AltBody = "信件內容"; 
	//信件內容(純文字版)

	if(!$mail->Send()){
		return false;
		//echo "寄信發生錯誤：" . $mail->ErrorInfo;
		//如果有錯誤會印出原因
	}
	else{ 
		return true;
		//echo "寄信成功";
	}   
}
?>  