<?php

use JUIT\ArrayDiffer;

require_once __DIR__ . '/vendor/autoload.php';

phpinfo();

$differ = new ArrayDiffer('first', 'second');
var_dump($differ->diff(['foo', 'bar'], ['foo', 'baz']));
var_dump($differ->diff(['foo', 'bar'], ['foo', 'bar', 'baz']));
