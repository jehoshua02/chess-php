# TODO

### Check / Checkmate / Stalemate

+ Determine if King is in check
    + Board->pieces() returns array of pieces
        + Piece->king(): finds king of same color in Board->pieces()
            + Piece->check(): check if Piece->king()->position() is a possible move for each piece on the board

+ Determine if a move would put King into check
    + Piece->move: Move the piece, Piece->check(), undo move if in check.

+ King cannot move into check
    + Inherits Piece->move

+ Determine if King is in checkmate
    + Piece->checkmate(): Piece->check() && count(King->moves()) === 0

+ Determine what moves would remove King from check / Determine why the King is in check
+ No piece can move unless it removes King from check

+ Stalemate (King not in check and no possible moves; no possible way to put King into checkmate)

+ No piece can make a move if it would put King of the same color into check
    + Piece->move

### Castling

+ King should be able to castle
+ King should not be able to castle
+ King cannot castle when in check

## King

+ King should have no possible moves
+ King should have one possible move
+ King should have two possible moves
+ King should have three possible moves
+ King should have four possible moves
+ King should have five possible moves
+ King should have six possible moves
+ King should have seven possible moves
+ King should have eight possible moves: up, down, left, right, upLeft, upRight, downLeft, downRight



## General

+ King, Queen, Bishop, Knight, Rook
+ Movement history (at least enough to support capture en passant)
+ Pawn should be able to capture en passant
+ Game Runner/Engine (encapsulates board, pieces, players, turn order, history, etc, whatever, the "glue" of it all)
+ Presentation layer?
