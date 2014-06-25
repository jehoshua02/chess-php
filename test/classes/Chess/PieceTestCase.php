<?php

namespace Chess;

abstract class PieceTestCase extends \Chess\TestCase
{
    /**
     * Asserts possible moves for a piece
     * @param  \Chess\Piece $piece
     * @param  int $count
     * @param  array $expected
     */
    protected function assertMoves($piece, $expectedCount, $expectedMoves, $message = null)
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
        $count = count($expectedMoves);
        $moves = $piece->moves();

        // assertions
        $this->assertCount($expectedCount, $expectedMoves, sprintf('%sExpected count does not agree with expected moves', $message));
        $this->assertEquals($expectedCount, $moves->count(), sprintf('%s%s should have %s possible moves', $message, $type, $count));
        foreach ($expectedMoves as $move) {
            if (is_string($move)) {
                $position = $move;
                $properties = array();
            } elseif (is_array($move)) {
                @list($position, $properties) = $move;
                if (!is_array($properties)) {
                    $properties = array();
                }
            }
            $move = call_user_func(array($moves, 'match'), $position, $properties);
            $this->assertFalse($move === false, sprintf('%s%s should be able to move to %s', $message, $type, $position));
        }
    }
}