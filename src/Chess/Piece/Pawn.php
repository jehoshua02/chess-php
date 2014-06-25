<?php

namespace Chess\Piece;
use \Chess\Move;
use \Chess\Moves;

class Pawn extends \Chess\Piece
{
    /**
     * Returns possible moves
     * @return \Chess\Moves
     */
    public function moves()
    {
        $moves = array_merge(
            $this->forward(),
            $this->diagonal('left'),
            $this->diagonal('right')
        );

        $moves = $this->filterCheckMoves($moves);

        return new Moves($moves);
    }

    /**
     * Returns possible moves in one direction
     * @return array Returns array of \Chess\Move objects
     */
    protected function forward()
    {
        $direction = $this->direction();

        $moves = array();

        // one
        $position = $this->board()->$direction($this->position());
        if ($this->board()->piece($position)) {
            return $moves;
        }

        $moves = array_merge($moves, $this->makeMoves($position));

        // two
        if (!$this->canMoveTwo()) {
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
     * Returns forward diagonal moves to side specified
     * @param string $side
     * @return array Returns array of \Chess\Move objects
     */
    protected function diagonal($side)
    {
        $direction = $this->direction() . ucfirst($side);

        $moves = array();

        $diagonal = $this->board()->$direction($this->position());
        if (!$diagonal) {
            return $moves;
        }

        $piece = $this->board()->piece($diagonal);
        if ($piece && $piece->player() !== $this->player()) {
            $moves = array_merge($moves, $this->makeMoves($diagonal));
            return $moves;
        }

        // en passant
        $side = $this->board()->$side($this->position());

        $piece = $this->board()->piece($side);
        if (!$piece || $piece->player() === $this->player()) {
            return $moves;
        }

        $move = $this->board()->getLastMove();
        if (!$move) {
            return $moves;
        }

        if ($move->piece() !== $piece) {
            return $moves;
        }

        $forward = $this->direction();
        $from = $this->board()->$forward($piece->position());
        $from = $this->board()->$forward($from);
        if ($move->from() !== $from) {
            return $moves;
        }

        $moves[] = new Move($this, $diagonal, array(array($piece->position(), null)));
        return $moves;
    }

    /**
     * Returns forward direction
     * @return string
     */
    protected function direction()
    {
        $direction = array(
            0 => 'up',
            1 => 'down'
        );
        foreach ($this->board()->players() as $index => $player) {
            if ($player === $this->player()) {
                break;
            }
        }
        return $direction[$index];
    }

    /**
     * Determines if pawn can move two spaces
     * @return boolean
     */
    protected function canMoveTwo()
    {
        $startRanks = array(
            self::LIGHT => 2,
            self::DARK => 7
        );
        $startRank = $startRanks[$this->player()];
        list($file, $rank) = $this->position();
        return $rank == $startRank;
    }

    /**
     * Makes moves for specified position
     * @param  string $position
     * @return array Returns array of \Chess\Move objects
     */
    protected function makeMoves($position)
    {
        $moves = array();
        if ($this->isPromotion($position)) {
            foreach (array('Queen', 'Bishop', 'Knight', 'Rook') as $promotion) {
                $moves[] = $this->makePromotionMove($position, $promotion);
            }
        } else {
            $moves[] = new Move($this, $position);
        }
        return $moves;
    }

    /**
     * Determines if position is promotion
     * @param string $position
     * @return boolean
     */
    protected function isPromotion($position)
    {
        $promotionRanks = array(
            self::LIGHT => 8,
            self::DARK => 1
        );
        $promoteRank = $promotionRanks[$this->player()];
        list($file, $rank) = $position;
        return $rank == $promoteRank;
    }

    /**
     * Creates a promotion move
     * @param  string $position
     * @param  string $promotion
     * @return \Chess\Move
     */
    protected function makePromotionMove($position, $promotion)
    {
        $class = sprintf('\\Chess\\Piece\\%s', $promotion);
        $piece = new $class($this->player());
        $changes = array(array($position, $piece));
        $properties = array('promote' => $promotion);
        return new Move($this, $position, $changes, $properties);
    }
}
