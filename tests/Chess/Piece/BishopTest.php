<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\Bishop;

class BishopTest extends \PHPUnit_Framework_TestCase
{
    public function testMoves()
    {
        $board = new Board(array(
            'D4' => new Bishop(Piece::LIGHT)
        ));
        $moves = $board->piece('D4')->moves();
        $this->assertCount(13, $moves, 'Bishop should have 13 possible moves');

        $message = 'Bishop should be able to move to %s';
        $positions = array('A1', 'B2', 'C3', 'E5', 'F6', 'G7', 'H8', 'A7', 'B6', 'C5', 'E3', 'F2', 'G1');
        foreach ($positions as $position) {
            $this->assertContains($position, $moves, sprintf($message, $position));
        }
    }
}
