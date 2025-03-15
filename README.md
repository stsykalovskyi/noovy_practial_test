# Destination API

This is a PHP-based API built with the Slim framework that retrieves destinations within a given radius from a selected location. It uses an SQLite database to store destination data and calculates distances using the Haversine formula.

## Features
- Fetches destinations within a given radius from a selected place
- Returns distances in ascending order
- Uses SQLite as a data source
- Built with PHP and the Slim framework

## Installation
### Prerequisites
- PHP >= 8.0
- Composer
- SQLite3

### Steps
1. **Install Dependencies:**
   ```sh
   composer install
   ```
2. **Run the Application:**
   ```sh
   php -S localhost:8000 -t public
   ```

## API Usage
### **Get Destinations within a Radius**
#### **Request:**
```
GET /destinations?place=Rome&radius=50
```
#### **Response:**
```json
[
  {
    "name": "Rome",
    "lat": 41.900444,
    "lon": 12.488605,
    "distance": 0
  },
  {
    "name": "Rome Ciampino Airport",
    "lat": 41.8316993713379,
    "lon": 12.5963001251221,
    "distance": 11.75
  },
  {
    "name": "Rome Ciampino Airport",
    "lat": 41.801543,
    "lon": 12.601673,
    "distance": 14.44
  },
  {
    "name": "Ciampino",
    "lat": 41.796501159668,
    "lon": 12.6091003417969,
    "distance": 15.27
  },
  {
    "name": "CASTELLI ROMANI",
    "lat": 41.8180999755859,
    "lon": 12.6597003936768,
    "distance": 16.87
  },
  {
    "name": "Sacrofano",
    "lat": 42.0620002746582,
    "lon": 12.4773998260498,
    "distance": 17.99
  },
  {
    "name": "Rome Leonardo Da Vinci\/Fiumicino Airport",
    "lat": 41.767263,
    "lon": 12.356161,
    "distance": 18.43
  },
  {
    "name": "Frascati",
    "lat": 41.809107,
    "lon": 12.678235,
    "distance": 18.7
  },
  {
    "name": "Guidonia Montecelio",
    "lat": 41.9683990478516,
    "lon": 12.6983995437622,
    "distance": 18.93
  },
  {
    "name": "Monterotondo",
    "lat": 42.053077,
    "lon": 12.594313,
    "distance": 19.09
  },
  {
    "name": "Mentana",
    "lat": 42.030200958252,
    "lon": 12.6400995254517,
    "distance": 19.11
  },
  {
    "name": "Grottaferrata",
    "lat": 41.7923011779785,
    "lon": 12.6684999465942,
    "distance": 19.15
  },
  {
    "name": "Marino",
    "lat": 41.76728,
    "lon": 12.6371,
    "distance": 19.25
  },
  {
    "name": "Rome-Monterotondo",
    "lat": 42.0620002746582,
    "lon": 12.5890998840332,
    "distance": 19.79
  },
  {
    "name": "Riano",
    "lat": 42.0787010192871,
    "lon": 12.4879999160767,
    "distance": 19.82
  }
]
```

## Project Structure
```
├── src/
│   ├── Controllers/
│   │   ├── DestinationController.php
│   ├── Services/
│   │   ├── DestinationService.php
│   ├── Database/
│   │   ├── Database.php
│   ├── Models/
│   │   ├── Destination.php
├── database/
│   ├── destinations.sqlite
├── public/
│   ├── index.php
├── tests/
│   ├── DestinationServiceTest.php
├── composer.json
├── README.md
```

## Testing
Run PHPUnit tests with:
```sh
vendor/bin/phpunit tests
```

## License
This project is licensed under the MIT License.

