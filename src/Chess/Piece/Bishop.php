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
        return $moves;
    }

    /**
     * Returns all moves in one direction
     * @param  string $direction
     * @return array
     */
    protected function slide($direction)
    {
        $moves = array();

        $position = $this->position();
        while (true) {
            $position = $this->board()->$direction($position);

            if (!$position) {
                break;
            }

            $moves[] = $position;
        }

        return $moves;
    }
}
