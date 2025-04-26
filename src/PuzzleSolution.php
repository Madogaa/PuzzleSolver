<?php

declare(strict_types=1);

namespace App;

final readonly class PuzzleSolution
{
    /**
     * @param int[][] $puzzleSolutionIndex
     */
    public function __construct(
        public array $puzzleSolutionIndex
    ) {
    }
}
