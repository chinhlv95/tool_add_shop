<?php

class TraitClass
{
    public static function addTimestamps(&$data) {

        $now = date('Y-m-d H:i:s');
        $data['created_at']	= $now;
		$data['updated_at']	= $now;
		$data['created_by']	= 'aloha_admin';
		$data['updated_by']	= 'aloha_admin';
    }

    public static function addTimestampsWithCorporation(&$data, $corporation) {

        $now = date('Y-m-d H:i:s');
        $data['created_at']	= $now;
		$data['updated_at']	= $now;
		$data['created_by']	= $corporation;
		$data['updated_by']	= $corporation;
    }

    public static function trimSpace($string) {

	    $string = trim($string,'	 ');
	    return $string;
	}

	public static function trimData($data) {

		$instance 	= new self();
		$key 		= array_map(array($instance, 'trimSpace'), array_keys($data));
		$value 		= array_map(array($instance, 'trimSpace'), $data);
		$result 	= array_combine($key, $value);
		return $result;
	}
}
