<?php

namespace Chess\Piece;
use \Chess\Move;

class King extends \Chess\Piece
{
    /**
     * Returns possible moves for piece
     * @return array Returns array of \Chess\Move objects
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

        $moves[] = $this->castle('left');
        $moves[] = $this->castle('right');

        $moves = array_filter($moves, function ($move) {
            return $move !== false;
        });

        $moves = $this->filterCheckMoves($moves);

        return $moves;
    }

    /**
     * Returns move in the direction specified
     * @param  string $direction
     * @return \Chess\Moves|false Returns false if not valid move for piece
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

        return new Move($this, $position);
    }

    /**
     * Returns castling move
     * @return \Chess\Move|false Returns false if not valid move
     */
    protected function castle($direction)
    {
        // cannot castle if king moved
        if ($this->moved()) {
            return false;
        }

        // cannot castle if king in check
        if ($this->check()) {
            return false;
        }

        // get all positions to the left until edge of board
        $positions = array();
        $position = $this->position();
        while ($position = $this->board()->$direction($position)) {
            $positions[] = $position;
        }

        // must be enough room to move two spaces and a rook
        if (count($positions) < 3) {
            return false;
        }

        // cannot castle if last position does not contain unmoved rook of same color
        $last = array_pop($positions);
        $piece = $this->board()->piece($last);
        if (
            !$piece
            || !is_a($piece, '\\Chess\\Piece\\Rook')
            || $piece->color() !== $this->color()
            || $piece->moved()
        ) {
            return false;
        }

        // cannot be any pieces in between
        foreach ($positions as $position) {
            if ($this->board()->piece($position)) {
                return false;
            }
        }

        // return position left two
        return new Move($this, $positions[1], array($positions[0], $piece));
    }
}
