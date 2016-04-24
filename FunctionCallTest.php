<?php
use PJSON\FunctionCall;
use PJSON\PJSONEncoder;

class FunctionCallTest extends PHPUnit_Framework_TestCase
{
    public function testFunctionCallEncode() {

        $encoder = new PJSONEncoder;
        $call = new FunctionCall('jQuery', ['#documentId']);
        $this->assertEquals('jQuery("#documentId")',$encoder->encode($call));
    }
}
