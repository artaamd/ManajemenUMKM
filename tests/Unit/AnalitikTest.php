<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\AnalitikController;
use PHPUnit\Framework\Attributes\Test;

class AnalitikTest extends TestCase
{
    #[Test]
    public function it_calculates_engagement_rate_correctly(): void
    {
        // Arrange
        $controller = new AnalitikController();
        $likes = 50;
        $comments = 20;
        $shares = 5;
        $followers = 1000;
        // Rumus: ((50 + 20 + 5) / 1000) * 100 = 7.5

        // Act
        $hasil_er = $controller->calculateRate($likes, $comments, $shares, $followers);

        // Assert
        $this->assertEquals(7.5, $hasil_er);
    }

    #[Test]
    public function it_determines_grade_correctly_from_rate(): void
    {
        // Arrange
        $controller = new AnalitikController();

        // Assert: Sesuaikan dengan logika grade di Controller Anda
        $this->assertEquals('A', $controller->calculateGrade(75.0));
        $this->assertEquals('B', $controller->calculateGrade(60.0));
        $this->assertEquals('C', $controller->calculateGrade(30.0));
        $this->assertEquals('D', $controller->calculateGrade(10.0));
    }
}