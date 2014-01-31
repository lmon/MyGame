<?php
require_once(dirname(__FILE__). '/MyBoard.php');

class MyGame{
 	var $board ;
 	var $currentdir = 's'; // default: poiting down
 	var $currentpos =  array(0,0); // default: in 0,0
 	var $lastposition; // default: in 0,0
 	var $lastdirection;
 	var $directions = 'nesw';
 	var $history = array();
 	var $gameStatus = 'unfinished';

	function __construct($d=array(10,12), $obs=array()){
		$this->lastdirection = $this->currentdir;
		$this->lastposition = $this->currentpos;
		$this->board = new MyBoard($d, $obs);			
	}

	function getBoard(){
		return $this->board;
	}

	function getDirection(){
		return $this->currentdir;
	}
	
	function getFinish(){
		return $this->board->getFinish();
	}

	function changeDirection($d){
		// if the target index is more than 1 place away, then fail
		$currentindex = strpos($this->directions, $this->currentdir);
		$targetindex = strpos($this->directions, $d);
			//print "\n".$targetindex ."-". $currentindex."\n";
		
		if(($targetindex - $currentindex) > 1 || ($targetindex - $currentindex) < -1){
			//print "\nfail ".$targetindex ."-". $currentindex." = ".($targetindex - $currentindex)."\n";
			//print substr($this->directions,$targetindex,1) ."->". substr($this->directions,$currentindex,1)." = ".($targetindex - $currentindex)."\n";
			array_push($this->history, array('failed-direction'=>$d));

			return false;
		}

		$this->lastdirection = $this->currentdir;
		$this->currentdir = $d;
		array_push($this->history, array('direction'=>$d));
	}

	function getPosition(){
		return $this->currentpos;
	}
	function getObstructions(){
		return $this->board->obstructions;
	}
/*
move function
takes a number as argument
* needs to test for out of bounds
* needs to test for collision
* needs to test for finish
*/
	function changePosition($m){
		$this->lastposition = $this->currentpos;
		$temppos = $this->currentpos;
		$result = "";
 
 		$newpos;
		// which data to update depends on which direction they are heading
		$slot = (($this->currentdir == 's') || ( $this->currentdir == 'n' ))?1:0;
		// whether it is a pos or negative move depends on which direction they are headed
		$dir = (($this->currentdir == 's') || ( $this->currentdir == 'e' ))?1:0;	
		// do i care about sides or top/bottom?
		$boundry = ($slot==1)?$this->board->getHeight():$this->board->getWidth();

		//y axis
		if($slot==1){  
			$newpos = ($dir == 1)?($this->currentpos[$slot]+$m) : ($this->currentpos[$slot]-$m);
		//x axis
		}else{
			$newpos = ($dir == 1)?($this->currentpos[$slot]+$m) : ($this->currentpos[$slot]-$m);
		}

		$temppos[$slot] = $newpos;

		if($this->onMoveIsOutofBounds($newpos,$boundry)){
			$result = "out-of-bounds";
		}		
		if($this->onMoveIsACollision($temppos)){
			$result = "collision";
		}
		if($this->onMoveIsAtFinish($temppos)){
			//print "==A==";
			$result = "finished";
			$this->gameStatus = "finished";
		}

		if($result == ""){			 
			$this->currentpos[$slot]= $newpos; 
			array_push($this->history, array('move'=>$m));
		}else{
			 
			//provide Feedback
			//print "==B== $result ";
			 
			array_push($this->history, array('failed move due to '.$result => $m ) ) ;
		}
		//print " currentpos = ".print_r($this->currentpos,true) ."\n";
		return array_keys( $this->history[count($this->history)-1])[0];
	}

	function onMoveIsOutofBounds($newpos,$boundry){
		
		// if they are not out of bounds, update the possition
		if(($newpos >= 0)&&($newpos<=$boundry)){ 
			return false;
		}else{
			//
			/*print "A ".($newpos >= 0)?"True \n":"False \n"; 
			print "B ".($newpos<=$this->board->getHeight())?"True \n":"False \n"; 
			print "C ".($newpos<=$this->board->getWidth())?"True \n":"False \n";  

			print "out of bounds trying to move $m spots to $newpos boundry is $boundry. Direction is $slot [".$this->currentdir."] (".$this->board->getHeight()."/".$this->board->getWidth().")  \n";
			 */
			return true;
		}
	
	}
	function onMoveIsACollision($tmppos){
		 
		/*print __FUNCTION__ ." \n ";
		print "Curent Pos: ";
		print_r($tmppos);
		print "obstructions: ";
		print_r($this->board->obstructions);
		
		if (in_array($tmppos, array_values($this->board->obstructions))) {
			print "==collision==";
		} else{
			print "NO COLLISION: ";
		print "===========\n";
		print "Curent Pos: ";
		print_r($tmppos);
		print "obstructions: ";
		print_r($this->board->obstructions);
		print "===========\n";
			
		}*/
		return (in_array($tmppos, array_values($this->board->obstructions)))?true : false;
	}
	
	function onMoveIsAtFinish($temppos){
		if($temppos == $this->board->getFinish()){
			//print "finished";
		} 
		return ($temppos == $this->board->getFinish())?true : false;
	}

	function getPlayerStatus(){
		return array(
				'direction'=>$this->currentdir,
				'position'=>$this->currentpos,
				'history'=>$this->history,
				'gameStatus'=>$this->gameStatus	
			);
	}

	function getBoardStatus(){
		return $this->board->getStatus();		
	}



}
?>