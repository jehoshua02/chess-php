<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\Pawn;
use \Chess\Piece\Queen;
use \Chess\Player;

class QueenTest extends \Chess\PieceTestCase
{
    public function testMoves()
    {
        $player1 = new Player();
        $board = $this->makeBoard(array(
            array('D4', 'Queen', 1)
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
        $player1 = new Player();
        $player2 = new Player();
        $board = $this->makeBoard(array(
            array('D4', 'Queen', 1),

            // from RookTest
            array('C4', 'Pawn', 1),
            array('D2', 'Pawn', 1),
            array('D5', 'Pawn', 2),
            array('F4', 'Pawn', 2),

            // from BishopTest
            array('C5', 'Pawn', 2),
            array('F6', 'Pawn', 2),
            array('C3', 'Pawn', 1),
            array('F2', 'Pawn', 1)
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
