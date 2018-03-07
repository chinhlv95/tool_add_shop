<?php

require_once './MC/Setting/MajorItem/Site.php';
require_once './MC/Setting/MajorItem/Shop.php';
require_once './MC/Setting/MajorItem/Supplier.php';
require_once './MC/Setting/MajorItem/ShopSupplier.php';
require_once './MC/Setting/MajorItem/Al_Auth_User.php';
require_once './MC/Setting/MajorItem/Setting.php';
require_once './MC/Setting/MajorItem/SupplierGroup.php';
require_once './MC/Setting/MajorItem/Cap.php';
require_once './MC/Setting/MajorItem/DivideKind.php';

class MajorItemFactory
{

	public function __construct()
	{
		$this->site 			= new Site();
		$this->shop 			= new Shop();
		$this->supplier 		= new Supplier();
		$this->shopSupplier 	= new ShopSupplier();
		$this->alAuthUser 		= new Al_Auth_User();
		$this->setting 			= new Setting();
		$this->supplierGroup 	= new SupplierGroup();
		$this->cap 				= new Cap();
		$this->divideKind 		= new DivideKind();
	}

	public function getMajorItemType($type)
	{
		$type = trim($type,'	 ');

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
		    case 'サプライヤグループ':
		        return $this->supplierGroup;
		        break;
		    case 'CAＰ設定':
		        return $this->cap;
		        break;
		    case '振分設定':
		        return $this->divideKind;
		        break;
		    default:
		        return null;
		        break;
        }
	}
}
