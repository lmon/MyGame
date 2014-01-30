<?php
require_once('/Library/WebServer/Documents/MonacoWork/simpletest/autorun.php');
require_once(dirname(__FILE__) .'/MyGame.php');
class GameTestCase extends UnitTestCase {

	function testCreation() {
        $g = new MyGame();
        $this->assertTrue($g);

          print $this->onFunctionEnd(__FUNCTION__);
    }

  function testCustomCreation() {
        $g = new MyGame(array(5,7), array( array(2,2), array(4,1) ) );
        $this->assertTrue($g);
        $this->assertTrue(
            $g->board->getWidth() == 5 &&
            $g->board->getHeight() == 7 &&
            $g->board->obstructions[0] == array(2,2) 
            );
          print $this->onFunctionEnd(__FUNCTION__);
    }

    function testHasBoard(){
       $g = new MyGame();
       $this->assertNotNull($g->getBoard());
             print $this->onFunctionEnd(__FUNCTION__);
    
    }

    function testDirection(){
       $g = new MyGame();
       $this->assertNotNull($g->getDirection());
             print $this->onFunctionEnd(__FUNCTION__);
    
    }

    function testTurnWest(){
       $g = new MyGame();
       $g->changeDirection('w');
       $this->assertTrue($g->currentdir != $g->lastdirection);
             print $this->onFunctionEnd(__FUNCTION__);
    
    }

    function testCantTurn180(){
       $g = new MyGame();
       $g->changeDirection('n');
       $this->assertFalse($g->currentdir == 'n');
       $g->changeDirection('s'); // set back

       $g->changeDirection('s');
       $this->assertTrue($g->currentdir == 's');
       $g->changeDirection('s'); // set back

       $g->changeDirection('e');
       $this->assertTrue($g->currentdir == 'e');
       $g->changeDirection('s'); // set back

       $g->changeDirection('w');
       $this->assertTrue($g->currentdir == 'w');

             print $this->onFunctionEnd(__FUNCTION__);
    
    }

    function testPosition(){
      $g = new MyGame();
      $this->assertNotNull($g->getPosition());
            print $this->onFunctionEnd(__FUNCTION__);
    
    }

    function testChangePositionY(){
      $g = new MyGame();
      $g->changePosition(1);
      $this->assertTrue($g->currentpos != $g->lastposition);
            print $this->onFunctionEnd(__FUNCTION__);
    
    }

    function testChangePositionX(){
      $g = new MyGame();
      $g->changeDirection('e');
      $g->changePosition(5);
      $this->assertTrue($g->currentpos != $g->lastposition);
      print $this->onFunctionEnd(__FUNCTION__);
    }
    
    function testCantMoveOutOfBounds(){
      $g = new MyGame();
      $originalposition = $g->getPosition();
      $g->changePosition(-1); // backwards=up since default is south
      $this->assertTrue(($g->currentpos == $originalposition ) );

      print "==== End ".__FUNCTION__. "====\n";
      print $this->onFunctionEnd(__FUNCTION__);
    }

    function testMovedCorrectDistance(){
      $g = new MyGame();
      $distance = 1;
      $g->changePosition($distance);
      $this->assertTrue( ($g->currentpos[1] - $distance) == $g->lastposition[1]);
      //print " Curr = ".$g->currentposition[1];
      //print "/ Last = ".$g->lastposition[1]."\n";
      print $this->onFunctionEnd(__FUNCTION__);
           
    }

    function testHistoryUpdated(){
      $g = new MyGame();
      $g->changePosition(1);
      $g->changePosition(3);
      $g->changePosition(2);
      $g->changePosition(4);
      $g->changePosition(4);
      $this->assertTrue( $g->history == array(
          array('move'=>1),
          array('move'=>3),
          array('move'=>2),
          array('move'=>4),
          array('failed move due to out-of-bounds' => 4),
       ) 
      );

      print_r($g->getPlayerStatus());
      print $this->onFunctionEnd(__FUNCTION__);
    }

    function testShowPlayerStatus(){
      $g = new MyGame();
      $this->assertNotNull( $s = $g->getPlayerStatus() );
      //print_r($s);
      print $this->onFunctionEnd(__FUNCTION__);
    }

    function onFunctionEnd($f){
      print "==== End ".$f. " ====\n";
    }
    
}
?>