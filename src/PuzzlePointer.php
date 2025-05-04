<?php

declare(strict_types=1);

namespace App;

final class PuzzlePointer
{
    private const int INDEX_OFFSET = 1;

    public function __construct(
        private readonly int $puzzleWidth,
        private int $row = 0,
        private int $column = 0
    ) {
    }

    public function moveNext(): void
    {
        if ($this->isLastColumn()) {
            $this->moveToNextRow();
            return;
        }
        $this->moveRight();
    }

    public function movePrevious(): void
    {
        if ($this->isFirstColumn() && !$this->isFirstRow()) {
            $this->moveToUpperRow();
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
        if ($this->isFirstRow()) {
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
        if ($this->isInitialPosition()) {
            return null;
        }

        if ($this->isFirstColumn()) {
            return $this->lastColumn();
        }

        return $this->column - 1;
    }

    public function isFirstColumn(): bool
    {
        return $this->column === 0;
    }

    private function isInitialPosition(): bool
    {
        return $this->isFirstRow() && $this->isFirstColumn();
    }

    private function moveToFirstColumn(): void
    {
        $this->column = 0;
    }

    private function moveRight(): void
    {
        ++$this->column;
    }

    private function isLastColumn(): bool
    {
        return $this->column === $this->lastColumn();
    }

    private function moveToNextRow(): void
    {
        $this->moveDown();
        $this->moveToFirstColumn();
    }

    private function moveDown(): void
    {
        ++$this->row;
    }

    private function moveLeft(): void
    {
        --$this->column;
    }

    private function isFirstRow(): bool
    {
        return $this->row === 0;
    }

    private function moveToUpperRow(): void
    {
        $this->moveUp();
        $this->moveToLastColumn();
    }

    private function moveUp(): void
    {
        --$this->row;
    }

    private function moveToLastColumn(): void
    {
        $this->column = $this->lastColumn();
    }

    private function lastColumn(): int
    {
        return $this->puzzleWidth - self::INDEX_OFFSET;
    }
}
