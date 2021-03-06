<?php

require_once './MC/Setting/CreateFolder.php';
require_once './MC/Setting/SettingSite.php';

class SettingFactory
{

	public function getSettingType($type)
	{
		$type = trim($type,'	 ');

		switch ($type) {
            case 'SCSサーバ作業':
		    	return new CreateFolder();
		    	break;
		    case 'マスタ設定':
		        return new SettingSite();
		        break;
		    default:
		        return null;
		        break;
        }
        return null;
	}
}
