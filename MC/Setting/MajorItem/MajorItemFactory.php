<?php

require_once './MC/Setting/MajorItem/Configuration.php';
require_once './MC/Setting/MajorItem/Shop.php';
require_once './MC/Setting/MajorItem/ShopSupplier.php';
require_once './MC/Setting/MajorItem/Site.php';
require_once './MC/Setting/MajorItem/Supplier.php';

class MajorItemFactory
{
	public function getMajorItemType($type, $dataQueryObj) {

		switch ($type) {
            case 'サイト':
		    	return new Site($dataQueryObj);
		    	break;
		    case 'ショップ':
		        return new Shop($dataQueryObj);
		        break;
		    case 'サプライヤ':
		        return new Supplier($dataQueryObj);
		        break;
		    case 'ショップ-サプライヤ':
		        return new ShopSupplier($dataQueryObj);
		        break;
		    case '設定':
		        return new Configuration($dataQueryObj);
		        break;
		    default:
		        return null;
		        break;
        }
        return null;
	}
}
?>