<?php
/*
require "DalSiclab.php";

	$userId = 1;
	$menu = DalSiclab::getInstance()->getMenu($userId);
	echo $menu;
*/
require "SiclabService.php";

	$siclabService = new SiclabService();

	$userId = 1;
	$menu = $siclabService->getMenu($userId);
	echo $menu;
