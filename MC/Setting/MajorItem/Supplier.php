<?php

require_once './MC/Setting/MajorItem/MajorItemInterface.php';
require_once './MC/Model/DataQuery.php';
require_once './MC/Setting/Trait/TraitClass.php';

class Supplier extends TraitClass implements MajorItemInterface
{

	private $dataQueryObj;
	private $table;

	public function __construct() {

		$this->dataQueryObj = DataQuery::getDataQueryObj();
		$this->table 		= 'supplier';
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

		$newData['code'] 		= $oldData['サプライヤコード'];
		$newData['name'] 		= $oldData['サプライヤ名'];
		$newData['name_kana'] 	= $oldData['サプライヤ名カナ'];
		$newData['tel'] 		= $oldData['電話番号'];
		$newData['fax'] 		= '';
		$newData['email'] 		= $oldData['メールアドレス'];
		$newData['api_code'] 	= $oldData['API連携コード'];
		$newData['reservation_auth'] 	= 0;
		if (!empty($oldData['サプライヤグループ'])) {
			$supplierGroupName 				= $oldData['サプライヤグループ'];
			$supplierGroup 					= $this->dataQueryObj->getData('supplier_group', 'name', $supplierGroupName);
			$newData['supplier_group_id'] 	= $supplierGroup->id;
		} else {
			$newData['supplier_group_id'] 	= 0;
		}
		$this->addTimestamps($newData);
	}

	public function existData($data) {

		$resultData = $this->dataQueryObj->getData($this->table, 'code', $data['code']);
		return $resultData;
	}
}
