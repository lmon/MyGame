<?php

class MyObject{
	var $info;
	function __construct(){
		$this->info = 1;
	}

	function changeInfo($val){
		$this->info = $val;
	}
}