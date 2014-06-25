<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\Pawn;
use \Chess\Piece\Knight;
use \Chess\Player;

class KnightTest extends \Chess\PieceTestCase
{
    public function testMoves()
    {
        $player1 = new Player();
        $board = $this->makeBoard(array(
            array('D4', 'Knight', 1)
        ));
        $this->assertMoves(
            $board->piece('D4'), 8,
            array('C6', 'E6', 'C2', 'E2', 'B3', 'B5', 'F3', 'F5'),
            'Knight should be able to make any basic move'
        );
    }

    public function testMovesBlocked()
    {
        $player1 = new Player();
        $player2 = new Player();
        $board = $this->makeBoard(array(
            array('D4', 'Knight', 1),

            // pieces to jump over to get to C6
            array('C5', 'Pawn', 1),
            array('D6', 'Pawn', 1),

            // piece to capture in E6
            array('E6', 'Pawn', 2),

            // same color will block E2
            array('E2', 'Pawn', 1)
        ));
        $this->assertMoves(
            $board->piece('D4'), 7,
            array('C6', 'E6', 'C2', 'B3', 'B5', 'F3', 'F5'),
            'Knight should be blocked'
        );
    }

    public function testEdgeOfBoard()
    {
        $player1 = new Player();
        $board = $this->makeBoard(array(
            array('B4', 'Knight', 1)
        ));
        $this->assertMoves(
            $board->piece('B4'), 6,
            array('A6', 'C6', 'D5', 'D3', 'C2', 'A2'),
            'Knight should not be able to move off board'
        );
    }
}
