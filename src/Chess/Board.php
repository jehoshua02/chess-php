<?php

namespace Chess;

class Board
{
    const WHITE_KING = 'WHITE_KING';
    const WHITE_QUEEN = 'WHITE_QUEEN';
    const WHITE_BISHOP = 'WHITE_BISHOP';
    const WHITE_KNIGHT = 'WHITE_KNIGHT';
    const WHITE_ROOK = 'WHITE_ROOK';
    const WHITE_PAWN = 'WHITE_PAWN';

    const BLACK_KING = 'BLACK_KING';
    const BLACK_QUEEN = 'BLACK_QUEEN';
    const BLACK_BISHOP = 'BLACK_BISHOP';
    const BLACK_KNIGHT = 'BLACK_KNIGHT';
    const BLACK_ROOK = 'BLACK_ROOK';
    const BLACK_PAWN = 'BLACK_PAWN';

    protected $positions = array(
        'A1' => self::WHITE_ROOK,
        'B1' => self::WHITE_KNIGHT,
        'C1' => self::WHITE_BISHOP,
        'D1' => self::WHITE_QUEEN,
        'E1' => self::WHITE_KING,
        'F1' => self::WHITE_BISHOP,
        'G1' => self::WHITE_KNIGHT,
        'H1' => self::WHITE_ROOK,

        'A2' => self::WHITE_PAWN,
        'B2' => self::WHITE_PAWN,
        'C2' => self::WHITE_PAWN,
        'D2' => self::WHITE_PAWN,
        'E2' => self::WHITE_PAWN,
        'F2' => self::WHITE_PAWN,
        'G2' => self::WHITE_PAWN,
        'H2' => self::WHITE_PAWN,

        'A7' => self::BLACK_PAWN,
        'B7' => self::BLACK_PAWN,
        'C7' => self::BLACK_PAWN,
        'D7' => self::BLACK_PAWN,
        'E7' => self::BLACK_PAWN,
        'F7' => self::BLACK_PAWN,
        'G7' => self::BLACK_PAWN,
        'H7' => self::BLACK_PAWN,

        'A8' => self::BLACK_ROOK,
        'B8' => self::BLACK_KNIGHT,
        'C8' => self::BLACK_BISHOP,
        'D8' => self::BLACK_KING,
        'E8' => self::BLACK_QUEEN,
        'F8' => self::BLACK_BISHOP,
        'G8' => self::BLACK_KNIGHT,
        'H8' => self::BLACK_ROOK,
    );

    /**
     * Construct method
     * @param array|null $positions Array of positions, where key is algebraic notation (A1 through H8), and value is the piece (Board::WHITE_PAWN)
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
