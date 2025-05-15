<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\PuzzleSolver\PuzzleDashboard;
use App\PuzzleSolver\PuzzlePiece\PuzzlePiece;
use App\PuzzleSolver\PuzzleSolution\PuzzleSolution;
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

        $canPuzzlePieceBeAddedResult = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $puzzlePiece);

        $this->assertTrue($canPuzzlePieceBeAddedResult);
    }

    public function test_it_cannot_puzzle_piece_be_added_when_first_puzzle_piece_and_borders_do_not_match(): void
    {
        $puzzleContext = "1 3\n0 2 0 1\n0 1 0 2\n1 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $puzzlePiece = $puzzleDashboard->availablePuzzlePieces[0];

        $canPuzzlePieceBeAddedResult = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $puzzlePiece);

        $this->assertFalse($canPuzzlePieceBeAddedResult);
    }

    public function test_it_can_puzzle_piece_be_added_when_matches_previous(): void
    {
        $puzzleContext = "1 3\n0 2 0 0\n0 1 0 2\n1 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPiece = $puzzleDashboard->availablePuzzlePieces[1];

        $puzzleDashboard->addPuzzlePiece($firstPiece);
        $canPuzzlePieceBeAddedResult = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $secondPiece);

        $this->assertTrue($canPuzzlePieceBeAddedResult);
    }

    public function test_it_can_puzzle_piece_be_added_when_matches_top(): void
    {
        $puzzleContext = "3 1\n0 0 2 0\n2 0 1 0\n1 0 0 0";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPiece = $puzzleDashboard->availablePuzzlePieces[1];

        $puzzleDashboard->addPuzzlePiece($firstPiece);
        $canPuzzlePieceBeAddedResult = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $secondPiece);

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
        $canPuzzlePieceBeAddedResult = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $fourthPiece);

        $this->assertTrue($canPuzzlePieceBeAddedResult);
    }

    public function test_it_first_row_puzzle_piece_can_be_added_when_matches_previous_and_has_top_border(): void
    {
        $puzzleContext = "1 3\n0 2 0 0\n0 2 0 1\n1 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPiece = $puzzleDashboard->availablePuzzlePieces[1];

        $puzzleDashboard->addPuzzlePiece($firstPiece);
        $canPuzzlePieceBeAddedResult = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $secondPiece);

        $this->assertTrue($canPuzzlePieceBeAddedResult);
    }

    public function test_it_first_row_puzzle_piece_can_not_be_added_when_matches_previous_and_has_top_border(): void
    {
        $puzzleContext = "1 3\n0 2 0 0\n1 1 0 2\n1 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPiece = $puzzleDashboard->availablePuzzlePieces[1];

        $puzzleDashboard->addPuzzlePiece($firstPiece);
        $canPuzzlePieceBeAddedResult = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $secondPiece);

        $this->assertFalse($canPuzzlePieceBeAddedResult);
    }

    public function test_it_first_column_puzzle_piece_can_be_added_when_matches_top_and_has_left_border(): void
    {
        $puzzleContext = "3 1\n0 0 2 0\n0 2 0 1\n1 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPiece = $puzzleDashboard->availablePuzzlePieces[1];

        $puzzleDashboard->addPuzzlePiece($firstPiece);
        $canPuzzlePieceBeAddedResult = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $secondPiece);

        $this->assertTrue($canPuzzlePieceBeAddedResult);
    }

    public function test_it_first_column_puzzle_piece_can_not_be_added_when_matches_top_and_has_left_border(): void
    {
        $puzzleContext = "3 1\n0 0 2 0\n1 2 0 1\n1 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPiece = $puzzleDashboard->availablePuzzlePieces[1];

        $puzzleDashboard->addPuzzlePiece($firstPiece);
        $canPuzzlePieceBeAddedResult = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $secondPiece);

        $this->assertFalse($canPuzzlePieceBeAddedResult);
    }

    public function test_it_can_not_puzzle_piece_be_added_when_is_not_right_top_corner(): void
    {
        $puzzleContext = "2 2\n0 2 4 0\n2 0 1 3\n4 1 0 0\n3 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPiece = $puzzleDashboard->availablePuzzlePieces[1];

        $puzzleDashboard->addPuzzlePiece($firstPiece);
        $canPuzzlePieceBeAddedResult = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $secondPiece);

        $this->assertFalse($canPuzzlePieceBeAddedResult);
    }

    public function test_it_can_puzzle_piece_be_added_when_is_right_top_corner(): void
    {
        $puzzleContext = "2 2\n0 2 4 0\n2 0 0 3\n4 1 0 0\n3 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPiece = $puzzleDashboard->availablePuzzlePieces[1];

        $puzzleDashboard->addPuzzlePiece($firstPiece);
        $canPuzzlePieceBeAddedResult = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $secondPiece);

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
        $canPuzzlePieceBeAddedResult = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $thirdPiece);

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
        $canPuzzlePieceBeAddedResult = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $thirdPiece);

        $this->assertTrue($canPuzzlePieceBeAddedResult);
    }

    public function test_it_cannot_add_one_row_puzzle_piece_when_solution_is_not_left_corner(): void
    {
        $puzzleContext = "1 3\n0 2 0 1\n0 1 0 2\n1 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $puzzlePiece = $puzzleDashboard->availablePuzzlePieces[0];

        $canPuzzlePieceBeAddedResult = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $puzzlePiece);

        $this->assertFalse($canPuzzlePieceBeAddedResult);
    }

    public function test_it_can_add_one_row_puzzle_piece_when_solution_is_left_corner(): void
    {
        $puzzleContext = "1 3\n0 2 0 0\n0 1 0 2\n1 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $puzzlePiece = $puzzleDashboard->availablePuzzlePieces[0];

        $canPuzzlePieceBeAddedResult = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $puzzlePiece);

        $this->assertTrue($canPuzzlePieceBeAddedResult);
    }

    public function test_it_cannot_add_one_row_puzzle_piece_when_solution_is_not_right_corner(): void
    {
        $puzzleContext = "1 3\n0 2 0 1\n0 1 0 2\n1 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPuzzlePiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPuzzlePiece = $puzzleDashboard->availablePuzzlePieces[1];
        $thirdPuzzlePiece = $puzzleDashboard->availablePuzzlePieces[2];

        $puzzleDashboard->addPuzzlePiece($firstPuzzlePiece);
        $puzzleDashboard->addPuzzlePiece($secondPuzzlePiece);
        $canPuzzlePieceBeAddedResult = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $thirdPuzzlePiece);

        $this->assertFalse($canPuzzlePieceBeAddedResult);
    }

    public function test_it_can_add_one_row_puzzle_piece_when_solution_is_right_corner(): void
    {
        $puzzleContext = "1 3\n0 2 0 1\n0 1 0 2\n0 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPuzzlePiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPuzzlePiece = $puzzleDashboard->availablePuzzlePieces[1];
        $thirdPuzzlePiece = $puzzleDashboard->availablePuzzlePieces[2];

        $puzzleDashboard->addPuzzlePiece($firstPuzzlePiece);
        $puzzleDashboard->addPuzzlePiece($secondPuzzlePiece);
        $canPuzzlePieceBeAddedResult = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $thirdPuzzlePiece);

        $this->assertTrue($canPuzzlePieceBeAddedResult);
    }

    public function test_it_cannot_add_middle_puzzle_piece_in_one_row_puzzle(): void
    {
        $puzzleContext = "1 3\n0 2 0 0\n1 1 0 2\n1 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPuzzlePiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPuzzlePiece = $puzzleDashboard->availablePuzzlePieces[1];

        $puzzleDashboard->addPuzzlePiece($firstPuzzlePiece);
        $canPuzzlePieceBeAddedResult = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $secondPuzzlePiece);

        $this->assertFalse($canPuzzlePieceBeAddedResult);
    }

    public function test_it_can_add_middle_puzzle_piece_in_one_row_puzzle(): void
    {
        $puzzleContext = "1 3\n0 2 0 0\n0 1 0 2\n1 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $firstPuzzlePiece = $puzzleDashboard->availablePuzzlePieces[0];
        $secondPuzzlePiece = $puzzleDashboard->availablePuzzlePieces[1];

        $puzzleDashboard->addPuzzlePiece($firstPuzzlePiece);
        $canPuzzlePieceBeAddedResult = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $secondPuzzlePiece);

        $this->assertTrue($canPuzzlePieceBeAddedResult);
    }

    public function test_it_cannot_add_middle_piece_in_last_row_of_two_by_three_puzzle(): void
    {
        $puzzleContext = "2 3\n0 2 0 0\n0 2 1 3\n1 0 0 0\n1 1 0 0\n1 1 2 3\n0 0 1 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $topLeftCornerPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $topMiddlePiece = $puzzleDashboard->availablePuzzlePieces[1];
        $topRightCornerPiece = $puzzleDashboard->availablePuzzlePieces[2];
        $leftBottomPiece = $puzzleDashboard->availablePuzzlePieces[3];
        $centerBottomPiece = $puzzleDashboard->availablePuzzlePieces[4];
        $puzzleDashboard->addPuzzlePiece($topLeftCornerPiece);
        $puzzleDashboard->addPuzzlePiece($topMiddlePiece);
        $puzzleDashboard->addPuzzlePiece($topRightCornerPiece);
        $puzzleDashboard->addPuzzlePiece($leftBottomPiece);

        $canBeAdded = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $centerBottomPiece);

        $this->assertFalse($canBeAdded);
    }


    public function test_it_can_add_middle_piece_in_last_row_of_two_by_three_puzzle(): void
    {
        $puzzleContext = "2 3\n0 2 0 0\n0 2 1 3\n1 0 0 0\n1 1 0 0\n1 1 2 0\n0 0 1 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $topLeftCornerPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $topMiddlePiece = $puzzleDashboard->availablePuzzlePieces[1];
        $topRightCornerPiece = $puzzleDashboard->availablePuzzlePieces[2];
        $leftBottomPiece = $puzzleDashboard->availablePuzzlePieces[3];
        $centerBottomPiece = $puzzleDashboard->availablePuzzlePieces[4];
        $puzzleDashboard->addPuzzlePiece($topLeftCornerPiece);
        $puzzleDashboard->addPuzzlePiece($topMiddlePiece);
        $puzzleDashboard->addPuzzlePiece($topRightCornerPiece);
        $puzzleDashboard->addPuzzlePiece($leftBottomPiece);

        $canBeAdded = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $centerBottomPiece);

        $this->assertTrue($canBeAdded);
    }

    public function test_it_cannot_add_bottom_right_corner_piece_in_two_by_two_puzzle(): void
    {
        $puzzleContext = "2 2\n0 2 0 0\n0 0 1 2\n2 1 0 0\n0 2 1 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $topLeftPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $topRightPiece = $puzzleDashboard->availablePuzzlePieces[1];
        $bottomLeftPiece = $puzzleDashboard->availablePuzzlePieces[2];
        $bottomRightPiece = $puzzleDashboard->availablePuzzlePieces[3];
        $puzzleDashboard->addPuzzlePiece($topLeftPiece);
        $puzzleDashboard->addPuzzlePiece($topRightPiece);
        $puzzleDashboard->addPuzzlePiece($bottomLeftPiece);

        $canBeAdded = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $bottomRightPiece);

        $this->assertFalse($canBeAdded);
    }

    public function test_it_can_add_bottom_right_corner_piece_in_two_by_two_puzzle(): void
    {
        $puzzleContext = "2 2\n0 2 0 0\n0 0 1 2\n2 1 0 0\n0 0 1 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $topLeftPiece = $puzzleDashboard->availablePuzzlePieces[0];
        $topRightPiece = $puzzleDashboard->availablePuzzlePieces[1];
        $bottomLeftPiece = $puzzleDashboard->availablePuzzlePieces[2];
        $bottomRightPiece = $puzzleDashboard->availablePuzzlePieces[3];
        $puzzleDashboard->addPuzzlePiece($topLeftPiece);
        $puzzleDashboard->addPuzzlePiece($topRightPiece);
        $puzzleDashboard->addPuzzlePiece($bottomLeftPiece);

        $canBeAdded = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $bottomRightPiece);

        $this->assertTrue($canBeAdded);
    }

    public function test_it_can_add_middle_right_piece_in_three_by_two_puzzle(): void
    {
        $puzzleContext = "3 2\n0 2 0 0\n0 0 1 2\n1 3 2 0\n1 3 1 0\n1 2 0 1\n0 0 2 2";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $middleRightPiece = $puzzleDashboard->availablePuzzlePieces[3];
        $puzzleDashboard->addPuzzlePiece($puzzleDashboard->availablePuzzlePieces[0]);
        $puzzleDashboard->addPuzzlePiece($puzzleDashboard->availablePuzzlePieces[1]);
        $puzzleDashboard->addPuzzlePiece($puzzleDashboard->availablePuzzlePieces[2]);

        $canBeAdded = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $middleRightPiece);

        $this->assertTrue($canBeAdded);
    }

    public function test_it_cannot_add_middle_right_piece_in_three_by_two_puzzle(): void
    {
        $puzzleContext = "3 2\n0 2 0 0\n0 0 1 2\n1 3 2 0\n1 3 1 4\n1 2 0 1\n0 0 2 2";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $middleRightPiece = $puzzleDashboard->availablePuzzlePieces[3];
        $puzzleDashboard->addPuzzlePiece($puzzleDashboard->availablePuzzlePieces[0]);
        $puzzleDashboard->addPuzzlePiece($puzzleDashboard->availablePuzzlePieces[1]);
        $puzzleDashboard->addPuzzlePiece($puzzleDashboard->availablePuzzlePieces[2]);

        $canBeAdded = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $middleRightPiece);

        $this->assertFalse($canBeAdded);
    }

    public function test_it_cannot_add_middle_piece_with_borders_in_three_by_three_puzzle(): void
    {
        $puzzleContext = "3 3\n0 2 0 0\n0 0 1 2\n1 3 2 0\n1 3 1 0\n3 0 2 1\n0 0 2 2\n1 3 1 4\n1 2 0 1\n0 0 2 2";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $middleRightPiece = $puzzleDashboard->availablePuzzlePieces[3];
        $puzzleDashboard->addPuzzlePiece($puzzleDashboard->availablePuzzlePieces[0]);
        $puzzleDashboard->addPuzzlePiece($puzzleDashboard->availablePuzzlePieces[1]);
        $puzzleDashboard->addPuzzlePiece($puzzleDashboard->availablePuzzlePieces[2]);

        $canBeAdded = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $middleRightPiece);

        $this->assertFalse($canBeAdded);
    }

    public function test_it_can_add_middle_piece_without_borders_in_three_by_three_puzzle(): void
    {
        $puzzleContext = "3 3\n0 2 0 0\n0 0 1 2\n1 3 2 0\n1 3 1 0\n3 1 2 1\n0 0 2 2\n1 3 1 4\n1 2 0 1\n0 0 2 2";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $middleRightPiece = $puzzleDashboard->availablePuzzlePieces[3];
        $puzzleDashboard->addPuzzlePiece($puzzleDashboard->availablePuzzlePieces[0]);
        $puzzleDashboard->addPuzzlePiece($puzzleDashboard->availablePuzzlePieces[1]);
        $puzzleDashboard->addPuzzlePiece($puzzleDashboard->availablePuzzlePieces[2]);

        $canBeAdded = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleDashboard->puzzleSolution, $middleRightPiece);

        $this->assertFalse($canBeAdded);
    }

    // TODO: Remove method, move rotating test cases to PuzzleSolverTests. Here should not have rotating logic test
    private function canPuzzlePieceBeAddedToSolutionRotating(PuzzleSolution $puzzleSolution, PuzzlePiece $puzzlePiece): bool
    {
        if ($this->puzzlePieceValidator->canPuzzlePieceBeAddedToSolution($puzzleSolution, $puzzlePiece)) {
            return true;
        }

        if ($puzzlePiece->getRotationsCount() <= PuzzlePiece::MAX_ROTATIONS) {
            $puzzlePiece->rotate();
            $canBeAdded = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleSolution, $puzzlePiece);
            if ($canBeAdded) {
                return true;
            }
        }

        return false;
    }
}
