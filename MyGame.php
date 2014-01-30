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

	function __construct($d=array(10,12),$obs=array()){
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
/*
move function
takes a number as argument
* needs to test for out of bounds
* needs to test for collision
* needs to test for finish
*/
	function changePosition($m){
		$this->lastposition = $this->currentpos;
		$result;
		$result = $result ?: $this->onMoveIsOutofBounds($m);
		$result = $result ?: $this->onMoveIsACollision();
		$result = $result ?: $this->onMoveIsAtFinish();


		if($this->lastposition != $this->currentpos){
			array_push($this->history, array('move'=>$m));
		}else{
			array_push($this->history, array('failed move due to '.$result => $m ) ) ;
		}
		//print " currentpos = ".print_r($this->currentpos,true) ."\n";
		return $this->currentpos;
	}

	function onMoveIsOutofBounds($m){
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
		// if they are not out of bounds, update the possition
		if(($newpos >= 0)&&($newpos<=$boundry)){ 
			$this->currentpos[$slot]= $newpos;//$this->currentpos[1]+$m;
		}else{
			//
			print "A ".($newpos >= 0)?"True \n":"False \n"; 
			print "B ".($newpos<=$this->board->getHeight())?"True \n":"False \n"; 
			print "C ".($newpos<=$this->board->getWidth())?"True \n":"False \n";  

			print "out of bounds trying to move $m spots to $newpos boundry is $boundry. Direction is $slot [".$this->currentdir."] (".$this->board->getHeight()."/".$this->board->getWidth().")  \n";
			return "out-of-bounds";
		}
	
  
		//y axis
		/*if($this->currentdir == 's'){  
			$newpos = $this->currentpos[1]+$m;
			if($newpos >= 0 && $newpos<=$this->board->getHeight() ){ 
					$this->currentpos[1]=$this->currentpos[1]+$m;
				}
		}elseif ( $this->currentdir == 'n' ){
			$newpos = $this->currentpos[1]-$m;	
			if($newpos >= 0 && $newpos<=$this->board->getHeight()){
				$this->currentpos[1]=$this->currentpos[1]-$m;
			}
		//x axis
		}elseif ( $this->currentdir == 'e' ){
			$newpos = $this->currentpos[0]+$m;	
			if($newpos >= 0 && $newpos<=$this->board->getWidth()){
				$this->currentpos[0]=$this->currentpos[0]+$m;
			}

		}elseif ( $this->currentdir == 'w' ){ 
			$newpos = $this->currentpos[0]-$m;	
			if($newpos >= 0 && $newpos<=$this->board->getWidth()){
				$this->currentpos[0]=$this->currentpos[0]-$m;
			}
		}*/

		return true;
	}
	function onMoveIsACollision(){
		if (in_array($this->currentpos, $this->board->obstructions)) {
			print "collision";
		}
		return (in_array($this->currentpos, $this->board->obstructions))?false : true;
	}
	
	function onMoveIsAtFinish(){
		if($this->currentpos = $this->board->getFinish()){
			print "finished";
		}

		return ($this->currentpos = $this->board->getFinish())?false : true;
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