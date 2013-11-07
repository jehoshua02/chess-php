<?php

namespace Chess\Piece;

class Rook extends \Chess\Piece
{
    /**
     * Returns all possible moves
     * @return array Returns array of \Chess\Move objects
     */
    public function moves()
    {
        $moves = array();

        foreach (array('up', 'down', 'left', 'right') as $direction) {
            $moves = array_merge($moves, $this->slide($direction));
        }

        $moves = $this->filterCheckMoves($moves);

        return $moves;
    }
}
