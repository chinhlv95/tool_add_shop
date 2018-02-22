<?php

require_once './MC/Setting/MajorItem/MajorItemInterface.php';

class Site implements MajorItemInterface
{
	private $table;
	private $dataQueryObj;

	function __construct($dataQueryObj) {

		$this->dataQueryObj = $dataQueryObj;
		$this->table 		= 'site';
	}

	public function addItem($data) {

		$newData = array();
		$this->formatData($data, $newData);
		$this->dataQueryObj->addData($this->table, $newData);
	}

	public function formatData($oldData, &$newData) {

		$newData['code'] 		= $oldData['サイトコード'];
		$newData['name'] 		= $oldData['サイト名'];
		$newData['name_kana'] 	= $oldData['サイト名カナ'];
		$newData['created_at']	= date('Y-m-d H:i:s');
		$newData['updated_at']	= date('Y-m-d H:i:s');
	}
}