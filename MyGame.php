<?php

class MyGame{
 	var $board ;
 	var $currentdirection = 's'; // default: poiting down
 	var $currentposition =  array(0,0); // default: in 0,0
 	var $lastposition; // default: in 0,0
 	var $lastdirection;
 	var $directions = 'nesw';

	function __construct(){
		$this->lastdirection = $this->currentdirection;
		$this->lastposition = $this->currentposition;
		$this->board = array(10,12);
	}

	function getBoard(){
		return $this->board;
	}

	function getDirection(){
		return $this->currentdirection;
	}

	function changeDirection($d){
		// if the target index is more than 1 place away, then fail
		$currentindex = strpos($this->directions, $this->currentdirection);
		$targetindex = strpos($this->directions, $d);
			//print "\n".$targetindex ."-". $currentindex."\n";
		
		if(($targetindex - $currentindex) > 1 || ($targetindex - $currentindex) < -1){
			print "\nfail ".$targetindex ."-". $currentindex." = ".($targetindex - $currentindex)."\n";
			print substr($this->directions,$targetindex,1) ."->". substr($this->directions,$currentindex,1)." = ".($targetindex - $currentindex)."\n";
			return false;
		}

		$this->lastdirection = $this->currentdirection;
		$this->currentdirection = $d;
	}

	function getPosition(){
		return $this->currentposition;
	}

	function changePosition($m){
		$this->lastposition = $this->currentposition;

		//y axis
		if($this->currentdirection == 's'){  $newpos = $this->currentposition[1]+$m;
			if($newpos >= 0 && $newpos<=$this->board[1] ){ $this->currentposition[1]=$this->currentposition[1]+$m;}
		}elseif ( $this->currentdirection == 'n' ){
			$newpos = $this->currentposition[1]-$m;	
			if($newpos >= 0 && $newpos<=$this->board[1]){$this->currentposition[1]=$this->currentposition[1]-$m;}
		//x axis
		}elseif ( $this->currentdirection == 'e' ){
			$newpos = $this->currentposition[0]+$m;	
			if($newpos >= 0 && $newpos<=$this->board[0]){$this->currentposition[0]=$this->currentposition[0]+$m;}

		}elseif ( $this->currentdirection == 'w' ){ 
			$newpos = $this->currentposition[0]-$m;	
			if($newpos >= 0 && $newpos<=$this->board[0]){$this->currentposition[0]=$this->currentposition[0]-$m;}
		}

		//print " currentposition = ".print_r($this->currentposition,true) ."\n";
		return $this->currentposition;
	}

}
?>