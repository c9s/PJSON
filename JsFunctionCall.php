<?php
namespace PJSON;

class JsFunctionCall
{
    protected $name;

    protected $args;

    public function __construct($name, $args)
    {
        $this->name = $name;
        $this->args = $args;
    }

    public function encode($encoder)
    {
        return $this->name . '(' . join(', ',array_map([$encoder,'encode'],$this->args)) . ')';
    }
}



