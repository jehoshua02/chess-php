<?php

namespace Chess\Piece;

class King extends \Chess\Piece
{
    /**
     * Returns possible moves for piece
     * @return array
     */
    public function moves()
    {
        $moves = array();

        $directions = array(
            'up', 'down', 'left', 'right',
            'upLeft', 'upRight', 'downLeft', 'downRight'
        );

        foreach ($directions as $direction) {
            $moves[] = $this->step($direction);
        }

        $moves = array_filter($moves, function ($move) {
            return $move !== false;
        });

        $moves = $this->filterCheckMoves($moves);

        return $moves;
    }

    /**
     * Returns position in the direction specified
     * @param  string $direction
     * @return string|false Returns false if not valid move for piece
     */
    protected function step($direction)
    {
        $position = $this->board()->$direction($this->position());

        if (!$position) {
            return false;
        }

        $piece = $this->board()->piece($position);
        if ($piece && $piece->color() === $this->color()) {
            return false;
        }

        return $position;
    }
}
