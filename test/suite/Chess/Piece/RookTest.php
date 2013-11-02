<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\Pawn;
use \Chess\Piece\Rook;

class RookTest extends \Chess\PieceTestCase
{
    public function testMoves()
    {
        $board = new Board(array(
            'D4' => new Rook(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D4'), 14,
            array(
                'A4', 'B4', 'C4', 'E4', 'F4', 'G4', 'H4',
                'D1', 'D2', 'D3', 'D5', 'D6', 'D7', 'D8'
            ),
            'Rook should be able to make any basic move'
        );
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
        $this->assertMoves(
            $board->piece('D4'), 4,
            array('D3', 'D5', 'E4', 'F4'),
            'Rook should be blocked'
        );
    }
}
