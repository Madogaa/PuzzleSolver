<?php

declare(strict_types=1);

namespace App;

use function count;

final class PuzzleSolution
{
    private int $totalSolvedPieces = 0;
    /**
     * @param int[][] $puzzleSolutionIndex
     */
    public function __construct(
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

    public function addPuzzlePieceAtSameRow(PuzzlePiece $puzzlePiece, int $currentRow): void
    {
        $this->puzzleSolutionIndex[$currentRow][] = $puzzlePiece->id;
        ++$this->totalSolvedPieces;
    }

    public function addPuzzlePieceAtNewRow(PuzzlePiece $puzzlePiece): void
    {
        $this->puzzleSolutionIndex[][] = $puzzlePiece->id;
        ++$this->totalSolvedPieces;
    }

    public function removePuzzleLastPiece(): void
    {
        $lastRowIndex = count($this->puzzleSolutionIndex) - 1;
        $lastRow = &$this->puzzleSolutionIndex[$lastRowIndex];

        array_pop($lastRow);
        if (empty($lastRow)) {
            array_pop($this->puzzleSolutionIndex);
        }
        --$this->totalSolvedPieces;
    }

    public function solvedPiecesCount(): int
    {
        return $this->totalSolvedPieces;
    }
}
