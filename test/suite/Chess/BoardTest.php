<?php

use \Chess\Piece;
use \Chess\Board;
use \Chess\Piece\King;
use \Chess\Piece\Queen;
use \Chess\Piece\Bishop;
use \Chess\Piece\Knight;
use \Chess\Piece\Rook;
use \Chess\Piece\Pawn;
use \Chess\Player;

class BoardTest extends \Chess\TestCase
{
    public function testVanillaBoard()
    {
        $board = new Board();

        // check piece types
        $expectations = array(
            array('King', array('E1', 'E8')),
            array('Queen', array('D1', 'D8')),
            array('Bishop', array('C1', 'C8', 'F1', 'F8')),
            array('Knight', array('B1', 'B8', 'G1', 'G8')),
            array('Rook', array('A1', 'A8', 'H1', 'H8')),
            array('Pawn', array('A2', 'B2', 'C2', 'D2', 'E2', 'F2', 'G2', 'H2')),
            array('Pawn', array('A7', 'B7', 'C7', 'D7', 'E7', 'F7', 'G7', 'H7')),
        );

        foreach ($expectations as $expectation) {
            list($class, $positions) = $expectation;
            foreach ($positions as $position) {
                $this->assertInstanceOf(
                    sprintf('\\Chess\\Piece\\%s', $class),
                    $board->piece($position),
                    sprintf('%s should be a %s', $position, $class)
                );
            }
        }

        // check piece player
        $files = str_split('ABCDEFGH');
        foreach ($files as $file) {
            $position = $file . '1';
            $this->assertEquals($board->piece($position)->player(0), $board->player(0));

            $position = $file . '2';
            $this->assertEquals($board->piece($position)->player(0), $board->player(0));

            $position = $file . '7';
            $this->assertEquals($board->piece($position)->player(1), $board->player(1));

            $position = $file . '8';
            $this->assertEquals($board->piece($position)->player(1), $board->player(1));
        }

        // check empty spaces
        $files = str_split('ABCDEFGH');
        $ranks = str_split('3456');

        foreach ($files as $file) {
            foreach ($ranks as $rank) {
                $position = $file . $rank;
                $this->assertNull($board->piece($position), "{$position} should be empty");
            }
        }
    }

    public function testPiece()
    {
        $player1 = new Player();
        $player2 = new Player();

        // set
        $board = new Board();
        $piece = new Pawn($player1);
        $this->assertEquals($piece, $board->piece('A1', $piece), 'Set should return the set piece');
        $this->assertInstanceOf('\\Chess\\Piece\\Pawn', $board->piece('A1'), 'A1 should be a Pawn');
        $this->assertFalse($board->piece('H9', new Pawn($player2)), 'Set should return false');

        // unset
        $board = new Board();
        $board->piece('A1', null);
        $this->assertNull($board->piece('A1'), 'A1 should be empty');

        // invalid position
        $board = new Board();
        $this->assertFalse($board->piece('H9'), 'H9 should be invalid position');
    }

    public function testUpDownLeftRightEtc()
    {
        $board = new Board();

        // test up
        $this->assertEquals('A2', $board->up('A1'), 'Postion above A1 should be A2');
        $this->assertFalse($board->up('A8'), 'There should be nothing above A8');

        // test down
        $this->assertEquals('A7', $board->down('A8'), 'Postion below A8 should be A7');
        $this->assertFalse($board->down('A1'), 'There should be nothing below A1');

        // test left
        $this->assertEquals('G1', $board->left('H1'), 'Position left of H1 should be G1');
        $this->assertFalse($board->left('A1'), 'There should be nothing left of A1');

        // test right
        $this->assertEquals('B1', $board->right('A1'), 'Position right of A1 should be B1');
        $this->assertFalse($board->right('H1'), 'There should be nothing right of H1');

        // test upLeft
        $this->assertEquals('G2', $board->upLeft('H1'), 'Position up and left of H1 should be G2');
        $this->assertFalse($board->upLeft('A8'), 'There should be nothing up and left of A8');

        // test upRight
        $this->assertEquals('B2', $board->upRight('A1'), 'Position up and right of A1 should be B2');
        $this->assertFalse($board->upRight('H8'), 'There should be nothing up and right of H8');

        // test downRight
        $this->assertEquals('B7', $board->downRight('A8'), 'Position down and right of A8 should be B7');
        $this->assertFalse($board->downRight('H1'), 'There should be nothing down and right of H1');

        // test downLeft
        $this->assertEquals('G7', $board->downLeft('H8'), 'Position down and right of H8 should be G7');
        $this->assertFalse($board->downLeft('A1'), 'There should be nothing down and right of A1');
    }

    public function testCustomBoard()
    {
        $player1 = new Player();

        $board = new Board(array(
            'A1' => new Pawn($player1),
        ));

        $this->assertInstanceOf('\\Chess\\Piece\\Pawn', $board->piece('A1'), 'A1 should be a Pawn');
        $this->assertNull($board->piece('A2'), "A2 should be empty");
    }

    public function testPosition()
    {
        $player1 = new Player();
        $piece = new Pawn($player1);
        $board = new Board(array(
            'A1' => $piece,
        ));
        $this->assertEquals('A1', $board->position($piece), 'Pawn should be on A1');

        $anotherPiece = new Pawn($player1);
        $this->assertFalse($board->position($anotherPiece), 'Pawn should not be found on board');
    }

    public function testPieces()
    {
        $player1 = new Player();
        $pieces = array(
            'D4' => new Pawn($player1)
        );
        $board = new Board($pieces);
        $this->assertEquals($pieces, $board->pieces(), 'Board should return all the pieces');
    }
}
