<?php

namespace Chess;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Makes a board
     * @param  array  $pieces Array of pieces, their position, and player.
     * @return \Chess\Board
     */
    public function makeBoard(array $pieces) {
        $players = array(new Player(), new Player());
        $boardPieces = array();
        foreach ($pieces as $piece) {
            list($position, $type, $player) = $piece;
            $type = '\\Chess\\Piece\\' . $type;
            $boardPieces[$position] = new $type($players[$player - 1]);
        }
        $board = new Board($boardPieces);
        return $board;
    }
}
