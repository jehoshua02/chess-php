<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\King;
use \Chess\Piece\Pawn;

class PieceStub extends \Chess\Piece
{

}

class PieceTest extends PHPUnit_Framework_TestCase
{
    public function testBoard()
    {
        $piece = new PieceStub(Piece::LIGHT);

        $board = new Board(array());
        $this->assertTrue($board === $piece->board($board), 'Piece should return board');
        $this->assertTrue($board === $piece->board(), 'Piece should return board again');

        $anotherBoard = new Board(array());
        $this->assertFalse($anotherBoard === $piece->board($anotherBoard), 'Piece board should be immutable');
        $this->assertTrue($board === $piece->board(), 'Piece board should not have changed');
    }

    public function testKing()
    {
        $piece = new PieceStub(Piece::LIGHT);
        $board = new Board(array(
            'D4' => $piece,
            'E8' => new King(Piece::DARK),
            'E1' => new King(Piece::LIGHT)
        ));
        $board->piece('D4', $piece);
        $king = $board->piece('E1');
        $this->assertTrue($king === $piece->king(), 'Every piece should know it\'s King');

        // no king
        $piece = new PieceStub(Piece::LIGHT);
        $board = new Board(array(
            'D4' => $piece
        ));
        $this->assertFalse($piece->king(), 'Piece on board with no King has no King');

        // no board
        $piece = new PieceStub(Piece::LIGHT);
        $this->assertFalse($piece->king(), 'Piece without a board has no King');
    }

    public function testCheck()
    {
        $piece = new PieceStub(Piece::LIGHT);
        $board = new Board(array(
            'A1' => $piece,
            'D4' => new King(Piece::LIGHT),
            'E5' => new Pawn(Piece::DARK)
        ));
        $this->assertTrue($piece->check(), 'King should be in check');

        // not in check
        $piece = new PieceStub(Piece::LIGHT);
        $board = new Board(array(
            'A1' => $piece,
            'D4' => new King(Piece::LIGHT),
            'E5' => new Pawn(Piece::LIGHT)
        ));
        $this->assertFalse($piece->check(), 'King should not be in check');
    }
}
