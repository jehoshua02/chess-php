<?php

namespace Chess\Piece;

class Bishop extends \Chess\Piece
{
    /**
     * Returns all possible moves
     * @return array
     */
    public function moves()
    {
        $moves = array();

        foreach (array('upLeft', 'upRight', 'downLeft', 'downRight') as $direction) {
            $moves = array_merge($moves, $this->slide($direction));
        }

        $moves = $this->filterCheckMoves($moves);

        return $moves;
    }
}
