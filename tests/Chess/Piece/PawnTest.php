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
        $this->assertEquals('D5', $board->getPiece('D4')->up(), 'Pawn should be able to move up');

        // blocked
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'D5' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->getPiece('D4')->up(), 'Pawn should not be able to move up');

        // dark
        $board = new Board(array(
            'D4' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->getPiece('D4')->up(), 'Pawn should not be able to move up');

        // two
        $board = new Board(array(
            'A2' => new Pawn(Piece::LIGHT)
        ));
        $this->assertEquals('A4', $board->getPiece('A2')->up(2), 'Pawn should be able to move two up from starting position');

        // two blocked
        $board = new Board(array(
            'A2' => new Pawn(Piece::LIGHT),
            'A3' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->getPiece('A2')->up(2), 'Pawn should be blocked from moving two up');

        $board = new Board(array(
            'A2' => new Pawn(Piece::LIGHT),
            'A4' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->getPiece('A2')->up(2), 'Pawn should be blocked from moving two up');

        // not on start position
        $board = new Board(array(
            'A3' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->getPiece('A3')->up(2), 'Pawn should be blocked from moving two up');
    }

    public function testDown()
    {
        $board = new Board(array(
            'D4' => new Pawn(Piece::DARK)
        ));
        $this->assertEquals('D3', $board->getPiece('D4')->down(), 'Pawn should be able to move down');

        $board = new Board(array(
            'D4' => new Pawn(Piece::DARK),
            'D3' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->getPiece('D4')->down(), 'Pawn should not be able to move down');

        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->getPiece('D4')->down(), 'Pawn should not be able to move down');
    }

    public function testLeft()
    {
        $board = new Board(array(
            'D4' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->getPiece('D4')->left(), 'Pawn should not be able to move left');
    }

    public function testRight()
    {
        $board = new Board(array(
            'D4' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->getPiece('D4')->right(), 'Pawn should not be able to move right');
    }

    public function testUpLeft()
    {
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->getPiece('D4')->upLeft(), 'Pawn should not be able to move up and left');

        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'C5' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->getPiece('D4')->upLeft(), 'Pawn should not be able to capture own color');

        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'C5' => new Pawn(Piece::DARK)
        ));
        $this->assertEquals('C5', $board->getPiece('D4')->upLeft(), 'Pawn should be able to capture up and left');

        $board = new Board(array(
            'A4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->getPiece('A4')->upLeft(), 'Pawn should not be able to move off edge of board');

        $board = new Board(array(
            'D4' => new Pawn(Piece::DARK),
            'C5' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->getPiece('D4')->upLeft(), 'Dark pawn should not be able to move up and left');
    }

    public function testUpRight()
    {
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->getPiece('D4')->upRight(), 'Pawn should not be able to move up and right');

        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'E5' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->getPiece('D4')->upRight(), 'Pawn should not be able to capture own color');

        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'E5' => new Pawn(Piece::DARK)
        ));
        $this->assertEquals('E5', $board->getPiece('D4')->upRight(), 'Pawn should be able to capture up and right');

        $board = new Board(array(
            'H4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->getPiece('H4')->upRight(), 'Pawn should not be able to move off edge of board');

        $board = new Board(array(
            'D4' => new Pawn(Piece::DARK),
            'E5' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->getPiece('D4')->upRight(), 'Dark pawn should not be able to move up and right');
    }
}
