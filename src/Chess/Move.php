<?php

namespace Chess;

class Move
{
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
     * List of board changes
     * @var array
     */
    protected $changes = array(
        'do' => array(),
        'undo' => array()
    );

    /**
     * Holds properties used for move filtering
     * @var array
     */
    protected $properties = array();

    /**
     * Construct method
     * @param \Chess\Piece $piece Piece to move
     * @param string $to Position to move to
     * @param array $changes Additional board changes to include in move
     * @param array $properties Properties used for move filtering (ex. array('promote' => 'Queen'))
     */
    public function __construct(\Chess\Piece $piece, $to, array $changes = array(), array $properties = array())
    {
        $this->piece = $piece;
        $this->from = $this->piece->position();
        $this->to = $to;

        $this->addChange($this->from, null);
        $this->addChange($this->to, $piece);
        foreach ($changes as $change) {
            list($position, $value) = $change;
            $this->addChange($position, $value);
        }

        foreach ($properties as $property => $value) {
            $this->addProperty($property, $value);
        }
    }

    /**
     * Returns list of board changes
     * @return array
     */
    public function changes($undo = false)
    {
        $key = ($undo) ? 'undo' : 'do';
        return $this->changes[$key];
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
     * Returns property value
     * @param  string $name
     * @return mixed|null Returns null if property not set
     */
    public function property($name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }
        return null;
    }

    /**
     * Returns properties for this move
     * @return array
     */
    public function properties()
    {
        return $this->properties;
    }

    /**
     * Adds board change to move
     * @param string $position
     * @param \Chess\Piece|null $value
     */
    protected function addChange($position, $value)
    {
        array_push($this->changes['do'], array($position, $value));
        array_unshift($this->changes['undo'], array($position, $this->piece->board()->piece($position)));
    }

    /**
     * Add property to move used for move filtering
     * @param string $name
     * @param mixed $value
     */
    protected function addProperty($name, $value)
    {
        $this->properties[$name] = $value;
    }
}
