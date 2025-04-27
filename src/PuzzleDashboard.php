<?php

declare(strict_types=1);

namespace App;

use function array_slice;

final readonly class PuzzleDashboard
{
    private const int PUZZLE_PIECES_INDEX_OFFSET = 1;

    /**
     * @param PuzzlePiece[] $puzzlePieces
     */
    private function __construct(
        public array $puzzlePieces,
        public PuzzleSolution $puzzleSolution,
        private int $heigh,
        private int $width
    ) {
    }

    public static function parse(string $puzzleContext): self
    {
        $splitPuzzleContext = explode("\n", $puzzleContext);
        $puzzleMeasurements = $splitPuzzleContext[0];
        $splitPuzzleMeasurements = explode(' ', $puzzleMeasurements);
        $puzzleHeight = (int) $splitPuzzleMeasurements[0];
        $puzzleWidth = (int) $splitPuzzleMeasurements[1];
        $puzzlePieces = array_slice($splitPuzzleContext, 1);

        return new self(
            array_map(
                static fn (string $puzzlePieceAsString, int $puzzlePiecePosition) => PuzzlePiece::parse($puzzlePieceAsString, $puzzlePiecePosition + self::PUZZLE_PIECES_INDEX_OFFSET),
                $puzzlePieces,
                array_keys($puzzlePieces)
            ),
            new PuzzleSolution(),
            $puzzleHeight,
            $puzzleWidth
        );
    }

    public function addPuzzlePiece(PuzzlePiece $puzzlePiece): void
    {
        $puzzleSolutionSolvedPiecesCount = $this->puzzleSolution->solvedPiecesCount();

        if ($puzzleSolutionSolvedPiecesCount % $this->width === 0) {
            $this->puzzleSolution->addPuzzlePieceAtNewRow($puzzlePiece);
        } else {
            $this->puzzleSolution->addPuzzlePieceAtSameRow($puzzlePiece);
        }
    }

    public function canPuzzlePieceBeAdded(PuzzlePiece $puzzlePiece): bool
    {
        if ($puzzlePiece->id === 1) {
            return true;
        }

        $previousPuzzlePiece = $this->getPreviousPuzzlePiece();
        if ($previousPuzzlePiece->matchHorizontally($puzzlePiece)) {
            return true;
        }

        $topPuzzlePiece = $this->getTopPuzzlePiece();
        if ($topPuzzlePiece->matchVertically($puzzlePiece)) {
            return true;
        }

        return false;
    }

    private function getPreviousPuzzlePiece(): ?PuzzlePiece
    {
        $previousPuzzlePieceId = $this->puzzleSolution->getPuzzleSolutionPreviousPieceId();
        $previousPuzzlePieceIndex = $previousPuzzlePieceId - self::PUZZLE_PIECES_INDEX_OFFSET;

        return $previousPuzzlePieceId !== null
            ? $this->puzzlePieces[$previousPuzzlePieceIndex]
            : null;
    }

    private function getTopPuzzlePiece(): ?PuzzlePiece
    {
        $hasToBeAddedToNewRow = $this->hasNextPieceBeAddedToNewRow();

        $topPuzzlePieceId = $this->puzzleSolution->getTopPuzzlePieceIndex($hasToBeAddedToNewRow);

        return $topPuzzlePieceId !== null
            ? $this->findPuzzlePieceById($topPuzzlePieceId)
            : null;
    }

    private function findPuzzlePieceById(int $puzzlePieceId): PuzzlePiece
    {
        $puzzlePiece = array_filter(
            $this->puzzlePieces,
            static fn (PuzzlePiece $puzzlePiece) => $puzzlePiece->id === $puzzlePieceId
        );

        return reset($puzzlePiece);
    }


    private function hasNextPieceBeAddedToNewRow(): bool
    {
        return $this->puzzleSolution->solvedPiecesCount() % $this->width === 0;
    }
}
