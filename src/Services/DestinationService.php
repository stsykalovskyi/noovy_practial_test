<?php

namespace App\Services;

use PDO;

class DestinationService {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Get destinations within the given radius from a selected place.
     *
     * @param string $place The name of the selected destination.
     * @param float $radius The radius in kilometers.
     * @return array List of destinations within the given radius.
     */
    public function getDestinationsInRadius(string $place, float $radius): array {
        // Fetch selected destination's coordinates
        $sql = "SELECT lat, lon FROM destinations WHERE name = :place LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':place' => $place]);
        $selectedDestination = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$selectedDestination) {
            error_log("Error: Selected destination '$place' not found.");
            return [];
        }

        $lat = (float)$selectedDestination['lat'];
        $lon = (float)$selectedDestination['lon'];

        // Fetch all destinations to calculate distances manually
        $sql = "SELECT name, lat, lon FROM destinations";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $destinations = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['lat'] === null || $row['lon'] === null) {
                error_log("Warning: Destination '{$row['name']}' has missing lat/lon values.");
                continue;
            }

            $distance = $this->calculateDistance($lat, $lon, (float)$row['lat'], (float)$row['lon']);

            // Only include destinations within the specified radius
            if ($distance <= $radius) {
                $destinations[] = [
                    'name' => $row['name'],
                    'lat' => (float)$row['lat'],
                    'lon' => (float)$row['lon'],
                    'distance' => round($distance, 2)
                ];
            }
        }

        // Sort results by distance in ascending order
        usort($destinations, fn($a, $b) => $a['distance'] <=> $b['distance']);

        return $destinations;
    }

    /**
     * Calculate the distance between two geographical coordinates using the Haversine formula.
     *
     * @param float $lat1 Latitude of the first location.
     * @param float $lon1 Longitude of the first location.
     * @param float $lat2 Latitude of the second location.
     * @param float $lon2 Longitude of the second location.
     * @return float Distance in kilometers.
     */
    public function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float {
        $earthRadius = 6371; // Radius of the Earth in km

        $latDiff = deg2rad($lat2 - $lat1);
        $lonDiff = deg2rad($lon2 - $lon1);

        $a = sin($latDiff / 2) * sin($latDiff / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lonDiff / 2) * sin($lonDiff / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
