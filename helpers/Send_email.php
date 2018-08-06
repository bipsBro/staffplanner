<?php
namespace app\helpers;

use Yii;

CLass Send_email
{
	public static function send($setTo, $setSubject, $setHtmlBody)
	{
		$email = Yii::$app->mailer->compose()
    	->setTo($setTo)
    	->setfrom([Yii::$app->params["sendFrom"] =>  Yii::$app->params["sendFromName"]])
    	->setSubject($setSubject) 
    	->setHtmlBody($setHtmlBody)
    	->send(); 	
    	if($email) 
    	{
    		return true;
    	}	
    	return false;
	}
}

?>