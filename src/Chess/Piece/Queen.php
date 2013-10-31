<?php

namespace Chess\Piece;

class Queen extends \Chess\Piece
{
    /**
     * Returns all possible moves
     * @return array
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
        return $moves;
    }
}
