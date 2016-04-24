<?php
use PJSON\PJSONEncoder;

class PJSONEncoderTest extends PHPUnit_Framework_TestCase
{

    public function inputDataProvider()
    {
        return [
            ['{"foo":1}',[ 'foo' => 1 ]],
            ['{"foo":0.3}',[ 'foo' => 0.3 ]],
            ['{"foo":true}',[ 'foo' => true ]],
            ['{"foo":false}',[ 'foo' => false ]],
            ['{"foo":false,"bar":true}',[ 'foo' => false, 'bar' => true, ]],
            ['[1,2,3,4,5]', [1,2,3,4,5]],
            ['[1,2,3,4,{"foo":false}]', [1,2,3,4,[ 'foo' => false ]]],

            // string tests
            ['{"bar":"abc\\nabc"}', ['bar' => "abc\nabc"]],
            ['{"bar":"abc\\tabc"}', ['bar' => "abc\tabc"]],
            ['{"bar":"abc\\rabc"}', ['bar' => "abc\rabc"]],
        ];
    }


    /**
     * @dataProvider inputDataProvider
     */
    public function testEncode($expected, $input)
    {
        $encoder = new PJSONEncoder;
        $this->assertEquals($expected, $encoder->encode($input));

        $output = $encoder->encode($input);
        $arr = json_decode($output, true);
        $this->assertNotEmpty($arr);
    }


    public function testEncodeSimpleScalar() {
        $a = [
            'foo' => 1,
            'bar' => 1,
        ];
        $encoder = new PJSONEncoder;
        $this->assertEquals('{"foo":1,"bar":1}',$encoder->encode($a));
    }

}
