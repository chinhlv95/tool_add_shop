<?php

require_once './MC/Model/PDOData.php';

class DataQuery extends PDOData
{
	private $dbPDO = null;

	function __construct($corporation) {

		$this->dbPDO = new PDOData($corporation);
	}

	public function getConnection() {

		return $this->dbPDO;
	}

	public function addData($table, $data) {

		$data = $this->prepareAddData($data);
		$dataId = $this->dbPDO->executeData('INSERT INTO `' . $table . '`' . $data['key'] . ' VALUES ' . $data['value']);
		return $dataId;
	}

	public function getData($table, $fieldName, $value) {
		$result = $this->dbPDO->selectData('SELECT * FROM `' . $table . '` WHERE `' . $fieldName . '` = "' .$value . '" LIMIT 1');
		return $result;
	}

	public function getDataWithMulConditions($table, $fieldName1, $value1, $fieldName2, $value2) {

		$result = $this->dbPDO->selectData('SELECT * FROM `' . $table . '` WHERE `' . $fieldName1 . '` = "' . $value1 . '" AND `' . $fieldName2 . '` = "' .$value2 . '" LIMIT 1');
		return $result;
	}

	public function updateData($table, $id, $data) {

		if (!empty($data['created_at'])) {
			unset($data['created_at']);
		}
		$data = $this->prepareUpdateData($data);
		$this->dbPDO->executeData('UPDATE `' . $table . '` SET ' . $data . ' WHERE id = ' . $id);
	}

	public function prepareAddData($data) {

		$key 	= '(';
		$value 	= '(';
		foreach ($data as $k => $v) {
			$key 	.= '`' . $k . '`, ';
			$value 	.= '\'' . $v . '\', ';
		}
		$key 	= substr($key, 0, -2) . ')';
		$value 	= substr($value, 0, -2) . ')';
		return ['key' => $key, 'value' => $value];
	}

	public function prepareUpdateData($data) {

		$result = '';
		foreach ($data as $k => $v) {
			$result	.= '`' . $k . '` = \'' . $v . '\', ';
		}
		$result = substr($result, 0, -2);
		return $result;
	}
}
