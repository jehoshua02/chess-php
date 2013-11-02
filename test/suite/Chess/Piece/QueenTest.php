<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\Pawn;
use \Chess\Piece\Queen;

class QueenTest extends \Chess\PieceTestCase
{
    public function testMoves()
    {
        $board = new Board(array(
            'D4' => new Queen(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D4'), 27,
            array(
                // all the same as Rook
                'A4', 'B4', 'C4', 'E4', 'F4', 'G4', 'H4', 'D1', 'D2', 'D3', 'D5', 'D6', 'D7', 'D8',
                // plus all the same as Bishop
                'A1', 'B2', 'C3', 'E5', 'F6', 'G7', 'H8', 'A7', 'B6', 'C5', 'E3', 'F2', 'G1'
            ),
            'Queen should be able to make any basic move'
        );
    }

    public function testMovesBlocked()
    {
        $board = new Board(array(
            'D4' => new Queen(Piece::LIGHT),

            // from RookTest
            'C4' => new Pawn(Piece::LIGHT),
            'D2' => new Pawn(Piece::LIGHT),
            'D5' => new Pawn(Piece::DARK),
            'F4' => new Pawn(Piece::DARK),

            // from BishopTest
            'C5' => new Pawn(Piece::DARK),
            'F6' => new Pawn(Piece::DARK),
            'C3' => new Pawn(Piece::LIGHT),
            'F2' => new Pawn(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D4'), 8,
            array(
                // from RookTest
                'D3', 'D5', 'E4', 'F4',
                // from BishopTest
                'E5', 'F6', 'C5', 'E3'
            ),
            'Queen should be blocked'
        );
    }
}
