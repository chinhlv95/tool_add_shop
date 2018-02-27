<?php

require_once './MC/Setting/MajorItem/MajorItemInterface.php';
require_once './MC/Setting/Trait/TraitClass.php';
require_once './phpass/PasswordHash.php';
require_once './MC/Model/DataQuery.php';

class Al_Auth_User extends TraitClass implements MajorItemInterface
{

	private $dataQueryObj;
	private $table;

	function __construct() {

		$this->dataQueryObj = DataQuery::getDataQueryObj();
		$this->table 		= 'al_auth_user';
		$this->passWord 	= 'password';
		$this->phpass 		= new PasswordHash(12, true);
	}

	public function addItem($data) {

		$newData 		= array();
		$data 			= $this->trimData($data);
		$this->formatData($data, $newData);
		$checkAlAuthUser = $this->existData($newData['al_auth_user']);
		if ($checkAlAuthUser == false) {
			$alAuthUserId = $this->dataQueryObj->addData($this->table, $newData['al_auth_user']);

			$newData['al_auth_user_permission']['al_auth_user_id']	= $alAuthUserId;
			$this->dataQueryObj->addData('al_auth_user_permission', $newData['al_auth_user_permission']);

			$newData['user_profile']['al_auth_user_id']	= $alAuthUserId;
			$this->dataQueryObj->addData('user_profile', $newData['user_profile']);
		} else {
			$this->dataQueryObj->updateData($this->table, $checkAlAuthUser->id, $newData['al_auth_user']);

			$userPermission = $this->dataQueryObj->getData('al_auth_user_permission', 'al_auth_user_id', $checkAlAuthUser->id);
			$this->dataQueryObj->updateData('al_auth_user_permission', $userPermission->id, $newData['al_auth_user_permission']);

			$userProfile = $this->dataQueryObj->getData('user_profile', 'al_auth_user_id', $checkAlAuthUser->id);
			$this->dataQueryObj->updateData('user_profile', $userPermission->id, $newData['user_profile']);
		}
	}

	public function formatData($oldData, &$newData) {

		$newData['al_auth_user']['user_id'] 	= $oldData['ユーザID'];
		$newData['al_auth_user']['password'] 	= $this->phpass->HashPassword($this->passWord);
		$this->addTimestamps($newData['al_auth_user']);

		$newData['al_auth_user_permission']['al_auth_permission_id']	= $this->getPermission($oldData['権限']);
		$this->addTimestamps($newData['al_auth_user_permission']);

		$newData['user_profile']['name']		= $oldData['管理ユーザ名'];
		$newData['user_profile']['description']	= $oldData['ユーザの説明'];
		if ($oldData['有効／無効'] == '有効') {
			$newData['user_profile']['is_active']	= 1;
		} else {
			$newData['user_profile']['is_active']	= 0;
		}
		$corporation 	= $this->dataQueryObj->getData('corporation', 'name', $oldData['法人']);
		$supplier 		= $this->dataQueryObj->getData('supplier', 'code', $oldData['サプライヤ']);
		$newData['user_profile']['corporation_id']	= $corporation->id;
		$newData['user_profile']['supplier_id']		= $supplier->id;
		$this->addTimestamps($newData['user_profile']);
	}

	public function existData($data) {

		$resultData = $this->dataQueryObj->getData('al_auth_user', 'user_id', $data['user_id']);
		return $resultData;
	}

	public function getPermission($permissionName) {

		switch ($permissionName) {
            case 'admin':
		    	return 1;
		    	break;
		    case 'shop':
		        return 2;
		        break;
		    case 'supplier':
		        return 3;
		        break;
		    case 'corporation':
		        return 4;
		        break;
		    default:
		        return null;
		        break;
        }
	}
}
