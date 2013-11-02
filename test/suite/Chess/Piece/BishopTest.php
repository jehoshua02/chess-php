<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\Pawn;
use \Chess\Piece\Bishop;

class BishopTest extends \Chess\PieceTestCase
{
    public function testMoves()
    {
        $board = new Board(array(
            'D4' => new Bishop(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D4'), 13,
            array('A1', 'B2', 'C3', 'E5', 'F6', 'G7', 'H8', 'A7', 'B6', 'C5', 'E3', 'F2', 'G1'),
            'Rook should be able to make any basic move'
        );

        // blocked
        $board = new Board(array(
            'D4' => new Bishop(Piece::LIGHT),
            'C5' => new Pawn(Piece::DARK),
            'F6' => new Pawn(Piece::DARK),
            'C3' => new Pawn(Piece::LIGHT),
            'F2' => new Pawn(Piece::LIGHT),
        ));
        $this->assertMoves(
            $board->piece('D4'), 4,
            array('E5', 'F6', 'C5', 'E3'),
            'Bishop should be blocked'
        );
    }
}
