<?php

require_once './MC/Setting/MajorItem/MajorItemInterface.php';
require_once './MC/Model/DataQuery.php';
require_once './MC/Setting/Trait/TraitClass.php';

class Cap implements MajorItemInterface
{

	private $dataQueryObj;
	private $table;

	function __construct() {

		$this->dataQueryObj = DataQuery::getDataQueryObj();
		$this->table 		= 'cap';
	}

	public function addItem($data) {

		try {
			$newData 	= array();
			$data 		= TraitClass::trimData($data);
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

		$supplierGroupName 				= $oldData['サプライヤグループ'];
		$supplierGroup					= $this->dataQueryObj->getData('supplier_group', 'name', $supplierGroupName);
		$newData['supplier_group_id'] 	= $supplierGroup->id;
		$newData['corporation_id'] 		= $supplierGroup->corporation_id;
		$newData['name'] 				= $oldData['CAP条件名'];
		$newData['quantity'] 			= $oldData['実店舗用数量'];
		$newData['type'] 				= $this->getCapType($oldData['タイプ']);
		TraitClass::addTimestampsWithCorporation($newData, $this->dataQueryObj->getCorporation());
	}

	public function existData($data) {

		$resultData = $this->dataQueryObj->getData($this->table, 'supplier_group_id', $data['supplier_group_id']);
		return $resultData;
	}

	public function getCapType($type) {

		switch ($type) {
            case '商品CS':
		    	return 1;
		    	break;
		    case 'カテゴリ':
		        return 2;
		        break;
		    case 'デフォルト':
		        return 99;
		        break;
		    default:
		        return null;
		        break;
        }
	}
}
