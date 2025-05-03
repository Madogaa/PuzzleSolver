<?php

declare(strict_types=1);

namespace App;

final class PuzzleSolution
{
    public PuzzlePointer $puzzlePointer;
    private int $totalSolvedPieces = 0;
    /**
     * @param int[][] $puzzleSolutionIndex
     */
    public function __construct(
        public PuzzleDimensions $puzzleDimensions,
        public array $puzzleSolutionIndex = []
    ) {
        $this->puzzlePointer = new PuzzlePointer($this->puzzleDimensions->width);
    }

    public static function format(?self $puzzleSolution): string
    {
        $puzzleSolutionIndex = $puzzleSolution->puzzleSolutionIndex;
        $puzzleSolutionIndexRows = [];
        foreach ($puzzleSolutionIndex as $puzzleSolution) {
            $puzzleSolutionIndexRows[] = implode(' ', $puzzleSolution);
        }

        return implode("\n", $puzzleSolutionIndexRows);
    }

    public function addPuzzlePieceAtSameRow(PuzzlePiece $puzzlePiece): void
    {
        $this->puzzleSolutionIndex[$this->puzzlePointer->row()][] = $puzzlePiece->id;
        $this->puzzlePointer->next();
        ++$this->totalSolvedPieces;
    }

    public function addPuzzlePieceAtNewRow(PuzzlePiece $puzzlePiece): void
    {
        $this->puzzleSolutionIndex[][] = $puzzlePiece->id;
        $this->puzzlePointer->next();
        ++$this->totalSolvedPieces;
    }

    public function removePuzzleLastPiece(): void
    {
        $isLastPieceOneRowBefore = $this->puzzlePointer->column() === 0;
        $rowOffset = $isLastPieceOneRowBefore ? -1 : 0;
        $lastRowIndex = $this->puzzlePointer->row() + $rowOffset;
        $lastRow = &$this->puzzleSolutionIndex[$lastRowIndex];

        array_pop($lastRow);
        $this->puzzlePointer->back();
        --$this->totalSolvedPieces;
    }

    public function removePuzzleLastRow(): void
    {
        array_pop($this->puzzleSolutionIndex);
        $this->puzzlePointer->back();
        --$this->totalSolvedPieces;
    }

    public function getTopPuzzlePieceId(): ?int
    {
        $puzzleCurrentRowIndex = $this->puzzlePointer->row() - 1;
        $currentUpperRow = $this->puzzleSolutionIndex[$puzzleCurrentRowIndex] ?? null;
        $puzzleCurrentColumnIndex = $this->puzzlePointer->column();

        return $currentUpperRow ? $currentUpperRow[$puzzleCurrentColumnIndex] : null;
    }

    public function isSolved(): bool
    {
        return $this->totalSolvedPieces === $this->puzzleDimensions->width * $this->puzzleDimensions->heigh;
    }
}
