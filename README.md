Flatten Tree
============

Pure PHP function to flatten an n-dimensional tree of scalars (represented as an array) into
a single dimension list (also represented as an array).

Requirements
------------

This function requires PHP >= 7.3

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

Test & Benchmark
----------------

Test with PHPUnit:

```bash 
$ vendor/bin/phpunit -c .
```

Benchmark with [Blackfire](https://blackfire.io/):

```bash
$ blackfire run php vendor/bin/phpunit 
```

There is an [example benchmark](https://blackfire.io/profiles/3c6772a5-8c64-477d-9f8a-c80698ad9ff9/graph) available.
