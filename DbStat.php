<?php
class models_Db_DbSta extends Zend_Db_Table_Abstract
{
    protected $_name = 'test_table';
    protected $_primary = 'GameID';
	
    public function __construct($name, $primary)
    {
    	$config = new Zend_Config(
				array(
					'database' => array(
						'adapter' => 'Mysqli',
						'params' => array(
							'dbname' => 'dbname',
							'username' => 'username',
							'password' => 'password',
						)
					)
				)
		);
		
		$this->_db = Zend_Db::factory($config->database);
    }
	
	public function insertData(data) {
		$this->_db->insert($data);
	}
	
	 public function getGame($where) {
		$select = $this->_db->select()->from($this);
		foreach($where AS $key=>$data) {
			$select->where(key.'=?',data);
		}
		$result = $this->fetchAll($select)->toArray();
		return result;
	}
}