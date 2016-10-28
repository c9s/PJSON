<?php
namespace PJSON;
use DateTime;
use Closure;
use Exception;

/**
 * PJSONEncoder implements a json encoder with PHP object to JavaScript object translation support.
 *
 * DateTime is translated to Date.UTC(...) in javascript.
 */
class PJSONEncoder
{
    protected $stringEncoder;

    protected $objectEncoder;

    protected $datetimeEncoder;

    protected $closureEncoder;

    public function __construct()
    {

    }

    public function setDateTimeEncoder($encoder)
    {
        $this->datetimeEncoder = $encoder;
    }

    public function setStringEncoder($encoder)
    {
        $this->stringEncoder = $encoder;
    }

    public function setObjectEncoder($encoder)
    {
        $this->objectEncoder = $encoder;
    }

    public function setClosureEncoder($encoder)
    {
        $this->closureEncoder = $encoder;
    }

    public function wrapDoubleQuote($s)
    {
        if (preg_match('/^".+"$/', $s)) {
            return $s;
        }

        return '"' . addcslashes($s, "\\\/\n\t\r\f\"") . '"';
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
                return call_user_func($this->stringEncoder, $a, $this);
            } else {
                return $this->wrapDoubleQuote($a);
            }
        } else if (is_scalar($a)) {

            return $a;

        } else if (is_array($a)) {

            // If all indexes are numberic
            $isList = array_keys($a) === range(0, count($a) - 1);
            if ($isList) {
                return '[' . join(',', array_map([$this, 'encode'], $a)) . ']';
            } else {
                $result = array();
                foreach ($a as $k => $v) {
                    $result[] = $this->wrapDoubleQuote($this->encode($k)) . ':' . $this->encode($v);
                }
                return '{' . join(',', $result) . '}';
            }
        } else if ($a instanceof JsSymbol) {

            return $a->encode($this);

        } else if ($a instanceof JsFunctionCall) {

            return $a->encode($this);

        } else if ($a instanceof JsNewObject) {

            return $a->encode($this);

        } else if ($a instanceof Closure && $this->closureEncoder) {

            return call_user_func($this->closureEncoder, $a, $this);

        } else if ($a instanceof DateTime && $this->datetimeEncoder) {

            return call_user_func($this->datetimeEncoder,$a, $this);

        } else if (is_object($a)) {
            if ($this->objectEncoder) {
                return call_user_func($this->objectEncoder, $a, $this);
            } else if ($a instanceof DateTime) {
                return sprintf('Date.UTC(%d,%d,%d)', $a->format('Y'), intval($a->format('m')) - 1, $a->format('j'));
            } else {
                throw new Exception("json encode failed: unsupported object type.");
            }
        }
        throw new Exception("json encode failed: unsupported type.");
    }



}

