<?php declare(strict_types=1);

namespace AshleyDawson\CanonicallyFlattenTree;

/**
 * Pure function that accepts an n-dimensional non-associative array representing a tree
 * and returns a flattened version of the tree represented as a single dimension array
 * canonicalised by sorting
 *
 * @param array $tree
 * @param string|null $type Assert tree must only contain this type, uses PHP's type checking method postfixes for is_null, is_int, is_string, etc.
 * @return array
 */
function canonically_flatten_scalar_tree(array $tree, ?string $type = null): array
{
    // Normalise type checking method name
    if (null !== $type) {
        $type = preg_replace('/^is_.*$/i', '', $type);
    }

    // Recursively reduce tree
    $reduction = ($r = function (array $tree, int $level = 1) use (&$r, $type): array {
        return array_reduce($tree, function (array $list, $node) use (&$r, &$level, $type): array {
            // Must guarantee that all nodes are scalars to assure canonicalisation
            if (is_object($node)) {
                throw new \InvalidArgumentException(sprintf(
                    'Tree nodes must be exclusively scalars, object given of type %s at level [%d]',
                    get_class($node),
                    $level
                ));
            }

            // Perform scalar type checking
            if ((! is_array($node)) && $type) {
                if (! call_user_func("\\is_{$type}", $node)) {
                    throw new \InvalidArgumentException(sprintf(
                        'Tree nodes must all be of type %s, %s given at level [%d]',
                        $type,
                        gettype($node),
                        $level
                    ));
                }
            }

            // Compound
            return array_merge($list, is_array($node) ? $r($node, ++ $level) : [$node]);
        }, []);
    })($tree);

    // Canonicalise reduction
    sort($reduction, SORT_NATURAL);

    return $reduction;
}
