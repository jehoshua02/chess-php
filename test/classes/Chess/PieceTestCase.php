<?php

namespace Chess;

abstract class PieceTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Asserts possible moves for a piece
     * @param  \Chess\Piece $piece
     * @param  array $expected
     */
    protected function assertMoves($piece, $expected)
    {
        $class = get_class($piece);
        $parts = explode('\\', $class);
        $type = array_pop($parts);
        $moves = $piece->moves();
        $count = count($expected);
        $this->assertCount($count, $moves, sprintf('%s should have %s possible moves', $type, $count));
        foreach ($expected as $position) {
            $this->assertContains($position, $moves, sprintf('%s should be able to move to %s', $type, $position));
        }
    }
}