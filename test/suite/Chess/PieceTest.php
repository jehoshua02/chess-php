<?php

use \Chess\Board;
use \Chess\Piece;
use \Chess\Piece\King;
use \Chess\Piece\Pawn;
use \Chess\Piece\Queen;
use \Chess\Player;

class PieceStub extends \Chess\Piece
{

}

class PieceTest extends PHPUnit_Framework_TestCase
{
    public function testBoard()
    {
        $player1 = new Player();
        $player2 = new Player();
        $piece = new PieceStub($player1);

        $board = new Board();
        $this->assertTrue($board === $piece->board($board), 'Piece should return board');
        $this->assertTrue($board === $piece->board(), 'Piece should return board again');

        $anotherBoard = new Board(array());
        $this->assertFalse($anotherBoard === $piece->board($anotherBoard), 'Piece board should be immutable');
        $this->assertTrue($board === $piece->board(), 'Piece board should not have changed');
    }

    public function testKing()
    {
        $player1 = new Player();
        $player2 = new Player();
        $piece = new PieceStub($player1);
        $board = new Board(array(
            'D4' => $piece,
            'E8' => new King($player2),
            'E1' => new King($player1)
        ));
        $board->piece('D4', $piece);
        $king = $board->piece('E1');
        $this->assertTrue($king === $piece->king(), 'Every piece should know it\'s King');

        // no king
        $player1 = new Player();
        $player2 = new Player();
        $piece = new PieceStub($player1);
        $board = new Board(array(
            'D4' => $piece
        ));
        $this->assertFalse($piece->king(), 'Piece on board with no King has no King');

        // no board
        $player1 = new Player();
        $player2 = new Player();
        $piece = new PieceStub($player1);
        $this->assertFalse($piece->king(), 'Piece without a board has no King');
    }

    public function testCheck()
    {
        $player1 = new Player();
        $player2 = new Player();
        $piece = new PieceStub($player1);
        $board = new Board(array(
            'A1' => $piece,
            'D4' => new King($player1),
            'E5' => new Pawn($player2)
        ));
        $this->assertTrue($piece->check(), 'King should be in check');

        // not in check
        $player1 = new Player();
        $player2 = new Player();
        $piece = new PieceStub($player1);
        $board = new Board(array(
            'A1' => $piece,
            'D4' => new King($player1),
            'E5' => new Pawn($player1)
        ));
        $this->assertFalse($piece->check(), 'King should not be in check');
    }

    public function testCheckmate()
    {
        $player1 = new Player();
        $player2 = new Player();
        $board = new Board(array(
            'D4' => new King($player1),
            'D5' => new Queen($player2),
            'D3' => new Queen($player2)
        ));
        $this->assertTrue($board->piece('D4')->checkmate(), 'King should be in checkmate');

        $player1 = new Player();
        $player2 = new Player();
        $board = new Board(array(
            'D4' => new King($player1),
            'D5' => new Queen($player2),
            'D3' => new Pawn($player2)
        ));
        $this->assertFalse($board->piece('D4')->checkmate(), 'King should not be in checkmate');

        $player1 = new Player();
        $player2 = new Player();
        $board = new Board(array(
            'D1' => new King($player1),
            'D2' => new Pawn($player2),
            'D3' => new Queen($player2)
        ));
        $check = $board->piece('D1')->check();
        $checkmate = $board->piece('D1')->checkmate();
        $this->assertFalse($checkmate && $check === false, 'Stalemate is not the same as checkmate');
    }

    public function testStalemate()
    {
        $player1 = new Player();
        $player2 = new Player();
        $board = new Board(array(
            'A1' => new PieceStub($player1),
            'D1' => new King($player1),
            'D2' => new Pawn($player2),
            'D3' => new Queen($player2)
        ));
        $this->assertTrue($board->piece('A1')->stalemate(), 'King should be in stalemate');

        $player1 = new Player();
        $player2 = new Player();
        $board = new Board(array(
            'A1' => new PieceStub($player1),
            'D1' => new King($player1),
            'D2' => new Pawn($player2)
        ));
        $this->assertFalse($board->piece('A1')->stalemate(), 'King should not be in stalemate');
    }
}
