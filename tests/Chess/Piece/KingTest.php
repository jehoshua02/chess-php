<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\King;

class KingTest extends \PHPUnit_Framework_TestCase
{
    public function testNoMoves()
    {
        $board = new Board(array(
            'D4' => new King(Piece::LIGHT)
        ));
        $moves = $board->piece('D4')->moves();
        $this->assertCount(0, $moves, 'King should have no possible moves');
    }
}
