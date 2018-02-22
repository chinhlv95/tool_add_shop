<?php

require_once './MC/Setting/MajorItem/MajorItemInterface.php';

class ShopSupplier implements MajorItemInterface
{
	private $table;
	private $dataQueryObj;

	function __construct($dataQueryObj) {

		$this->dataQueryObj = $dataQueryObj;
		$this->table 		= 'supply_shop';
	}

	public function addItem($data) {

		$newData = array();
		$this->formatData($data, $newData);
		$checkData = $this->existData($newData);
		if ($checkData == false) {
			$this->dataQueryObj->addData($this->table, $newData);
		} else {
			unset($newData['created_at']);
			$this->dataQueryObj->updateData($this->table, $checkData->id, $newData);
		}
	}

	public function formatData($oldData, &$newData) {

		$supplierName 			= $oldData['サプライヤ'];
		$corporationName 		= $oldData['法人名'];
		$siteName 				= $oldData['サイト名'];
		$newData['priority'] 	= $oldData['優先度'];
		$newData['is_active'] 	= 1;
		$supplier 				= $this->dataQueryObj->getData('supplier', 'name', $supplierName);
		$newData['supplier_id'] = $supplier->id;
		$corporation 			= $this->dataQueryObj->getData('corporation', 'name', $corporationName);
		$site 					= $this->dataQueryObj->getData('site', 'name', $siteName);
		$shop 					= $this->dataQueryObj->getDataWithMulConditions('shop', 'corporation_id', $corporation->id, 'site_id', $site->id);
		$newData['shop_id'] 	= $shop->id;
		$newData['created_at']	= date('Y-m-d H:i:s');
		$newData['updated_at']	= date('Y-m-d H:i:s');
	}

	public function existData($data) {

		$resultData = $this->dataQueryObj->getDataWithMulConditions($this->table, 'supplier_id', $data['supplier_id'], 'shop_id', $data['shop_id']);
		if ($resultData == false) {
			return false;
		} else {
			return $resultData;
		}
	}
}