<?php

require_once './MC/Setting/CreateFolder.php';
require_once './MC/Setting/SettingSite.php';
require_once './MC/Setting/Trait/TraitClass.php';

class SettingFactory
{
	use TraitClass;

	public function getSettingType($type) {

		$type = $this->trimSpace($type);

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
