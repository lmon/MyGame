<?php
require_once(dirname(__FILE__). '/MyBoard.php');

class MyGame{
 	var $board ;
 	var $currentdirection = 's'; // default: poiting down
 	var $currentposition =  array(0,0); // default: in 0,0
 	var $lastposition; // default: in 0,0
 	var $lastdirection;
 	var $directions = 'nesw';
 	var $history = array();
 	var $gameStatus = 'unfinished';

	function __construct($d=null,$obs=null){
		$this->lastdirection = $this->currentdirection;
		$this->lastposition = $this->currentposition;
		if($d==null && $obs==null){
			$this->board = new MyBoard(array(10,12), array());
		}else{
			$this->board = new MyBoard($d, $obs);			
		}
	}

	function getBoard(){
		return $this->board;
	}

	function getDirection(){
		return $this->currentdirection;
	}
	
	function getFinish(){
		return $this->board->getFinish();
	}

	function changeDirection($d){
		// if the target index is more than 1 place away, then fail
		$currentindex = strpos($this->directions, $this->currentdirection);
		$targetindex = strpos($this->directions, $d);
			//print "\n".$targetindex ."-". $currentindex."\n";
		
		if(($targetindex - $currentindex) > 1 || ($targetindex - $currentindex) < -1){
			//print "\nfail ".$targetindex ."-". $currentindex." = ".($targetindex - $currentindex)."\n";
			//print substr($this->directions,$targetindex,1) ."->". substr($this->directions,$currentindex,1)." = ".($targetindex - $currentindex)."\n";
			array_push($this->history, array('failed-direction'=>$d));

			return false;
		}

		$this->lastdirection = $this->currentdirection;
		$this->currentdirection = $d;
		array_push($this->history, array('direction'=>$d));
	}

	function getPosition(){
		return $this->currentposition;
	}
/*
move function
takes a number as argument
* needs to test for out of bounds
* needs to test for collision
* needs to test for finish
*/
	function changePosition($m){
		$this->lastposition = $this->currentposition;
		$result;
		$result = $result ?: $this->onMoveIsOutofBounds($m);
		$result = $result ?: $this->onMoveIsACollision();
		$result = $result ?: $this->onMoveIsAtFinish();


		if($this->lastposition != $this->currentposition){
			array_push($this->history, array('move'=>$m));
		}else{
			array_push($this->history, array('failed move due to '.$result => $m ) ) ;
		}
		//print " currentposition = ".print_r($this->currentposition,true) ."\n";
		return $this->currentposition;
	}

	function onMoveIsOutofBounds($m){
		$newpos;
		// which data to update depends on which direction they are heading
		$slot = (($this->currentdirection == 's') || ( $this->currentdirection == 'n' ))?1:0;
		// whether it is a pos or negative move depends on which direction they are headed
		$dir = (($this->currentdirection == 's') || ( $this->currentdirection == 'e' ))?1:0;	
		 
		//y axis
		if($slot == 1){  
				$newpos = ($dir == 1)?($this->currentposition[$slot]+$m) : ($this->currentposition[$slot]-$m);
		//x axis
		}else{
				$newpos = ($dir == 1)?($this->currentposition[$slot]+$m) : ($this->currentposition[$slot]-$m);
		}
		// if they are not out of bounds, update the possition
		if($newpos >= 0 && $newpos<=$this->board->getHeight() &&  $newpos<=$this->board->getWidth() ){ 
			$this->currentposition[$slot]= $newpos;//$this->currentposition[1]+$m;
		}else{
			//
			print "out of bounds $m \n";
			return "out-of-bounds";
		}
	
  
		//y axis
		/*if($this->currentdirection == 's'){  
			$newpos = $this->currentposition[1]+$m;
			if($newpos >= 0 && $newpos<=$this->board->getHeight() ){ 
					$this->currentposition[1]=$this->currentposition[1]+$m;
				}
		}elseif ( $this->currentdirection == 'n' ){
			$newpos = $this->currentposition[1]-$m;	
			if($newpos >= 0 && $newpos<=$this->board->getHeight()){
				$this->currentposition[1]=$this->currentposition[1]-$m;
			}
		//x axis
		}elseif ( $this->currentdirection == 'e' ){
			$newpos = $this->currentposition[0]+$m;	
			if($newpos >= 0 && $newpos<=$this->board->getWidth()){
				$this->currentposition[0]=$this->currentposition[0]+$m;
			}

		}elseif ( $this->currentdirection == 'w' ){ 
			$newpos = $this->currentposition[0]-$m;	
			if($newpos >= 0 && $newpos<=$this->board->getWidth()){
				$this->currentposition[0]=$this->currentposition[0]-$m;
			}
		}*/

		return true;
	}
	function onMoveIsACollision(){
		if (in_array($this->currentposition, $this->board->obstructions)) {
			print "collision";
		}
		return (in_array($this->currentposition, $this->board->obstructions))?false : true;
	}
	
	function onMoveIsAtFinish(){
		if($this->currentposition = $this->board->getFinish()){
			print "finished";
		}

		return ($this->currentposition = $this->board->getFinish())?false : true;
	}

	function getPlayerStatus(){
		return array(
				'direction'=>$this->currentdirection,
				'position'=>$this->currentposition,
				'history'=>$this->history,
				'gameStatus'=>$this->gameStatus	
			);
	}

	function getBoardStatus(){
		return $this->board->getStatus();		
	}



}
?>