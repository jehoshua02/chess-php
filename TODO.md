# TODO

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

### Check / Checkmate / Stalemate

+ Determine if King is in check
+ Determine if a move would put King into check
+ King cannot move into check
+ Determine if King is in checkmate (all moves put into check and in check)
+ Determine what moves would remove King from check / Determine why the King is in check
+ No piece can move unless it removes King from check
+ Stalemate (King not in check and no possible moves; no possible way to put King into checkmate)
+ No piece can make a move if it would put King of the same color into check

### Castling

+ King should be able to castle
+ King should not be able to castle
+ King cannot castle when in check



## General

+ King, Queen, Bishop, Knight, Rook
+ Movement history (at least enough to support capture en passant)
+ Pawn should be able to capture en passant
+ Game Runner/Engine (encapsulates board, pieces, players, turn order, history, etc, whatever, the "glue" of it all)
+ Presentation layer?
