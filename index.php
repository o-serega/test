<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
mb_internal_encoding("UTF-8");


class controller {


    public function __construct() {
		
		
		require_once __DIR__ . '/view/index.tml';
		
		
	}


}

$controller = new controller;

?>