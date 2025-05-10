<?php

declare(strict_types=1);

namespace App\PuzzleSolver\PuzzleSolution;

use App\PuzzleSolver\PuzzlePiece\PuzzlePiece;

final class PuzzleSolution
{
    private PuzzlePointer $puzzlePointer;
    private int $totalSolvedPieces = 0;

    /**
     * @param PuzzlePiece[][] $puzzleSolution
     */
    public function __construct(public PuzzleDimensions $puzzleDimensions, public array $puzzleSolution = [])
    {
        $this->puzzlePointer = new PuzzlePointer($this->puzzleDimensions->width, $this->puzzleDimensions->heigh);
    }

    public static function format(self $puzzleSolution): string
    {
        foreach ($puzzleSolution->puzzleSolution as $puzzleSolutionRow) {
            $puzzleSolutionWithPuzzlePieceIds = array_map(static fn (PuzzlePiece $puzzlePiece) => $puzzlePiece->id, $puzzleSolutionRow);
            $puzzleSolutionRows[] = implode(' ', $puzzleSolutionWithPuzzlePieceIds);
        }

        return implode("\n", $puzzleSolutionRows);
    }

    public function addPuzzlePiece(PuzzlePiece $puzzlePiece): void
    {
        if ($this->puzzlePointer->column() === 0) {
            $this->addPuzzlePieceAtNewRow($puzzlePiece);
            return;
        }

        $this->addPuzzlePieceAtSameRow($puzzlePiece);
    }

    public function removePuzzlePiece(): void
    {
        if ($this->puzzlePointer->previousColumn() === 0) {
            $this->removePuzzleLastRow();
            return;
        }

        $this->removePuzzleLastPiece();
    }

    public function getTopPuzzlePiece(): ?PuzzlePiece
    {
        $previousRow = $this->puzzlePointer->previousRow();
        if ($previousRow === null) {
            return null;
        }

        return $this->puzzleSolution[$previousRow][$this->puzzlePointer->column()];
    }

    public function getPreviousPiece(): ?PuzzlePiece
    {
        if ($this->puzzlePointer->isFirstColumn()) {
            return null;
        }

        return $this->puzzleSolution[$this->puzzlePointer->row()][$this->puzzlePointer->previousColumn()];
    }

    public function isFirstPieceToBeSolved(): bool
    {
        return $this->puzzlePointer->isInitialPosition() === true;
    }

    public function isOneRowPuzzle(): bool
    {
        return $this->puzzleDimensions->heigh === 1;
    }

    public function isPieceToBeSolvedInFirstRow(): bool
    {
        return $this->puzzlePointer->isFirstRow() === true;
    }

    public function isPieceToBeSolvedInRightTopCorner(): bool
    {
        return $this->puzzlePointer->isFirstRow() && $this->puzzlePointer->isLastColumn();
    }

    public function isPieceToBeSolvedInFirstColumn(): bool
    {
        return $this->puzzlePointer->isFirstColumn() === true;
    }

    public function isPieceToBeSolvedLeftBottomCorner(): bool
    {
        return $this->puzzlePointer->isLastRow() && $this->puzzlePointer->isFirstColumn();
    }

    public function isPieceToBeSolvedRightBottomCorner(): bool
    {
        return $this->puzzlePointer->isLastRow() && $this->puzzlePointer->isLastColumn();
    }

    public function isPieceToBeSolvedInLastRow(): bool
    {
        return $this->puzzlePointer->isLastRow();
    }

    public function isSolved(): bool
    {
        return $this->totalSolvedPieces === $this->puzzleDimensions->width * $this->puzzleDimensions->heigh;
    }

    public function isPieceToBeSolvedInLastColumn(): bool
    {
        return $this->puzzlePointer->isLastColumn();
    }

    public function isOneColumnPuzzle(): bool
    {
        return $this->puzzleDimensions->width === 1;
    }

    private function addPuzzlePieceAtNewRow(PuzzlePiece $puzzlePiece): void
    {
        $this->puzzleSolution[][] = $puzzlePiece;
        $this->moveForwards();
    }

    private function addPuzzlePieceAtSameRow(PuzzlePiece $puzzlePiece): void
    {
        $this->puzzleSolution[$this->puzzlePointer->row()][] = $puzzlePiece;
        $this->moveForwards();
    }

    private function removePuzzleLastRow(): void
    {
        array_pop($this->puzzleSolution);
        $this->moveBackwards();
    }

    private function removePuzzleLastPiece(): void
    {
        $rowIndex = $this->puzzlePointer->isFirstColumn() ? $this->puzzlePointer->previousRow() : $this->puzzlePointer->row();
        array_pop($this->puzzleSolution[$rowIndex]);
        $this->moveBackwards();
    }

    private function moveForwards(): void
    {
        $this->puzzlePointer->moveNext();
        $this->increaseSolvedPiecesCounter();
    }

    private function increaseSolvedPiecesCounter(): void
    {
        ++$this->totalSolvedPieces;
    }

    private function moveBackwards(): void
    {
        $this->puzzlePointer->movePrevious();
        $this->decreaseSolvedPiecesCounter();
    }

    private function decreaseSolvedPiecesCounter(): void
    {
        --$this->totalSolvedPieces;
    }
}
