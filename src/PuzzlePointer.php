<?php

declare(strict_types=1);

namespace App;

final class PuzzlePointer
{
    public function __construct(
        public readonly int $puzzleWidth,
        public int $row = 0,
        public int $column = 0
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
}
