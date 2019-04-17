<?php

namespace AshleyDawson\CanonicallyFlattenTree\Test;

use function AshleyDawson\CanonicallyFlattenTree\canonically_flatten_scalar_tree;
use PHPUnit\Framework\TestCase;

/**
 * Class CanonicallyFlattenScalarTreeTest
 *
 * @package AshleyDawson\CanonicallyFlattenTree\Test
 */
class CanonicallyFlattenScalarTreeTest extends TestCase
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
            [false, 1, 3, 4.5, 'apple'],
            canonically_flatten_scalar_tree(['apple', 3, [false, [1, [[4.5]]]]])
        );
    }

    /**
     * @test
     */
    public function it_produces_a_flattened_and_canonicalised_list_with_duplicates_preserved()
    {
        $this->assertEquals(
            ['alpha', 'beta', 'beta', 'delta', 'gamma'],
            canonically_flatten_scalar_tree(['gamma', 'beta', ['alpha', ['beta']], [[['delta']]]])
        );
    }

    /**
     * @test
     */
    public function it_throws_invalid_argument_exception_if_tree_contains_non_scalars()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Tree nodes must be exclusively scalars, object given of type stdClass at level [5]'
        );

        canonically_flatten_scalar_tree([5, 3, [2, [1, [[new \stdClass()]]]]]);
    }

    /**
     * @test
     */
    public function it_produces_a_non_associative_array_from_an_associative_tree()
    {
        $this->assertEquals(
            ['alpha', 'beta'],
            canonically_flatten_scalar_tree(['y' => 'beta', ['x' => 'alpha']])
        );
    }

    /**
     * @test
     */
    public function it_is_idempotent()
    {
        $this->assertEquals(
            ['alpha', 'beta', 'gamma'],
            canonically_flatten_scalar_tree(['alpha', 'beta', 'gamma'])
        );
    }

    /**
     * @test
     */
    public function it_produces_a_canonicalised_list_from_an_already_flat_list()
    {
        $this->assertEquals(
            ['alpha', 'beta', 'gamma'],
            canonically_flatten_scalar_tree(['gamma', 'beta', 'alpha'])
        );
    }

    /**
     * @test
     */
    public function it_guarantees_result_as_a_list_of_specified_types_for_integer()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Tree nodes must all be of type string, integer given at level [2]'
        );

        canonically_flatten_scalar_tree(['gamma', 'beta', ['alpha', 8]], 'string');
    }

    /**
     * @test
     */
    public function it_guarantees_result_as_a_list_of_specified_types_for_boolean()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Tree nodes must all be of type string, boolean given at level [2]'
        );

        canonically_flatten_scalar_tree(['gamma', 'beta', ['alpha', false]], 'string');
    }

    /**
     * @test
     */
    public function it_guarantees_result_as_a_list_of_specified_types_for_real_numbers()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Tree nodes must all be of type string, double given at level [2]'
        );

        canonically_flatten_scalar_tree(['gamma', 'beta', ['alpha', 1.8]], 'string');
    }

    /**
     * @test
     */
    public function it_guarantees_result_as_a_list_of_specified_types_using_string()
    {
        $this->assertEquals(
            ['alpha', 'beta', 'gamma', 'lambda'],
            canonically_flatten_scalar_tree(['gamma', 'beta', ['alpha', 'lambda']], 'string')
        );
    }

    /**
     * @test
     */
    public function it_guarantees_result_as_a_list_of_specified_types_using_integer()
    {
        $this->assertEquals(
            [1, 2, 3, 4],
            canonically_flatten_scalar_tree([2, 4, [1, 3]], 'integer')
        );
    }

    /**
     * @test
     */
    public function it_guarantees_result_as_a_list_of_specified_types_using_real_numbers()
    {
        $this->assertEquals(
            [1.7, 2.3, 3.8, 4.1],
            canonically_flatten_scalar_tree([2.3, 4.1, [1.7, 3.8]], 'float')
        );
    }

    /**
     * @test
     */
    public function it_guarantees_result_as_a_list_of_specified_types_using_boolean()
    {
        $this->assertEquals(
            [false, false, true],
            canonically_flatten_scalar_tree([false, true, [false]], 'bool')
        );
    }
}
