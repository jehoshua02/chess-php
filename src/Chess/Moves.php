<?php

namespace Chess;

class Moves
{
    /**
     * Holds list of moves
     * @var array Array of \Chess\Move objects
     */
    protected $moves = array();

    /**
     * Construct method
     * @param array $moves array of \Chess\Move objects
     */
    public function __construct(array $moves)
    {
        foreach ($moves as $move) {
            $this->addMove($move);
        }
    }

    /**
     * Filters moves based on some property
     * @param  string $property
     * @param  string $value
     * @return \Chess\Moves
     */
    public function filter($property, $value)
    {
        $moves = array_filter($this->moves, function ($move) use ($property, $value) {
            return $move->property($property) === $value;
        });

        return new Moves($moves);
    }

    /**
     * Adds move
     * @param \Chess\Move $move
     */
    protected function addMove(\Chess\Move $move)
    {
        $this->moves[] = $move;
    }
}
