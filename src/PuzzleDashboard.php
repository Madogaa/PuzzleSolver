<?php

declare(strict_types=1);

namespace App;

use function array_slice;
use function count;

final class PuzzleDashboard
{
    private const int PUZZLE_PIECES_INDEX_OFFSET = 1;

    /** @var PuzzlePiece[] */
    public readonly array $puzzlePieces;

    /**
     * @param PuzzlePiece[] $availablePuzzlePieces
     */
    private function __construct(
        public array $availablePuzzlePieces,
        public readonly PuzzleSolution $puzzleSolution,
        private readonly int $heigh,
        private readonly int $width
    ) {
        $this->puzzlePieces = $availablePuzzlePieces;
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
            ),
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

        $this->availablePuzzlePieces = array_filter(
            $this->availablePuzzlePieces,
            static fn (PuzzlePiece $availablePuzzlePiece) => $availablePuzzlePiece->id !== $puzzlePiece->id
        );
    }

    public function removePuzzlePiece(PuzzlePiece $puzzlePiece): void
    {
        $solvedPiecesCountAfterDeleting = $this->puzzleSolution->solvedPiecesCount() - 1;

        if ($solvedPiecesCountAfterDeleting % $this->width === 0) {
            $this->puzzleSolution->removePuzzleLastRow();
        } else {
            $this->puzzleSolution->removePuzzleLastPiece();
        }

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

    public function isSolved(): bool
    {
        return $this->puzzleSolution->solvedPiecesCount() === $this->width * $this->heigh;
    }

    private function getPreviousPuzzlePiece(): ?PuzzlePiece
    {
        $previousPuzzlePieceId = $this->getPuzzleSolutionPreviousPieceId();

        return $previousPuzzlePieceId !== null
            ? $this->findPuzzlePieceById($previousPuzzlePieceId)
            : null;
    }

    private function getPuzzleSolutionPreviousPieceId(): ?int
    {
        if ($this->puzzleSolution->isNextPieceAtFirstColumn()) {
            return null;
        }

        $lastRow = end($this->puzzleSolution->puzzleSolutionIndex);
        if (!$lastRow) {
            return null;
        }

        $lastRowValue = end($lastRow);
        return $lastRowValue !== false ? $lastRowValue : null;
    }

    private function findPuzzlePieceById(int $puzzlePieceId): PuzzlePiece
    {
        $puzzlePiece = array_filter(
            $this->puzzlePieces,
            static fn (PuzzlePiece $puzzlePiece) => $puzzlePiece->id === $puzzlePieceId
        );

        return reset($puzzlePiece);
    }

    private function getTopPuzzlePiece(): ?PuzzlePiece
    {
        $topPuzzlePieceId = $this->getTopPuzzlePieceId();

        return $topPuzzlePieceId !== null
            ? $this->findPuzzlePieceById($topPuzzlePieceId)
            : null;
    }

    private function getTopPuzzlePieceId(): ?int
    {
        $puzzleCurrentRowIndex = $this->puzzleSolution->getNextRowPointerIndex();
        $currentUpperRow = $this->puzzleSolution->puzzleSolutionIndex[$puzzleCurrentRowIndex - 1] ?? null;
        $puzzleCurrentColumnIndex = $this->puzzleSolution->getNextColumnPointerIndex();

        return $currentUpperRow ? $currentUpperRow[$puzzleCurrentColumnIndex] : null;
    }
}
