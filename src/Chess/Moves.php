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
     * Returns matching move
     * @param string $to
     * @param array $properties
     * @return \Chess\Move|false Returns false if no matching move
     * @throws \Exception If more than one matching move
     */
    public function match($to, array $properties = array())
    {
        $moves = $this->to($to, $properties);

        if ($moves->count() > 1) {
            throw new \Exception('Move than one matching move');
        }

        if ($moves->count() < 1) {
            return false;
        }

        $moves = $moves->raw();
        return array_shift($moves);
    }

    /**
     * Returns matching moves
     * @param  string $to
     * @param  array $properties Optionally filter by properties
     * @return \Chess\Moves Returns array of \Chess\Move objects
     */
    public function to($to, array $properties = array())
    {
        $moves = array_filter($this->moves, function ($move) use ($to, $properties) {
            if ($move->to() !== $to) {
                return false;
            }

            foreach ($properties as $name => $value) {
                if ($move->property($name) !== $value) {
                    return false;
                }
            }

            return true;
        });

        return new Moves($moves);
    }

    /**
     * Returns count of moves
     * @return int
     */
    public function count()
    {
        return count($this->moves);
    }

    /**
     * Returns raw array of moves
     * @return array Returns array of \Chess\Move objects
     */
    public function raw()
    {
        return $this->moves;
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
