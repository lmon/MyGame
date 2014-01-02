<?php
require_once(dirname(__FILE__) .'/../../simpletest/autorun.php');
require_once(dirname(__FILE__) .'/MyGameController.php');
class GameControllerTestCase extends UnitTestCase {
	function testCreation(){
		$gc = new MyGameController();
        $this->assertTrue($gc);
        $this->assertTrue($gc->gameStatus == 'notstarted');
	}

	function testCanStart(){
		$gc = new MyGameController();
		$gc->gameStart();
        $this->assertTrue($gc->gameStatus == 'started');
	}

	function testCanPlay(){
		$gc = new MyGameController();
        $gc->gameStart();
        $gc->playerMove();
		//print_r( $gc->playerStatus() )."\n";
        $this->assertTrue($gc->gameStatus=='started' || $gc->gameStatus=='finished');

	}

	function testCanFinish(){
		$gc = new MyGameController();
        $gc->gameStart();
        $gc->playerMove(2);
		$gc->playerMove(2);
		$gc->playerMove(2);
		$gc->playerMove(6);
		$gc->playerTurn('e');
		//print_r( $gc->playerStatus() )."\n";

        $gc->playerMove(2);
		$gc->playerMove(2);
		$gc->playerMove(2);
		$gc->playerMove(4);

        $this->assertTrue($gc->gameStatus=='finished');

        $gc->playerMove(1);
	}

	function testPlayLoop(){
		$gc = new MyGameController();
        $gc->gameStart();
        $gc->playLoopStart();
    	//$this->assertTrue($gc->gameIsRunning);
     	//$gc->gameEnd();
    	//$this->assertFalse($gc->gameIsRunning);
	}

	function testIsUnique(){}

}