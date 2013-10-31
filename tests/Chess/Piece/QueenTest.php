<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\Pawn;
use \Chess\Piece\Queen;

class QueenTest extends \PHPUnit_Framework_TestCase
{
    public function testMoves()
    {
        $board = new Board(array(
            'D4' => new Queen(Piece::LIGHT)
        ));
        $moves = $board->piece('D4')->moves();
        $this->assertCount(27, $moves, 'Queen should have 27 possible moves');

        $message = 'Queen should be able to move to %s';
        $positions = array(
            // all the same as Rook
            'A4', 'B4', 'C4', 'E4', 'F4', 'G4', 'H4', 'D1', 'D2', 'D3', 'D5', 'D6', 'D7', 'D8',
            // plus all the same as Bishop
            'A1', 'B2', 'C3', 'E5', 'F6', 'G7', 'H8', 'A7', 'B6', 'C5', 'E3', 'F2', 'G1'
        );
        foreach ($positions as $position) {
            $this->assertContains($position, $moves, sprintf($message, $position));
        }
    }
}
