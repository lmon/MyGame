<?php
require_once('/Library/WebServer/Documents/MonacoWork/simpletest/autorun.php');
require_once('./MyObject.php');
class FileTestCase extends UnitTestCase {

	function testCreation() {
        $w = new MyObject();
        $this->assertTrue($w);
    }

    function testInformation(){
       $w = new MyObject();
       $this->assertTrue($w->info);
    }

    function testInformationValue(){
       $w = new MyObject();
       $this->assertNotNull($w->info);
    }

    function testInformationValueChanged(){
       $w = new MyObject();
       $newvalue = 10;
       $this->assertTrue( ($w->info != $newvalue) );

       $w->changeInfo($newvalue);
	   $this->assertTrue( ($w->info == $newvalue) );

    }

}
?>