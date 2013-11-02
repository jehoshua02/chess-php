<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\Pawn;
use \Chess\Piece\King;

class KingTest extends \Chess\PieceTestCase
{
    public function testMoves()
    {
        $board = new Board(array(
            'D4' => new King(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D4'), 8,
            array('C5', 'D5', 'E5', 'C4', 'E4', 'C3', 'D3', 'E3'),
            'King should be able to move to any adjacent position'
        );

        // edge of board
        $board = new Board(array(
            'A4' => new King(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('A4'), 5,
            array('A5', 'B5', 'B4', 'A3', 'B3'),
            'King cannot move off board'
        );

        // blocked
        $board = new Board(array(
            'D4' => new King(Piece::LIGHT),
            'D5' => new Pawn(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D4'), 7,
            array('C5', 'E5', 'C4', 'E4', 'C3', 'D3', 'E3'),
            'King should be blocked'
        );

        // cannot move into check
        $board = new Board(array(
            'D4' => new King(Piece::LIGHT),
            'F5' => new Pawn(Piece::DARK)
        ));
        $this->assertMoves(
            $board->piece('D4'), 7,
            array('C5', 'D5', 'E5', 'C4', 'C3', 'D3', 'E3'),
            'King cannot move into check'
        );
    }
}
