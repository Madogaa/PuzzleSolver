<?php

declare(strict_types=1);

namespace App;

final class PuzzleSolution
{
    private PuzzlePointer $puzzlePointer;
    private int $totalSolvedPieces = 0;
    /**
     * @param PuzzlePiece[][] $puzzleSolutionIndex
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
            $puzzleSolution = array_map(
                static fn (PuzzlePiece $puzzlePiece) => $puzzlePiece->id,
                $puzzleSolution
            );
            $puzzleSolutionIndexRows[] = implode(' ', $puzzleSolution);
        }

        return implode("\n", $puzzleSolutionIndexRows);
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

        return $this->puzzleSolutionIndex[$previousRow][$this->puzzlePointer->column()];
    }

    public function getPuzzleSolutionPreviousPiece(): ?PuzzlePiece
    {
        if ($this->puzzlePointer->isFirstColumn()) {
            return null;
        }

        return $this->puzzleSolutionIndex[$this->puzzlePointer->row()][$this->puzzlePointer->previousColumn()];
    }

    public function isSolved(): bool
    {
        return $this->totalSolvedPieces === $this->puzzleDimensions->width * $this->puzzleDimensions->heigh;
    }

    private function removePuzzleLastPiece(): void
    {
        $rowIndex = $this->puzzlePointer->isFirstColumn() ?
            $this->puzzlePointer->previousRow() :
            $this->puzzlePointer->row();

        array_pop($this->puzzleSolutionIndex[$rowIndex]);
        $this->puzzlePointer->back();
        --$this->totalSolvedPieces;
    }

    private function removePuzzleLastRow(): void
    {
        array_pop($this->puzzleSolutionIndex);
        $this->puzzlePointer->back();
        --$this->totalSolvedPieces;
    }

    private function addPuzzlePieceAtSameRow(PuzzlePiece $puzzlePiece): void
    {
        $this->puzzleSolutionIndex[$this->puzzlePointer->row()][] = $puzzlePiece;
        $this->puzzlePointer->next();
        ++$this->totalSolvedPieces;
    }

    private function addPuzzlePieceAtNewRow(PuzzlePiece $puzzlePiece): void
    {
        $this->puzzleSolutionIndex[][] = $puzzlePiece;
        $this->puzzlePointer->next();
        ++$this->totalSolvedPieces;
    }
}
