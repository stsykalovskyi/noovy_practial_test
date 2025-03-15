<?php

namespace App\Models;

class Destination {
    public string $name;
    public float $lat;
    public float $long;

    public function __construct(string $name, float $lat, float $long) {
        $this->name = $name;
        $this->lat = $lat;
        $this->long = $long;
    }
}
