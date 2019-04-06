<?php declare(strict_types=1);

namespace AshleyDawson\CanonicallyFlattenTree;

/**
 * Pure function that accepts an n-dimensional non-associative array representing a tree
 * and returns a flattened version of the tree represented as a single dimension array
 * canonicalised by ordering alphabetically
 *
 * @param array $tree
 * @return array
 */
function canonically_flatten_tree(array $tree): array
{
    // Recursively reduce tree
    $reduction = ($r = function (array $tree) use (&$r): array {
        return array_reduce($tree, function (array $list, $node) use (&$r): array {
            return array_merge($list, is_array($node) ? $r($node) : [$node]);
        }, []);
    })($tree);

    // Canonicalise reduction
    sort($reduction);

    return $reduction;
}
