<?php
require_once(dirname(__FILE__). '/MyGame.php');

class MyGameController{
 	var $game ;
 	var $history = array();
 	var $gameStatus = 'notstarted'; # notstarted|started|finished;
 	var $gameIsRunning = false;
 	var $maxloops = 100;
	
	function __construct($autostart = false){
		if($autostart==true){
			$this->gameStart();
			$this->playLoopStart();
		}
	}

	function gameStart(){
		$this->game = new MyGame(array(10,12), array(array(6,6),array(3,7)));
		$this->gameStatus = 'started';
	}

	function gameEnd(){
		$this->playLoopEnd();
		print "Game Over.";

	}

	function playLoopStart(){
		$this->gameIsRunning = true;

		$count = 0;
		$feedback ;
			
		while(($this->gameIsRunning == true) && ($count < $this->maxloops) ){

			$count++;
			
 			echo " => $feedback \nMake your move, partner: \n";
			$handle = fopen ("php://stdin","r");
			$line = fgets($handle);
		 
			// handle input by directing to appropriate functions
			if(trim($line) == "exit") {
				    echo "Quiting!\n";
				    $this->playLoopEnd();
			    	print_r($this->playerStatus());
			    	exit;
			
			}elseif(trim($line) == "status"){ 
				    print_r($this->playerStatus());
			
			}elseif( preg_match('/(move) ([0-9]+)/',trim($line), $matches) ){
					print "got ". $matches[2] ."\n";
					$feedback = $this->playerMove($matches[2]);
					
			}elseif( preg_match('/(turn) ([news])/',trim($line), $matches) ){
					print "got ". $matches[2]."\n";
					$feedback = $this->playerTurn($matches[2]);	
			}elseif(trim($line) == "full"){ 
				    print_r($this->playerFullStatus());

			}elseif(trim($line) == "history"){ 
				    print_r($this->playerHistory());

			}else{ 
				print "Please try again. Commands: 'exit' to exit \n
				status\n
				full \n
				history\n
				move [0-99...]\n
				turn [n|e|w|s]\n
				";
			}
			//echo "Thank you, continuing...$count \n";

		}

	}

	function playLoopEnd(){
		$this->gameIsRunning = false;
	}

	function playerMove($m = 1){
		if($this->gameStatus == 'finished'){$this->rejectMove();}		
		$r = $this->game->changePosition( $m );
		//finished?
		if($this->game->getPosition() == $this->game->getFinish()){
			$this->gameStatus = 'finished';
			print "Congratulations";
			$this->gameEnd();		
		}

		return $r;
	}

	function playerTurn($d){
		if($this->gameStatus == 'finished'){$this->rejectMove();}		
		if($d!=null){ 
			return $this->game->changeDirection( $d );
		}
	}

	function rejectMove(){
		return false;		
	}

	function playerFullStatus(){
		return $this->game->getPlayerStatus();
	}

	function playerHistory(){
		return $this->game->history;
	}

	function playerStatus(){
		$status = "Board: \n";
		$status .= "Direction: ".$this->game->currentdirection."\n";
		$status .= "No. moves: ".count($this->playerHistory())."\n";
			// draw the board 
			for($i=0; $i<=$this->game->board->dimensions[1]; $i++){
				for($j=0; $j<=$this->game->board->dimensions[0]; $j++){
					if(array($j, $i) == $this->game->getPosition()){
						$status .= "[X]";
					}elseif(in_array( array($j, $i), $this->game->getObstructions())){

						$status .= "[0]";

					}else{
						$status .= "[ ]";						
					}				
				}	
				$status .= "$i\n";
			}
 
print_r($this->game->getObstructions());
		return $status."\n";
	}

}
?>