<?php

interface MajorItemInterface
{
	public function addItem($data);

	public function formatData($oldData, &$newData);

	public function existData($data);
}
