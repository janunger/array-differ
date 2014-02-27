# ArrayDiffer

Simple differ component for PHP which calculates a delta array out of two given arrays or hashmaps

[![Build Status](https://api.travis-ci.org/janunger/array-differ.png?branch=master)](http://travis-ci.org/janunger/array-differ)

## Installation

You can use [Composer](http://getcomposer.org/) to download and install this package as well as its dependencies.

### Composer

To add this package as a local, per-project dependency to your project, simply add a dependency on `juit/array-differ` to your project's `composer.json` file. Here is a minimal example of a `composer.json` file that just defines a dependency on the ArrayDiffer component:

    {
        "require": {
            "juit/array-differ": "*"
        }
    }

### Usage

The `ArrayDiffer` class can be used to calculate a delta array out of two given arrays:

```php
use JUIT\ArrayDiffer;

$differ = new ArrayDiffer();
var_dump($differ->diff(['foo', 'bar'], ['foo', 'baz']));
```

The code above yields the output below:

    array(1) {
        [1] =>
        array(2) {
            'FROM' =>
            string(3) "bar"
            'TO' =>
            string(3) "baz"
        }
    }

Which means that on the second position (index 1) the two values are different.

```php
use JUIT\ArrayDiffer;

$differ = new ArrayDiffer();
var_dump($differ->diff(['foo', 'bar'], ['foo', 'bar', 'baz']));
```

The code above yields the output below:

    array(1) {
        [2] =>
        array(1) {
            'TO' =>
            string(3) "baz"
        }
    }
    
Which means that on the third position (index 2) the 'to' array has an additional value 'baz'.

You may optionally set your own 'from' and 'to' headers:

```php
use JUIT\ArrayDiffer;

$differ = new ArrayDiffer('first', 'second');
var_dump($differ->diff(['foo', 'bar'], ['foo', 'baz']));
```

The code above yields the output below:
    
    array(1) {
        [1] =>
        array(2) {
            'first' =>
            string(3) "bar"
            'second' =>
            string(3) "baz"
        }
    }
