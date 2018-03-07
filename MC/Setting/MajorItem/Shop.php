<?php

require_once './MC/Setting/MajorItem/MajorItemInterface.php';
require_once './MC/Model/DataQuery.php';
require_once './MC/Setting/Trait/TraitClass.php';

class Shop implements MajorItemInterface
{

	private $dataQueryObj;
	private $table;

	function __construct()
	{
		$this->dataQueryObj = DataQuery::getDataQueryObj();
		$this->table 		= 'shop';
	}

	public function addItem($data)
	{
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

	public function formatData($oldData, &$newData)
	{
		$corporationName 		= $oldData['法人名'];
		$siteName 				= $oldData['サイト名'];
		$type 					= $oldData['種別'];
		$productCodeParentFlag 	= $oldData['SCS商品コード主店舗'];
		$newData['code'] 		= $oldData['コード'];
		$newData['user_name'] 	= $oldData['担当者名'];
		$newData['tel'] 		= $oldData['電話番号'];
		$newData['fax'] 		= '';
		$newData['email'] 		= $oldData['メールアドレス'];
		$newData['url_path'] 	= $oldData['URL'];
		$corporation 				= $this->dataQueryObj->getData('corporation', 'name', $corporationName);
		$newData['corporation_id'] 	= $corporation->id;
		$site 						= $this->dataQueryObj->getData('site', 'name', $siteName);
		$newData['site_id'] 		= $site->id;
		if ($type == 'API') {
			$newData['kind'] = 1;
		} elseif ($type == 'バッチ') {
			$newData['kind'] = 2;
		}
		if ($productCodeParentFlag == '主店舗') {
			$newData['product_code_parent_flag'] = 1;
		} elseif ($productCodeParentFlag == '紐付け対象') {
			$newData['product_code_parent_flag'] = 2;
		}
		TraitClass::addTimestamps($newData);
	}

	public function existData($data)
	{
		$resultData = $this->dataQueryObj->getData($this->table, 'code', $data['code']);
		return $resultData;
	}
}
