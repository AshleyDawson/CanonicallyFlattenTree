<?php

namespace AshleyDawson\CanonicallyFlattenTree\Test;

use function AshleyDawson\CanonicallyFlattenTree\canonically_flatten_tree;
use PHPUnit\Framework\TestCase;

/**
 * Class TestFlattenTree
 *
 * @package AshleyDawson\FlattenTree\Test
 */
class CanonicallyFlattenTreeTest extends TestCase
{
    /**
     * @test
     */
    public function it_produces_a_flattened_and_canonicalised_list_from_unordered_tree()
    {
        $this->assertEquals(
            ['alpha', 'beta', 'delta', 'gamma'],
            canonically_flatten_tree(['gamma', ['alpha', ['beta']], [[['delta']]]])
        );
    }
}
