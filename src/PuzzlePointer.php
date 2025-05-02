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

    public function moveRight(): void
    {
        ++$this->column;
    }

    public function moveLeft(): void
    {
        --$this->column;
    }

    public function moveDown(): void
    {
        ++$this->row;
        $this->column = 0;
    }

    public function moveUp(): void
    {
        --$this->row;
        $this->column = $this->puzzleWidth - 1;
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
        return ($this->column() + 1) % $this->puzzleWidth === 0;
    }
}
