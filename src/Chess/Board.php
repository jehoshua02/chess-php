<?php

namespace Chess;

class Board
{
    const LIGHT_KING = 'LIGHT_KING';
    const LIGHT_QUEEN = 'LIGHT_QUEEN';
    const LIGHT_BISHOP = 'LIGHT_BISHOP';
    const LIGHT_KNIGHT = 'LIGHT_KNIGHT';
    const LIGHT_ROOK = 'LIGHT_ROOK';
    const LIGHT_PAWN = 'LIGHT_PAWN';

    const DARK_KING = 'DARK_KING';
    const DARK_QUEEN = 'DARK_QUEEN';
    const DARK_BISHOP = 'DARK_BISHOP';
    const DARK_KNIGHT = 'DARK_KNIGHT';
    const DARK_ROOK = 'DARK_ROOK';
    const DARK_PAWN = 'DARK_PAWN';

    protected $positions = array(
        'A1' => self::LIGHT_ROOK,
        'B1' => self::LIGHT_KNIGHT,
        'C1' => self::LIGHT_BISHOP,
        'D1' => self::LIGHT_QUEEN,
        'E1' => self::LIGHT_KING,
        'F1' => self::LIGHT_BISHOP,
        'G1' => self::LIGHT_KNIGHT,
        'H1' => self::LIGHT_ROOK,

        'A2' => self::LIGHT_PAWN,
        'B2' => self::LIGHT_PAWN,
        'C2' => self::LIGHT_PAWN,
        'D2' => self::LIGHT_PAWN,
        'E2' => self::LIGHT_PAWN,
        'F2' => self::LIGHT_PAWN,
        'G2' => self::LIGHT_PAWN,
        'H2' => self::LIGHT_PAWN,

        'A7' => self::DARK_PAWN,
        'B7' => self::DARK_PAWN,
        'C7' => self::DARK_PAWN,
        'D7' => self::DARK_PAWN,
        'E7' => self::DARK_PAWN,
        'F7' => self::DARK_PAWN,
        'G7' => self::DARK_PAWN,
        'H7' => self::DARK_PAWN,

        'A8' => self::DARK_ROOK,
        'B8' => self::DARK_KNIGHT,
        'C8' => self::DARK_BISHOP,
        'D8' => self::DARK_KING,
        'E8' => self::DARK_QUEEN,
        'F8' => self::DARK_BISHOP,
        'G8' => self::DARK_KNIGHT,
        'H8' => self::DARK_ROOK,
    );

    /**
     * Construct method
     * @param array|null $positions Array of positions, where key is algebraic notation (A1 through H8), and value is the piece (Board::LIGHT_PAWN)
     */
    public function __construct(array $positions = null)
    {
        if ($positions !== null) {
            $this->positions = $positions;
        }
    }

    /**
     * Returns the piece type at specified position
     * @param  string $position Algebraic notation (A1 through H8)
     * @return string|false Returns false if position is empty
     */
    public function pieceAt($position)
    {
        return array_key_exists($position, $this->positions) ? $this->positions[$position] : false;
    }
}
