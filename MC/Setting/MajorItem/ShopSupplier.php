<?php

require_once './MC/Setting/MajorItem/MajorItemInterface.php';
require_once './MC/Model/DataQuery.php';
require_once './MC/Setting/Trait/TraitClass.php';

class ShopSupplier extends TraitClass implements MajorItemInterface
{

	private $dataQueryObj;
	private $table;

	function __construct() {

		$this->dataQueryObj = DataQuery::getDataQueryObj();
		$this->table 		= 'supply_shop';
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
		$this->addTimestamps($newData);
	}

	public function existData($data) {

		$resultData = $this->dataQueryObj->getDataWithMulConditions($this->table, 'supplier_id', $data['supplier_id'], 'shop_id', $data['shop_id']);
		return $resultData;
	}
}
