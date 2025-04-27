<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\PuzzleDashboard;
use App\PuzzlePiece;
use PHPUnit\Framework\TestCase;

class PuzzleDashboardTest extends TestCase
{
    public function test_it_can_puzzle_piece_be_added_when_first_puzzle_piece(): void
    {
        $puzzleContext = "1 3\n0 2 0 0\n0 1 0 2\n1 0 0 1";
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);
        $puzzlePiece = new PuzzlePiece(0, 0, 0, 0, 0);

        $canPuzzlePieceBeAddedResult = $puzzleDashboard->canPuzzlePieceBeAdded($puzzlePiece);

        $this->assertTrue($canPuzzlePieceBeAddedResult);
    }
}
