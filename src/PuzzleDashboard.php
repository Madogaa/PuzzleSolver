<?php

declare(strict_types=1);

namespace App;

use function array_filter;
use function array_slice;

final class PuzzleDashboard
{
    private const int PUZZLE_PIECES_INDEX_OFFSET = 1;

    /**
     * @param PuzzlePiece[] $availablePuzzlePieces
     */
    private function __construct(
        public array $availablePuzzlePieces,
        public readonly PuzzleSolution $puzzleSolution
    ) {
    }

    public static function parse(string $puzzleContext): self
    {
        $splitPuzzleContext = explode("\n", $puzzleContext);
        $puzzleMeasurements = $splitPuzzleContext[0];
        $splitPuzzleMeasurements = explode(' ', $puzzleMeasurements);
        $puzzleHeight = (int)$splitPuzzleMeasurements[0];
        $puzzleWidth = (int)$splitPuzzleMeasurements[1];
        $puzzlePieces = array_slice($splitPuzzleContext, 1);

        return new self(
            array_map(
                static fn (string $puzzlePieceAsString, int $puzzlePiecePosition) => PuzzlePiece::parse($puzzlePieceAsString, $puzzlePiecePosition + self::PUZZLE_PIECES_INDEX_OFFSET),
                $puzzlePieces,
                array_keys($puzzlePieces)
            ),
            new PuzzleSolution(
                new PuzzleDimensions($puzzleHeight, $puzzleWidth)
            )
        );
    }

    public function addPuzzlePiece(PuzzlePiece $puzzlePiece): void
    {
        $this->puzzleSolution->addPuzzlePiece($puzzlePiece);
        $this->availablePuzzlePieces = array_filter(
            $this->availablePuzzlePieces,
            static fn (PuzzlePiece $availablePuzzlePiece) => $availablePuzzlePiece->id !== $puzzlePiece->id
        );
    }

    public function removePuzzlePiece(PuzzlePiece $puzzlePiece): void
    {
        $this->puzzleSolution->removePuzzlePiece();
        $this->availablePuzzlePieces[] = $puzzlePiece;
    }

    public function canPuzzlePieceBeAddedWithRotations(PuzzlePiece $puzzlePiece): bool
    {
        if ($this->canPuzzlePieceBeAdded($puzzlePiece)) {
            return true;
        }

        if ($puzzlePiece->getRotationsCount() <= PuzzlePiece::MAX_ROTATIONS) {
            $puzzlePiece->rotate();
            $canBeAdded = $this->canPuzzlePieceBeAddedWithRotations($puzzlePiece);
            if ($canBeAdded) {
                return true;
            }
        }

        return false;
    }

    public function canPuzzlePieceBeAdded(PuzzlePiece $puzzlePiece): bool
    {
        $previousPuzzlePiece = $this->getPreviousPuzzlePiece();
        $topPuzzlePiece = $this->getTopPuzzlePiece();
        if (!$previousPuzzlePiece && !$topPuzzlePiece) {
            return true;
        }

        if (!$topPuzzlePiece && $previousPuzzlePiece->matchHorizontally($puzzlePiece)) {
            return true;
        }

        if (!$previousPuzzlePiece && $topPuzzlePiece->matchVertically($puzzlePiece)) {
            return true;
        }

        if (
            $previousPuzzlePiece
            && $topPuzzlePiece
            && $previousPuzzlePiece->matchHorizontally($puzzlePiece)
            && $topPuzzlePiece->matchVertically($puzzlePiece)
        ) {
            return true;
        }

        return false;
    }

    private function getPreviousPuzzlePiece(): ?PuzzlePiece
    {
        $previousPuzzlePieceId = $this->puzzleSolution->getPuzzleSolutionPreviousPiece();

        return $previousPuzzlePieceId !== null
            ? $previousPuzzlePieceId
            : null;
    }

    private function getTopPuzzlePiece(): ?PuzzlePiece
    {
        $topPuzzlePieceId = $this->puzzleSolution->getTopPuzzlePiece();

        return $topPuzzlePieceId !== null
            ? $topPuzzlePieceId
            : null;
    }
}
