<?php

require_once './MC/Setting/MajorItem/MajorItemInterface.php';
require_once './MC/Model/DataQuery.php';
require_once './MC/Setting/Trait/TraitClass.php';

class SupplierGroup extends TraitClass implements MajorItemInterface
{

	private $dataQueryObj;
	private $table;

	function __construct() {

		$this->dataQueryObj = DataQuery::getDataQueryObj();
		$this->table 		= 'supplier_group';
	}

	public function addItem($data) {

		try {
			$newData 	= array();
			$data 		= $this->trimData($data);
			$this->formatData($data, $newData);
			$checkData 	= $this->existData($newData);
			if ($checkData == false) {
				$this->dataQueryObj->addData($this->table, $newData);
			} else {
				$this->dataQueryObj->updateData($this->table, $checkData->id, $newData);
			}
		} catch(Exception $e) {
	    	//Print out the error message.
	    	echo $e->getMessage();
	    }
	}

	public function formatData($oldData, &$newData) {

		$corporationName 			= $oldData['法人'];
		$newData['name'] 			= $oldData['サプライヤグループ名'];
		$corporation 				= $this->dataQueryObj->getData('corporation', 'name', $corporationName);
		$newData['corporation_id'] 	= $corporation->id;
		$this->addTimestamps($newData);
	}

	public function existData($data) {

		$resultData = $this->dataQueryObj->getData($this->table, 'name', $data['name']);
		return $resultData;
	}
}
