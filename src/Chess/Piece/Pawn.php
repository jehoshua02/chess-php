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
        $up = $this->board->up($this->getPosition());
        return $this->board->get($up) ? false : $up;
    }
}
