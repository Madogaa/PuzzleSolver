<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\PuzzleSolver\PuzzleDashboard;
use App\PuzzleSolver\PuzzleValidator\PuzzlePieceValidator;
use PHPUnit\Framework\TestCase;

class PuzzlePieceValidatorTest extends TestCase
{
    private PuzzlePieceValidator $puzzlePieceValidator;

    protected function setUp(): void
    {
        $this->puzzlePieceValidator = new PuzzlePieceValidator();
    }


    public function test_it_can_puzzle_piece_be_added_when_first_puzzle_piece(): void
    {
        $puzzleContext = "1 3\n0 2 0 0\n0 1 0 2\n1 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $puzzlePiece = $puzzleDashboard->availablePuzzlePieces[0];

        $canPuzzlePieceBeAddedResult = $this->puzzlePieceValidator->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $puzzlePiece);

        $this->assertTrue($canPuzzlePieceBeAddedResult);
    }

    public function test_it_cannot_puzzle_piece_be_added_when_first_puzzle_piece_and_borders_do_not_match(): void
    {
        $puzzleContext = "1 3\n0 2 0 1\n0 1 0 2\n1 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $puzzlePiece = $puzzleDashboard->availablePuzzlePieces[0];

        $canPuzzlePieceBeAddedResult = $this->puzzlePieceValidator->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $puzzlePiece);

        $this->assertFalse($canPuzzlePieceBeAddedResult);
    }

    public function test_it_can_puzzle_piece_be_added_when_matches_previous(): void
    {
        $puzzleContext = "1 3\n0 2 0 0\n0 1 0 2\n1 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPiece = $puzzleDashboard->availablePuzzlePieces[1];

        $puzzleDashboard->addPuzzlePiece($firstPiece);
        $canPuzzlePieceBeAddedResult = $this->puzzlePieceValidator->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $secondPiece);

        $this->assertTrue($canPuzzlePieceBeAddedResult);
    }

    public function test_it_can_puzzle_piece_be_added_when_matches_top(): void
    {
        $puzzleContext = "3 1\n0 0 2 0\n2 0 1 0\n1 0 0 0";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPiece = $puzzleDashboard->availablePuzzlePieces[1];

        $puzzleDashboard->addPuzzlePiece($firstPiece);
        $canPuzzlePieceBeAddedResult = $this->puzzlePieceValidator->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $secondPiece);

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
        $canPuzzlePieceBeAddedResult = $this->puzzlePieceValidator->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $fourthPiece);

        $this->assertTrue($canPuzzlePieceBeAddedResult);
    }

    public function test_it_first_row_puzzle_piece_can_be_added_when_matches_previous_and_has_top_border(): void
    {
        $puzzleContext = "1 3\n0 2 0 0\n1 2 0 1\n1 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPiece = $puzzleDashboard->availablePuzzlePieces[1];

        $puzzleDashboard->addPuzzlePiece($firstPiece);
        $canPuzzlePieceBeAddedResult = $this->puzzlePieceValidator->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $secondPiece);

        $this->assertTrue($canPuzzlePieceBeAddedResult);
    }

    public function test_it_first_row_puzzle_piece_can_not_be_added_when_matches_previous_and_has_top_border(): void
    {
        $puzzleContext = "1 3\n0 2 0 0\n1 1 0 2\n1 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPiece = $puzzleDashboard->availablePuzzlePieces[1];

        $puzzleDashboard->addPuzzlePiece($firstPiece);
        $canPuzzlePieceBeAddedResult = $this->puzzlePieceValidator->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $secondPiece);

        $this->assertFalse($canPuzzlePieceBeAddedResult);
    }

    public function test_it_first_column_puzzle_piece_can_be_added_when_matches_top_and_has_left_border(): void
    {
        $puzzleContext = "3 1\n0 0 2 0\n0 2 0 1\n1 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPiece = $puzzleDashboard->availablePuzzlePieces[1];

        $puzzleDashboard->addPuzzlePiece($firstPiece);
        $canPuzzlePieceBeAddedResult = $this->puzzlePieceValidator->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $secondPiece);

        $this->assertTrue($canPuzzlePieceBeAddedResult);
    }

    public function test_it_first_column_puzzle_piece_can_not_be_added_when_matches_top_and_has_left_border(): void
    {
        $puzzleContext = "3 1\n0 0 2 0\n1 2 0 1\n1 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPiece = $puzzleDashboard->availablePuzzlePieces[1];

        $puzzleDashboard->addPuzzlePiece($firstPiece);
        $canPuzzlePieceBeAddedResult = $this->puzzlePieceValidator->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $secondPiece);

        $this->assertFalse($canPuzzlePieceBeAddedResult);
    }

    public function test_it_can_not_puzzle_piece_be_added_when_is_not_right_top_corner(): void
    {
        $puzzleContext = "2 2\n0 2 4 0\n2 0 1 3\n4 1 0 0\n3 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPiece = $puzzleDashboard->availablePuzzlePieces[1];

        $puzzleDashboard->addPuzzlePiece($firstPiece);
        $canPuzzlePieceBeAddedResult = $this->puzzlePieceValidator->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $secondPiece);

        $this->assertFalse($canPuzzlePieceBeAddedResult);
    }

    public function test_it_can_puzzle_piece_be_added_when_is_right_top_corner(): void
    {
        $puzzleContext = "2 2\n0 2 4 0\n2 0 0 3\n4 1 0 0\n3 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPiece = $puzzleDashboard->availablePuzzlePieces[1];

        $puzzleDashboard->addPuzzlePiece($firstPiece);
        $canPuzzlePieceBeAddedResult = $this->puzzlePieceValidator->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $secondPiece);

        $this->assertTrue($canPuzzlePieceBeAddedResult);
    }

    public function test_it_can_not_puzzle_piece_be_added_when_is_not_left_bottom_corner(): void
    {
        $puzzleContext = "2 2\n0 2 4 0\n0 0 3 2\n4 1 0 1\n3 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPiece = $puzzleDashboard->availablePuzzlePieces[1];
        $thirdPiece = $puzzleDashboard->availablePuzzlePieces[2];

        $puzzleDashboard->addPuzzlePiece($firstPiece);
        $puzzleDashboard->addPuzzlePiece($secondPiece);
        $canPuzzlePieceBeAddedResult = $this->puzzlePieceValidator->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $thirdPiece);

        $this->assertFalse($canPuzzlePieceBeAddedResult);
    }

    public function test_it_can_puzzle_piece_be_added_when_is_left_bottom_corner(): void
    {
        $puzzleContext = "2 2\n0 2 4 0\n0 0 3 2\n4 1 0 0\n3 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPiece = $puzzleDashboard->availablePuzzlePieces[1];
        $thirdPiece = $puzzleDashboard->availablePuzzlePieces[2];

        $puzzleDashboard->addPuzzlePiece($firstPiece);
        $puzzleDashboard->addPuzzlePiece($secondPiece);
        $canPuzzlePieceBeAddedResult = $this->puzzlePieceValidator->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $thirdPiece);

        $this->assertTrue($canPuzzlePieceBeAddedResult);
    }
}
