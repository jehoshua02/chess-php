<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\Rook;

class RookTest extends \PHPUnit_Framework_TestCase
{
    public function testMoves()
    {
        $board = new Board(array(
            'D4' => new Rook(Piece::LIGHT)
        ));
        $moves = $board->piece('D4')->moves();
        $this->assertCount(14, $moves, 'Rook should have 13 possible moves');

        $message = 'Rook should be able to move to %s';
        $positions = array('A4', 'B4', 'C4', 'E4', 'F4', 'G4', 'H4', 'D1', 'D2', 'D3', 'D5', 'D6', 'D7', 'D8');
        foreach ($positions as $position) {
            $this->assertContains($position, $moves, sprintf($message, $position));
        }
    }
}
