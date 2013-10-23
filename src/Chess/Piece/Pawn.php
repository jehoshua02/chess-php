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
        $down = $this->board->down($this->getPosition());
        return $this->board->get($down) ? false : $down;
    }
}
