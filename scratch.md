It seems the highest encapsulating object would be the "Game"

```php
$game = new \Chess\Game();
$game->play();
```

This is neat and clean looking, but how does it know how to interact with the user?

Perhaps extend the class ...

```php
$game = new \Chess\Http\Game();
$game->play();
```

Extending the class and overriding the play method might do the trick.
The play method would pull stuff out of the request, interpret user intent, interact with
the parent class, then return an http response.

The game state would also need to be loaded and saved between requests ...

```php
$game = \Chess\Http\Game::load();
$game->play();
$game->save();
```

Or maybe like this ...

```php
$game = new \Chess\Http\Game($_SESSION['game-data']);
$game->play();
$_SESSION['game-data'] = $game->data();
```

Or perhaps, this could be handled in the play method too. So we are back at ...

```php
$game = new \Chess\Http\Game();
$game->play();
```

What about Cli?

```php
$game = new \Chess\Cli\Game();
$game->play();
```

Looks the same really. Except the play method would now prompt the user for moves.

There's also no real saving or loading between requests. It would just be a loop.

The Cli play method would look like this ...

```php
public function play()
{
    while (true) {
        if ($this->isCheckmate()) {
            $this->checkmateMessage();
            break;
        }

        if ($this->isStalemate()) {
            $this->stalemateMessage();
            break;
        }

        $this->board()->print();
        $this->player()->move();
    }
}
```
