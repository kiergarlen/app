<?php
require "DalSiclab.php";

class SiclabService
{
	public function SiclabService() {
	}

	public function getMenu($userId) {
		return DalSiclab::getInstance()->getMenu($userId);
	}
}


