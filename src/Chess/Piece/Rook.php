<?php

namespace Chess\Piece;

class Rook extends \Chess\Piece
{
    /**
     * Returns all possible moves
     * @return array
     */
    public function moves()
    {
        $moves = array();
        foreach (array('up', 'down', 'left', 'right') as $direction) {
            $moves = array_merge($moves, $this->slide($direction));
        }
        return $moves;
    }
}
