<?php

class MyBoard {
	
	var $boardName = 'Board 1';
	var $dimensions;
	var $obstructions;
	var $boardStatus = 'unfinished';


	function __construct($d = array(10,10), $o=array(array(8,8)) ){
		$this->dimensions = $d;

		$this->obstructions = $o;
	}

	function getWidth(){
		return $this->dimensions[0];
	}

	function getHeight(){
		return $this->dimensions[1];
	}

	function getFinish(){
		// finish is bottom right, for this game
		return array($this->getWidth(), $this->getHeight());
	}
	
	function getStatus(){
		return array(
			'boardName'=>$this->boardName,
			'dimensions'=>$this->dimensions,
			'obstructions'=>$this->obstructions,
			'boardStatus'=>$this->boardStatus	
		);
	}	
}
?>