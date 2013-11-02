<?php

namespace Chess\Piece;

class Pawn extends \Chess\Piece
{
    /**
     * Moves piece to specified position
     * @param  string $position
     * @return boolean
     */
    public function move($position, array $options = array())
    {
        $moves = $this->moves();
        if (!in_array($position, $moves)) {
            return false;
        }

        $piece = $this;

        // promotion
        if (array_key_exists('promote', $options)) {
            $valid = in_array($options['promote'], array('Queen', 'Bishop', 'Knight', 'Rook'));
            if (!$valid) {
                return false;
            }
            $class = sprintf('\\Chess\\Piece\\%s', $options['promote']);
            $piece = new $class($this->color());
        }

        $this->board()->piece($this->position(), null);
        $this->board()->piece($position, $piece);
        return true;
    }

    /**
     * Returns all possible moves
     * @return array
     */
    public function moves()
    {
        $moves = array(
            $this->up(),
            $this->up(2),
            $this->upLeft(),
            $this->upRight(),
            $this->down(),
            $this->down(2),
            $this->downLeft(),
            $this->downRight()
        );

        $moves = array_filter($moves, function ($move) {
            return $move !== false;
        });

        $moves = $this->filterCheckMoves($moves);

        return $moves;
    }

    /**
     * Returns position above piece's position
     * @param int $count
     * @return string|false Returns false if not valid move for piece
     */
    protected function up($count = 1)
    {
        if ($this->color() === self::DARK) {
            return false;
        }

        $position = $this->position();

        $up = $this->board()->up($position);
        if (!$up) {
            return false;
        }

        if ($this->board()->piece($up)) {
            return false;
        }

        if ($count === 1) {
            return $up;
        }

        list($file, $rank) = str_split($position);
        if ($rank != 2) {
            return false;
        }

        $up = $this->board()->up($up);
        if ($this->board()->piece($up)) {
            return false;
        }

        return $up;
    }

    /**
     * Returns position below piece's position
     * @param int $count
     * @return string|false Returns false if not valid move for piece
     */
    protected function down($count = 1)
    {
        if ($this->color() === self::LIGHT) {
            return false;
        }

        $position = $this->position();

        $down = $this->board()->down($position);
        if ($this->board()->piece($down)) {
            return false;
        }

        if ($count === 1) {
            return $down;
        }

        list($file, $rank) = str_split($position);
        if ($rank != 7) {
            return false;
        }

        $down = $this->board()->down($down);
        if ($this->board()->piece($down)) {
            return false;
        }

        return $down;
    }

    /**
     * Returns position up and left of piece's position
     * @return string|false Returns false if not valid move for piece
     */
    protected function upLeft()
    {
        if ($this->color() === self::DARK) {
            return false;
        }
        $upLeft = $this->board()->upLeft($this->position());
        if (!$upLeft) {
            return false;
        }
        $piece = $this->board()->piece($upLeft);
        if ($piece && $piece->color() !== $this->color()) {
            return $upLeft;
        }
        return false;
    }

    /**
     * Returns position up and right of piece's position
     * @return string|false Returns false if not valid move for piece
     */
    protected function upRight()
    {
        if ($this->color() === self::DARK) {
            return false;
        }
        $upRight = $this->board()->upRight($this->position());
        if (!$upRight) {
            return false;
        }
        $piece = $this->board()->piece($upRight);
        if ($piece && $piece->color() !== $this->color()) {
            return $upRight;
        }
        return false;
    }

    /**
     * Returns position down and left of piece's position
     * @return string|false Returns false if not valid move for piece
     */
    protected function downLeft()
    {
        if ($this->color() === self::LIGHT) {
            return false;
        }
        $downLeft = $this->board()->downLeft($this->position());
        if (!$downLeft) {
            return false;
        }
        $piece = $this->board()->piece($downLeft);
        if ($piece && $piece->color() !== $this->color()) {
            return $downLeft;
        }
        return false;
    }

    /**
     * Returns position down and right of piece's position
     * @return string|false Returns false if not valid move for piece
     */
    protected function downRight()
    {
        if ($this->color() === self::LIGHT) {
            return false;
        }
        $downRight = $this->board()->downRight($this->position());
        if (!$downRight) {
            return false;
        }
        $piece = $this->board()->piece($downRight);
        if ($piece && $piece->color() !== $this->color()) {
            return $downRight;
        }
        return false;
    }

}
