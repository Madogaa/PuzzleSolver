<?php

declare(strict_types=1);

namespace App;

use function count;

final class PuzzleSolution
{
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
    }

    public function addPuzzlePieceAtNewRow(PuzzlePiece $puzzlePiece): void
    {
        $this->puzzleSolutionIndex[][] = $puzzlePiece->id;
    }

    public function removePuzzleLastPiece(): void
    {
        $lastRowIndex = count($this->puzzleSolutionIndex) - 1;

        if ($lastRowIndex < 0) {
            return;
        }

        $lastRow = &$this->puzzleSolutionIndex[$lastRowIndex];

        array_pop($lastRow);
        if (empty($lastRow)) {
            array_pop($this->puzzleSolutionIndex);
        }
    }

    public function solvedPiecesCount(): int
    {
        return array_reduce(
            $this->puzzleSolutionIndex,
            static fn (int $carry, array $row) => $carry + count($row),
            0
        );
    }
}
