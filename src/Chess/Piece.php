<?php

namespace Chess;

abstract class Piece
{
    const DARK = 0;
    const LIGHT = 1;

    /**
     * Color of piece
     * @var int
     */
    protected $color;

    /**
     * Board the piece is on
     * @var \Chess\Board
     */
    protected $board;

    /**
     * Construct method
     * @param int $color
     */
    public function __construct($color)
    {
        $this->color = $color;
    }

    /**
     * Returns color of the piece
     * @return int
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Gets or sets board on piece
     * @param  \Chess\Board|null $board
     * @return \Chess\Board
     */
    public function setBoard(\Chess\Board $board)
    {
        $this->board = $board;
    }

    /**
     * Returns piece's position
     * @return string|false
     */
    public function getPosition()
    {
        return $this->board->getPosition($this);
    }
}
