<?php
require_once(dirname(__FILE__) .'/../../simpletest/autorun.php');
require_once(dirname(__FILE__) .'/MyGameController.php');
class GameControllerTestCase2 extends UnitTestCase {
	 
	function testGame(){
		$gc = new MyGameController('autostart');
	}

}