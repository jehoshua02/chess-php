<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\Pawn;
use \Chess\Piece\Knight;

class KnightTest extends \PHPUnit_Framework_TestCase
{
    public function testMoves()
    {
        $board = new Board(array(
            'D4' => new Knight(Piece::LIGHT)
        ));
        $moves = $board->piece('D4')->moves();
        $this->assertCount(8, $moves, 'Knight should have eight possible moves');

        $message = 'Knight should be able to move to %s';
        $positions = array('C6', 'E6', 'C2', 'E2', 'B3', 'B5', 'F3', 'F5');
        foreach ($positions as $position) {
            $this->assertContains($position, $moves, sprintf($message, $position));
        }
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
        $moves = $board->piece('D4')->moves();
        $this->assertCount(7, $moves, 'Knight should have eight possible moves');

        $message = 'Knight should be able to move to %s';
        $positions = array('C6', 'E6', 'C2', 'B3', 'B5', 'F3', 'F5');
        foreach ($positions as $position) {
            $this->assertContains($position, $moves, sprintf($message, $position));
        }
    }

    public function testEdgeOfBoard()
    {
        $board = new Board(array(
            'B4' => new Knight(Piece::LIGHT)
        ));
        $moves = $board->piece('B4')->moves();
        $this->assertCount(6, $moves, 'Knight should have six possible moves');
    }
}
