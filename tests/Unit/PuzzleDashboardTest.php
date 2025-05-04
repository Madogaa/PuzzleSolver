<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\PuzzleDashboard;
use PHPUnit\Framework\TestCase;

class PuzzleDashboardTest extends TestCase
{
    public function test_it_can_puzzle_piece_be_added_when_first_puzzle_piece(): void
    {
        $puzzleContext = "1 3\n0 2 0 0\n0 1 0 2\n1 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $puzzlePiece = $puzzleDashboard->availablePuzzlePieces[0];

        $canPuzzlePieceBeAddedResult = $puzzleDashboard->canPuzzlePieceBeAdded($puzzlePiece);

        $this->assertTrue($canPuzzlePieceBeAddedResult);
    }

    public function test_it_can_puzzle_piece_be_added_when_matches_previous(): void
    {
        $puzzleContext = "1 3\n0 2 0 0\n0 1 0 2\n1 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPiece = $puzzleDashboard->availablePuzzlePieces[1];

        $puzzleDashboard->addPuzzlePiece($firstPiece);
        $canPuzzlePieceBeAddedResult = $puzzleDashboard->canPuzzlePieceBeAdded($secondPiece);

        $this->assertTrue($canPuzzlePieceBeAddedResult);
    }

    public function test_it_can_puzzle_piece_be_added_when_matches_top(): void
    {
        $puzzleContext = "3 1\n0 0 2 0\n2 0 1 0\n1 0 0 0";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPiece = $puzzleDashboard->availablePuzzlePieces[1];

        $puzzleDashboard->addPuzzlePiece($firstPiece);
        $canPuzzlePieceBeAddedResult = $puzzleDashboard->canPuzzlePieceBeAdded($secondPiece);

        $this->assertTrue($canPuzzlePieceBeAddedResult);
    }

    public function test_it_can_puzzle_piece_be_added_when_matches_top_and_previous(): void
    {
        $puzzleContext = "2 2\n0 2 4 0\n0 0 3 2\n4 1 0 0\n3 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPiece = $puzzleDashboard->availablePuzzlePieces[1];
        $thirdPiece = $puzzleDashboard->availablePuzzlePieces[2];
        $fourthPiece = $puzzleDashboard->availablePuzzlePieces[3];

        $puzzleDashboard->addPuzzlePiece($firstPiece);
        $puzzleDashboard->addPuzzlePiece($secondPiece);
        $puzzleDashboard->addPuzzlePiece($thirdPiece);
        $canPuzzlePieceBeAddedResult = $puzzleDashboard->canPuzzlePieceBeAdded($fourthPiece);

        $this->assertTrue($canPuzzlePieceBeAddedResult);
    }
}
