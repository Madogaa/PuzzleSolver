<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\PuzzleSolver\PuzzleSolution\NoPuzzleSolutionException;
use App\PuzzleSolver\PuzzleSolver;
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

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = '1';
        self::assertEquals($expectedPuzzleSolution, $puzzleSolutions[0]);
    }

    public function test_it_solves2x1_puzzle(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 1\n0 0 1 0\n1 0 0 0";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "1\n2";
        self::assertEquals($expectedPuzzleSolution, $puzzleSolutions[0]);
    }

    public function test_it_solves2x1_puzzle_when_pieces_are_unordered(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 1\n1 0 0 0\n0 0 1 0";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "2\n1";
        self::assertEquals($expectedPuzzleSolution, $puzzleSolutions[0]);
    }

    public function test_it_solves2x1_puzzle_when_pieces_are_unordered_and_rotated(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 1\n0 0 1 0\n0 0 0 1";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "1\n2";
        self::assertEquals($expectedPuzzleSolution, $puzzleSolutions[0]);
    }

    public function test_it_solves1x2_puzzle(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "1 2\n0 1 0 0\n0 0 0 1";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = '1 2';
        self::assertEquals($expectedPuzzleSolution, $puzzleSolutions[0]);
    }

    public function test_it_solves1x2_puzzle_unordered(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "1 2\n0 0 0 1\n0 1 0 0";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = '1 2';
        $expectedPuzzleSolution1 = '2 1';
        self::assertEquals($expectedPuzzleSolution, $puzzleSolutions[0]);
        self::assertEquals($expectedPuzzleSolution1, $puzzleSolutions[1]);
    }

    public function test_it_solves1x3_puzzle(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "1 3\n0 1 0 0\n0 2 0 1\n0 0 0 2";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = '1 2 3';
        self::assertEquals($expectedPuzzleSolution, $puzzleSolutions[0]);
    }

    public function test_it_solves1x3_puzzle_with_pieces_unordered(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "1 3\n0 0 0 2\n0 1 0 0\n0 2 0 1";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = '2 3 1';
        self::assertEquals($expectedPuzzleSolution, $puzzleSolutions[0]);
    }

    public function test_it_solves2x2_puzzle(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 2\n0 2 4 0\n0 0 3 2\n4 1 0 0\n3 0 0 1";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "1 2\n3 4";
        self::assertEquals($expectedPuzzleSolution, $puzzleSolutions[0]);
    }

    public function test_it_solves2x2_puzzle_with_pieces_unordered(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 2\n0 0 3 2\n3 0 0 1\n4 1 0 0\n0 2 4 0";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "4 1\n3 2";
        self::assertEquals($expectedPuzzleSolution, $puzzleSolutions[0]);
    }

    public function test_it_solves2x3_puzzle(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 3\n0 1 2 0\n0 3 4 1\n0 0 1 3\n2 2 0 0\n4 1 0 2\n1 0 3 1";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "1 2 3\n4 5 6";
        self::assertEquals($expectedPuzzleSolution, $puzzleSolutions[0]);
    }

    public function test_it_solves2x3_puzzle_unordered(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 3\n1 0 3 1\n0 3 4 1\n0 0 1 3\n2 2 0 0\n4 1 0 2\n0 1 2 0";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "6 2 3\n4 5 1";
        self::assertEquals($expectedPuzzleSolution, $puzzleSolutions[0]);
    }

    public function test_it_solves3x3_puzzle(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "3 3\n0 1 2 0\n0 3 4 1\n0 0 1 3\n2 2 3 0\n4 1 1 2\n1 0 3 1\n3 3 0 0\n1 1 0 3\n3 0 0 1";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "1 2 3\n4 5 6\n7 8 9";
        self::assertEquals($expectedPuzzleSolution, $puzzleSolutions[0]);
    }

    public function test_it_solves3x3_puzzle_unordered(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "3 3\n3 0 0 1\n0 3 4 1\n0 0 1 3\n2 2 3 0\n4 1 1 2\n1 0 3 1\n3 3 0 0\n1 1 0 3\n0 1 2 0";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "9 2 3\n4 5 6\n7 8 1";
        self::assertEquals($expectedPuzzleSolution, $puzzleSolutions[0]);
    }

    public function test_it_solves4x4_puzzle(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "4 4\n0 1 5 0\n0 1 5 1\n0 1 5 1\n0 0 3 1\n5 2 2 0\n5 1 3 2\n5 3 4 1\n3 0 1 3\n2 3 5 0\n3 2 1 3\n4 1 2 2\n1 0 3 1\n5 2 0 0\n1 1 0 2\n2 2 0 1\n3 0 0 2";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "1 2 3 4\n5 6 7 8\n9 10 11 12\n13 14 15 16";
        $expectedPuzzleSolution1 = "1 3 2 4\n5 6 7 8\n9 10 11 12\n13 14 15 16";
        self::assertEquals($expectedPuzzleSolution, $puzzleSolutions[0]);
        self::assertEquals($expectedPuzzleSolution1, $puzzleSolutions[1]);
    }

    public function test_it_solves4x4_puzzle_unordered(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "4 4\n0 1 5 1\n5 1 3 2\n5 2 2 0\n0 0 3 1\n0 1 5 0\n0 1 5 1\n3 0 1 3\n5 3 4 1\n3 2 1 3\n2 3 5 0\n5 2 0 0\n1 0 3 1\n4 1 2 2\n1 1 0 2\n2 2 0 1\n3 0 0 2";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);


        $expectedPuzzleSolution = "5 1 6 4\n3 2 8 7\n10 9 13 12\n11 14 15 16";
        $expectedPuzzleSolution1 = "5 6 1 4\n3 2 8 7\n10 9 13 12\n11 14 15 16";
        self::assertEquals($expectedPuzzleSolution, $puzzleSolutions[0]);
        self::assertEquals($expectedPuzzleSolution1, $puzzleSolutions[1]);
    }
}
