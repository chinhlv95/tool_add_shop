<?php

require_once './PHPExcel/PHPExcel/IOFactory.php';
require_once './MC/Setting/Setting.php';

class SettingSite implements Setting
{
	public function __construct() {

	}

	public function executeSetting($corporation, $worksheet) {
		
		$highestRow         = $worksheet->getHighestRow(); // e.g. 10
	    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
	    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
	    $nrColumns = ord($highestColumn) - 64;
	    echo $highestRow . '----' . $highestColumn . '-----'. $highestColumnIndex;
	    echo $nrColumns . ' columns (A-' . $highestColumn . ') ';
	    echo ' and ' . $highestRow . ' row.';
	    echo '<br>Data: <table border="1"><tr>';
	    for ($row = 1; $row <= $highestRow; ++ $row) {
	        echo '<tr>';
	        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
	            $cell = $worksheet->getCellByColumnAndRow($col, $row);
	            $val = $cell->getValue();
	            $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
	            echo '<td>' . $val . '</td>';
	        }
	        echo '</tr>';
	    }
    	echo '</table>';
	}
}
?>