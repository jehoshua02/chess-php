<?php

namespace Chess\Piece;
use \Chess\Moves;

class Queen extends \Chess\Piece
{
    /**
     * Returns all possible moves
     * @return \Chess\Moves
     */
    public function moves()
    {
        $moves = array();

        $directions = array(
            // same as Rook
            'up', 'down', 'left', 'right',
            // plus the same as Bishop
            'upLeft', 'upRight', 'downLeft', 'downRight'
        );

        foreach ($directions as $direction) {
            $moves = array_merge($moves, $this->slide($direction));
        }

        $moves = $this->filterCheckMoves($moves);

        return new Moves($moves);
    }
}
