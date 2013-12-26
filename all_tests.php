<?php
require_once(dirname(__FILE__) .'/../../simpletest/autorun.php');
    
class AllTests extends TestSuite {
    function AllTests() {
        parent::__construct();
        $this->addFile('MyGame_Test.php');
        $this->addFile('MyBoard_Test.php');
    }
}
?>