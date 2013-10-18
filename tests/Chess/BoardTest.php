<?php

namespace Chess;
use \Chess\Board;

class BoardTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildAndGetPieces()
    {
        $board = Board::build();

        $this->assertTrue($board->pieceAt('a1') === Board::WHITE_ROOK);
        $this->assertTrue($board->pieceAt('b1') === Board::WHITE_KNIGHT);
        $this->assertTrue($board->pieceAt('c1') === Board::WHITE_BISHOP);
        $this->assertTrue($board->pieceAt('d1') === Board::WHITE_QUEEN);
        $this->assertTrue($board->pieceAt('e1') === Board::WHITE_KING);
        $this->assertTrue($board->pieceAt('f1') === Board::WHITE_BISHOP);
        $this->assertTrue($board->pieceAt('g1') === Board::WHITE_KNIGHT);
        $this->assertTrue($board->pieceAt('h1') === Board::WHITE_ROOK);

        $this->assertTrue($board->pieceAt('a2') === Board::WHITE_PAWN);
        $this->assertTrue($board->pieceAt('b2') === Board::WHITE_PAWN);
        $this->assertTrue($board->pieceAt('c2') === Board::WHITE_PAWN);
        $this->assertTrue($board->pieceAt('d2') === Board::WHITE_PAWN);
        $this->assertTrue($board->pieceAt('e2') === Board::WHITE_PAWN);
        $this->assertTrue($board->pieceAt('f2') === Board::WHITE_PAWN);
        $this->assertTrue($board->pieceAt('g2') === Board::WHITE_PAWN);
        $this->assertTrue($board->pieceAt('h2') === Board::WHITE_PAWN);

        $this->assertTrue($board->pieceAt('a7') === Board::BLACK_PAWN);
        $this->assertTrue($board->pieceAt('b7') === Board::BLACK_PAWN);
        $this->assertTrue($board->pieceAt('c7') === Board::BLACK_PAWN);
        $this->assertTrue($board->pieceAt('d7') === Board::BLACK_PAWN);
        $this->assertTrue($board->pieceAt('e7') === Board::BLACK_PAWN);
        $this->assertTrue($board->pieceAt('f7') === Board::BLACK_PAWN);
        $this->assertTrue($board->pieceAt('g7') === Board::BLACK_PAWN);
        $this->assertTrue($board->pieceAt('h7') === Board::BLACK_PAWN);

        $this->assertTrue($board->pieceAt('a8') === Board::BLACK_ROOK);
        $this->assertTrue($board->pieceAt('b8') === Board::BLACK_KNIGHT);
        $this->assertTrue($board->pieceAt('c8') === Board::BLACK_BISHOP);
        $this->assertTrue($board->pieceAt('d8') === Board::BLACK_KING);
        $this->assertTrue($board->pieceAt('e8') === Board::BLACK_QUEEN);
        $this->assertTrue($board->pieceAt('f8') === Board::BLACK_BISHOP);
        $this->assertTrue($board->pieceAt('g8') === Board::BLACK_KNIGHT);
        $this->assertTrue($board->pieceAt('h8') === Board::BLACK_ROOK);

    }
}
