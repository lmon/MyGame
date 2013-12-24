<?php
require_once('/Library/WebServer/Documents/simpletest/autorun.php');
require_once('./MyGame.php');
class GameTestCase extends UnitTestCase {

	function testCreation() {
        $g = new MyGame();
        $this->assertTrue($g);
    }

    function testHasBoard(){
       $g = new MyGame();
       $this->assertNotNull($g->getBoard());
    }

    function testDirection(){
       $g = new MyGame();
       $this->assertNotNull($g->getDirection());
    }

    function testTurnWest(){
       $g = new MyGame();
       $g->changeDirection('w');
       $this->assertTrue($g->currentdirection != $g->lastdirection);
    }

    function testCantTurn180(){
       $g = new MyGame();
       $g->changeDirection('n');
       $this->assertFalse($g->currentdirection == 'n');
       $g->changeDirection('s'); // set back

       $g->changeDirection('s');
       $this->assertTrue($g->currentdirection == 's');
       $g->changeDirection('s'); // set back

       $g->changeDirection('e');
       $this->assertTrue($g->currentdirection == 'e');
       $g->changeDirection('s'); // set back

       $g->changeDirection('w');
       $this->assertTrue($g->currentdirection == 'w');
    }

    function testPosition(){
      $g = new MyGame();
      $this->assertNotNull($g->getPosition());
    
    }

    function testChangePositionY(){
      $g = new MyGame();
      $g->changePosition(1);
      $this->assertTrue($g->currentposition != $g->lastposition);
    }

    function testChangePositionX(){
      $g = new MyGame();
      $g->changeDirection('e');
      $g->changePosition(5);
      $this->assertTrue($g->currentposition != $g->lastposition);
    }
    
    function testCantMoveOutOfBounds(){
      $g = new MyGame();
      $originalposition = $g->getPosition();
      $g->changePosition(-1); // backwards-up since default is south
      $this->assertTrue(($g->currentposition == $originalposition ) );
    }

    function testMovedCorrectDistance(){
      $g = new MyGame();
      $distance = 1;
      $g->changePosition($distance);
      $this->assertTrue( ($g->currentposition[1] - $distance) == ($g->lastposition[1]) );
      print " Curr = ".$g->currentposition[1];
      print " / Last = ".$g->lastposition[1];
       
    }
    
/*    function testCanOnlyMoveOneAtATime(){
      $g = new MyGame();
      $g->changePosition(2);
      $this->assertFalse($g->currentposition != $g->lastposition);
    }*/
}
?>