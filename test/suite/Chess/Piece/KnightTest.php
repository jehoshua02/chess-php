<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\Pawn;
use \Chess\Piece\Knight;

class KnightTest extends \Chess\PieceTestCase
{
    public function testMoves()
    {
        $board = new Board(array(
            'D4' => new Knight(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D4'), 8,
            array('C6', 'E6', 'C2', 'E2', 'B3', 'B5', 'F3', 'F5'),
            'Knight should be able to make any basic move'
        );
    }

    public function testMovesBlocked()
    {
        $board = new Board(array(
            'D4' => new Knight(Piece::LIGHT),

            // pieces to jump over to get to C6
            'C5' => new Pawn(Piece::LIGHT),
            'D6' => new Pawn(Piece::LIGHT),

            // piece to capture in E6
            'E6' => new Pawn(Piece::DARK),

            // same color will block E2
            'E2' => new Pawn(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D4'), 7,
            array('C6', 'E6', 'C2', 'B3', 'B5', 'F3', 'F5'),
            'Knight should be blocked'
        );
    }

    public function testEdgeOfBoard()
    {
        $board = new Board(array(
            'B4' => new Knight(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('B4'), 6,
            array('A6', 'C6', 'D5', 'D3', 'C2', 'A2'),
            'Knight should not be able to move off board'
        );
    }
}
