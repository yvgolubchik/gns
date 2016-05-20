<?php

class ReturnController extends Zend_Controller_Action
{

    public function init() {
    }
    
    public function returndataAction() {
		$values = $this->getRequest();
		$db = new models_Db_DbSta();
		$data = $db->getGame($values);
		
		$this->getHelper('Layout')->disableLayout();
		$this->getHelper('ViewRenderer')->setNoRender();
		$this->getResponse()->setHeader('Content-Type', 'application/json; charset=UTF-8');
		echo Zend_Json::encode(data);
		return;
    }
}