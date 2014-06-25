<?php

namespace Chess;
use \Chess\Piece\King;
use \Chess\Piece\Queen;
use \Chess\Piece\Bishop;
use \Chess\Piece\Knight;
use \Chess\Piece\Rook;
use \Chess\Piece\Pawn;
use \Chess\Move;
use \Chess\Player;

class Board
{
    /**
     * Stores pieces indexed by position
     * @var array An array of \Chess\Piece objects
     */
    protected $pieces = array();

    /**
     * Stores players in turn order
     * @var array An array of \Chess\Player objects
     */
    protected $players = array();

    /**
     * List of moves made
     * @var array An array of \Chess\Move objects
     */
    protected $moves = array();

    /**
     * Construct method
     */
    public function __construct($pieces = null)
    {
        if ($pieces !== null) {
            foreach ($pieces as $position => $piece) {
                $player = $piece->player();
                if (!in_array($player, $this->players)) {
                    $this->players[] = $player;
                }
                $this->piece($position, $piece);
            }
            return;
        }

        $player1 = new Player();
        $player2 = new Player();

        $this->players = array($player1, $player2);

        $this->piece('A1', new Rook($player1));
        $this->piece('B1', new Knight($player1));
        $this->piece('C1', new Bishop($player1));
        $this->piece('D1', new Queen($player1));
        $this->piece('E1', new King($player1));
        $this->piece('F1', new Bishop($player1));
        $this->piece('G1', new Knight($player1));
        $this->piece('H1', new Rook($player1));

        $this->piece('A2', new Pawn($player1));
        $this->piece('B2', new Pawn($player1));
        $this->piece('C2', new Pawn($player1));
        $this->piece('D2', new Pawn($player1));
        $this->piece('E2', new Pawn($player1));
        $this->piece('F2', new Pawn($player1));
        $this->piece('G2', new Pawn($player1));
        $this->piece('H2', new Pawn($player1));

        $this->piece('A7', new Pawn($player2));
        $this->piece('B7', new Pawn($player2));
        $this->piece('C7', new Pawn($player2));
        $this->piece('D7', new Pawn($player2));
        $this->piece('E7', new Pawn($player2));
        $this->piece('F7', new Pawn($player2));
        $this->piece('G7', new Pawn($player2));
        $this->piece('H7', new Pawn($player2));

        $this->piece('A8', new Rook($player2));
        $this->piece('B8', new Knight($player2));
        $this->piece('C8', new Bishop($player2));
        $this->piece('D8', new Queen($player2));
        $this->piece('E8', new King($player2));
        $this->piece('F8', new Bishop($player2));
        $this->piece('G8', new Knight($player2));
        $this->piece('H8', new Rook($player2));
    }

    /**
     * Returns player
     * @return \Chess\Player
     */
    public function player($index)
    {
        return $this->players[$index];
    }

    /**
     * Returns list of players
     * @return array Returns array of \Chess\Player objects
     */
    public function players()
    {
        return $this->players;
    }

    /**
     * Gets, sets, or unsets piece for specified position
     * @param  string $position
     * @param  \Chess\Piece|null $piece Omit to just get piece. Pass null to unset piece.
     * @return \Chess\Piece|null|false Returns null if position is empty. Returns false if position invalid.
     */
    public function piece($position, \Chess\Piece $piece = null)
    {
        $files = str_split('ABCDEFGH');
        $ranks = str_split('12345678');
        list($file, $rank) = str_split($position);
        $valid = in_array($file, $files) && in_array($rank, $ranks);

        if (!$valid) {
            return false;
        }

        $args = func_get_args();
        if (count($args) === 1) {
            // get piece
            if (!array_key_exists($position, $this->pieces)) {
                return null;
            }
            return $this->pieces[$position];
        }

        if ($piece === null) {
            // remove piece
            if (array_key_exists($position, $this->pieces)) {
                unset($this->pieces[$position]);
            }
            return null;
        }

        // set piece
        $piece->board($this);
        $this->pieces[$position] = $piece;
        return $piece;
    }

    /**
     * Returns all the pieces on the board indexed by position
     * @return array
     */
    public function pieces()
    {
        return $this->pieces;
    }

    /**
     * Returns position of piece
     * @param  \Chess\Piece $piece
     * @return string|false
     */
    public function position(\Chess\Piece $piece)
    {
        foreach ($this->pieces() as $position => $boardPiece) {
            if ($piece === $boardPiece) {
                return $position;
            }
        }
        return false;
    }

    /**
     * Executes a move
     * @param \Chess\Move $move
     */
    public function move(\Chess\Move $move)
    {
        foreach ($move->changes() as $change) {
            list($position, $value) = $change;
            $this->piece($position, $value);
        }
        array_push($this->moves, $move);
    }

    /**
     * Undoes the last move in history
     */
    public function undo()
    {
        $move = array_pop($this->moves);
        foreach ($move->changes(true) as $change) {
            list($position, $value) = $change;
            $this->piece($position, $value);
        }
    }

    /**
     * Returns last move
     * @return \Chess\Move|false
     */
    public function getLastMove()
    {
        $key = count($this->moves) - 1;
        if (array_key_exists($key, $this->moves)) {
            return $this->moves[$key];
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
