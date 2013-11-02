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
    public function color()
    {
        return $this->color;
    }

    /**
     * Gets or sets board
     * @param  \Chess\Board|null $board
     * @return \Chess\Board
     */
    public function board(\Chess\Board $board = null)
    {
        if (empty($this->board)) {
            $this->board = $board;
        }
        return $this->board;
    }

    /**
     * Returns piece's position
     * @return string|false
     */
    public function position()
    {
        return $this->board()->position($this);
    }

    /**
     * Returns possible moves for piece
     * @return array
     */
    public function moves()
    {
        return array();
    }

    /**
     * Returns the King piece
     * @return \Chess\Piece\King|false Returns false if unable to find King
     */
    public function king()
    {
        if (!$this->board()) {
            return false;
        }

        foreach ($this->board()->pieces() as $piece) {
            if (
                is_a($piece, '\\Chess\\Piece\\King')
                && $piece->color() === $this->color()
            ) {
                return $piece;
            }
        }

        return false;
    }

    /**
     * Determines if the King is in check
     * @return boolean
     */
    public function check()
    {
        $position = $this->king()->position();

        foreach ($this->board()->pieces() as $piece) {
            if (in_array($position, $piece->moves())) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns all moves in one direction
     * @param  string $direction
     * @return array
     */
    protected function slide($direction)
    {
        $moves = array();

        $position = $this->position();
        while (true) {
            $position = $this->board()->$direction($position);

            if (!$position) {
                break;
            }

            $piece = $this->board()->piece($position);
            if (!$piece) {
                $moves[] = $position;
                continue;
            }

            if ($piece->color() !== $this->color()) {
                $moves[] = $position;
            }

            break;
        }

        return $moves;
    }
}
