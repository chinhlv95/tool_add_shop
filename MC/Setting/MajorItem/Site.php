<?php

require_once './MC/Setting/MajorItem/MajorItemInterface.php';
require_once './MC/Model/DataQuery.php';
require_once './MC/Setting/Trait/TraitClass.php';

class Site implements MajorItemInterface
{
	use TraitClass;

	private $dataQueryObj;
	private $table;

	function __construct() {

		$this->dataQueryObj = DataQuery::getDataQueryObj();
		$this->table 		= 'site';
	}

	public function addItem($data) {

		$newData 	= array();
		$data 		= $this->trimData($data);
		$this->formatData($data, $newData);
		$checkData 	= $this->existData($newData);
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
		return $resultData;
	}
}
