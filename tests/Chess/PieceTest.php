<?php

use \Chess\Piece;
use \Chess\Board;

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
        $board = new Board();
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
}
