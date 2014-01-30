<?php
require_once('/Library/WebServer/Documents/MonacoWork/simpletest/autorun.php');

require_once(dirname(__FILE__) .'/MyBoard.php');
class BoardTestCase extends UnitTestCase {

	function testCreation() {
        $b = new MyBoard();
        $this->assertTrue($b);
    }

	function testValuesSet() {
        $b = new MyBoard(array(21,21));
        $this->assertNotNull($b->dimensions);
        $this->assertNotNull($b->obstructions);

        $d = array(21,21);
        $o = array(array(4,9), array(4,19));
        $b = new MyBoard($d, $o);
        $this->assertEqual($b->dimensions, $d);
        $this->assertEqual($b->obstructions, $o);
      }

     function testGetValuesByName(){
     	$b = new MyBoard();
     	$this->assertNotNull($b->getWidth());
     	$this->assertNotNull($b->getHeight());
     } 

     function testGetFinish(){
        $b = new MyBoard();
        $this->assertNotNull($b->getFinish());
     } 

     function testShowBoardStatus(){
      $b = new MyBoard();
      $this->assertNotNull( $s = $b->getStatus() );
      print_r($s);
    }

}