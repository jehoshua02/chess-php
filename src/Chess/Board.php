<?php

namespace Chess;
use \Chess\Piece\King;
use \Chess\Piece\Queen;
use \Chess\Piece\Bishop;
use \Chess\Piece\Knight;
use \Chess\Piece\Rook;
use \Chess\Piece\Pawn;

class Board
{
    /**
     * Stores positions of pieces
     * @var array
     */
    protected $positions = array();

    /**
     * Construct method
     * @param array|null $positions Array of positions, where key is algebraic notation (A1 through H8), and value is the piece (Board::LIGHT_PAWN)
     */
    public function __construct($positions = null)
    {
        $this->positions = array(
            'A1' => new Rook(Piece::LIGHT),
            'B1' => new Knight(Piece::LIGHT),
            'C1' => new Bishop(Piece::LIGHT),
            'D1' => new Queen(Piece::LIGHT),
            'E1' => new King(Piece::LIGHT),
            'F1' => new Bishop(Piece::LIGHT),
            'G1' => new Knight(Piece::LIGHT),
            'H1' => new Rook(Piece::LIGHT),

            'A2' => new Pawn(Piece::LIGHT),
            'B2' => new Pawn(Piece::LIGHT),
            'C2' => new Pawn(Piece::LIGHT),
            'D2' => new Pawn(Piece::LIGHT),
            'E2' => new Pawn(Piece::LIGHT),
            'F2' => new Pawn(Piece::LIGHT),
            'G2' => new Pawn(Piece::LIGHT),
            'H2' => new Pawn(Piece::LIGHT),

            'A7' => new Pawn(Piece::DARK),
            'B7' => new Pawn(Piece::DARK),
            'C7' => new Pawn(Piece::DARK),
            'D7' => new Pawn(Piece::DARK),
            'E7' => new Pawn(Piece::DARK),
            'F7' => new Pawn(Piece::DARK),
            'G7' => new Pawn(Piece::DARK),
            'H7' => new Pawn(Piece::DARK),

            'A8' => new Rook(Piece::DARK),
            'B8' => new Knight(Piece::DARK),
            'C8' => new Bishop(Piece::DARK),
            'D8' => new Queen(Piece::DARK),
            'E8' => new King(Piece::DARK),
            'F8' => new Bishop(Piece::DARK),
            'G8' => new Knight(Piece::DARK),
            'H8' => new Rook(Piece::DARK),
        );
    }

    /**
     * Returns the piece type at specified position
     * @param  string $position Algebraic notation (A1 through H8)
     * @return \Chess\Piece|false Returns false if position is empty
     */
    public function get($position)
    {
        return array_key_exists($position, $this->positions) ? $this->positions[$position] : false;
    }

    /**
     * Sets piece for specified position
     * @param string $position
     * @param \Chess\Piece $piece
     * @return boolean
     */
    public function set($position, \Chess\Piece $piece)
    {
        $files = str_split('ABCDEFGH');
        $ranks = str_split('12345678');
        list($file, $rank) = str_split($position);
        $valid = in_array($file, $files) && in_array($rank, $ranks);
        if ($valid) {
            $this->positions[$position] = $piece;
        }
        return $valid;
    }

    /**
     * Clears the specified position
     * @param  string $position
     */
    public function clear($position)
    {
        if (array_key_exists($position, $this->positions)) {
            unset($this->positions[$position]);
        }
    }

    /**
     * Returns the position above the position specified
     * @param  string $position
     * @return string|false
     */
    public function up($position)
    {
        list($file, $rank) = str_split($position);
        if ($rank === '8') {
            return false;
        }
        return $file . ($rank + 1);
    }

    /**
     * Returns the position below the position specified
     * @param  string $position
     * @return string|false
     */
    public function down($position)
    {
        list($file, $rank) = str_split($position);
        if ($rank == '1') {
            return false;
        }
        return $file . ($rank - 1);
    }

    /**
     * Returns the position left of specified position
     * @param  string $position
     * @return string|false
     */
    public function left($position)
    {
        list($file, $rank) = str_split($position);
        if ($file === 'A') {
            return false;
        }
        $files = str_split('ABCDEFGH');
        return $files[array_search($file, $files) - 1] . $rank;
    }

    /**
     * Returns the position right of specified position
     * @param  string $position
     * @return string|false
     */
    public function right($position)
    {
        list($file, $rank) = str_split($position);
        if ($file === 'H') {
            return false;
        }
        $files = str_split('ABCDEFGH');
        return $files[array_search($file, $files) + 1] . $rank;
    }

    /**
     * Returns the position up and left of specified position
     * @param  string $position
     * @return string
     */
    public function upLeft($position)
    {
        $up = $this->up($position);
        return $up ? $this->left($up) : false;
    }

    /**
     * Returns the position up and right of specified position
     * @param  string $position
     * @return string
     */
    public function upRight($position)
    {
        $up = $this->up($position);
        return $up ? $this->right($up) : false;
    }

    /**
     * Returns the position down and right of specified position
     * @param  string $position
     * @return string
     */
    public function downRight($position)
    {
        $down = $this->down($position);
        return $down ? $this->right($down) : false;
    }

    /**
     * Returns the position down and left of specified position
     * @param  string $position
     * @return string
     */
    public function downLeft($position)
    {
        $down = $this->down($position);
        return $down ? $this->left($down) : false;
    }
}
