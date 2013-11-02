<?php

namespace Chess;

abstract class PieceTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Asserts possible moves for a piece
     * @param  \Chess\Piece $piece
     * @param  array $expected
     */
    protected function assertMoves($piece, $expected, $message = null)
    {
        // get type of piece
        $class = get_class($piece);
        $parts = explode('\\', $class);
        $type = array_pop($parts);

        // message
        if ($message !== null) {
            $message .= ': ';
        }

        // get moves and count
        $count = count($expected);
        $moves = $piece->moves();

        // assertions
        $this->assertCount($count, $moves, sprintf('%s%s should have %s possible moves', $message, $type, $count));
        foreach ($expected as $position) {
            $this->assertContains($position, $moves, sprintf('%s%s should be able to move to %s', $message, $type, $position));
        }
    }
}