<?php

require_once './PHPExcel/PHPExcel/IOFactory.php';
require_once './MC/Setting/SettingFactory.php';

class SettingController
{
	public function __construct() {

		$this->settingType = new SettingFactory();
	}

	public function setShop($corporation, $target_path) {

		$objPHPExcel 	= PHPExcel_IOFactory::load($target_path);
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			$worksheetTitle = $worksheet->getTitle();
			$objSetting		= $this->settingType->getSettingType($worksheetTitle);
			if(!empty($objSetting)) {
				$objSetting->executeSetting($corporation, $worksheet);
			}
		}
		unlink($target_path);
	}
}
