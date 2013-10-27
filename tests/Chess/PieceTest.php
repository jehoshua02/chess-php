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
}