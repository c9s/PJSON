<?php
use PJSON\PJSONEncoder;
use PJSON\JsFunctionCall;

class JsFunctionCallTest extends PHPUnit_Framework_TestCase
{
    public function testFunctionCallEncode() {

        $encoder = new PJSONEncoder;
        $call = new JsFunctionCall('jQuery', ['#documentId']);
        $this->assertEquals('jQuery("#documentId")',$encoder->encode($call));
    }
}
