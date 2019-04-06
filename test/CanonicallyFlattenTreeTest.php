<?php

namespace AshleyDawson\CanonicallyFlattenTree\Test;

use function AshleyDawson\CanonicallyFlattenTree\canonically_flatten_scalar_tree;
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
    public function it_produces_a_flattened_and_canonicalised_list_from_unordered_tree_of_strings()
    {
        $this->assertEquals(
            ['alpha', 'beta', 'delta', 'gamma'],
            canonically_flatten_scalar_tree(['gamma', ['alpha', ['beta']], [[['delta']]]])
        );
    }

    /**
     * @test
     */
    public function it_produces_a_flattened_and_canonicalised_list_from_unordered_tree_of_integers()
    {
        $this->assertEquals(
            [1, 2, 3, 4, 5],
            canonically_flatten_scalar_tree([5, 3, [2, [1, [[4]]]]])
        );
    }

    /**
     * @test
     */
    public function it_produces_a_flattened_and_canonicalised_list_from_unordered_tree_of_real_numbers()
    {
        $this->assertEquals(
            [1.1, 2.5, 3.1, 4.25, 5.8],
            canonically_flatten_scalar_tree([5.8, 3.1, [2.5, [1.1, [[4.25]]]]])
        );
    }

    /**
     * @test
     */
    public function it_produces_a_flattened_and_canonicalised_list_from_unordered_tree_of_mixed_scalar_types()
    {
        $this->assertEquals(
            [false, 'apple', 1, 3, 4.5],
            canonically_flatten_scalar_tree(['apple', 3, [false, [1, [[4.5]]]]])
        );
    }

    /**
     * @test
     */
    public function it_throws_invalid_argument_exception_if_tree_contains_non_scalars()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Tree nodes must be exclusively scalars, object given of type stdClass');

        canonically_flatten_scalar_tree([5, 3, [2, [1, [[new \stdClass()]]]]]);
    }
}
