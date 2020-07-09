<?php
// Create new service for PHP Remoting as Class
class talkback
{
    function talkback () 
	{
        // Define the methodTable for this class in the constructor
        $this->methodTable = array(
            "returnString" => array(
                "description" => "Return a String",
                "access" => "remote"
            ),
            "returnNumber" => array(
                "description" => "Return a Number",
                "access" => "remote"
            ),
            "returnArray" => array(
                "description" => "Return an Array",
                "access" => "remote"
            )
        );
    }

    function returnString ($in) {
        return "You said '$in' and I totally agree!";
    }

    function returnNumber ($in) {
        return $in * 10;
    }

    function returnArray ($in) {
        $objVal = $in['foo'];
        return array("theKey" => "Your Object contained the value $objVal");
    }
}
?>