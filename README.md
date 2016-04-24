PJSON
============

PJSONEncoder implements a JSON encoder with PHP object to JavaScript object translation support.

You can specify your own encoder for each PHP types:

```php
use PJSON\PJSONEncoder;
use PJSON\DateTimeEncoder;
$encoder = new PJSONEncoder;
$encoder->setDateTimeEncoder(new DateTimeEncoder(DateTime::ATOM));
$encoder->setStringEncoder(function($value, $encoder) {
    return '"' . addcslashes($value) . '"';
});
$encoder->setClosureEncoder(function($closure, $encoder) {
    return $encoder->encode($closure(1,2,3));
});
$output = $encoder->encode([ ... PHP Array here ... ]);
```

And you can also encode JavaScript symbols or JavaScript function call in JSON from PHP:

```php
$encoder = new PJSONEncoder;
$call = new JsFunctionCall('jQuery', ['#documentId']);
$encoder->encode($call); // outputs 'jQuery("#documentId")'
$encoder->encode(['a' => new JsSymbol('js_var')]); // outputs {"a": js_var}
```

## Install

    composer require corneltek/pjson '*'

## License

This package is released under MIT License
