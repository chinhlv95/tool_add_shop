<?php

require_once './MC/Setting/MajorItem/Setting.php';
require_once './MC/Setting/MajorItem/Shop.php';
require_once './MC/Setting/MajorItem/ShopSupplier.php';
require_once './MC/Setting/MajorItem/Site.php';
require_once './MC/Setting/MajorItem/Supplier.php';
require_once './MC/Setting/MajorItem/Al_Auth_User.php';

class MajorItemFactory
{
	public function __construct($dataQueryObj) {

		$this->site 		= new Site($dataQueryObj);
		$this->shop 		= new Shop($dataQueryObj);
		$this->supplier 	= new Supplier($dataQueryObj);
		$this->shopSupplier = new ShopSupplier($dataQueryObj);
		$this->alAuthUser 	= new Al_Auth_User($dataQueryObj);
		$this->setting 		= new Setting($dataQueryObj);
	}

	public function getMajorItemType($type) {

		switch ($type) {
            case 'サイト':
		    	return $this->site;
		    	break;
		    case 'ショップ':
		        return $this->shop;
		        break;
		    case 'サプライヤ':
		        return $this->supplier;
		        break;
		    case 'ショップ-サプライヤ':
		        return $this->shopSupplier;
		        break;
		    case '倉庫ユーザ':
		        return $this->alAuthUser;
		        break;
		    case '設定':
		        return $this->setting;
		        break;
		    default:
		        return null;
		        break;
        }
        return null;
	}
}
