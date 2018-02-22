<?php

require_once './MC/Setting/MajorItem/MajorItemInterface.php';

class Supplier implements MajorItemInterface
{
	private $table;
	private $dataQueryObj;

	function __construct($dataQueryObj) {

		$this->dataQueryObj = $dataQueryObj;
		$this->table 		= 'supplier';
	}

	public function addItem($data) {

		$newData = array();
		$this->formatData($data, $newData);
		$this->dataQueryObj->addData($this->table, $newData);
	}

	public function formatData($oldData, &$newData) {

		$supplierGroupName 		= $oldData['サプライヤグループ'];
		$newData['code'] 		= $oldData['サプライヤコード'];
		$newData['name'] 		= $oldData['サプライヤ名'];
		$newData['name_kana'] 	= $oldData['サプライヤ名カナ'];
		$newData['tel'] 		= $oldData['電話番号'];
		$newData['fax'] 		= '';
		$newData['email'] 		= $oldData['メールアドレス'];
		$newData['api_code'] 	= $oldData['API連携コード'];
		$newData['reservation_auth'] 	= 0;
		$supplierGroup 					= $this->dataQueryObj->getData('supplier_group', 'name', $supplierGroupName);
		$newData['supplier_group_id'] 	= $supplierGroup->id;
		$newData['created_at']	= date('Y-m-d H:i:s');
		$newData['updated_at']	= date('Y-m-d H:i:s');
	}
}