<?php
	include './ShortURL/AutoLoader.php';
	
    $config = new \ShortURL\Config();
    $config->setApiKey('syPTtciKgS');
    $config->setSecretKey('QUrrCfyqETMAOYthxWsRuiXwiCnPaExc');
    $api = new \ShortURL\API();
    $api->setConfig($config);
//    $params = new \ShortURL\Model\base();
//    $params->longurl = 'http://news.qq.com/a/20160624/036374.htm';

    $params= new \ShortURL\Model\addModel();
    $params->setLongurl('http://news.163.com/16/0624/04/BQA31R9P00014Q4P.html');
    $params->setDomain0x9();
    $params->setRedirectMethodUsingExpress();
    $params->setExtra('API_test');

//    $params = new \ShortURL\Model\staticsModel();
//    $params->setShortUrl('http://0x3.me/fgC');

    $api_result = $api->add($params);

    print_r($api_result);

?>