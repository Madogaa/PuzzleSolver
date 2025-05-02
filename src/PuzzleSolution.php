<?php

declare(strict_types=1);

namespace App;

use function count;

final class PuzzleSolution
{
    private int $totalSolvedPieces = 0;
    private int $currentRowIndex = 0;
    private int $currentColumnIndex = 0;
    /**
     * @param int[][] $puzzleSolutionIndex
     */
    public function __construct(
        public PuzzleDimensions $puzzleDimensions,
        public array $puzzleSolutionIndex = []
    ) {
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
        ++$this->currentColumnIndex;
        ++$this->totalSolvedPieces;
    }

    public function addPuzzlePieceAtNewRow(PuzzlePiece $puzzlePiece): void
    {
        $this->puzzleSolutionIndex[][] = $puzzlePiece->id;
        $this->currentColumnIndex = 0;
        ++$this->currentRowIndex;
        ++$this->totalSolvedPieces;
    }

    public function removePuzzleLastPiece(): void
    {
        $lastRowIndex = count($this->puzzleSolutionIndex) - 1;
        $lastRow = &$this->puzzleSolutionIndex[$lastRowIndex];

        array_pop($lastRow);
        --$this->currentColumnIndex;
        --$this->totalSolvedPieces;
    }

    public function removePuzzleLastRow(): void
    {
        array_pop($this->puzzleSolutionIndex);
        $this->currentColumnIndex = $this->puzzleDimensions->width - 1;
        --$this->currentRowIndex;
        --$this->totalSolvedPieces;
    }

    public function solvedPiecesCount(): int
    {
        return $this->totalSolvedPieces;
    }

    public function getNextRowPointerIndex(): int
    {
        $isNewRow = $this->isNextPieceAtFirstColumn();
        $lastRowIndex = $this->currentRowIndex - 1;
        $rowOffset = $isNewRow ? 1 : 0;
        return $lastRowIndex + $rowOffset;
    }

    public function getNextColumnPointerIndex(): int
    {
        $puzzleCurrentRow = $this->currentColumnIndex;
        $isNewLine = $this->isNextPieceAtFirstColumn();
        return $isNewLine ? 0 : $puzzleCurrentRow + 1;
    }

    private function isNextPieceAtFirstColumn(): bool
    {
        return $this->solvedPiecesCount() % $this->puzzleDimensions->width === 0;
    }
}
