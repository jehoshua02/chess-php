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
        $this->assertEquals('D5', $board->piece('D4')->up(), 'Pawn should be able to move up');

        // blocked
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'D5' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->piece('D4')->up(), 'Pawn should not be able to move up');

        // dark
        $board = new Board(array(
            'D4' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->piece('D4')->up(), 'Pawn should not be able to move up');

        // two
        $board = new Board(array(
            'A2' => new Pawn(Piece::LIGHT)
        ));
        $this->assertEquals('A4', $board->piece('A2')->up(2), 'Pawn should be able to move two up from starting position');

        // two blocked
        $board = new Board(array(
            'A2' => new Pawn(Piece::LIGHT),
            'A3' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->piece('A2')->up(2), 'Pawn should be blocked from moving two up');

        $board = new Board(array(
            'A2' => new Pawn(Piece::LIGHT),
            'A4' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->piece('A2')->up(2), 'Pawn should be blocked from moving two up');

        // not on start position
        $board = new Board(array(
            'A3' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->piece('A3')->up(2), 'Pawn should be blocked from moving two up');

        // three
        $board = new Board(array(
            'A2' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->piece('A2')->up(3), 'Pawn cannot move three up');
    }

    public function testDown()
    {
        $board = new Board(array(
            'D4' => new Pawn(Piece::DARK)
        ));
        $this->assertEquals('D3', $board->piece('D4')->down(), 'Pawn should be able to move down');

        // blocked
        $board = new Board(array(
            'D4' => new Pawn(Piece::DARK),
            'D3' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->piece('D4')->down(), 'Pawn should not be able to move down');

        // light
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->piece('D4')->down(), 'Pawn should not be able to move down');

        // two
        $board = new Board(array(
            'A7' => new Pawn(Piece::DARK)
        ));
        $this->assertEquals('A5', $board->piece('A7')->down(2), 'Pawn should be able to move two down from starting position');

        $board = new Board(array(
            'A7' => new Pawn(Piece::DARK),
            'A5' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->piece('A7')->down(2), 'Pawn should be blocked from moving two down');

        // not on start position
        $board = new Board(array(
            'A6' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->piece('A6')->down(2), 'Pawn should be blocked from moving two down');

        // three
        $board = new Board(array(
            'A7' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->piece('A7')->down(3), 'Pawn cannot move three down');
    }

    public function testLeft()
    {
        $board = new Board(array(
            'D4' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->piece('D4')->left(), 'Pawn should not be able to move left');
    }

    public function testRight()
    {
        $board = new Board(array(
            'D4' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->piece('D4')->right(), 'Pawn should not be able to move right');
    }

    public function testUpLeft()
    {
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->piece('D4')->upLeft(), 'Pawn should not be able to move up and left');

        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'C5' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->piece('D4')->upLeft(), 'Pawn should not be able to capture own color');

        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'C5' => new Pawn(Piece::DARK)
        ));
        $this->assertEquals('C5', $board->piece('D4')->upLeft(), 'Pawn should be able to capture up and left');

        $board = new Board(array(
            'A4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->piece('A4')->upLeft(), 'Pawn should not be able to move off edge of board');

        $board = new Board(array(
            'D4' => new Pawn(Piece::DARK),
            'C5' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->piece('D4')->upLeft(), 'Dark pawn should not be able to move up and left');
    }

    public function testUpRight()
    {
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->piece('D4')->upRight(), 'Pawn should not be able to move up and right');

        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'E5' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->piece('D4')->upRight(), 'Pawn should not be able to capture own color');

        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'E5' => new Pawn(Piece::DARK)
        ));
        $this->assertEquals('E5', $board->piece('D4')->upRight(), 'Pawn should be able to capture up and right');

        $board = new Board(array(
            'H4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->piece('H4')->upRight(), 'Pawn should not be able to move off edge of board');

        $board = new Board(array(
            'D4' => new Pawn(Piece::DARK),
            'E5' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($board->piece('D4')->upRight(), 'Dark pawn should not be able to move up and right');
    }

    public function testDownLeft()
    {
        $board = new Board(array(
            'D5' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->piece('D5')->downLeft(), 'Pawn should not be able to move down and left');

        $board = new Board(array(
            'D5' => new Pawn(Piece::DARK),
            'C4' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->piece('D5')->downLeft(), 'Pawn should not be able to capture own color');

        $board = new Board(array(
            'D5' => new Pawn(Piece::DARK),
            'C4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertEquals('C4', $board->piece('D5')->downLeft(), 'Pawn should be able to capture down and left');

        $board = new Board(array(
            'A5' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->piece('A5')->downLeft(), 'Pawn should not be able to move off edge of board');

        $board = new Board(array(
            'D5' => new Pawn(Piece::LIGHT),
            'C4' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->piece('D5')->downLeft(), 'Light pawn should not be able to move down and left');
    }

    public function testDownRight()
    {
        $board = new Board(array(
            'D5' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->piece('D5')->downRight(), 'Pawn should not be able to move down and right');

        $board = new Board(array(
            'D5' => new Pawn(Piece::DARK),
            'E4' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->piece('D5')->downRight(), 'Pawn should not be able to capture own color');

        $board = new Board(array(
            'D5' => new Pawn(Piece::DARK),
            'E4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertEquals('E4', $board->piece('D5')->downRight(), 'Pawn should be able to capture down and right');

        $board = new Board(array(
            'H4' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->piece('H4')->downRight(), 'Pawn should not be able to move off edge of board');

        $board = new Board(array(
            'D5' => new Pawn(Piece::LIGHT),
            'E4' => new Pawn(Piece::DARK)
        ));
        $this->assertFalse($board->piece('D5')->downRight(), 'Light pawn should not be able to move down and right');
    }
}
