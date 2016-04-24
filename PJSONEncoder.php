<?php
namespace PJSON;
use DateTime;

/**
 * JsJsonEncoder implements a json encoder with PHP object to JavaScript object translation support.
 *
 * DateTime is translated to Date.UTC(...) in javascript.
 */
class PJSONEncoder
{
    protected $stringEncoder;

    protected $objectEncoder;

    protected $datetimeEncoder;

    public function __construct()
    {

    }


    public function setDateTimeEncoder(callable $encoder)
    {
        $this->datetimeEncoder = $encoder;
    }

    public function setStringEncoder(callable $encoder)
    {
        $this->stringEncoder = $encoder;
    }

    public function setObjectEncoder(callable $encoder)
    {
        $this->objectEncoder = $encoder;
    }

    /**
     * @param mixed $a
     */
    public function encode($a = null)
    {
        if ($a === null) {
            return 'null';
        } else if ($a === false) {
            return 'false';
        } else if ($a === true) {
            return 'true';
        } else if (is_float($a)) {
            return $a;
        } else if (is_string($a)) {
            if ($this->stringEncoder) {
                return $this->stringEncoder($a, $this);
            } else {
                return '"' . addcslashes($a, "\\\/\n\t\r\f\"") . '"';
            }
        } else if (is_scalar($a)) {
            return $a;
        } else if (is_array($a)) {

            // If all indexes are numberic
            $isList = count(array_filter(array_keys($a),"is_numeric")) === count(array_keys($a));
            if ($isList) {
                return '[' . join(',', array_map([$this, 'encode'], $a)) . ']';
            } else {
                $result = array();
                foreach ($a as $k => $v) {
                    $result[] = $this->encode($k) . ':' . $this->encode($v);
                }
                return '{' . join(',', $result) . '}';
            }

        } else if ($a instanceof DateTime && $this->datetimeEncoder) {

            return $this->datetimeEncoder($a, $this);

        } else if (is_object($a)) {
            if ($this->objectEncoder) {
                return $this->objectEncoder($a, $this);
            } else if ($a instanceof DateTime) {
                return sprintf('Date.UTC(%d,%d,%d)', $a->format('Y'), intval($a->format('m')) - 1, $a->format('j'));
            } else {
                throw new Exception("json encode failed: unsupported object type.");
            }
        }
        throw new Exception("json encode failed: unsupported type.");
    }



}
