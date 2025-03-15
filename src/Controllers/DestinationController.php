<?php

namespace App\Controllers;

use App\Services\DestinationService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDO;

class DestinationController {
    private DestinationService $destinationService;

    public function __construct(PDO $pdo) {
        $this->destinationService = new DestinationService($pdo);
    }

    public function getDestinations(Request $request, Response $response): Response {
        $queryParams = $request->getQueryParams();
        $place = $queryParams['place'] ?? '';
        $radius = isset($queryParams['radius']) ? (float)$queryParams['radius'] : 0;

        if (!$place || $radius <= 0) {
            $response->getBody()->write(json_encode(['error' => 'Invalid parameters']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $destinations = $this->destinationService->getDestinationsInRadius($place, $radius);

        $response->getBody()->write(json_encode($destinations));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
