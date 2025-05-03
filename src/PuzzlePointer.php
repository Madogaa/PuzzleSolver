<?php

declare(strict_types=1);

namespace App;

final class PuzzlePointer
{
    private const int POINTER_INDEX_OFFSET = 1;
    public function __construct(
        public readonly int $puzzleWidth,
        private int $row = 0,
        private int $column = 0
    ) {
    }

    public function reset(): void
    {
        $this->row = 0;
        $this->column = 0;
    }

    public function init(): void
    {
        $this->moveRight();
    }

    public function moveRight(): void
    {
        ++$this->column;
        if ($this->column === $this->puzzleWidth) {
            $this->moveDown();
        }
    }

    public function moveLeft(): void
    {
        --$this->column;
        if ($this->column < 0) {
            $this->moveUp();
        }
    }

    public function moveDown(): void
    {
        ++$this->row;
        $this->column = 0;
    }

    public function moveUp(): void
    {
        --$this->row;
        $this->column = $this->puzzleWidth - self::POINTER_INDEX_OFFSET;
    }

    public function row(): int
    {
        return $this->row;
    }

    public function column(): int
    {
        return $this->column;
    }

    public function isNextPieceAtFirstColumn(): bool
    {
        return ($this->column()) % $this->puzzleWidth === 0;
    }
}
