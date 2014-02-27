<?php

namespace JUIT;

class ArrayDifferTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function empty_result_on_two_equal_strings()
    {
        $from = 'abc';
        $to = 'abc';

        $SUT = new ArrayDiffer();

        $this->assertEquals([], $SUT->diff($from, $to));
    }

    /**
     * @test
     */
    public function two_different_strings()
    {
        $from = 'abc';
        $to = 'abcd';

        $SUT = new ArrayDiffer();

        $expected = [
            'FROM' => 'abc',
            'TO' => 'abcd'
        ];
        $this->assertEquals($expected, $SUT->diff($from, $to));
    }

    /**
     * @test
     */
    public function identical_arrays()
    {
        $from = ['abc'];
        $to = ['abc'];

        $SUT = new ArrayDiffer();

        $this->assertEquals([], $SUT->diff($from, $to));
    }

    /**
     * @test
     */
    public function arrays_with_different_values()
    {
        $from = ['abc', 'bcd', 'cde'];
        $to = ['abc', 'bce', 'cde'];

        $SUT = new ArrayDiffer();

        $expected = [
            1 => [
                'FROM' => 'bcd',
                'TO' => 'bce'
            ]
        ];
        $this->assertEquals($expected, $SUT->diff($from, $to));
    }

    /**
     * @test
     */
    public function arrays_with_missing_values()
    {
        $from = ['abc', 'bcd', 'cde'];
        $to = ['abc', 'bcd'];

        $SUT = new ArrayDiffer();

        $expected = [
            2 => [
                'FROM' => 'cde'
            ]
        ];
        $this->assertEquals($expected, $SUT->diff($from, $to));
    }

    /**
     * @test
     */
    public function arrays_with_additional_values()
    {
        $from = ['abc', 'bcd'];
        $to = ['abc', 'bcd', 'cde'];

        $SUT = new ArrayDiffer();

        $expected = [
            2 => [
                'TO' => 'cde'
            ]
        ];
        $this->assertEquals($expected, $SUT->diff($from, $to));
    }

    /**
     * @test
     */
    public function identical_hashmaps()
    {
        $from = ['my_key' => 'abc'];
        $to = ['my_key' => 'abc'];

        $SUT = new ArrayDiffer();

        $this->assertEquals([], $SUT->diff($from, $to));
    }

    /**
     * @test
     */
    public function hashmaps_with_identical_keys_and_different_values()
    {
        $from = ['my_key' => 'abc'];
        $to = ['my_key' => 'abcd'];

        $SUT = new ArrayDiffer();

        $expected = [
            'my_key' => [
                'FROM' => 'abc',
                'TO' => 'abcd'
            ]
        ];
        $this->assertEquals($expected, $SUT->diff($from, $to));
    }

    /**
     * @test
     */
    public function hashmaps_with_different_keys()
    {
        $from = ['my_key' => 'abc'];
        $to = ['my_other_key' => 'abc'];

        $SUT = new ArrayDiffer();

        $expected = [
            'my_key' => [
                'FROM' => 'abc'
            ],
            'my_other_key' => [
                'TO' => 'abc'
            ]
        ];
        $this->assertEquals($expected, $SUT->diff($from, $to));
    }

    /**
     * @test
     */
    public function nested_identical_hashmaps()
    {
        $from = [
            'identical' => 'abc',
            'identical_hashmap' => [
                'some_key' => 'bcd',
                'some_other_key' => 'cde'
            ]
        ];
        $to = [
            'identical' => 'abc',
            'identical_hashmap' => [
                'some_key' => 'bcd',
                'some_other_key' => 'cde'
            ]
        ];

        $SUT = new ArrayDiffer();

        $this->assertEquals([], $SUT->diff($from, $to));
    }

    /**
     * @test
     */
    public function nested_hashmaps_with_different_values()
    {
        $from = [
            'identical' => 'abc',
            'differing_hashmap' => [
                'foo' => 'bar'
            ],
            'identical_hashmap' => [
                'some_key' => 'bcd',
                'some_other_key' => 'cde'
            ]
        ];
        $to = [
            'identical' => 'abc',
            'differing_hashmap' => [
                'foo' => 'baz'
            ],
            'identical_hashmap' => [
                'some_key' => 'bcd',
                'some_other_key' => 'cde'
            ]
        ];

        $SUT = new ArrayDiffer();

        $expected = [
            'differing_hashmap' => [
                'foo' => [
                    'FROM' => 'bar',
                    'TO' => 'baz'
                ]
            ],
        ];
        $this->assertEquals($expected, $SUT->diff($from, $to));
    }

    /**
     * @test
     */
    public function nested_hashmaps_three_levels()
    {
        $from = [
            'identical' => 'abc',
            'differing_hashmap' => [
                'foo' => [
                    'different_third_level_key' => 'bar',
                    'identical_third_level_key' => 'foofoo',
                ]
            ],
            'identical_hashmap' => [
                'some_key' => 'bcd',
                'some_other_key' => 'cde'
            ]
        ];
        $to = [
            'identical' => 'abc',
            'differing_hashmap' => [
                'foo' => [
                    'different_third_level_key' => 'baz',
                    'identical_third_level_key' => 'foofoo',
                ]
            ],
            'identical_hashmap' => [
                'some_key' => 'bcd',
                'some_other_key' => 'cde'
            ]
        ];

        $SUT = new ArrayDiffer();

        $expected = [
            'differing_hashmap' => [
                'foo' => [
                    'different_third_level_key' => [
                        'FROM' => 'bar',
                        'TO' => 'baz'
                    ]
                ]
            ],
        ];
        $this->assertEquals($expected, $SUT->diff($from, $to));
    }

    /**
     * @test
     */
    public function nested_hashmap_with_missing_element()
    {
        $from = [
            'some_hashmap' => [
                'first_element' => 'abc',
                'second_element' => 'bcd'
            ]
        ];
        $to = [
            'some_hashmap' => [
                'first_element' => 'abc'
            ]
        ];

        $SUT = new ArrayDiffer();

        $expected = [
            'some_hashmap' => [
                'second_element' => [
                    'FROM' => 'bcd'
                ]
            ]
        ];
        $this->assertEquals($expected, $SUT->diff($from, $to));
    }

    /**
     * @test
     */
    public function nested_hashmap_with_additional_element()
    {
        $from = [
            'some_hashmap' => [
                'first_element' => 'abc'
            ]
        ];
        $to = [
            'some_hashmap' => [
                'first_element' => 'abc',
                'second_element' => 'bcd'
            ]
        ];

        $SUT = new ArrayDiffer();

        $expected = [
            'some_hashmap' => [
                'second_element' => [
                    'TO' => 'bcd'
                ]
            ]
        ];
        $this->assertEquals($expected, $SUT->diff($from, $to));
    }

    /**
     * @test
     */
    public function order_does_not_matter()
    {
        $from = [
            'first_element' => 'abc',
            'second_element' => 'bcd'
        ];
        $to = [
            'second_element' => 'bcd',
            'first_element' => 'abc'
        ];

        $SUT = new ArrayDiffer();

        $this->assertEquals([], $SUT->diff($from, $to));
    }

    /**
     * @test
     */
    public function can_set_custom_from_and_to_header()
    {
        $from = 'abc';
        $to = 'abcd';

        $SUT = new ArrayDiffer('FIRST', 'SECOND');

        $expected = [
            'FIRST' => 'abc',
            'SECOND' => 'abcd'
        ];
        $this->assertEquals($expected, $SUT->diff($from, $to));
    }


}
