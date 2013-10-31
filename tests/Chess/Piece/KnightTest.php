<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\Pawn;
use \Chess\Piece\Knight;

class KnightTest extends \PHPUnit_Framework_TestCase
{
    public function testMoves()
    {
        $board = new Board(array(
            'D4' => new Knight(Piece::LIGHT)
        ));
        $moves = $board->piece('D4')->moves();
        $this->assertCount(8, $moves, 'Knight should have eight possible moves');

        $message = 'Knight should be able to move to %s';
        $positions = array('C6', 'E6', 'C2', 'E2', 'B3', 'B5', 'F3', 'F5');
        foreach ($positions as $position) {
            $this->assertContains($position, $moves, sprintf($message, $position));
        }
    }
}
