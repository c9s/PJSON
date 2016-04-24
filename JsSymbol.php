<?php
namespace PJSON;

class JsSymbol
{
    protected $symbol;

    public function __construct($symbol)
    {
        $this->symbol = $symbol;
    }

    public function encode($encoder)
    {
        return $this->symbol;
    }

    public function __toString()
    {
        return $this->symbol;
    }
}



