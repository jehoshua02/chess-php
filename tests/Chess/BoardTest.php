<?php

namespace Chess;
use \Chess\Board;

class BoardTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildAndGetPieces()
    {
        $board = new Board();

        $this->assertTrue($board->pieceAt('A1') === Board::WHITE_ROOK, 'A1 should be WHITE_ROOK');
        $this->assertTrue($board->pieceAt('B1') === Board::WHITE_KNIGHT, 'B1 should be WHITE_KNIGHT');
        $this->assertTrue($board->pieceAt('C1') === Board::WHITE_BISHOP, 'C1 should be WHITE_BISHOP');
        $this->assertTrue($board->pieceAt('D1') === Board::WHITE_QUEEN, 'D1 should be WHITE_QUEEN');
        $this->assertTrue($board->pieceAt('E1') === Board::WHITE_KING, 'E1 should be WHITE_KING');
        $this->assertTrue($board->pieceAt('F1') === Board::WHITE_BISHOP, 'F1 should be WHITE_BISHOP');
        $this->assertTrue($board->pieceAt('G1') === Board::WHITE_KNIGHT, 'G1 should be WHITE_KNIGHT');
        $this->assertTrue($board->pieceAt('H1') === Board::WHITE_ROOK, 'H1 should be WHITE_ROOK');

        $this->assertTrue($board->pieceAt('A2') === Board::WHITE_PAWN, 'A2 should be WHITE_PAWN');
        $this->assertTrue($board->pieceAt('B2') === Board::WHITE_PAWN, 'B2 should be WHITE_PAWN');
        $this->assertTrue($board->pieceAt('C2') === Board::WHITE_PAWN, 'C2 should be WHITE_PAWN');
        $this->assertTrue($board->pieceAt('D2') === Board::WHITE_PAWN, 'D2 should be WHITE_PAWN');
        $this->assertTrue($board->pieceAt('E2') === Board::WHITE_PAWN, 'E2 should be WHITE_PAWN');
        $this->assertTrue($board->pieceAt('F2') === Board::WHITE_PAWN, 'F2 should be WHITE_PAWN');
        $this->assertTrue($board->pieceAt('G2') === Board::WHITE_PAWN, 'G2 should be WHITE_PAWN');
        $this->assertTrue($board->pieceAt('H2') === Board::WHITE_PAWN, 'H2 should be WHITE_PAWN');

        $this->assertTrue($board->pieceAt('A7') === Board::BLACK_PAWN, 'A7 should be BLACK_PAWN');
        $this->assertTrue($board->pieceAt('B7') === Board::BLACK_PAWN, 'B7 should be BLACK_PAWN');
        $this->assertTrue($board->pieceAt('C7') === Board::BLACK_PAWN, 'C7 should be BLACK_PAWN');
        $this->assertTrue($board->pieceAt('D7') === Board::BLACK_PAWN, 'D7 should be BLACK_PAWN');
        $this->assertTrue($board->pieceAt('E7') === Board::BLACK_PAWN, 'E7 should be BLACK_PAWN');
        $this->assertTrue($board->pieceAt('F7') === Board::BLACK_PAWN, 'F7 should be BLACK_PAWN');
        $this->assertTrue($board->pieceAt('G7') === Board::BLACK_PAWN, 'G7 should be BLACK_PAWN');
        $this->assertTrue($board->pieceAt('H7') === Board::BLACK_PAWN, 'H7 should be BLACK_PAWN');

        $this->assertTrue($board->pieceAt('A8') === Board::BLACK_ROOK, 'A8 should be BLACK_ROOK');
        $this->assertTrue($board->pieceAt('B8') === Board::BLACK_KNIGHT, 'B8 should be BLACK_KNIGHT');
        $this->assertTrue($board->pieceAt('C8') === Board::BLACK_BISHOP, 'C8 should be BLACK_BISHOP');
        $this->assertTrue($board->pieceAt('D8') === Board::BLACK_KING, 'D8 should be BLACK_KING');
        $this->assertTrue($board->pieceAt('E8') === Board::BLACK_QUEEN, 'E8 should be BLACK_QUEEN');
        $this->assertTrue($board->pieceAt('F8') === Board::BLACK_BISHOP, 'F8 should be BLACK_BISHOP');
        $this->assertTrue($board->pieceAt('G8') === Board::BLACK_KNIGHT, 'G8 should be BLACK_KNIGHT');
        $this->assertTrue($board->pieceAt('H8') === Board::BLACK_ROOK, 'H8 should be BLACK_ROOK');

    }

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
}
