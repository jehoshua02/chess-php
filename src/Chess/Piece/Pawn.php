<?php

namespace Chess\Piece;
use \Chess\Move;

class Pawn extends \Chess\Piece
{
    /**
     * Returns all possible moves
     * @return array Returns array of \Chess\Move objects
     */
    public function moves()
    {
        $moves = array_merge(
            $this->slide('up'),
            $this->slide('down'),
            array(
                $this->upLeft(),
                $this->upRight(),
                $this->downLeft(),
                $this->downRight()
            )
        );

        $moves = array_filter($moves, function ($move) {
            return $move !== false;
        });

        $moves = $this->filterCheckMoves($moves);

        return $moves;
    }

    /**
     * Returns possible moves in one direction
     * @return array Returns array of \Chess\Move objects
     */
    protected function slide($direction)
    {
        $moves = array();

        // dark cannot move up
        if ($direction === 'up' && $this->color() === self::DARK) {
            return $moves;
        }

        // light cannot move down
        if ($direction === 'down' && $this->color() === self::LIGHT) {
            return $moves;
        }

        // one
        $position = $this->board()->$direction($this->position());
        if ($this->board()->piece($position)) {
            return $moves;
        }

        $moves[] = new Move($this, $position);

        // two
        list($file, $rank) = str_split($this->position());
        if ($direction === 'up' && $rank != 2) {
            return $moves;
        }

        if ($direction === 'down' && $rank != 7) {
            return $moves;
        }

        $position = $this->board()->$direction($position);
        if ($this->board()->piece($position)) {
            return $moves;
        }

        $moves[] = new Move($this, $position);

        return $moves;
    }

    /**
     * Returns up left move
     * @return \Chess\Move|false Returns false if not valid move for piece
     */
    protected function upLeft()
    {
        if ($this->color() === self::DARK) {
            return false;
        }

        $upLeft = $this->board()->upLeft($this->position());
        if (!$upLeft) {
            return false;
        }

        $piece = $this->board()->piece($upLeft);
        if ($piece && $piece->color() !== $this->color()) {
            return new Move($this, $upLeft);
        }

        // en passant
        $left = $this->board()->left($this->position());
        if (!$left) {
            return false;
        }

        $piece = $this->board()->piece($left);
        if (!$piece || $piece->color() === $this->color()) {
            return false;
        }

        $move = $this->board()->getLastMove();
        if (!$move) {
            return false;
        }

        if ($move->piece() !== $piece) {
            return false;
        }

        $from = $this->board()->down($piece->position());
        $from = $this->board()->down($from);
        if ($move->from() === $from) {
            return false;
        }

        return new Move($this, $upLeft, array(array($piece->position(), null)));
    }

    /**
     * Returns up right move
     * @return \Chess\Move|false Returns false if not valid move for piece
     */
    protected function upRight()
    {
        if ($this->color() === self::DARK) {
            return false;
        }

        $upRight = $this->board()->upRight($this->position());
        if (!$upRight) {
            return false;
        }

        $piece = $this->board()->piece($upRight);
        if ($piece && $piece->color() !== $this->color()) {
            return new Move($this, $upRight);
        }

        // en passant
        $right = $this->board()->right($this->position());
        if (!$right) {
            return false;
        }

        $piece = $this->board()->piece($right);
        if (!$piece || $piece->color() === $this->color()) {
            return false;
        }

        $move = $this->board()->getLastMove();
        if (!$move) {
            return false;
        }

        if ($move->piece() !== $piece) {
            return false;
        }

        $from = $this->board()->down($piece->position());
        $from = $this->board()->down($from);
        if ($move->from() === $from) {
            return false;
        }

        return new Move($this, $upRight, array(array($piece->position(), null)));
    }

    /**
     * Returns down left move
     * @return \Chess\Move|false Returns false if not valid move for piece
     */
    protected function downLeft()
    {
        if ($this->color() === self::LIGHT) {
            return false;
        }

        $downLeft = $this->board()->downLeft($this->position());
        if (!$downLeft) {
            return false;
        }

        $piece = $this->board()->piece($downLeft);
        if ($piece && $piece->color() !== $this->color()) {
            return new Move($this, $downLeft);
        }

        // en passant
        $left = $this->board()->left($this->position());
        if (!$left) {
            return false;
        }

        $piece = $this->board()->piece($left);
        if (!$piece || $piece->color() === $this->color()) {
            return false;
        }

        $move = $this->board()->getLastMove();
        if (!$move) {
            return false;
        }

        if ($move->piece() !== $piece) {
            return false;
        }

        $from = $this->board()->down($piece->position());
        $from = $this->board()->down($from);
        if ($move->from() === $from) {
            return false;
        }

        return new Move($this, $downLeft, array(array($piece->position(), null)));
    }

    /**
     * Returns down right move
     * @return \Chess\Move|false Returns false if not valid move for piece
     */
    protected function downRight()
    {
        if ($this->color() === self::LIGHT) {
            return false;
        }

        $downRight = $this->board()->downRight($this->position());
        if (!$downRight) {
            return false;
        }

        $piece = $this->board()->piece($downRight);
        if ($piece && $piece->color() !== $this->color()) {
            return new Move($this, $downRight);
        }

        // en passant
        $right = $this->board()->right($this->position());
        if (!$right) {
            return false;
        }

        $piece = $this->board()->piece($right);
        if (!$piece || $piece->color() === $this->color()) {
            return false;
        }

        $move = $this->board()->getLastMove();
        if (!$move) {
            return false;
        }

        if ($move->piece() !== $piece) {
            return false;
        }

        $from = $this->board()->down($piece->position());
        $from = $this->board()->down($from);
        if ($move->from() === $from) {
            return false;
        }

        return new Move($this, $downRight, array(array($piece->position(), null)));
    }

}
