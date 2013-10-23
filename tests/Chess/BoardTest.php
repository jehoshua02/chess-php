<?php

namespace Chess;
use \Chess\Board;
use \Chess\Piece\King;
use \Chess\Piece\Queen;
use \Chess\Piece\Bishop;
use \Chess\Piece\Knight;
use \Chess\Piece\Rook;
use \Chess\Piece\Pawn;

class BoardTest extends \PHPUnit_Framework_TestCase
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
                    $board->get($position),
                    sprintf('%s should be a %s', $position, $class)
                );
            }
        }

        // check piece color
        $files = str_split('ABCDEFGH');
        foreach ($files as $file) {
            $position = $file . '1';
            $this->assertEquals($board->get($position)->color(), Piece::LIGHT);

            $position = $file . '2';
            $this->assertEquals($board->get($position)->color(), Piece::LIGHT);

            $position = $file . '7';
            $this->assertEquals($board->get($position)->color(), Piece::DARK);

            $position = $file . '8';
            $this->assertEquals($board->get($position)->color(), Piece::DARK);
        }

        // check empty spaces
        $files = str_split('ABCDEFGH');
        $ranks = str_split('3456');

        foreach ($files as $file) {
            foreach ($ranks as $rank) {
                $position = $file . $rank;
                $this->assertFalse($board->get($position), "{$position} should be empty");
            }
        }
    }

    public function testSet()
    {
        $board = new Board();
        $this->assertTrue($board->set('A1', new Pawn(Piece::DARK)), 'Set should return true');
        $this->assertInstanceOf('\\Chess\\Piece\\Pawn', $board->get('A1'), 'A1 should be a King');
        $this->assertFalse($board->set('H9', new Pawn(Piece::DARK)), 'Set should return false');
    }

    public function testClear()
    {
        $board = new Board();
        $board->clear('A1');
        $this->assertFalse($board->get('A1'), 'A1 should be clear');
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
        $board = new Board(array(
            'A1' => new Pawn(Piece::LIGHT),
        ));

        $this->assertInstanceOf('\\Chess\\Piece\\Pawn', $board->get('A1'), 'A1 should be a Pawn');
        $this->assertFalse($board->get('A2'), "A2 should be empty");
    }

    public function testFind()
    {
        $piece = new Pawn(Piece::LIGHT);
        $board = new Board(array(
            'A1' => $piece,
        ));
        $this->assertEquals('A1', $board->find($piece), 'Pawn should be on A1');

        $anotherPiece = new Pawn(Piece::LIGHT);
        $this->assertFalse($board->find($anotherPiece), 'Pawn should not be found on board');
    }
}
