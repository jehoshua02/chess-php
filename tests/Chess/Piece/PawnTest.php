<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\Pawn;

class PawnTest extends \PHPUnit_Framework_TestCase
{
    public function testMove()
    {
        // valid move
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT)
        ));
        $piece = $board->piece('D4');
        $this->assertTrue($board->piece('D4')->move('D5'), 'Pawn should be able to move');
        $this->assertNull($board->piece('D4'), 'Pawn should not be in D4 anymore');
        $this->assertTrue($board->piece('D5') === $piece, 'Pawn should now be in D5');

        // invalid move
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT)
        ));
        $piece = $board->piece('D4');
        $this->assertFalse($board->piece('D4')->move('D3'), 'Pawn should not be able to move');
        $this->assertTrue($board->piece('D4') === $piece, 'Pawn should be in D4 still');
    }

    public function testPromotion()
    {
        // allowed promotions
        foreach (array('Queen', 'Bishop', 'Knight', 'Rook') as $promotion) {
            $board = new Board(array(
                'D7' => new Pawn(Piece::LIGHT)
            ));
            $piece = $board->piece('D7');
            $piece->move('D8', array('promote' => $promotion));
            $class = sprintf('\\Chess\\Piece\\%s', $promotion);
            $this->assertInstanceOf($class, $board->piece('D8'), sprintf('Pawn should promote to %s', $promotion));
            $this->assertEquals($piece->color(), $board->piece('D8')->color(), 'Piece should be same color after promotion');
        }

        // not allowed promotions
        foreach (array('King', 'Pawn') as $promotion) {
            $board = new Board(array(
                'D7' => new Pawn(Piece::LIGHT)
            ));
            $piece = $board->piece('D7');
            $moved = $piece->move('D8', array('promote' => $promotion));
            $this->assertFalse($moved, sprintf('Pawn should not be able to promote to %s', $promotion));
        }
    }

    public function testNoMoves()
    {
        // pawn should have no moves
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'D5' => new Pawn(Piece::DARK)
        ));
        $moves = $board->piece('D4')->moves();
        $this->assertCount(0, $moves, 'Pawn should have no possible moves');
        $moves = $board->piece('D5')->moves();
        $this->assertCount(0, $moves, 'Pawn should have no possible moves');
    }

    public function testOneMove()
    {
        // pawn should have one move: up one
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT)
        ));
        $moves = $board->piece('D4')->moves();
        $this->assertCount(1, $moves, 'Pawn should have one possible move');
        $this->assertContains('D5', $moves, 'Pawn should be able to move up one');

        // pawn should have one move: down one
        $board = new Board(array(
            'D5' => new Pawn(Piece::DARK)
        ));
        $moves = $board->piece('D5')->moves();
        $this->assertCount(1, $moves, 'Pawn should have one possible move');
        $this->assertContains('D4', $moves, 'Pawn should be able to move down one');

        // pawn should have one move: capture up left
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'D5' => new Pawn(Piece::DARK),
            'C5' => new Pawn(Piece::DARK)
        ));
        $moves = $board->piece('D4')->moves();
        $this->assertCount(1, $moves, 'Pawn should have one possible move');
        $this->assertContains('C5', $moves, 'Pawn should be able to capture up left');

        // pawn should have one move: capture up right
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'D5' => new Pawn(Piece::DARK),
            'E5' => new Pawn(Piece::DARK)
        ));
        $moves = $board->piece('D4')->moves();
        $this->assertCount(1, $moves, 'Pawn should have one possible move');
        $this->assertContains('E5', $moves, 'Pawn should be able to capture up right');

        // pawn should have one move: capture down left
        $board = new Board(array(
            'D5' => new Pawn(Piece::DARK),
            'D4' => new Pawn(Piece::LIGHT),
            'C4' => new Pawn(Piece::LIGHT)
        ));
        $moves = $board->piece('D5')->moves();
        $this->assertCount(1, $moves, 'Pawn should have one possible move');
        $this->assertContains('C4', $moves, 'Pawn should be able to capture down left');

        // pawn should have one move: capture down right
        $board = new Board(array(
            'D5' => new Pawn(Piece::DARK),
            'D4' => new Pawn(Piece::LIGHT),
            'E4' => new Pawn(Piece::LIGHT)
        ));
        $moves = $board->piece('D5')->moves();
        $this->assertCount(1, $moves, 'Pawn should have one possible move');
        $this->assertContains('E4', $moves, 'Pawn should be able to capture down right');
    }

    public function testTwoMoves()
    {
        // pawn should have two moves: up, up two
        $board = new Board(array(
            'D2' => new Pawn(Piece::LIGHT)
        ));
        $moves = $board->piece('D2')->moves();
        $this->assertCount(2, $moves);
        $this->assertContains('D3', $moves, 'Pawn should be able to move up one');
        $this->assertContains('D4', $moves, 'Pawn should be able to move up two');

        // pawn should have two moves: up, up left
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'C5' => new Pawn(Piece::DARK)
        ));
        $moves = $board->piece('D4')->moves();
        $this->assertCount(2, $moves, 'Pawn should have two possible moves');
        $this->assertContains('D5', $moves, 'Pawn should be able to move up');
        $this->assertContains('C5', $moves, 'Pawn should be able to capture up and left');

        // pawn should have two moves: up, up left (up two blocked)
        $board = new Board(array(
            'D2' => new Pawn(Piece::LIGHT),
            'D4' => new Pawn(Piece::DARK),
            'C3' => new Pawn(Piece::DARK)
        ));
        $moves = $board->piece('D2')->moves();
        $this->assertCount(2, $moves, 'Pawn should have two possible moves');
        $this->assertContains('D3', $moves, 'Pawn should be able to move up one');
        $this->assertContains('C3', $moves, 'Pawn should be able to capture up left');

        // pawn should have two moves: up, up right
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'E5' => new Pawn(Piece::DARK)
        ));
        $moves = $board->piece('D4')->moves();
        $this->assertCount(2, $moves, 'Pawn should have two possible moves');
        $this->assertContains('D5', $moves, 'Pawn should be able to move up');
        $this->assertContains('E5', $moves, 'Pawn should be able to capture up right');

        // pawn should have two moves: up, up right (up two blocked)
        $board = new Board(array(
            'D2' => new Pawn(Piece::LIGHT),
            'E3' => new Pawn(Piece::DARK),
            'D4' => new Pawn(Piece::DARK)
        ));
        $moves = $board->piece('D2')->moves();
        $this->assertCount(2, $moves, 'Pawn should have two possible moves');
        $this->assertContains('D3', $moves, 'Pawn should be able to move up');
        $this->assertContains('E3', $moves, 'Pawn should be able to capture up right');

        // pawn should have two moves: up left, up right
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'D5' => new Pawn(Piece::DARK),
            'C5' => new Pawn(Piece::DARK),
            'E5' => new Pawn(Piece::DARK)
        ));
        $moves = $board->piece('D4')->moves();
        $this->assertCount(2, $moves, 'Pawn should have two possible moves');
        $this->assertContains('C5', $moves, 'Pawn should be able to capture up left');
        $this->assertContains('E5', $moves, 'Pawn should be able to capture up right');

        // pawn should have two moves: down, down two
        $board = new Board(array(
            'D7' => new Pawn(Piece::DARK)
        ));
        $moves = $board->piece('D7')->moves();
        $this->assertCount(2, $moves, 'Pawn should have two possible moves');
        $this->assertContains('D6', $moves, 'Pawn should be able to move down one');
        $this->assertContains('D5', $moves, 'Pawn should be able to move down two');

        // pawn should have two moves: down, down left
        $board = new Board(array(
            'D5' => new Pawn(Piece::DARK),
            'C4' => new Pawn(Piece::LIGHT)
        ));
        $moves = $board->piece('D5')->moves();
        $this->assertCount(2, $moves, 'Pawn should have two possible moves');
        $this->assertContains('D4', $moves, 'Pawn should be able to move down');
        $this->assertContains('C4', $moves, 'Pawn should be able to capture down left');

        // pawn should have two moves: down, down left (down two blocked)
        $board = new Board(array(
            'D7' => new Pawn(Piece::DARK),
            'C6' => new Pawn(Piece::LIGHT),
            'D5' => new Pawn(Piece::LIGHT)
        ));
        $moves = $board->piece('D7')->moves();
        $this->assertCount(2, $moves, 'Pawn should have two possible moves');
        $this->assertContains('D6', $moves, 'Pawn should be able to move down');
        $this->assertContains('C6', $moves, 'Pawn should be able to capture down left');

        // pawn should have two moves: down, down right
        $board = new Board(array(
            'D5' => new Pawn(Piece::DARK),
            'E4' => new Pawn(Piece::LIGHT)
        ));
        $moves = $board->piece('D5')->moves();
        $this->assertCount(2, $moves, 'Pawn should have two possible moves');
        $this->assertContains('D4', $moves, 'Pawn should be able to move down');
        $this->assertContains('E4', $moves, 'Pawn should be able to capture down right');

        // pawn should have two moves: down, down right (down two blocked)
        $board = new Board(array(
            'D7' => new Pawn(Piece::DARK),
            'E6' => new Pawn(Piece::LIGHT),
            'D5' => new Pawn(Piece::LIGHT)
        ));
        $moves = $board->piece('D7')->moves();
        $this->assertCount(2, $moves, 'Pawn should have two possible moves');
        $this->assertContains('D6', $moves, 'Pawn should be able to move down');
        $this->assertContains('E6', $moves, 'Pawn should be able to capture down right');

        // pawn should have two moves: down left, down right
        $board = new Board(array(
            'D5' => new Pawn(Piece::DARK),
            'D4' => new Pawn(Piece::LIGHT),
            'C4' => new Pawn(Piece::LIGHT),
            'E4' => new Pawn(Piece::LIGHT)
        ));
        $moves = $board->piece('D5')->moves();
        $this->assertCount(2, $moves, 'Pawn should have two possible moves');
        $this->assertContains('C4', $moves, 'Pawn should be able to capture down left');
        $this->assertContains('E4', $moves, 'Pawn should be able to capture down right');
    }

    public function testThreeMoves()
    {
        // pawn should have three moves: up, up two, up left
        $board = new Board(array(
            'D2' => new Pawn(Piece::LIGHT),
            'C3' => new Pawn(Piece::DARK)
        ));
        $moves = $board->piece('D2')->moves();
        $this->assertCount(3, $moves, 'Pawn should have three possible moves');
        $this->assertContains('D3', $moves, 'Pawn should be able to move up one');
        $this->assertContains('D4', $moves, 'Pawn should be able to move up two');
        $this->assertContains('C3', $moves, 'Pawn should be able to capture up left');

        // pawn should have three moves: up, up two, up right
        $board = new Board(array(
            'D2' => new Pawn(Piece::LIGHT),
            'E3' => new Pawn(Piece::DARK)
        ));
        $moves = $board->piece('D2')->moves();
        $this->assertCount(3, $moves, 'Pawn should have three possible moves');
        $this->assertContains('D3', $moves, 'Pawn should be able to move up one');
        $this->assertContains('D4', $moves, 'Pawn should be able to move up two');
        $this->assertContains('E3', $moves, 'Pawn should be able to capture up right');

        // pawn should have three moves: up, up left, up right
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'C5' => new Pawn(Piece::DARK),
            'E5' => new Pawn(Piece::DARK)
        ));
        $moves = $board->piece('D4')->moves();
        $this->assertCount(3, $moves, 'Pawn should have three possible moves');
        $this->assertContains('D5', $moves, 'Pawn should be able to move up one');
        $this->assertContains('C5', $moves, 'Pawn should be able to capture up left');
        $this->assertContains('E5', $moves, 'Pawn should be able to capture up right');

        // pawn should have three moves: up, up left, up right (up two blocked)
        $board = new Board(array(
            'D2' => new Pawn(Piece::LIGHT),
            'D4' => new Pawn(Piece::DARK),
            'C3' => new Pawn(Piece::DARK),
            'E3' => new Pawn(Piece::DARK)
        ));
        $moves = $board->piece('D2')->moves();
        $this->assertCount(3, $moves, 'Pawn should have three possible moves');
        $this->assertContains('D3', $moves, 'Pawn should be able to move up one');
        $this->assertContains('C3', $moves, 'Pawn should be able to capture up left');
        $this->assertContains('E3', $moves, 'Pawn should be able to capture up right');

        // pawn should have three moves: down, down two, down left
        $board = new Board(array(
            'D7' => new Pawn(Piece::DARK),
            'C6' => new Pawn(Piece::LIGHT)
        ));
        $moves = $board->piece('D7')->moves();
        $this->assertCount(3, $moves, 'Pawn should have three possible moves');
        $this->assertContains('D6', $moves, 'Pawn should be able to move down one');
        $this->assertContains('D5', $moves, 'Pawn should be able to move down two');
        $this->assertContains('C6', $moves, 'Pawn should be able to capture down left');

        // pawn should have three moves: down, down two, down right
        $board = new Board(array(
            'D7' => new Pawn(Piece::DARK),
            'E6' => new Pawn(Piece::LIGHT)
        ));
        $moves = $board->piece('D7')->moves();
        $this->assertCount(3, $moves, 'Pawn should have three possible moves');
        $this->assertContains('D6', $moves, 'Pawn should be able to move down one');
        $this->assertContains('D5', $moves, 'Pawn should be able to move down two');
        $this->assertContains('E6', $moves, 'Pawn should be able to capture down right');

        // pawn should have three moves: down, down left, down right
        $board = new Board(array(
            'D5' => new Pawn(Piece::DARK),
            'C4' => new Pawn(Piece::LIGHT),
            'E4' => new Pawn(Piece::LIGHT)
        ));
        $moves = $board->piece('D5')->moves();
        $this->assertCount(3, $moves, 'Pawn should have three possible moves');
        $this->assertContains('D4', $moves, 'Pawn should be able to move down one');
        $this->assertContains('C4', $moves, 'Pawn should be able to capture down left');
        $this->assertContains('E4', $moves, 'Pawn should be able to capture down right');

        // pawn should have three moves: down, down left, down right (down two blocked)
        $board = new Board(array(
            'D7' => new Pawn(Piece::DARK),
            'D5' => new Pawn(Piece::LIGHT),
            'C6' => new Pawn(Piece::LIGHT),
            'E6' => new Pawn(Piece::LIGHT)
        ));
        $moves = $board->piece('D7')->moves();
        $this->assertCount(3, $moves, 'Pawn should have three possible moves');
        $this->assertContains('D6', $moves, 'Pawn should be able to move down one');
        $this->assertContains('C6', $moves, 'Pawn should be able to capture down left');
        $this->assertContains('E6', $moves, 'Pawn should be able to capture down right');
    }

    public function testFourMoves()
    {
        // pawn should have four moves: up, up two, up left, up right
        $board = new Board(array(
            'D2' => new Pawn(Piece::LIGHT),
            'C3' => new Pawn(Piece::DARK),
            'E3' => new Pawn(Piece::DARK)
        ));
        $moves = $board->piece('D2')->moves();
        $this->assertCount(4, $moves, 'Pawn should have four possible moves');
        $this->assertContains('D3', $moves, 'Pawn should be able to move up one');
        $this->assertContains('D4', $moves, 'Pawn should be able to move up two');
        $this->assertContains('C3', $moves, 'Pawn should be able to capture up left');
        $this->assertContains('E3', $moves, 'Pawn should be able to capture up right');

        // pawn should have four moves: down, down two, down left, down right
        $board = new Board(array(
            'D7' => new Pawn(Piece::DARK),
            'C6' => new Pawn(Piece::LIGHT),
            'E6' => new Pawn(Piece::LIGHT)
        ));
        $moves = $board->piece('D7')->moves();
        $this->assertCount(4, $moves, 'Pawn should have four possible moves');
        $this->assertContains('D6', $moves, 'Pawn should be able to move down one');
        $this->assertContains('D5', $moves, 'Pawn should be able to move down two');
        $this->assertContains('C6', $moves, 'Pawn should be able to capture down left');
        $this->assertContains('E6', $moves, 'Pawn should be able to capture down right');
    }

    public function testEdgeOfBoard()
    {
        $board = new Board(array(
            'A4' => new Pawn(Piece::LIGHT)
        ));
        $moves = $board->piece('A4')->moves();
        $this->assertCount(1, $moves, 'Pawn should have one possible move');
        $this->assertContains('A5', $moves, 'Pawn should be able to move up');

        $board = new Board(array(
            'H4' => new Pawn(Piece::LIGHT)
        ));
        $moves = $board->piece('H4')->moves();
        $this->assertCount(1, $moves, 'Pawn should have one possible move');
        $this->assertContains('H5', $moves, 'Pawn should be able to move up');

        $board = new Board(array(
            'A5' => new Pawn(Piece::DARK)
        ));
        $moves = $board->piece('A5')->moves();
        $this->assertCount(1, $moves, 'Pawn should have one possible move');
        $this->assertContains('A4', $moves, 'Pawn should be able to move down');

        $board = new Board(array(
            'H5' => new Pawn(Piece::DARK)
        ));
        $moves = $board->piece('H5')->moves();
        $this->assertCount(1, $moves, 'Pawn should have one possible move');
        $this->assertContains('H4', $moves, 'Pawn should be able to move down');
    }
}
