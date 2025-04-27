<?php

declare(strict_types=1);

namespace App;

use function array_key_exists;
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

    public function addPuzzlePieceAtSameRow(PuzzlePiece $puzzlePiece): void
    {
        $this->puzzleSolutionIndex[0][] = $puzzlePiece->id;
    }

    public function addPuzzlePieceAtNewRow(PuzzlePiece $puzzlePiece): void
    {
        $this->puzzleSolutionIndex[][] = $puzzlePiece->id;
    }

    public function getPuzzleSolutionPreviousPieceId(): ?int
    {
        $lastRow = end($this->puzzleSolutionIndex);

        return end($lastRow) !== false ? end($lastRow) : null;
    }

    public function getTopPuzzlePieceIndex(bool $nextPieceStartsOnNewRow): ?int
    {
        $rowOffset = $nextPieceStartsOnNewRow ? 0 : 1;
        $puzzleCurrentRowIndex = count($this->puzzleSolutionIndex) - $rowOffset;

        if ($puzzleCurrentRowIndex === 0) {
            return null;
        }

        $puzzleCurrentRow = end($this->puzzleSolutionIndex);
        $puzzleCurrentColumnIndex = !$nextPieceStartsOnNewRow ? count($puzzleCurrentRow) : 0;
        $currentUpperRow = $this->puzzleSolutionIndex[$puzzleCurrentRowIndex - 1] ?? null;
        if ($currentUpperRow === null || !array_key_exists($puzzleCurrentColumnIndex, $currentUpperRow)) {
            return null;
        }

        return $currentUpperRow[$puzzleCurrentColumnIndex];
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
