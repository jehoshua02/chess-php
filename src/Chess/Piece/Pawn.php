<?php

namespace Chess\Piece;

class Pawn extends \Chess\Piece
{
    /**
     * Returns position above piece's position
     * @return string|false Returns false if not valid move for piece
     */
    public function up()
    {
        if ($this->color === self::DARK) {
            return false;
        }
        $up = $this->board->up($this->getPosition());
        return $this->board->get($up) ? false : $up;
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
        return $this->board->get($down) ? false : $down;
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
        $upLeft = $this->board->upLeft($this->getPosition());
        $piece = $this->board->get($upLeft);
        if ($piece && $piece->color() !== $this->color()) {
            return $upLeft;
        }
        return false;
    }
}
