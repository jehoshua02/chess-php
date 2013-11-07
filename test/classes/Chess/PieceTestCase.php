<?php

namespace Chess;

abstract class PieceTestCase extends \PHPUnit_Framework_TestCase
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
        $moves = array_map(function ($move) {
            return $move->to();
        }, $piece->moves());

        // assertions
        $this->assertCount($expectedCount, $expectedMoves, sprintf('%sExpected count does not agree with expected moves', $message));
        $this->assertCount($count, $moves, sprintf('%s%s should have %s possible moves', $message, $type, $count));
        foreach ($expectedMoves as $position) {
            $this->assertContains($position, $moves, sprintf('%s%s should be able to move to %s', $message, $type, $position));
        }
    }
}