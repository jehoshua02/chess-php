<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\Pawn;
use \Chess\Piece\King;

class KingTest extends \PHPUnit_Framework_TestCase
{
    public function testMoves()
    {
        $board = new Board(array(
            'D4' => new King(Piece::LIGHT)
        ));
        $moves = $board->piece('D4')->moves();
        $this->assertCount(8, $moves, 'King should have eight possible moves');
        foreach (array('C5', 'D5', 'E5', 'C4', 'E4', 'C3', 'D3', 'E3') as $position) {
            $this->assertContains($position, $moves, sprintf('King should be able to move to %s', $position));
        }

        // edge of board
        $board = new Board(array(
            'A4' => new King(Piece::LIGHT)
        ));
        $moves = $board->piece('A4')->moves();
        $this->assertCount(5, $moves, 'King should have five possible moves');
        foreach (array('A5', 'B5', 'B4', 'A3', 'B3') as $position) {
            $this->assertContains($position, $moves, sprintf('King should be able to move to %s', $position));
        }

        // blocked
        $board = new Board(array(
            'D4' => new King(Piece::LIGHT),
            'D5' => new Pawn(Piece::LIGHT)
        ));
        $moves = $board->piece('D4')->moves();
        $this->assertCount(7, $moves, 'King should have seven possible moves');
        foreach (array('C5', 'E5', 'C4', 'E4', 'C3', 'D3', 'E3') as $position) {
            $this->assertContains($position, $moves, sprintf('King should be able to move to %s', $position));
        }
    }
}
