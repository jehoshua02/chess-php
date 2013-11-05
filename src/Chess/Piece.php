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
        if (!$this->king()) {
            return false;
        }
        return $this->king()->underThreat();
    }

    /**
     * Determines whether piece is under threat of being captured
     * @return boolean
     */
    public function underThreat()
    {
        foreach ($this->board()->pieces() as $piece) {
            if ($piece->color() === $this->color()) {
                continue;
            }
            if (in_array($this->position(), $piece->moves())) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determines if checkmate
     * @return boolean
     */
    public function checkmate()
    {
        return $this->check() && !$this->hasMoves();
    }

    /**
     * Determins if stalemate
     * @return boolean
     */
    public function stalemate()
    {
        return !$this->check() && !$this->hasMoves();
    }

    /**
     * Determines if any piece has possible moves
     * @return boolean
     */
    protected function hasMoves()
    {
        foreach ($this->board()->pieces() as $piece) {
            if ($piece->color() !== $this->color()) {
                continue;
            }
            if (count($piece->moves()) > 0) {
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

    /**
     * Filters moves that result in check
     * @param array $moves
     * @return array
     */
    protected function filterCheckMoves($moves)
    {
        foreach ($moves as $key => $move) {
            if ($this->isCheckAfterMove($move)) {
                unset($moves[$key]);
            }
        }

        return $moves;
    }

    /**
     * Determines King would be in check after a move
     * @param string $position
     * @return boolean
     */
    protected function isCheckAfterMove($position)
    {
        // save what is needed to undo move
        $current = $this->position();
        $piece = $this->board()->piece($position);

        // execute move
        $this->board()->piece($current, null);
        $this->board()->piece($position, $this);

        $check = $this->check();

        // put the pieces back
        $this->board()->piece($position, $piece);
        $this->board()->piece($current, $this);

        return $check;
    }
}
