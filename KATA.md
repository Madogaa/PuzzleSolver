# Development task - Puzzle

This task is a complex problem to assess your abilities as a developer. It is designed to allow you to demonstrate some, particularly, your ability to write efficient, clean, maintainable, generic algorithms.

This task is not about having a brilliant idea and solving it using a super-optimized clever shortcut. Instead, it would take an incremental, step-by-step, systematic approach to the problem, and write an algorithm that solves the problem first, in a clean, but suboptimal way. If you have spare time, you may choose to use that time making it more efficient.

## Exercise

The task is to create a script that will solve a puzzle.

All the pieces of our puzzle have four sides. Each one of the sides is represented by a positive integer. These numbers represent shapes. The number zero represents the border, which is a special side.

For example, on these pieces, you can see sides 0 (border), 1, 2 and 3. Side 1 fits with side 1, side 2 would fit with side 2, etc. On the last images you can see how 3 pieces could fit together.

Even though the sides 1 and 2 look similar, they are actually mirrored and that’s why they have a different number.

There could be more than 2 pieces with the same side. That means that those pieces can fit together.

The sides of the pieces are named sequentially, clockwise, starting with the left side. For example, the first piece is 0 1 2 0.


The puzzle file is defined on a text file. A puzzle has a width and a height, which are defined on the first row of the file; then, line by line represents each one of the pieces. For example, this is a 16-piece puzzle:

```text
4 4
1 4 3 5
0 5 3 5
1 5 3 0
5 4 5 2
1 5 0 0
0 5 2 1
1 0 4 4
2 4 4 2
4 5 0 5
3 2 1 0
4 0 0 3
3 0 0 1
5 5 1 0
5 0 0 1
0 4 2 4
4 5 1 4
```

Each piece is numbered sequentially, and the first piece is the piece number 1.

This is a solution to that puzzle:
```text
5 7 15 11
9 16 4 3
13 1 8 10
14 2 6 12
```

The solutions are written using the piece numbers, separated by spaces, and one line per row.

A puzzle could have multiple solutions. For example, this is also a solution for that same puzzle:
```text
5 13 9 14
2 1 16 7
6 8 4 15
12 10 3 11
```




Actually, all puzzles will have more than one solution, since you can rotate the solution, for example 180 degrees. For the purpose of this exercise we are not interested in the rotated solutions. For example, these two solutions are equivalent:
```text
5 7 15 11                          14 13 9 5
9 16 4 3       is the same as      2 1 16 7
13 1 8 10                          6 8 4 15
14 2 6 12                          12 10 3 11
```

With that in mind, the puzzle above has exactly two different solutions. Different solutions are represented as below, with a new line in between. These would be the solutions file for the sample puzzle:
```text
5 7 15 11
9 16 4 3
13 1 8 10
14 2 6 12
```
```text
5 13 9 14
2 1 16 7
6 8 4 15
12 10 3 11
```

## Rules
- You need to use all the pieces, and you can only use each piece once, (please note that there could be two identical pieces listed)
- The border needs to be around the puzzle
- The corner pieces have to be at the corners
- You **can rotate** the pieces. For example, if a piece is `0 1 2 3`, you can rotate it, i.e. that piece is the same as `1 2 3 0`, `2 3 0 1` and `3 0 1 2`.
- You **cannot flip** the pieces. For example, the piece 0 1 2 3 from the previous example is not the same as `0 3 2 1`, so you cannot use it as that.

Your solution should be tested with other puzzles, so you need to make sure that your algorithm works on every scenario. As a sample, we are providing a 5x5 and a 8x8 puzzles for you to test your script. The provided 5x5 puzzle has one solution, the 8x8 puzzle has 2. Your program should provide all the solutions, not just the first one.
