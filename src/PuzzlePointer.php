<?php

declare(strict_types=1);

namespace App;

final class PuzzlePointer
{
    private const int INDEX_OFFSET = 1;

    public function __construct(
        public readonly int $puzzleWidth,
        private int $row = 0,
        private int $column = 0
    ) {
    }

    public function next(): void
    {
        if ($this->hasReachedRightEnd()) {
            $this->startANewLine();
            return;
        }
        $this->moveRight();
    }

    public function back(): void
    {
        if ($this->hasReachedLeftEnd() && !$this->hasReachedTopEnd()) {
            $this->moveUp();
            return;
        }
        $this->moveLeft();
    }

    public function row(): int
    {
        return $this->row;
    }

    public function previousRow(): ?int
    {
        if ($this->hasReachedTopEnd()) {
            return null;
        }

        return $this->row - 1;
    }

    public function column(): int
    {
        return $this->column;
    }

    public function previousColumn(): ?int
    {
        if ($this->isFirstPosition()) {
            return null;
        }

        if ($this->isFirstColumn()) {
            return $this->puzzleWidth - self::INDEX_OFFSET;
        }

        return $this->column - 1;
    }

    public function isFirstColumn(): bool
    {
        return $this->column === 0;
    }

    private function isFirstPosition(): bool
    {
        return $this->hasReachedTopEnd() && $this->isFirstColumn();
    }

    private function moveToFirstColumn(): void
    {
        $this->column = 0;
    }

    private function moveRight(): void
    {
        ++$this->column;
    }

    private function hasReachedRightEnd(): bool
    {
        return $this->column === $this->puzzleWidth - self::INDEX_OFFSET;
    }

    private function startANewLine(): void
    {
        $this->moveOneRowDown();
        $this->moveToFirstColumn();
    }

    private function moveOneRowDown(): void
    {
        ++$this->row;
    }

    private function moveLeft(): void
    {
        --$this->column;
    }

    private function hasReachedLeftEnd(): bool
    {
        return $this->column === 0;
    }

    private function hasReachedTopEnd(): bool
    {
        return $this->row === 0;
    }

    private function moveUp(): void
    {
        $this->moveOneRowUp();
        $this->moveToLastColumn();
    }

    private function moveOneRowUp(): void
    {
        --$this->row;
    }

    private function moveToLastColumn(): void
    {
        $this->column = $this->puzzleWidth - self::INDEX_OFFSET;
    }
}
