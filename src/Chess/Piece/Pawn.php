<?php

namespace Chess\Piece;

class Pawn extends \Chess\Piece
{
    /**
     * Returns position above piece's position
     * @param int $count
     * @return string|false Returns false if not valid move for piece
     */
    public function up($count = 1)
    {
        if ($this->color() === self::DARK) {
            return false;
        }

        if ($count > 2) {
            return false;
        }

        $position = $this->position();

        $up = $this->board->up($position);
        if ($this->board->get($up)) {
            return false;
        }

        if ($count === 1) {
            return $up;
        }

        list($file, $rank) = str_split($position);
        if ($rank != 2) {
            return false;
        }

        $up = $this->board->up($up);
        if ($this->board->get($up)) {
            return false;
        }

        return $up;
    }

    /**
     * Returns position below piece's position
     * @param int $count
     * @return string|false Returns false if not valid move for piece
     */
    public function down($count = 1)
    {
        if ($this->color() === self::LIGHT) {
            return false;
        }

        if ($count > 2) {
            return false;
        }

        $position = $this->position();

        $down = $this->board->down($position);
        if ($this->board->get($down)) {
            return false;
        }

        if ($count === 1) {
            return $down;
        }

        list($file, $rank) = str_split($position);
        if ($rank != 7) {
            return false;
        }

        $down = $this->board->down($down);
        if ($this->board->get($down)) {
            return false;
        }

        return $down;
    }

    /**
     * Returns false (pawns cannot move left)
     * @return false
     */
    public function left()
    {
        return false;
    }

    /**
     * Returns false (pawns cannot move right)
     * @return false
     */
    public function right()
    {
        return false;
    }

    /**
     * Returns position up and left of piece's position
     * @return string|false Returns false if not valid move for piece
     */
    public function upLeft()
    {
        if ($this->color() === self::DARK) {
            return false;
        }
        $upLeft = $this->board->upLeft($this->position());
        if (!$upLeft) {
            return false;
        }
        $piece = $this->board->get($upLeft);
        if ($piece && $piece->color() !== $this->color()) {
            return $upLeft;
        }
        return false;
    }

    /**
     * Returns position up and right of piece's position
     * @return string|false Returns false if not valid move for piece
     */
    public function upRight()
    {
        if ($this->color() === self::DARK) {
            return false;
        }
        $upRight = $this->board->upRight($this->position());
        if (!$upRight) {
            return false;
        }
        $piece = $this->board->get($upRight);
        if ($piece && $piece->color() !== $this->color()) {
            return $upRight;
        }
        return false;
    }

    /**
     * Returns position down and left of piece's position
     * @return string|false Returns false if not valid move for piece
     */
    public function downLeft()
    {
        if ($this->color() === self::LIGHT) {
            return false;
        }
        $downLeft = $this->board->downLeft($this->position());
        if (!$downLeft) {
            return false;
        }
        $piece = $this->board->get($downLeft);
        if ($piece && $piece->color() !== $this->color()) {
            return $downLeft;
        }
        return false;
    }

    /**
     * Returns position down and right of piece's position
     * @return string|false Returns false if not valid move for piece
     */
    public function downRight()
    {
        if ($this->color() === self::LIGHT) {
            return false;
        }
        $downRight = $this->board->downRight($this->position());
        if (!$downRight) {
            return false;
        }
        $piece = $this->board->get($downRight);
        if ($piece && $piece->color() !== $this->color()) {
            return $downRight;
        }
        return false;
    }

}
