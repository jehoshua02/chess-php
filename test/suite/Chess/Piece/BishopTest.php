<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\Pawn;
use \Chess\Piece\Bishop;
use \Chess\Player;

class BishopTest extends \Chess\PieceTestCase
{
    public function testMoves()
    {
        $player1 = new Player();
        $player2 = new Player();
        $board = $this->makeBoard(array(
            array('D4', 'Bishop', 1)
        ));
        $this->assertMoves(
            $board->piece('D4'), 13,
            array('A1', 'B2', 'C3', 'E5', 'F6', 'G7', 'H8', 'A7', 'B6', 'C5', 'E3', 'F2', 'G1'),
            'Bishop should be able to make any basic move'
        );

        // blocked
        $player1 = new Player();
        $player2 = new Player();
        $board = $this->makeBoard(array(
            array('D4', 'Bishop', 1),
            array('C5', 'Pawn', 2),
            array('F6', 'Pawn', 2),
            array('C3', 'Pawn', 1),
            array('F2', 'Pawn', 1),
        ));
        $this->assertMoves(
            $board->piece('D4'), 4,
            array('E5', 'F6', 'C5', 'E3'),
            'Bishop should be blocked'
        );
    }
}
