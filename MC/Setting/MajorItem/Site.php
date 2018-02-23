<?php

require_once './MC/Setting/MajorItem/MajorItemInterface.php';
require_once './MC/Setting/Trait/TraitClass.php';

class Site implements MajorItemInterface
{
	use TraitClass;

	private $table;
	private $dataQueryObj;

	function __construct($dataQueryObj) {

		$this->dataQueryObj = $dataQueryObj;
		$this->table 		= 'site';
	}

	public function addItem($data) {

		$newData = array();
		$this->formatData($data, $newData);
		$checkData = $this->existData($newData);
		if ($checkData == false) {
			$this->dataQueryObj->addData($this->table, $newData);
		} else {
			$this->dataQueryObj->updateData($this->table, $checkData->id, $newData);
		}
	}

	public function formatData($oldData, &$newData) {

		$newData['code'] 		= $oldData['サイトコード'];
		$newData['name'] 		= $oldData['サイト名'];
		$newData['name_kana'] 	= $oldData['サイト名カナ'];
		$this->addTimestamps($newData);
	}

	public function existData($data) {

		$resultData = $this->dataQueryObj->getData($this->table, 'code', $data['code']);
		if ($resultData == false) {
			return false;
		} else {
			return $resultData;
		}
	}
}