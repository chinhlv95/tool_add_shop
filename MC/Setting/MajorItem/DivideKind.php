<?php

require_once './MC/Setting/MajorItem/MajorItemInterface.php';
require_once './MC/Model/DataQuery.php';
require_once './MC/Setting/Trait/TraitClass.php';

class DivideKind implements MajorItemInterface
{

	private $dataQueryObj;
	private $table;

	function __construct()
	{
		$this->dataQueryObj = DataQuery::getDataQueryObj();
		$this->table 		= 'divide_kind_group';
	}

	public function addItem($data)
	{
		try {
			$newData 	= array();
			$data 		= TraitClass::trimData($data);
			$this->formatData($data, $newData);
			$checkData 	= $this->existData($newData['divide_kind_group']);
			if ($checkData == false) {
				$divideKindId = $this->dataQueryObj->addData($this->table, $newData['divide_kind_group']);

				$newData['divide_kind_detail']['api']['divide_kind_group_id'] = $divideKindId;
				$this->dataQueryObj->addData('divide_kind_detail', $newData['divide_kind_detail']['api']);

				$newData['divide_kind_detail']['batch']['divide_kind_group_id'] = $divideKindId;
				$this->dataQueryObj->addData('divide_kind_detail', $newData['divide_kind_detail']['batch']);

			} else {
				$this->dataQueryObj->updateData($this->table, $checkData->id, $newData['divide_kind_group']);

				$dataAPI 	= array('divide_kind_group_id' => $checkData->id, 'kind' => 2);
				$divideAPI 	= $this->dataQueryObj->getDataWithMulConditions('divide_kind_detail', $dataAPI);
				$this->dataQueryObj->updateData('divide_kind_detail', $divideAPI->id, $newData['divide_kind_detail']['api']);

				$dataBatch 		= array('divide_kind_group_id' => $checkData->id, 'kind' => 1);
				$divideBatch 	= $this->dataQueryObj->getDataWithMulConditions('divide_kind_detail', $dataBatch);
				$this->dataQueryObj->updateData('divide_kind_detail', $divideBatch->id, $newData['divide_kind_detail']['batch']);
			}
		} catch(Exception $e) {
	    	//Print out the error message.
	    	echo $e->getMessage();
	    }
	}

	public function formatData($oldData, &$newData)
	{
		$corporationName 	= $this->dataQueryObj->getCorporation();
		$supplierGroupName 	= $oldData['サプライヤグループ'];
		$supplierGroup		= $this->dataQueryObj->getData('supplier_group', 'name', $supplierGroupName);
		if ($supplierGroup) {
			$newData['divide_kind_group']['supplier_group_id'] 	= $supplierGroup->id;
		} else {
			$newData['divide_kind_group']['supplier_group_id'] 	= 0;
		}
		$newData['divide_kind_group']['type'] 				= $this->getDeivdeType($oldData['タイプ']);
		$corporation					= $this->dataQueryObj->getData('corporation', 'code', $corporationName);
		$newData['divide_kind_group']['corporation_id'] 		= $corporation->id;
		$newData['divide_kind_group']['name'] 				= $oldData['振り分けグループ名'];
		if (!empty($oldData['コード'])) {
			$newData['divide_kind_group']['reference'] 		= $oldData['コード'];
		} else {
			$newData['divide_kind_group']['reference'] 		= '';
		}
		TraitClass::addTimestampsWithCorporation($newData['divide_kind_group'], $corporationName);

		$newData['divide_kind_detail']['api']['name'] 		= $oldData['振り分けグループ名'];
		$newData['divide_kind_detail']['api']['kind'] 		= 2;
		$newData['divide_kind_detail']['api']['rate'] 		= $oldData['API振分'] * 100;
		TraitClass::addTimestampsWithCorporation($newData['divide_kind_detail']['api'], $corporationName);

		$newData['divide_kind_detail']['batch']['name'] 	= $oldData['振り分けグループ名'];
		$newData['divide_kind_detail']['batch']['kind'] 	= 1;
		$newData['divide_kind_detail']['batch']['rate'] 	= $oldData['バッチ振分'] * 100;
		TraitClass::addTimestampsWithCorporation($newData['divide_kind_detail']['batch'], $corporationName);

	}

	public function existData($data)
	{
		$fieldData = array('corporation_id' => $data['corporation_id'], 'type' => $data['type'], 'reference' => $data['reference'], 'supplier_group_id' => $data['supplier_group_id']);
		$resultData = $this->dataQueryObj->getDataWithMulConditions($this->table, $fieldData);
		return $resultData;
	}

	public function getDeivdeType($type)
	{
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
