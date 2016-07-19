<?php
// this check prevents access to debug front controllers that are deployed by accident to production servers.
// feel free to remove this, extend it or make something more sophisticated.
$allowedIps = array(
	'::1',
	'127.0.0.1',
	'77.236.207.7',
	'188.122.208.17',
	'94.113.252.51'
);
if (!in_array(@$_SERVER['REMOTE_ADDR'], $allowedIps) && strpos($_SERVER['REMOTE_ADDR'], '192.168.0.') === false && strpos($_SERVER['REMOTE_ADDR'], '192.168.1.') === false) {
	die('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

require_once(dirname(__FILE__).'/config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);
sfContext::createInstance($configuration)->dispatch();

