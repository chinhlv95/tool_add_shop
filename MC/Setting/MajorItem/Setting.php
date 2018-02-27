<?php

require_once './MC/Setting/MajorItem/MajorItemInterface.php';
require_once './MC/Model/DataQuery.php';
require_once './MC/Setting/Trait/TraitClass.php';

class Setting implements MajorItemInterface
{

	private $dataQueryObj;
	private $table;

	function __construct() {

		$this->dataQueryObj = DataQuery::getDataQueryObj();
		$this->table 		= 'setting';
	}

	public function addItem($data) {

		$newData 	= array();
		$data 		= TraitClass::trimData($data);
		$this->formatData($data, $newData);
		$checkData 	= $this->existData($newData);
		if ($checkData == false) {
			$this->dataQueryObj->addData($this->table, $newData);
		} else {
			$this->dataQueryObj->updateData($this->table, $checkData->id, $newData);
		}
	}

	public function formatData($oldData, &$newData) {

		$newData = $oldData;
		TraitClass::addTimestamps($newData);
	}

	public function existData($data) {

		$resultData = $this->dataQueryObj->getData($this->table, 'key', $data['key']);
		return $resultData;
	}
}
