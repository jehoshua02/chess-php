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
        $this->assertCount(13, $moves);

        // down left
        $this->assertContains('A1', $moves, 'Bishop should be able to move to A1');
        $this->assertContains('B2', $moves, 'Bishop should be able to move to B2');
        $this->assertContains('C3', $moves, 'Bishop should be able to move to C3');

        // up right
        $this->assertContains('E5', $moves, 'Bishop should be able to move to E5');
        $this->assertContains('F6', $moves, 'Bishop should be able to move to F6');
        $this->assertContains('G7', $moves, 'Bishop should be able to move to G7');
        $this->assertContains('H8', $moves, 'Bishop should be able to move to H8');

        // up left
        $this->assertContains('A7', $moves, 'Bishop should be able to move to A7');
        $this->assertContains('B6', $moves, 'Bishop should be able to move to B6');
        $this->assertContains('C5', $moves, 'Bishop should be able to move to C5');

        // down right
        $this->assertContains('E3', $moves, 'Bishop should be able to move to E3');
        $this->assertContains('F2', $moves, 'Bishop should be able to move to F2');
        $this->assertContains('G1', $moves, 'Bishop should be able to move to G1');
    }
}
