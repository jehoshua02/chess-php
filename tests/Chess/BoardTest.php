<?php

namespace Chess;
use \Chess\Board;

class BoardTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests that all the right pieces are in the right place on a fresh board
     */
    public function testBuildAndGetPieces()
    {
        $board = new Board();

        $this->assertTrue($board->pieceAt('A1') === Board::LIGHT_ROOK, 'A1 should be LIGHT_ROOK');
        $this->assertTrue($board->pieceAt('B1') === Board::LIGHT_KNIGHT, 'B1 should be LIGHT_KNIGHT');
        $this->assertTrue($board->pieceAt('C1') === Board::LIGHT_BISHOP, 'C1 should be LIGHT_BISHOP');
        $this->assertTrue($board->pieceAt('D1') === Board::LIGHT_QUEEN, 'D1 should be LIGHT_QUEEN');
        $this->assertTrue($board->pieceAt('E1') === Board::LIGHT_KING, 'E1 should be LIGHT_KING');
        $this->assertTrue($board->pieceAt('F1') === Board::LIGHT_BISHOP, 'F1 should be LIGHT_BISHOP');
        $this->assertTrue($board->pieceAt('G1') === Board::LIGHT_KNIGHT, 'G1 should be LIGHT_KNIGHT');
        $this->assertTrue($board->pieceAt('H1') === Board::LIGHT_ROOK, 'H1 should be LIGHT_ROOK');

        $this->assertTrue($board->pieceAt('A2') === Board::LIGHT_PAWN, 'A2 should be LIGHT_PAWN');
        $this->assertTrue($board->pieceAt('B2') === Board::LIGHT_PAWN, 'B2 should be LIGHT_PAWN');
        $this->assertTrue($board->pieceAt('C2') === Board::LIGHT_PAWN, 'C2 should be LIGHT_PAWN');
        $this->assertTrue($board->pieceAt('D2') === Board::LIGHT_PAWN, 'D2 should be LIGHT_PAWN');
        $this->assertTrue($board->pieceAt('E2') === Board::LIGHT_PAWN, 'E2 should be LIGHT_PAWN');
        $this->assertTrue($board->pieceAt('F2') === Board::LIGHT_PAWN, 'F2 should be LIGHT_PAWN');
        $this->assertTrue($board->pieceAt('G2') === Board::LIGHT_PAWN, 'G2 should be LIGHT_PAWN');
        $this->assertTrue($board->pieceAt('H2') === Board::LIGHT_PAWN, 'H2 should be LIGHT_PAWN');

        $this->assertTrue($board->pieceAt('A7') === Board::DARK_PAWN, 'A7 should be DARK_PAWN');
        $this->assertTrue($board->pieceAt('B7') === Board::DARK_PAWN, 'B7 should be DARK_PAWN');
        $this->assertTrue($board->pieceAt('C7') === Board::DARK_PAWN, 'C7 should be DARK_PAWN');
        $this->assertTrue($board->pieceAt('D7') === Board::DARK_PAWN, 'D7 should be DARK_PAWN');
        $this->assertTrue($board->pieceAt('E7') === Board::DARK_PAWN, 'E7 should be DARK_PAWN');
        $this->assertTrue($board->pieceAt('F7') === Board::DARK_PAWN, 'F7 should be DARK_PAWN');
        $this->assertTrue($board->pieceAt('G7') === Board::DARK_PAWN, 'G7 should be DARK_PAWN');
        $this->assertTrue($board->pieceAt('H7') === Board::DARK_PAWN, 'H7 should be DARK_PAWN');

        $this->assertTrue($board->pieceAt('A8') === Board::DARK_ROOK, 'A8 should be DARK_ROOK');
        $this->assertTrue($board->pieceAt('B8') === Board::DARK_KNIGHT, 'B8 should be DARK_KNIGHT');
        $this->assertTrue($board->pieceAt('C8') === Board::DARK_BISHOP, 'C8 should be DARK_BISHOP');
        $this->assertTrue($board->pieceAt('D8') === Board::DARK_KING, 'D8 should be DARK_KING');
        $this->assertTrue($board->pieceAt('E8') === Board::DARK_QUEEN, 'E8 should be DARK_QUEEN');
        $this->assertTrue($board->pieceAt('F8') === Board::DARK_BISHOP, 'F8 should be DARK_BISHOP');
        $this->assertTrue($board->pieceAt('G8') === Board::DARK_KNIGHT, 'G8 should be DARK_KNIGHT');
        $this->assertTrue($board->pieceAt('H8') === Board::DARK_ROOK, 'H8 should be DARK_ROOK');

    }

    /**
     * Tests that all the right spaces are empty on a fresh board
     */
    public function testEmptySpaces()
    {
        $board = new Board();

        $letters = str_split('ABCDEFGH');
        $numbers = str_split('3456');

        foreach ($letters as $letter) {
            foreach ($numbers as $number) {
                $position = $letter . $number;
                $this->assertFalse($board->pieceAt($position), "{$position} should be empty");
            }
        }
    }

    /**
     * Tests that custom board setups can be used (this will be super handy for setting up other tests)
     */
    public function testCustomBoard()
    {
        $board = new Board(array(
            'A1' => Board::LIGHT_PAWN
        ));

        $this->assertTrue($board->pieceAt('A1') === Board::LIGHT_PAWN);
        $this->assertFalse($board->pieceAt('B1'));
    }

    /**
     * Tests all the rules for moving a pawn
     */
    public function testPawn()
    {
        // basic movement (just a pawn on a board)
        $board = new Board(array(
            'D4' => Board::LIGHT_PAWN,
        ));
        $moves = $board->movesFor('D4');
        $this->assertCount(1, $moves, 'Pawn only has one possible move');
        $this->assertContains('D5', $moves, 'Pawn can move forward');

        // @todo edge of board / promotion
        // @todo blocked
        // @todo start position
        // @todo capturing
        // @todo en passant
    }
}
