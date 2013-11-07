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
     * @param array $changes List of additional board changes to make
     */
    public function __construct(\Chess\Piece $piece, $to, array $changes = array())
    {
        $this->piece = $piece;
        $this->from = $piece->position();
        $this->to = $to;

        array_unshift(
            $changes,
            array($this->from, null),
            array($to, $piece)
        );

        $this->changes = $changes;
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
}
