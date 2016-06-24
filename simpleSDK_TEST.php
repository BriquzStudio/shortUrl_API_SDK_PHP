<?php
	/**
	* simpleSDK Test Case
	*/
	include './simpleSDK.php';
	
	$api_key = 'syPTtciKgS';
	$secret_key = 'QUrrCfyqETMAOYthxWsRuiXwiCnPaExc';
	$api = new \ShortURL\API();
	$api->setApiKey($api_key);
	$api->setSecretKey($secret_key);
	$statics = $api->add('qq.com');
	print_r($statics);
?>