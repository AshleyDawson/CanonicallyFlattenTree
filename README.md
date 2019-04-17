Canonically Flatten Tree
========================

[![Build Status](https://travis-ci.org/AshleyDawson/CanonicallyFlattenTree.svg?branch=master)](https://travis-ci.org/AshleyDawson/CanonicallyFlattenTree)

Pure PHP function to flatten an n-dimensional tree of scalars (represented as an array) into
a single dimension list (also represented as an array).

TODO
----

* Benchmark various flattening algorithms, including `\RecursiveArrayIterator`, etc.
* Technically I think it's a nested set we're operating on (sort of), so in v2 I'd propose changing the terminology to suit

Requirements
------------

This function requires PHP >= 7.1

Installation
------------

Installation via [Composer](https://getcomposer.org/):

```bash
$ composer req ashleydawson/canonically-flatten-tree
```

Usage
-----

Basic usage of the function is as follows:

```php
<?php

require 'vendor/autoload.php';

$tree = [
    "gamma", 
    [
        "alpha", 
        [
            "beta",
        ],
    ], 
    [
        [
            [
                "delta",
            ]
        ]
    ],
];

$list = \AshleyDawson\CanonicallyFlattenTree\canonically_flatten_scalar_tree($tree);

print_r($list);

/*
Where output is:

Array
(
    [0] => alpha
    [1] => beta
    [2] => delta
    [3] => gamma
)
*/
```

Add type checking for scalars:

```php
<?php

require 'vendor/autoload.php';

// This will produce an invalid argument exception stating the nature of the type failure and at what level
// In this case we're asserting that all tree nodes must be of type "string"
try {
    \AshleyDawson\CanonicallyFlattenTree\canonically_flatten_scalar_tree(['alpha', [8]], 'string');
} catch (\InvalidArgumentException $e) {
    var_dump($e);
}

```

Test & Benchmark
----------------

Test with [PHPUnit](https://phpunit.de/):

```bash 
$ vendor/bin/phpunit -c .
```

Benchmark with [Blackfire](https://blackfire.io/):

```bash
$ blackfire run php vendor/bin/phpunit 
```

There is an [example benchmark report](https://blackfire.io/profiles/3c6772a5-8c64-477d-9f8a-c80698ad9ff9/graph) available.
