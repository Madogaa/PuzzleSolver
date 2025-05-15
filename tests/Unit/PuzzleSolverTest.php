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
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
    }

    public function test_it_solves2x1_puzzle(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 1\n0 0 1 0\n1 0 0 0";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "1\n2";
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
    }

    public function test_it_solves2x1_puzzle_when_pieces_are_unordered(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 1\n1 0 0 0\n0 0 1 0";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "1\n2";
        $expectedPuzzleSolution1 = "2\n1";
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
        self::assertContains($expectedPuzzleSolution1, $puzzleSolutions);
    }

    public function test_it_solves2x1_puzzle_when_pieces_are_unordered_and_rotated(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 1\n0 0 1 0\n0 0 0 1";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "1\n2";
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
    }

    public function test_it_solves1x2_puzzle(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "1 2\n0 1 0 0\n0 0 0 1";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = '1 2';
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
    }

    public function test_it_solves1x2_puzzle_unordered(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "1 2\n0 0 0 1\n0 1 0 0";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = '1 2';
        $expectedPuzzleSolution1 = '2 1';
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
        self::assertContains($expectedPuzzleSolution1, $puzzleSolutions);
    }

    public function test_it_solves1x3_puzzle(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "1 3\n0 1 0 0\n0 2 0 1\n0 0 0 2";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = '1 2 3';
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
    }

    public function test_it_solves1x3_puzzle_with_pieces_unordered(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "1 3\n0 0 0 2\n0 1 0 0\n0 2 0 1";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = '2 3 1';
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
    }

    public function test_it_solves1x3_puzzle_with_pieces_unordered_with_rotating_pieces(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "1 3\n0 0 0 2\n0 1 0 0\n0 2 0 1";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = '2 3 1';
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
    }

    public function test_it_solves1x3_puzzle_with_pieces_unordered_with_rotating_pieces_until_max_rotations(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "1 3\n0 0 0 2\n0 0 1 0\n0 2 0 1";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = '2 3 1';
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
    }

    public function test_it_solves2x2_puzzle(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 2\n0 2 4 0\n0 0 3 2\n4 1 0 0\n3 0 0 1";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "1 2\n3 4";
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
    }

    public function test_it_solves2x2_puzzle_with_rotating_pieces(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 2\n0 0 2 4\n3 2 0 0\n1 0 0 4\n1 3 0 0";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "2 4\n1 3";

        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
    }

    public function test_it_solves2x2_puzzle_unordered_with_rotating_pieces(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 2\n3 2 0 0\n0 0 2 4\n1 0 0 4\n1 3 0 0";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "1 4\n2 3";
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
    }

    public function test_it_solves2x2_puzzle_with_pieces_unordered(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 2\n0 0 3 2\n3 0 0 1\n4 1 0 0\n0 2 4 0";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "4 1\n3 2";
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
    }

    public function test_it_solves2x3_puzzle(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 3\n0 1 2 0\n0 3 4 1\n0 0 1 3\n2 2 0 0\n4 1 0 2\n1 0 0 1";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "1 2 3\n4 5 6";
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
    }

    public function test_it_solves2x3_puzzle_unordered(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "2 3\n1 0 0 1\n0 0 1 3\n0 3 4 1\n4 1 0 2\n2 2 0 0\n0 1 2 0";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "6 3 2\n5 4 1";
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
    }

    public function test_it_solves3x3_puzzle(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "3 3\n0 1 2 0\n0 3 4 1\n0 0 1 3\n2 2 3 0\n4 1 1 2\n1 0 3 1\n3 3 0 0\n1 1 0 3\n3 0 0 1";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "1 2 3\n4 5 6\n7 8 9";
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
    }

    public function test_it_solves3x3_puzzle_unordered(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "3 3\n3 0 0 1\n0 3 4 1\n0 0 1 3\n2 2 3 0\n4 1 1 2\n1 0 3 1\n3 3 0 0\n1 1 0 3\n0 1 2 0";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "9 2 3\n4 5 6\n7 8 1";
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
    }

    public function test_it_solves4x4_puzzle(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "4 4\n0 1 5 0\n0 1 5 1\n0 1 5 1\n0 0 3 1\n5 2 2 0\n5 1 3 2\n5 3 4 1\n3 0 1 3\n2 3 5 0\n3 2 1 3\n4 1 2 2\n1 0 3 1\n5 2 0 0\n1 1 0 2\n2 2 0 1\n3 0 0 2";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "1 2 3 4\n5 6 7 8\n9 10 11 12\n13 14 15 16";
        $expectedPuzzleSolution1 = "1 3 2 4\n5 6 7 8\n9 10 11 12\n13 14 15 16";
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
        self::assertContains($expectedPuzzleSolution1, $puzzleSolutions);
    }

    public function test_it_solves4x4_puzzle_unordered(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "4 4\n0 1 5 1\n5 1 3 2\n5 2 2 0\n0 0 3 1\n0 1 5 0\n0 1 5 1\n3 0 1 3\n5 3 4 1\n3 2 1 3\n2 3 5 0\n5 2 0 0\n1 0 3 1\n4 1 2 2\n1 1 0 2\n2 2 0 1\n3 0 0 2";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "5 1 6 4\n3 2 8 7\n10 9 13 12\n11 14 15 16";
        $expectedPuzzleSolution1 = "5 6 1 4\n3 2 8 7\n10 9 13 12\n11 14 15 16";
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
        self::assertContains($expectedPuzzleSolution1, $puzzleSolutions);
    }

    public function test_it_solves4x4_puzzle_kata_test_case(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "4 4\n1 4 3 5\n0 5 3 5\n1 5 3 0\n5 4 5 2\n1 5 0 0\n0 5 2 1\n1 0 4 4\n2 4 4 2\n4 5 0 5\n3 2 1 0\n4 0 0 3\n3 0 0 1\n5 5 1 0\n5 0 0 1\n0 4 2 4\n4 5 1 4";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "5 7 15 11\n9 16 4 3\n13 1 8 10\n14 2 6 12";
        $expectedPuzzleSolution2 = "5 13 9 14\n2 1 16 7\n6 8 4 15\n12 10 3 11";
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
        self::assertContains($expectedPuzzleSolution2, $puzzleSolutions);
    }

    public function test_it_solves5x5_puzzle_kata_test_case(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "5 5\n9 6 5 0\n1 6 10 2\n0 2 3 0\n3 4 9 1\n9 0 4 4\n8 9 2 3\n0 0 7 6\n3 10 6 5\n4 8 4 5\n9 7 0 0\n3 9 1 4\n2 4 0 8\n8 9 0 7\n2 4 5 2\n0 3 10 7\n7 2 10 6\n9 0 4 9\n4 0 3 3\n3 10 8 0\n2 0 7 8\n10 3 0 4\n0 9 1 7\n9 5 9 7\n0 6 3 4\n5 3 0 0";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "3 20 22 13 10\n18 6 11 9 5\n21 2 4 14 12\n15 8 23 16 19\n7 24 17 1 25";
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
    }

    public function test_it_solves8x8_puzzle_kata_test_case(): void
    {
        $puzzleSolver = new PuzzleSolver();
        $puzzlePieces = "8 8\n7 3 9 2\n10 3 7 3\n8 10 9 10\n0 0 10 3\n1 8 10 4\n8 10 5 6\n10 8 2 0\n3 1 7 1\n2 2 2 0\n3 9 5 7\n9 0 4 3\n9 4 10 0\n0 8 7 9\n9 4 8 4\n5 9 0 3\n0 7 4 10\n7 3 6 0\n10 3 0 5\n10 0 8 8\n3 10 3 4\n2 1 2 3\n5 0 10 7\n8 5 8 8\n6 9 6 1\n10 8 9 1\n8 3 4 8\n8 3 5 3\n4 4 0 10\n6 10 2 4\n8 8 1 2\n4 9 8 6\n7 10 6 7\n1 7 0 9\n4 8 0 9\n9 4 5 2\n9 9 8 1\n0 10 9 2\n2 3 3 4\n0 2 4 4\n8 1 4 6\n6 9 8 0\n7 1 3 4\n10 7 4 10\n9 4 6 10\n10 6 4 3\n3 7 3 10\n2 6 0 8\n10 0 10 10\n5 2 9 9\n7 1 4 10\n4 8 1 4\n4 2 9 0\n8 0 9 1\n0 9 10 0\n1 4 0 3\n4 1 6 5\n0 6 9 0\n5 4 4 3\n10 8 0 8\n0 0 2 10\n7 2 5 8\n5 7 5 4\n4 9 7 0\n10 10 2 2";

        $puzzleSolutions = $puzzleSolver->solve($puzzlePieces);

        $expectedPuzzleSolution = "4 12 52 55 18 22 48 60\n15 62 35 25 43 32 64 9\n33 8 40 6 5 56 49 37\n17 38 26 23 30 50 44 16\n41 1 2 3 29 42 24 63\n59 46 10 36 31 20 45 39\n47 21 61 51 14 58 27 7\n57 53 13 34 19 28 11 54";
        $expectedPuzzleSolution2 = "4 12 52 55 18 22 48 60\n15 62 35 25 43 32 64 9\n33 8 40 6 5 56 49 37\n17 38 26 23 30 50 44 16\n41 1 46 3 29 42 24 63\n59 2 10 36 31 20 45 39\n47 21 61 51 14 58 27 7\n57 53 13 34 19 28 11 54";
        self::assertContains($expectedPuzzleSolution, $puzzleSolutions);
        self::assertContains($expectedPuzzleSolution2, $puzzleSolutions);
    }
}
