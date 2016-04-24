<?php
namespace PJSON;
use DateTime;

class DateTimeEncoder
{
    protected $format;

    public function __construct($format)
    {
        $this->format = $format;
    }

    public function __invoke(DateTime $value, $encoder)
    {
        return $value->format($this->format);
    }
}



