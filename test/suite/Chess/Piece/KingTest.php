<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\Pawn;
use \Chess\Piece\King;
use \Chess\Piece\Rook;
use \Chess\Piece\Knight;
use \Chess\Piece\Bishop;
use \Chess\Player;

class KingTest extends \Chess\PieceTestCase
{
    public function testMoves()
    {
        $board = $this->makeBoard(array(
            array('D4', 'King', 1)
        ));
        $this->assertMoves(
            $board->piece('D4'), 8,
            array('C5', 'D5', 'E5', 'C4', 'E4', 'C3', 'D3', 'E3'),
            'King should be able to move to any adjacent position'
        );

        // edge of board
        $board = $this->makeBoard(array(
            array('A4', 'King', 1)
        ));
        $this->assertMoves(
            $board->piece('A4'), 5,
            array('A5', 'B5', 'B4', 'A3', 'B3'),
            'King cannot move off board'
        );

        // blocked
        $board = $this->makeBoard(array(
            array('D4', 'King', 1),
            array('D5', 'Pawn', 1)
        ));
        $this->assertMoves(
            $board->piece('D4'), 7,
            array('C5', 'E5', 'C4', 'E4', 'C3', 'D3', 'E3'),
            'King should be blocked'
        );

        // cannot move into check
        $player1 = new Player();
        $player2 = new Player();
        $board = $this->makeBoard(array(
            array('D4', 'King', 1),
            array('F5', 'Pawn', 2)
        ));
        $this->assertMoves(
            $board->piece('D4'), 7,
            array('C5', 'D5', 'E5', 'C4', 'C3', 'D3', 'E3'),
            'King cannot move into check'
        );
    }

    public function testCastling()
    {
        $player1 = new Player();
        $board = $this->makeBoard(array(
            array('E1', 'King', 1),
            array('A1', 'Rook', 1),
            array('H1', 'Rook', 1)
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
        $player1 = new Player();
        $board = $this->makeBoard(array(
            array('E1', 'King', 1)
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
        $player1 = new Player();
        $board = $this->makeBoard(array(
            array('E1', 'King', 1),
            array('A1', 'Rook', 1),
            array('H1', 'Rook', 1),

            // blocking pieces
            array('B1', 'Knight', 1),
            array('F1', 'Bishop', 1)
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
        $player1 = new Player();
        $player2 = new Player();
        $board = $this->makeBoard(array(
            array('E1', 'King', 1),
            array('A1', 'Rook', 1),
            array('H1', 'Rook', 1),

            // threatening piece
            array('E4', 'Rook', 2)
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
        $player1 = new Player();
        $board = $this->makeBoard(array(
            array('E1', 'King', 1),
            array('A1', 'Rook', 1)
        ));
        // move rook
        $board->piece('A1')->move('A2');
        $board->piece('A2')->move('A1');
        $this->assertMoves(
            $board->piece('E1'), 5,
            array(
                // only the normal moves
                'D2', 'E2', 'F2', 'D1', 'F1'
            ),
            'King should not be able to castle if Rook has moved'
        );

        // king already moved
        $player1 = new Player();
        $board = $this->makeBoard(array(
            array('E1', 'King', 1),
            array('A1', 'Rook', 1)
        ));
        // move king
        $board->piece('E1')->move('E2');
        $board->piece('E2')->move('E1');
        $this->assertMoves(
            $board->piece('E1'), 5,
            array(
                // only the normal moves
                'D2', 'E2', 'F2', 'D1', 'F1'
            ),
            'King should not be able to castle if it has moved'
        );

        // cannot castle into check
        $player1 = new Player();
        $player2 = new Player();
        $board = $this->makeBoard(array(
            array('E1', 'King', 1),
            array('A1', 'Rook', 1),
            array('C4', 'Rook', 2)
        ));
        $this->assertMoves(
            $board->piece('E1'), 5,
            array('D2', 'E2', 'F2', 'D1', 'F1'),
            'King should not be able to castle into check'
        );
    }
}
