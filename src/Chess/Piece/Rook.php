<?php

namespace Chess\Piece;
use \Chess\Moves;

class Rook extends \Chess\Piece
{
    /**
     * Returns all possible moves
     * @return \Chess\Moves
     */
    public function moves()
    {
        $moves = array();

        foreach (array('up', 'down', 'left', 'right') as $direction) {
            $moves = array_merge($moves, $this->slide($direction));
        }

        $moves = $this->filterCheckMoves($moves);

        return new Moves($moves);
    }
}
