<?php

declare(strict_types=1);

namespace App;

use function count;
use function in_array;

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

    public function removePuzzlePieceById(int $puzzlePieceId): void
    {
        $this->puzzleSolutionIndex = array_filter(
            $this->puzzleSolutionIndex,
            static fn (array $row) => !in_array($puzzlePieceId, $row)
        );
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
