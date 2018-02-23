<?php

require_once './PHPExcel/PHPExcel/IOFactory.php';
require_once './MC/Setting/SettingInterface.php';

class CreateFolder implements SettingInterface
{
	public function __construct() {

	}

	public function executeSetting($corporation = null, $worksheet) {

		$lowestRow 			= 4;
		$configCol 			= "G";
		$highestRow         = $worksheet->getHighestRow(); // e.g. 10
	    $configColumnIndex  = PHPExcel_Cell::columnIndexFromString($configCol);

	    $log = '';
	    for ($row = $lowestRow; $row <= $highestRow; $row ++) {
	        $cell 		= $worksheet->getCellByColumnAndRow($configColumnIndex - 1, $row);
	        $colorCell 	=  $cell->getStyle()->getFill()->getStartColor()->getRGB();
	        $val 		= $cell->getValue();
	        if ($val && ($colorCell == 'FFFFFF' || $colorCell == '000000')) {
	        	shell_exec($val);
	        	$log .= date("Y-m-d h:i:s") . '--> Execute command: ' . $val . "\r\n";
	        }
	    }

	    file_put_contents('./logs/log-'.date("Y-m-d").'.txt', $log, FILE_APPEND);
	}
}
