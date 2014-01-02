<?php

$count = 0;

while(1){

	echo "Are you sure you want to do this?  Type 'yes' to continue: ";
	$handle = fopen ("php://stdin","r");
	$line = fgets($handle);
	if(trim($line) != 'yes'){
	    echo "ABORTING!\n";
	    exit;
	}
	$count++;
	echo "\n";
	echo "Thank you, continuing...$count \n";

}
 


?>