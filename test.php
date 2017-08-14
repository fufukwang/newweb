<?php 
require("_mail.php");
for($i=0;$i<5;$i++){
	$email = 'king.no1.wang@gmail.com';
	$name = 'email test';
	$subject = 'emailtesting';
	ob_start();
	require './testhtml.php';
	$body = ob_get_contents();
	ob_clean();
	sentmail($email,$name,$subject,$body);
}

?>  