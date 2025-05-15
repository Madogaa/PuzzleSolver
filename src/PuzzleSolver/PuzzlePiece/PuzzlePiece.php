<?php

declare(strict_types=1);

namespace App\PuzzleSolver\PuzzlePiece;

use function sprintf;

final class PuzzlePiece
{
    public const int MAX_ROTATIONS = 3;

    private const int PUZZLE_PIECES_INDEX_OFFSET = 1;

    public int $rotationsCount = 0;

    public function __construct(
        public readonly int $id,
        public int $top,
        public int $right,
        public int $bottom,
        public int $left
    ) {
    }

    public function __toString(): string
    {
        return sprintf(
            'Id[%s] %s %s %s %s Rotations[%s]',
            $this->id,
            $this->top,
            $this->right,
            $this->bottom,
            $this->left,
            $this->rotationsCount
        );
    }

    public static function parse(string $pieceAsString, int $piecePosition): self
    {
        $pieceShapes = explode(' ', $pieceAsString);
        return new self(
            $piecePosition + self::PUZZLE_PIECES_INDEX_OFFSET,
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

    public function rotate(): void
    {
        [$this->top, $this->right, $this->bottom, $this->left] = [$this->left, $this->top, $this->right, $this->bottom];
        ++$this->rotationsCount;
    }

    public function getRotationsCount(): int
    {
        return $this->rotationsCount;
    }

    public function hasTopBorder(): bool
    {
        return $this->top === 0;
    }

    public function hasLeftBorder(): bool
    {
        return $this->left === 0;
    }

    public function hasRightBorder(): bool
    {
        return $this->right === 0;
    }

    public function hasBottomBorder(): bool
    {
        return $this->bottom === 0;
    }

    public function resetRotation(): void
    {
        while ($this->rotationsCount != 0) {
            $this->rotateBack();
        }
    }

    private function rotateBack(): void
    {
        [$this->top, $this->right, $this->bottom, $this->left] = [$this->right, $this->bottom, $this->left, $this->top];
        --$this->rotationsCount;
    }
}
