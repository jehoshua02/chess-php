<?php

namespace Chess;

class Move
{
    /**
     * List of board changes
     * @var array
     */
    protected $changes = array();

    /**
     * List of board changes to undo move
     * @var array
     */
    protected $undo = array();

    /**
     * Piece to move
     * @var \Chess\Piece
     */
    protected $piece;

    /**
     * Position to move piece from
     * @var string
     */
    protected $from;

    /**
     * Position to move piece to
     * @var string
     */
    protected $to;

    /**
     * Construct method
     * @param \Chess\Piece $piece Piece to move
     * @param string $to Position to move to
     * @param array $changes, ... Additional board changes to include in move
     */
    public function __construct(\Chess\Piece $piece, $to, array $change = null)
    {
        $args = func_get_args();

        $this->piece = array_shift($args);
        $this->from = $this->piece->position();
        $this->to = array_shift($args);

        $changes = $args;
        array_unshift(
            $changes,
            array($this->from, null),
            array($this->to, $this->piece)
        );

        foreach ($changes as $change) {
            list($position, $value) = $change;
            $this->addChange($position, $value);
        }
    }

    /**
     * Returns list of board changes
     * @return array
     */
    public function changes()
    {
        return $this->changes;
    }

    /**
     * Returns list of board changes to undo
     * @return array
     */
    public function undo()
    {
        return $this->undo;
    }

    /**
     * Returns piece moved
     * @return \Chess\Piece
     */
    public function piece()
    {
        return $this->piece;
    }

    /**
     * Returns position to move from
     * @return string
     */
    public function from()
    {
        return $this->from;
    }

    /**
     * Returns position to move to
     * @return string
     */
    public function to()
    {
        return $this->to;
    }

    /**
     * Adds board change to move
     * @param string $position
     * @param \Chess\Piece|null $value
     */
    protected function addChange($position, $value)
    {
        array_push($this->changes, array($position, $value));
        array_unshift($this->undo, array($position, $this->piece->board()->piece($position)));
    }
}
