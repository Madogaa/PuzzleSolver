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

    public function addFirstPuzzlePiece(PuzzlePiece $puzzlePiece): void
    {
        $this->puzzleSolutionIndex[][] = $puzzlePiece->id;
        $this->puzzlePointer->init();
        ++$this->totalSolvedPieces;
    }

    public function addPuzzlePieceAtSameRow(PuzzlePiece $puzzlePiece): void
    {
        $this->puzzleSolutionIndex[$this->puzzlePointer->row()][] = $puzzlePiece->id;
        $this->puzzlePointer->moveRight();
        ++$this->totalSolvedPieces;
    }

    public function addPuzzlePieceAtNewRow(PuzzlePiece $puzzlePiece): void
    {
        $this->puzzleSolutionIndex[][] = $puzzlePiece->id;
        $this->puzzlePointer->moveRight();
        ++$this->totalSolvedPieces;
    }

    public function removePuzzleLastPiece(): void
    {
        if ($this->puzzlePointer->column() === 0) {
            $lastRowIndex = $this->puzzlePointer->row() - 1;
        } else {
            $lastRowIndex = $this->puzzlePointer->row();
        }
        $lastRow = &$this->puzzleSolutionIndex[$lastRowIndex];

        array_pop($lastRow);
        $this->puzzlePointer->moveLeft();
        --$this->totalSolvedPieces;
    }

    public function removePuzzleLastRow(): void
    {
        array_pop($this->puzzleSolutionIndex);
        $this->puzzlePointer->moveLeft();
        --$this->totalSolvedPieces;
    }

    public function solvedPiecesCount(): int
    {
        return $this->totalSolvedPieces;
    }

    public function removeFirstPuzzlePiece(): void
    {
        $this->puzzleSolutionIndex = [];
        $this->puzzlePointer->reset();
        --$this->totalSolvedPieces;
    }
}
