<?php

declare(strict_types=1);

namespace App;

use function sprintf;

final readonly class PuzzlePiece
{
    public function __construct(
        public int $id,
        public int $top,
        public int $right,
        public int $bottom,
        public int $left
    ) {
    }

    public function __toString(): string
    {
        return sprintf(
            'Id[%s] %s %s %s %s',
            $this->id,
            $this->top,
            $this->right,
            $this->bottom,
            $this->left
        );
    }

    public static function parse(string $pieceAsString, int $piecePosition): self
    {
        $pieceShapes = explode(' ', $pieceAsString);
        return new self(
            $piecePosition,
            (int)$pieceShapes[0],
            (int)$pieceShapes[1],
            (int)$pieceShapes[2],
            (int)$pieceShapes[3]
        );
    }

    public function matchVertically(self $puzzlePiece): bool
    {
        return $this->bottom != 0 && $this->bottom == $puzzlePiece->top;
    }


    public function matchHorizontally(self $puzzlePiece): bool
    {
        return $this->right != 0 && $this->right == $puzzlePiece->left;
    }
}
