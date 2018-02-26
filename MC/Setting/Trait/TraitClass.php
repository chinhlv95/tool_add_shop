<?php

trait TraitClass
{
    public function addTimestamps(&$data) {

        $now = date('Y-m-d H:i:s');
        $data['created_at']	= $now;
		$data['updated_at']	= $now;
		$data['created_by']	= 'aloha_admin';
		$data['updated_by']	= 'aloha_admin';
    }

    public function addTimestampsWithCorporation(&$data, $corporation) {

        $now = date('Y-m-d H:i:s');
        $data['created_at']	= $now;
		$data['updated_at']	= $now;
		$data['created_by']	= $corporation;
		$data['updated_by']	= $corporation;
    }

    public function trimSpace($string) {

	    $string = trim($string,'	 ');
	    return $string;
	}

	public function trimData($data) {

		$key 	= array_map(array($this, 'trimSpace'), array_keys($data));
		$value 	= array_map(array($this, 'trimSpace'), $data);
		$result = array_combine($key, $value);
		return $result;
	}
}
