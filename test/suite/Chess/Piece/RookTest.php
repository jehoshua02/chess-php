<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\Pawn;
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

    public function testMovesBlocked()
    {
        $board = new Board(array(
            'D4' => new Rook(Piece::LIGHT),
            'C4' => new Pawn(Piece::LIGHT),
            'D2' => new Pawn(Piece::LIGHT),
            'D5' => new Pawn(Piece::DARK),
            'F4' => new Pawn(Piece::DARK)
        ));
        $moves = $board->piece('D4')->moves();
        $this->assertCount(4, $moves, 'Rook should have four possible moves');

        $message = 'Rook should be able to move to %s';
        $positions = array('D3', 'D5', 'E4', 'F4');
        foreach ($positions as $position) {
            $this->assertContains($position, $moves, sprintf($message, $position));
        }
    }
}
