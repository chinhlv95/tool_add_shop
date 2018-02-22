<?php

require_once './PHPExcel/PHPExcel/IOFactory.php';
require_once './MC/Setting/SettingInterface.php';
require_once './MC/Model/DataQuery.php';
require_once './MC/Setting/MajorItem/MajorItemFactory.php';

class SettingSite implements SettingInterface
{
	public function __construct() {

		$this->majorItemObj = new MajorItemFactory();
	}

	public function executeSetting($corporation, $worksheet) {

		$dataQueryObj 			= new DataQuery($corporation);
		$connection 			= $dataQueryObj->getConnection()->getConnection();
		// $connection->beginTransaction();

		try {

			$lowestRow 			= 3;
			$lowestColumn 		= "C";
			$highestRow         = $worksheet->getHighestRow();
		    $lowestColumn 		= PHPExcel_Cell::columnIndexFromString($lowestColumn);
		    $data 				= array();
		    $majorItemType 		= '';

		    for ($row = $lowestRow; $row <= $highestRow; $row++) {
		    	$majorItemTypeNow = $worksheet->getCellByColumnAndRow($lowestColumn -1, $row)->getValue();
	            $key 			= $worksheet->getCellByColumnAndRow($lowestColumn, $row)->getValue();
	            $val 			= $worksheet->getCellByColumnAndRow($lowestColumn + 1, $row)->getValue();
	            if (!empty($majorItemTypeNow)) {
	            	if (!empty($data)) {
	            		$majorItem = $this->majorItemObj->getMajorItemType($majorItemType, $dataQueryObj);
	            		if ($majorItem != null) {
	            			$majorItem->addItem($data);
	            		}
	            	}
	            	$data = array();
	            }
	            $data[$key] = $val;
	            if ($majorItemTypeNow != null) {
	            	$majorItemType 	= $worksheet->getCellByColumnAndRow($lowestColumn -1, $row)->getValue();
	            }
		    }

	    	// $connection->commit();
	    } catch(Exception $e) {
	    	//Print out the error message.
	    	echo $e->getMessage();
	    	// $connection->rollBack();
	    }
	}
}
?>