<?php

require_once './PHPExcel/PHPExcel/IOFactory.php';
require_once './MC/Setting/Setting.php';

class CreateForder implements Setting
{
	public function __construct() {

	}

	public function executeSetting($corporation = null, $worksheet) {
		$config 	  		= include('./config/config.php');
		$startRow 			= $config['create_forder_sheet']['start_row'];
		$startCol 			= $config['create_forder_sheet']['start_col'];
		$highestRow         = $worksheet->getHighestRow(); // e.g. 10
	    $configColumnIndex  = PHPExcel_Cell::columnIndexFromString($startCol);

	    $log = '';
	    for ($row = $startRow; $row <= $highestRow; $row ++) {
	        $cell = $worksheet->getCellByColumnAndRow($configColumnIndex - 1, $row);
	        $val = $cell->getValue();
	        if ($val) {
	        	shell_exec($val);
	        	$log .= date("Y-m-d h:i:s") . '--> Execute command: ' . $val . "\r\n";
	        }
	    }

	    file_put_contents('./logs/log-'.date("Y-m-d").'.txt', $log, FILE_APPEND);
	}
}
?>