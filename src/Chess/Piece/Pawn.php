<?php

namespace Chess\Piece;

class Pawn extends \Chess\Piece
{
    /**
     * Returns position above piece's position
     * @return string|false Returns false if not valid move for piece
     */
    public function up($count = 1)
    {
        if ($this->color === self::DARK) {
            return false;
        }

        if ($count > 2) {
            return false;
        }

        $position = $this->getPosition();

        $up = $this->board->up($this->getPosition());
        if ($this->board->getPiece($up)) {
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
        if ($this->board->getPiece($up)) {
            return false;
        }

        return $up;
    }

    /**
     * Returns position below piece's position
     * @return string|false Returns false if not valid move for piece
     */
    public function down()
    {
        if ($this->color === self::LIGHT) {
            return false;
        }
        $down = $this->board->down($this->getPosition());
        return $this->board->getPiece($down) ? false : $down;
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
        if ($this->getColor() === self::DARK) {
            return false;
        }
        $upLeft = $this->board->upLeft($this->getPosition());
        if (!$upLeft) {
            return false;
        }
        $piece = $this->board->getPiece($upLeft);
        if ($piece && $piece->getColor() !== $this->getColor()) {
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
        if ($this->getColor() === self::DARK) {
            return false;
        }
        $upRight = $this->board->upRight($this->getPosition());
        if (!$upRight) {
            return false;
        }
        $piece = $this->board->getPiece($upRight);
        if ($piece && $piece->getColor() !== $this->getColor()) {
            return $upRight;
        }
        return false;
    }
}
