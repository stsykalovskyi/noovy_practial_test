<?php

use PHPUnit\Framework\TestCase;
use App\Services\DestinationService;
use PDO;
use PDOStatement;

class DestinationServiceTest extends TestCase {
    private $pdoMock;
    private $service;

    protected function setUp(): void {
        // Create a mock PDO instance
        $this->pdoMock = $this->createMock(PDO::class);

        // Initialize the DestinationService with the mock PDO
        $this->service = new DestinationService($this->pdoMock);
    }

    public function testGetDestinationsInRadiusReturnsEmptyArrayIfPlaceNotFound(): void {
        // Mock the PDO statement
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('fetch')->willReturn(false);

        // Mock prepare() method to return the statement mock
        $this->pdoMock->method('prepare')->willReturn($stmtMock);

        // Call the method
        $result = $this->service->getDestinationsInRadius('NonExistentPlace', 50);

        // Assert that the result is an empty array
        $this->assertSame([], $result);
    }

    public function testCalculateDistanceReturnsCorrectValue(): void {
        // Test distance between Rome (41.900444, 12.488605) and Ciampino Airport (41.831699, 12.596300)
        $distance = $this->service->calculateDistance(41.900444, 12.488605, 41.831699, 12.596300);

        // Expected value (approximate)
        $expectedDistance = 11.75;

        // Assert the distance is approximately correct
        $this->assertEqualsWithDelta($expectedDistance, $distance, 0.5);
    }
}
