<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\Pawn;

class PawnTest extends \Chess\PieceTestCase
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
            $failed = $board->piece('D8') === null && $board->piece('D7') === $piece;
            $this->assertTrue($failed, 'Pawn should still be in the same place when promotion fails');
        }
    }

    public function testNoMoves()
    {
        // pawn should have no moves
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'D5' => new Pawn(Piece::DARK)
        ));
        $this->assertMoves(
            $board->piece('D4'), 0, array(),
            'Pawn should have no possible moves'
        );
        $this->assertMoves(
            $board->piece('D5'), 0, array(),
            'Pawn should have no possible moves'
        );
    }

    public function testOneMove()
    {
        // pawn should have one move: up one
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D4'), 1, array('D5'),
            'Pawn should have one possible move (up)'
        );

        // pawn should have one move: down one
        $board = new Board(array(
            'D5' => new Pawn(Piece::DARK)
        ));
        $this->assertMoves(
            $board->piece('D5'), 1, array('D4'),
            'Pawn should have one possible move (down)'
        );

        // pawn should have one move: capture up left
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'D5' => new Pawn(Piece::DARK),
            'C5' => new Pawn(Piece::DARK)
        ));
        $this->assertMoves(
            $board->piece('D4'), 1, array('C5'),
            'Pawn should have one possible move (up left)'
        );

        // pawn should have one move: capture up right
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'D5' => new Pawn(Piece::DARK),
            'E5' => new Pawn(Piece::DARK)
        ));
        $this->assertMoves(
            $board->piece('D4'), 1, array('E5'),
            'Pawn should have one possible move (up right)'
        );

        // pawn should have one move: capture down left
        $board = new Board(array(
            'D5' => new Pawn(Piece::DARK),
            'D4' => new Pawn(Piece::LIGHT),
            'C4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D5'), 1, array('C4'),
            'Pawn should have one possible move (down left)'
        );

        // pawn should have one move: capture down right
        $board = new Board(array(
            'D5' => new Pawn(Piece::DARK),
            'D4' => new Pawn(Piece::LIGHT),
            'E4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D5'), 1, array('E4'),
            'Pawn should have one possible move (down right)'
        );
    }

    public function testTwoMoves()
    {
        // pawn should have two moves: up, up two
        $board = new Board(array(
            'D2' => new Pawn(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D2'), 2, array('D3', 'D4'),
            'Pawn should have two possible moves (up, up two)'
        );

        // pawn should have two moves: up, up left
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'C5' => new Pawn(Piece::DARK)
        ));
        $this->assertMoves(
            $board->piece('D4'), 2, array('D5', 'C5'),
            'Pawn should have two possible moves (up, up left)'
        );

        // pawn should have two moves: up, up left (up two blocked)
        $board = new Board(array(
            'D2' => new Pawn(Piece::LIGHT),
            'D4' => new Pawn(Piece::DARK),
            'C3' => new Pawn(Piece::DARK)
        ));
        $this->assertMoves(
            $board->piece('D2'), 2, array('D3', 'C3'),
            'Pawn should have two possible moves (up, up left; up two blocked)'
        );

        // pawn should have two moves: up, up right
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'E5' => new Pawn(Piece::DARK)
        ));
        $this->assertMoves(
            $board->piece('D4'), 2, array('D5', 'E5'),
            'Pawn should have two possible moves (up, up right)'
        );

        // pawn should have two moves: up, up right (up two blocked)
        $board = new Board(array(
            'D2' => new Pawn(Piece::LIGHT),
            'E3' => new Pawn(Piece::DARK),
            'D4' => new Pawn(Piece::DARK)
        ));
        $this->assertMoves(
            $board->piece('D2'), 2, array('D3', 'E3'),
            'Pawn should have two possible moves (up, up right; up two blocked)'
        );

        // pawn should have two moves: up left, up right
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'D5' => new Pawn(Piece::DARK),
            'C5' => new Pawn(Piece::DARK),
            'E5' => new Pawn(Piece::DARK)
        ));
        $this->assertMoves(
            $board->piece('D4'), 2, array('C5', 'E5'),
            'Pawn should have two possible moves (up left, up right)'
        );

        // pawn should have two moves: down, down two
        $board = new Board(array(
            'D7' => new Pawn(Piece::DARK)
        ));
        $this->assertMoves(
            $board->piece('D7'), 2, array('D6', 'D5'),
            'Pawn should have two possible moves (down, down two)'
        );

        // pawn should have two moves: down, down left
        $board = new Board(array(
            'D5' => new Pawn(Piece::DARK),
            'C4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D5'), 2, array('D4', 'C4'),
            'Pawn should have two possible moves (down, down left)'
        );

        // pawn should have two moves: down, down left (down two blocked)
        $board = new Board(array(
            'D7' => new Pawn(Piece::DARK),
            'C6' => new Pawn(Piece::LIGHT),
            'D5' => new Pawn(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D7'), 2, array('D6', 'C6'),
            'Pawn should have two possible moves (down, down left; down two blocked)'
        );

        // pawn should have two moves: down, down right
        $board = new Board(array(
            'D5' => new Pawn(Piece::DARK),
            'E4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D5'), 2, array('D4', 'E4'),
            'Pawn should have two possible moves (down, down right)'
        );

        // pawn should have two moves: down, down right (down two blocked)
        $board = new Board(array(
            'D7' => new Pawn(Piece::DARK),
            'E6' => new Pawn(Piece::LIGHT),
            'D5' => new Pawn(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D7'), 2, array('D6', 'E6'),
            'Pawn should have two possible moves (down, down right; down two blocked)'
        );

        // pawn should have two moves: down left, down right
        $board = new Board(array(
            'D5' => new Pawn(Piece::DARK),
            'D4' => new Pawn(Piece::LIGHT),
            'C4' => new Pawn(Piece::LIGHT),
            'E4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D5'), 2, array('C4', 'E4'),
            'Pawn should have two possible moves (down left, down right)'
        );
    }

    public function testThreeMoves()
    {
        // pawn should have three moves: up, up two, up left
        $board = new Board(array(
            'D2' => new Pawn(Piece::LIGHT),
            'C3' => new Pawn(Piece::DARK)
        ));
        $this->assertMoves(
            $board->piece('D2'), 3, array('D3', 'D4', 'C3'),
            'Pawn should have three possible moves (up, up two, up left)'
        );

        // pawn should have three moves: up, up two, up right
        $board = new Board(array(
            'D2' => new Pawn(Piece::LIGHT),
            'E3' => new Pawn(Piece::DARK)
        ));
        $this->assertMoves(
            $board->piece('D2'), 3, array('D3', 'D4', 'E3'),
            'Pawn should have three possible moves (up, up two, up right)'
        );

        // pawn should have three moves: up, up left, up right
        $board = new Board(array(
            'D4' => new Pawn(Piece::LIGHT),
            'C5' => new Pawn(Piece::DARK),
            'E5' => new Pawn(Piece::DARK)
        ));
        $this->assertMoves(
            $board->piece('D4'), 3, array('D5', 'C5', 'E5'),
            'Pawn should have three possible moves (up, up left, up right)'
        );

        // pawn should have three moves: up, up left, up right (up two blocked)
        $board = new Board(array(
            'D2' => new Pawn(Piece::LIGHT),
            'D4' => new Pawn(Piece::DARK),
            'C3' => new Pawn(Piece::DARK),
            'E3' => new Pawn(Piece::DARK)
        ));
        $this->assertMoves(
            $board->piece('D2'), 3, array('D3', 'C3', 'E3'),
            'Pawn should have three possible moves (up, up left, up right; up two blocked)'
        );

        // pawn should have three moves: down, down two, down left
        $board = new Board(array(
            'D7' => new Pawn(Piece::DARK),
            'C6' => new Pawn(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D7'), 3, array('D6', 'D5', 'C6'),
            'Pawn should have three possible moves (down, down two, down left)'
        );

        // pawn should have three moves: down, down two, down right
        $board = new Board(array(
            'D7' => new Pawn(Piece::DARK),
            'E6' => new Pawn(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D7'), 3, array('D6', 'D5', 'E6'),
            'Pawn should have three possible moves (down, down two, down right)'
        );

        // pawn should have three moves: down, down left, down right
        $board = new Board(array(
            'D5' => new Pawn(Piece::DARK),
            'C4' => new Pawn(Piece::LIGHT),
            'E4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D5'), 3, array('D4', 'C4', 'E4'),
            'Pawn should have three possible moves (down, down left, down right)'
        );

        // pawn should have three moves: down, down left, down right (down two blocked)
        $board = new Board(array(
            'D7' => new Pawn(Piece::DARK),
            'D5' => new Pawn(Piece::LIGHT),
            'C6' => new Pawn(Piece::LIGHT),
            'E6' => new Pawn(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D7'), 3, array('D6', 'C6', 'E6'),
            'Pawn should have three possible moves (down, down left, down right; down two blocked)'
        );
    }

    public function testFourMoves()
    {
        // pawn should have four moves: up, up two, up left, up right
        $board = new Board(array(
            'D2' => new Pawn(Piece::LIGHT),
            'C3' => new Pawn(Piece::DARK),
            'E3' => new Pawn(Piece::DARK)
        ));
        $this->assertMoves(
            $board->piece('D2'), 4, array('D3', 'D4', 'C3', 'E3'),
            'Pawn should have four possible moves (up, up two, up left, up right)'
        );

        // pawn should have four moves: down, down two, down left, down right
        $board = new Board(array(
            'D7' => new Pawn(Piece::DARK),
            'C6' => new Pawn(Piece::LIGHT),
            'E6' => new Pawn(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D7'), 4, array('D6', 'D5', 'C6', 'E6'),
            'Pawn should have four possible moves (down, down two, down left, down right)'
        );
    }

    public function testEdgeOfBoard()
    {
        $board = new Board(array(
            'A4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('A4'), 1, array('A5'),
            'Pawn should have one possible move'
        );

        $board = new Board(array(
            'H4' => new Pawn(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('H4'), 1, array('H5'),
            'Pawn should have one possible move'
        );

        $board = new Board(array(
            'A5' => new Pawn(Piece::DARK)
        ));
        $this->assertMoves(
            $board->piece('A5'), 1, array('A4'),
            'Pawn should have one possible move'
        );

        $board = new Board(array(
            'H5' => new Pawn(Piece::DARK)
        ));
        $this->assertMoves(
            $board->piece('H5'), 1, array('H4'),
            'Pawn should have one possible move'
        );
    }

    public function testEnPassant()
    {
        $board = new Board(array(
            'D4' => new Pawn(Piece::DARK),
            'C2' => new Pawn(Piece::LIGHT)
        ));
        $board->piece('C2')->move('C4');
        $this->assertMoves(
            $board->piece('D4'), 2, array('D3', 'C3'),
            'Pawn should be able to capture en passant'
        );
    }
}
