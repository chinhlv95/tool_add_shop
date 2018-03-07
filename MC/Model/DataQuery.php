<?php

require_once './MC/Model/PDOData.php';
require_once './Log/Log.php';

class DataQuery extends PDOData
{
	static private $instance 	= null;
	private $dbPDO 				= null;
	private $corporation 		= null;

	private function __construct($corporation)
	{
		$this->dbPDO 		= PDOData::getInstance($corporation);
		$this->corporation 	= $corporation;
	}

	static function getDataQueryObj()
	{
		return self::$instance;
	}

	static function getInstance($corporation)
	{
		if (self::$instance == null) {
			self::$instance = new DataQuery($corporation);
		}
		return self::$instance;
	}

	public function getCorporation()
	{
		return $this->corporation;
	}

	public function getData($table, $fieldName, $value)
	{
		$result = $this->dbPDO->selectData('SELECT * FROM `' . $table . '` WHERE `' . $fieldName . '` = "' .$value . '" LIMIT 1');
		return $result;
	}

	public function getDataWithMulConditions($table, $data)
	{
		$compareStr = $this->prepareGetData($data);
		$result 	= $this->dbPDO->selectData('SELECT * FROM `' . $table . '` WHERE ' . $compareStr . ' LIMIT 1');
		return $result;
	}

	public function addData($table, $data)
	{
		Log::writeQueryLog( __FUNCTION__, $data);
		$data 	= $this->prepareAddData($data);
		$dataId = $this->dbPDO->executeData('INSERT INTO `' . $table . '`' . $data['key'] . ' VALUES ' . $data['value']);
		return $dataId;
	}

	public function updateData($table, $id, $data)
	{
		if (!empty($data['created_at'])) {
			unset($data['created_at']);
		}
		Log::writeQueryLog( __FUNCTION__, $data);
		$data = $this->prepareUpdateData($data);
		$this->dbPDO->executeData('UPDATE `' . $table . '` SET ' . $data . ' WHERE id = ' . $id);
	}

	public function prepareGetData($data)
	{
		$result 	= '';
		foreach ($data as $k => $v) {
			$result 	.= '`' . $k . '`=\'' . $v . '\' AND ';
		}
		$result 	= substr($result, 0, -5);
		return $result;
	}

	public function prepareAddData($data)
	{
		$key 	= '(';
		$value 	= '(';
		foreach ($data as $k => $v) {
			$key 	.= '`' . $k . '`, ';
			$value 	.= '\'' . $v . '\', ';
		}
		$key 	= substr($key, 0, -2) . ')';
		$value 	= substr($value, 0, -2) . ')';
		return array('key' => $key, 'value' => $value);
	}

	public function prepareUpdateData($data)
	{
		$result = '';
		foreach ($data as $k => $v) {
			$result	.= '`' . $k . '` = \'' . $v . '\', ';
		}
		$result = substr($result, 0, -2);
		return $result;
	}
}
