<?php

namespace Chess\Piece;
use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\Pawn;

class PawnTest extends \PHPUnit_Framework_TestCase
{
    public function testUp()
    {
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertEquals('D5', $board->get('D4')->up(), 'Pawn should be able to move up');

        // blocked
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'D5' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->get('D4')->up(), 'Pawn should not be able to move up');

        // dark
        $board = new Board(array(
            'D4' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->get('D4')->up(), 'Pawn should not be able to move up');
    }

    public function testDown()
    {
        $board = new Board(array(
            'D4' => new Pawn(Piece::DARK)
        ));
        $this->assertEquals('D3', $board->get('D4')->down(), 'Pawn should be able to move down');

        $board = new Board(array(
            'D4' => new Pawn(Piece::DARK),
            'D3' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->get('D4')->down(), 'Pawn should not be able to move down');

        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->get('D4')->down(), 'Pawn should not be able to move down');
    }
}
