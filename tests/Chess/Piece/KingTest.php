<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\King;

class KingTest extends \PHPUnit_Framework_TestCase
{
    public function testCheck()
    {
        $king = new King(Piece::LIGHT);
        $board = new Board(array(
            'D4' => $king
        ));
        $this->assertFalse($king->check(), 'King should not be in check');
    }
}
