<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\Pawn;
use \Chess\Piece\King;
use \Chess\Piece\Rook;
use \Chess\Piece\Knight;
use \Chess\Piece\Bishop;

class KingTest extends \Chess\PieceTestCase
{
    public function testMoves()
    {
        $board = new Board(array(
            'D4' => new King(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D4'), 8,
            array('C5', 'D5', 'E5', 'C4', 'E4', 'C3', 'D3', 'E3'),
            'King should be able to move to any adjacent position'
        );

        // edge of board
        $board = new Board(array(
            'A4' => new King(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('A4'), 5,
            array('A5', 'B5', 'B4', 'A3', 'B3'),
            'King cannot move off board'
        );

        // blocked
        $board = new Board(array(
            'D4' => new King(Piece::LIGHT),
            'D5' => new Pawn(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('D4'), 7,
            array('C5', 'E5', 'C4', 'E4', 'C3', 'D3', 'E3'),
            'King should be blocked'
        );

        // cannot move into check
        $board = new Board(array(
            'D4' => new King(Piece::LIGHT),
            'F5' => new Pawn(Piece::DARK)
        ));
        $this->assertMoves(
            $board->piece('D4'), 7,
            array('C5', 'D5', 'E5', 'C4', 'C3', 'D3', 'E3'),
            'King cannot move into check'
        );
    }

    public function testCastling()
    {
        $board = new Board(array(
            'E1' => new King(Piece::LIGHT),
            'A1' => new Rook(Piece::LIGHT),
            'H1' => new Rook(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('E1'), 7,
            array(
                // all the normal moves
                'D2', 'E2', 'F2', 'D1', 'F1',
                // left castle and right castle
                'C1', 'G1'
            ),
            'King should be able to castle'
        );

        // no rooks
        $board = new Board(array(
            'E1' => new King(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('E1'), 5,
            array(
                // only the normal moves
                'D2', 'E2', 'F2', 'D1', 'F1'
            ),
            'King should not be able to castle with no rooks'
        );

        // blocked
        $board = new Board(array(
            'E1' => new King(Piece::LIGHT),
            'A1' => new Rook(Piece::LIGHT),
            'H1' => new Rook(Piece::LIGHT),

            // blocking pieces
            'B1' => new Knight(Piece::LIGHT),
            'F1' => new Bishop(Piece::LIGHT)
        ));
        $this->assertMoves(
            $board->piece('E1'), 4,
            array(
                // only the normal moves
                'D2', 'E2', 'F2', 'D1'
            ),
            'King should not be able to castle with pieces in the way'
        );

        // check
        $board = new Board(array(
            'E1' => new King(Piece::LIGHT),
            'A1' => new Rook(Piece::LIGHT),
            'H1' => new Rook(Piece::LIGHT),

            // threatening piece
            'E4' => new Rook(Piece::DARK)
        ));
        $this->assertMoves(
            $board->piece('E1'), 4,
            array(
                // only the normal moves
                'D2', 'F2', 'D1', 'F1'
            ),
            'King should not be able to castle while in check'
        );

        // rook already moved
        $board = new Board(array(
            'E1' => new King(Piece::LIGHT),
            'A1' => new Rook(Piece::LIGHT)
        ));
        // move rook
        $board->piece('A1')->move('A2');
        $board->piece('A1')->move('A1');
        $this->assertMoves(
            $board->piece('E1'), 5,
            array(
                // only the normal moves
                'D2', 'E2', 'F2', 'D1', 'F1'
            ),
            'King should not be able to castle if Rook has moved'
        );

        // king already moved
        $board = new Board(array(
            'E1' => new King(Piece::LIGHT),
            'A1' => new Rook(Piece::LIGHT)
        ));
        // move king
        $board->piece('E1')->move('E2');
        $board->piece('E1')->move('E1');
        $this->assertMoves(
            $board->piece('E1'), 5,
            array(
                // only the normal moves
                'D2', 'E2', 'F2', 'D1', 'F1'
            ),
            'King should not be able to castle if it has moved'
        );
    }
}
