<?php

class ParseController extends Zend_Controller_Action
{

    public function init() {
    	$this->_helper->removeHelper('viewRenderer');
    	$this->_key = 'f84c60a7c0af4a61a0ac7a7f98228cd5';
    }
    
    public function getdataAction($season = '2016', $format = 'JSON') {
    	if(!in_array($format, array('JSON', 'XML'))) {
    		$format = 'JSON';
    	}
    	
    	$validator = new Zend_Validate_Digits();
    	if(!$validator->isValid($season)) {
    		$season = date('Y');
    	}

   		$uri = "https://api.fantasydata.net/mlb/v2/{$format}/Games/{$season}";
    	
		$curl = new Zend_Http_Client_Adapter_Curl();
		$client = new Zend_Http_Client($uri);
		$client->setAdapter($curl);
		$client->setMethod(Zend_Http_Client::GET);
		$client->setHeaders('Ocp-Apim-Subscription-Key: ' . $this->_key);

		$response = $client->request();
		if($response->getStatus() != 200 || $response->getMessage() != 'OK') {
			return FALSE;
		}
		
		$body = $response->getBody();
		switch ($format){
			case 'JSON':
				$insertData = Zend_Json::decode($body, Zend_Json::TYPE_ARRAY);
				break;
			case 'XML':
				$body = Zend_Json::fromXml($body, true);
				$body = Zend_Json::decode($body, Zend_Json::TYPE_ARRAY);				
				$insertData = $body['ArrayOfGame']['Game'];
				break;
		}
		if(!$insertData) {
			return FALSE;
		}
		
		$db = new models_Db_DbSta();
		foreach($insertData AS $data) {
			$db->insertData($data);
		}		
    }
}
