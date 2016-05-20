<?php

class GameController extends Zend_Controller_Action
{

    public function init() {
    }
    
    public function gameAction() {
		$values = $this->getRequest();
		$data = Zend_Json::decode($values['game'], Zend_Json::TYPE_ARRAY);
		$returnData = array();
		foreach($data AS $toView) {
			if($toView['DateTime'] && $toView["HomeTeam"] && $toView["AwayTeam"] && $toView["StadiumID"]) {
				$returnData[] = $toView['DateTime'].' | '.$toView["HomeTeam"].' | '.$toView["AwayTeam"].' | '.$toView["StadiumID"];
			}
		}
		$this->view->game = $returnData;
		return;
    }
}
