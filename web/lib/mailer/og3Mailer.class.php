<?php

class og3Mailer extends sfMailer
{
	public function send(Swift_Mime_Message $message, &$failedRecipients = null)
	{
		$transport = $this->getTransport();
		$transport->setHost(sfConfig::get('app_sendmail_host'));
		$transport->setPort(sfConfig::get('app_sendmail_port'));
		$transport->setUserName(sfConfig::get('app_sendmail_username'));
		$transport->setPassword(sfConfig::get('app_sendmail_password'));
		parent::send($message, $failedRecipients);
	}
}
