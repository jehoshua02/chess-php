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
    }
}
