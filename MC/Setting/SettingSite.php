<?php

require_once './PHPExcel/PHPExcel/IOFactory.php';
require_once './MC/Setting/SettingInterface.php';
require_once './MC/Model/DataQuery.php';
require_once './MC/Setting/MajorItem/MajorItemFactory.php';
require_once './Log/Log.php';

class SettingSite implements SettingInterface
{

	public function executeSetting($corporation, $worksheet) {

		$dataQueryObj 	= DataQuery::getInstance($corporation);
		$majorItemObj 	= new MajorItemFactory();

		try {

			$lowestRow 			= 3;
			$lowestColumn 		= "C";
			$highestRow         = $worksheet->getHighestRow();
		    $lowestColumn 		= PHPExcel_Cell::columnIndexFromString($lowestColumn);
		    $data 				= array();
		    $majorItemType 		= '';

		    for ($row = $lowestRow; $row <= $highestRow; $row++) {
		    	$colorCell 		=  $worksheet->getCellByColumnAndRow($lowestColumn - 1, $row)->getStyle()->getFill()->getStartColor()->getRGB();
		    	if ($colorCell == 'FFFFFF' || $colorCell == '000000') {
			    	$checkConfigurationName = $worksheet->getCellByColumnAndRow($lowestColumn - 2, $row)->getValue();
			    	$checkConfigurationName = trim($checkConfigurationName, '	 ');
			    	if ($checkConfigurationName != '設定') {
				    	$majorItemTypeNow 	= $worksheet->getCellByColumnAndRow($lowestColumn - 1, $row)->getValue();
			            $key 				= $worksheet->getCellByColumnAndRow($lowestColumn, $row)->getValue();
			            $val 				= $worksheet->getCellByColumnAndRow($lowestColumn + 1, $row)->getValue();
			            if (!empty($majorItemTypeNow)) {
			            	if (!empty($data)) {
			            		$majorItem = $majorItemObj->getMajorItemType($majorItemType);
			            		if ($majorItem != null) {
			            			Log::writeMajorLog($majorItemType);
			            			$majorItem->addItem($data);
			            		}
			            	}
			            	$data = array();
			            }
			            $data[$key] = $val;
			            if (!empty($majorItemTypeNow)) {
			            	$majorItemType 	= $worksheet->getCellByColumnAndRow($lowestColumn -1, $row)->getValue();
			            }
			        } elseif ($checkConfigurationName == '設定') {
			        	if (!empty($data)) {
		            		$majorItem = $majorItemObj->getMajorItemType($majorItemType);
		            		if ($majorItem != null) {
		            			Log::writeMajorLog($majorItemType);
		            			$majorItem->addItem($data);
		            		}
		            	}
			        	$majorItemType = '設定';
			        	$majorItem = $majorItemObj->getMajorItemType($majorItemType);
			        	for ($row1 = $row + 2; $row1 <= $highestRow; $row1++) {
			        		$setting['name']	= $worksheet->getCellByColumnAndRow($lowestColumn, $row1)->getValue();
			            	$setting['key'] 	= $worksheet->getCellByColumnAndRow($lowestColumn + 1, $row1)->getValue();
			            	$setting['value']	= $worksheet->getCellByColumnAndRow($lowestColumn + 2, $row1)->getValue();
			            	if ($setting['key'] != null) {
			            		Log::writeMajorLog($majorItemType);
			            		$majorItem->addItem($setting);
			            	} else {
			            		break;
			            	}
			        	}
			        	break;
			        }
			    }
		    }
	    } catch(Exception $e) {
	    	//Print out the error message.
	    	echo $e->getMessage();
	    }
	}
}
