<?php

namespace Chess\Piece;

class Knight extends \Chess\Piece
{
    /**
     * Returns all possible moves
     * @return array
     */
    public function moves()
    {
        $moves = array(
            $this->jump('up', 'upLeft'),
            $this->jump('up', 'upRight'),
            $this->jump('down', 'downLeft'),
            $this->jump('down', 'downRight'),
            $this->jump('left', 'upLeft'),
            $this->jump('left', 'downLeft'),
            $this->jump('right', 'upRight'),
            $this->jump('right', 'downRight')
        );

        $moves = array_filter($moves, function ($move) {
            return $move !== false;
        });

        $moves = $this->filterCheckMoves($moves);

        return $moves;
    }

    /**
     * Returns jump position
     * @param  string $direction, $direction, ...
     * @return string|false Returns false if not a valid move for piece
     */
    protected function jump()
    {
        $directions = func_get_args();
        $position = $this->position();
        foreach ($directions as $direction) {
            $position = $this->board()->$direction($position);
            if (!$position) {
                return false;
            }
        }

        $piece = $this->board()->piece($position);
        if ($piece && $piece->color() === $this->color()) {
            return false;
        }

        return $position;
    }
}
