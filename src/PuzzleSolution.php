<?php

declare(strict_types=1);

namespace App;

use function count;

final class PuzzleSolution
{
    private int $totalSolvedPieces = 0;

    public PuzzlePointer $puzzlePointer;
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
        $this->puzzleSolutionIndex[$this->getNextRowPointerIndex()][] = $puzzlePiece->id;
        $this->puzzlePointer->moveRight();
        ++$this->totalSolvedPieces;
    }

    public function addPuzzlePieceAtNewRow(PuzzlePiece $puzzlePiece): void
    {
        $this->puzzleSolutionIndex[][] = $puzzlePiece->id;
        $this->puzzlePointer->moveDown();
        ++$this->totalSolvedPieces;
    }

    public function removePuzzleLastPiece(): void
    {
        $lastRowIndex = count($this->puzzleSolutionIndex) - 1;
        $lastRow = &$this->puzzleSolutionIndex[$lastRowIndex];

        array_pop($lastRow);
        $this->puzzlePointer->moveLeft();
        --$this->totalSolvedPieces;
    }

    public function removePuzzleLastRow(): void
    {
        array_pop($this->puzzleSolutionIndex);
        $this->puzzlePointer->moveUp();
        --$this->totalSolvedPieces;
    }

    public function solvedPiecesCount(): int
    {
        return $this->totalSolvedPieces;
    }

    public function getNextRowPointerIndex(): int
    {
        $isNewRow = $this->puzzlePointer->isNextPieceAtFirstColumn();
        $lastRowIndex = $this->puzzlePointer->row() - 1;
        $rowOffset = $isNewRow ? 1 : 0;
        return $lastRowIndex + $rowOffset;
    }

    public function getNextColumnPointerIndex(): int
    {
        $puzzleCurrentRow = $this->puzzlePointer->column();
        $isNewLine = $this->puzzlePointer->isNextPieceAtFirstColumn();
        return $isNewLine ? 0 : $puzzleCurrentRow + 1;
    }
}
