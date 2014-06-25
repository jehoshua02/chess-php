<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\Pawn;
use \Chess\Piece\Rook;
use \Chess\Player;

class RookTest extends \Chess\PieceTestCase
{
    public function testMoves()
    {
        $player1 = new Player();
        $board = $this->makeBoard(array(
            array('D4', 'Rook', 1)
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
        $player1 = new Player();
        $player2 = new Player();
        $board = $this->makeBoard(array(
            array('D4', 'Rook', 1),
            array('C4', 'Pawn', 1),
            array('D2', 'Pawn', 1),
            array('D5', 'Pawn', 2),
            array('F4', 'Pawn', 2)
        ));
        $this->assertMoves(
            $board->piece('D4'), 4,
            array('D3', 'D5', 'E4', 'F4'),
            'Rook should be blocked'
        );
    }
}
