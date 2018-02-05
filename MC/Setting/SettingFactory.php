<?php

require_once './MC/Setting/CreateForder.php';
require_once './MC/Setting/SettingSite.php';

class SettingFactory
{
	public function getSettingType($type) {

		switch ($type) {
            case "SCSサーバ作業":
		    	return new CreateForder();
		    	break;
		    case "マスタ設定":
		        return new SettingSite();
		        break;
		    default:
		        return null;
		        break;
        }
        return null;
	}
}
?>