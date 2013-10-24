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
     */
    public function __construct($positions = null)
    {
        if ($positions !== null) {
            foreach ($positions as $position => $piece) {
                $this->setPiece($position, $piece);
            }
            return;
        }

        $this->setPiece('A1', new Rook(Piece::LIGHT));
        $this->setPiece('B1', new Knight(Piece::LIGHT));
        $this->setPiece('C1', new Bishop(Piece::LIGHT));
        $this->setPiece('D1', new Queen(Piece::LIGHT));
        $this->setPiece('E1', new King(Piece::LIGHT));
        $this->setPiece('F1', new Bishop(Piece::LIGHT));
        $this->setPiece('G1', new Knight(Piece::LIGHT));
        $this->setPiece('H1', new Rook(Piece::LIGHT));

        $this->setPiece('A2', new Pawn(Piece::LIGHT));
        $this->setPiece('B2', new Pawn(Piece::LIGHT));
        $this->setPiece('C2', new Pawn(Piece::LIGHT));
        $this->setPiece('D2', new Pawn(Piece::LIGHT));
        $this->setPiece('E2', new Pawn(Piece::LIGHT));
        $this->setPiece('F2', new Pawn(Piece::LIGHT));
        $this->setPiece('G2', new Pawn(Piece::LIGHT));
        $this->setPiece('H2', new Pawn(Piece::LIGHT));

        $this->setPiece('A7', new Pawn(Piece::DARK));
        $this->setPiece('B7', new Pawn(Piece::DARK));
        $this->setPiece('C7', new Pawn(Piece::DARK));
        $this->setPiece('D7', new Pawn(Piece::DARK));
        $this->setPiece('E7', new Pawn(Piece::DARK));
        $this->setPiece('F7', new Pawn(Piece::DARK));
        $this->setPiece('G7', new Pawn(Piece::DARK));
        $this->setPiece('H7', new Pawn(Piece::DARK));

        $this->setPiece('A8', new Rook(Piece::DARK));
        $this->setPiece('B8', new Knight(Piece::DARK));
        $this->setPiece('C8', new Bishop(Piece::DARK));
        $this->setPiece('D8', new Queen(Piece::DARK));
        $this->setPiece('E8', new King(Piece::DARK));
        $this->setPiece('F8', new Bishop(Piece::DARK));
        $this->setPiece('G8', new Knight(Piece::DARK));
        $this->setPiece('H8', new Rook(Piece::DARK));
    }

    /**
     * Returns the piece type at specified position
     * @param  string $position Algebraic notation (A1 through H8)
     * @return \Chess\Piece|false Returns false if position is empty
     */
    public function getPiece($position)
    {
        return array_key_exists($position, $this->positions) ? $this->positions[$position] : false;
    }

    /**
     * Sets piece for specified position
     * @param string $position
     * @param \Chess\Piece $piece
     * @return boolean
     */
    public function setPiece($position, \Chess\Piece $piece)
    {
        $files = str_split('ABCDEFGH');
        $ranks = str_split('12345678');
        list($file, $rank) = str_split($position);
        $valid = in_array($file, $files) && in_array($rank, $ranks);
        if ($valid) {
            $piece->setBoard($this);
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
     * Returns position of piece
     * @param  \Chess\Piece $piece
     * @return string|false
     */
    public function find(\Chess\Piece $piece)
    {
        foreach ($this->positions as $position => $boardPiece) {
            if ($piece === $boardPiece) {
                return $position;
            }
        }
        return false;
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
