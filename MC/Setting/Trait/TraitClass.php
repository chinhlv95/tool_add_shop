<?php

trait TraitClass
{
    public function addTimestamps(&$data)
    {
        $now = date('Y-m-d H:i:s');
        $data['created_at']	= $now;
		$data['updated_at']	= $now;
		$data['created_by']	= 'aloha_admin';
		$data['updated_by']	= 'aloha_admin';
    }
}