<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\NoPuzzleSolutionException;
use App\PuzzleSolver;
use PHPUnit\Framework\TestCase;

class PuzzleSolverTest extends TestCase
{
    public function test_it_throws_exception_when_no_solution(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 1\n0 0 2 0\n1 0 0 0";

        $this->expectException(NoPuzzleSolutionException::class);
        $puzzleSolver->solve($puzzlePieces);
    }
    public function test_it_solves1x1_puzzle(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "1 1\n0 0 0 0";

        $puzzleSolution = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = '1';
        self::assertEquals($expectedPuzzleSolution, $puzzleSolution);
    }

    public function test_it_solves2x1_puzzle(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 1\n0 0 1 0\n1 0 0 0";

        $puzzleSolution = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "1\n2";
        self::assertEquals($expectedPuzzleSolution, $puzzleSolution);
    }

    public function test_it_solves2x1_puzzle_when_pieces_are_unordered(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 1\n1 0 0 0\n0 0 1 0";

        $puzzleSolution = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "2\n1";
        self::assertEquals($expectedPuzzleSolution, $puzzleSolution);
    }

    public function test_it_solves1x2_puzzle(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "1 2\n0 1 0 0\n0 0 0 1";

        $puzzleSolution = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = '1 2';
        self::assertEquals($expectedPuzzleSolution, $puzzleSolution);
    }

    public function test_it_solves1x2_puzzle_unordered(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "1 2\n0 0 0 1\n0 1 0 0";

        $puzzleSolution = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = '2 1';
        self::assertEquals($expectedPuzzleSolution, $puzzleSolution);
    }

    public function test_it_solves1x3_puzzle(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "1 3\n0 1 0 0\n0 2 0 1\n0 0 0 2";

        $puzzleSolution = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = '1 2 3';
        self::assertEquals($expectedPuzzleSolution, $puzzleSolution);
    }

    public function test_it_solves1x3_puzzle_with_pieces_unordered(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "1 3\n0 0 0 2\n0 1 0 0\n0 2 0 1";

        $puzzleSolution = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = '2 3 1';
        self::assertEquals($expectedPuzzleSolution, $puzzleSolution);
    }

    public function test_it_solves2x2_puzzle(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 2\n0 2 4 0\n0 0 3 2\n4 1 0 0\n3 0 0 1";

        $puzzleSolution = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "1 2\n3 4";
        self::assertEquals($expectedPuzzleSolution, $puzzleSolution);
    }

    public function test_it_solves2x2_puzzle_with_pieces_unordered(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 2\n0 0 3 2\n3 0 0 1\n4 1 0 0\n0 2 4 0";

        $puzzleSolution = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "4 1\n3 2";
        self::assertEquals($expectedPuzzleSolution, $puzzleSolution);
    }

    public function test_it_solves2x3_puzzle(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 3\n" .
            "0 1 2 0\n" .   // ID 1
            "0 3 4 1\n" .   // ID 2
            "0 0 1 3\n" .   // ID 3
            "2 2 3 0\n" .   // ID 4
            "4 1 1 2\n" .   // ID 5
            "1 0 3 1";      // ID 6

        $puzzleSolution = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "1 2 3\n4 5 6";
        self::assertEquals($expectedPuzzleSolution, $puzzleSolution);
    }

    public function test_it_solves3x3_puzzle(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "3 3\n0 1 2 0\n0 3 4 1\n0 0 1 3\n2 2 3 0\n4 1 1 2\n1 0 3 1\n3 3 0 0\n1 1 0 3\n3 0 0 1";

        $puzzleSolution = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "1 2 3\n4 5 6\n7 8 9";
        self::assertEquals($expectedPuzzleSolution, $puzzleSolution);
    }
}
