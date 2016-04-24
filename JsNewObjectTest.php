<?php
use PJSON\PJSONEncoder;
use PJSON\JsFunctionCall;
use PJSON\JsNewObject;

class JsNewObjectTest extends PHPUnit_Framework_TestCase
{
    public function testNewObject() {

        $encoder = new PJSONEncoder;
        $call = new JsNewObject('Modal', ['arg1', 'arg2']);
        $this->assertEquals('new Modal("arg1", "arg2")',$encoder->encode($call));
    }
}
