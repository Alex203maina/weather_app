# Weather Application

A full-stack weather application built with Next.js, TypeScript, and Laravel. The application fetches weather data from OpenWeatherMap API and provides a modern, responsive user interface.

## Features

### Frontend
- Search for weather by city
- Display current weather information:
  - Temperature
  - Weather description
  - Humidity
  - Weather icon
- Responsive design
- Dark mode support
- Real-time weather updates

### Backend
- RESTful API endpoints for weather data
- City-based weather search
- OpenWeatherMap API integration
- Caching for improved performance
- Error handling and validation
- API documentation

## Technologies Used

### Frontend
- Next.js 15.3.1
- TypeScript
- Tailwind CSS
- RippleUI
- Fetch API for AJAX requests

### Backend
- Laravel 10.x
- PHP 8.1+
- OpenWeatherMap API
- Redis (for caching)
- MySQL/PostgreSQL

## Prerequisites

### Frontend
- Node.js (v18 or higher)
- npm (v9 or higher)
- A running Laravel backend server (default: http://localhost:8000)

### Backend
- PHP 8.1 or higher
- Composer
- MySQL/PostgreSQL
- Redis (optional, for caching)
- OpenWeatherMap API key

## Installation

1. Clone the repository:
```bash
git clone https://github.com/Alex203maina/weather_app.git
cd weather_app
```

### Frontend Setup
1. Navigate to the frontend directory:
```bash
cd frontend
```

2. Install dependencies:
```bash
npm install
```

3. Create a `.env.local` file:
```bash
NEXT_PUBLIC_API_URL=http://localhost:8000
```

4. Start the development server:
```bash
npm run dev
```

The frontend will be available at http://localhost:3000

### Backend Setup
1. Navigate to the backend directory:
```bash
cd backend
```

2. Install dependencies:
```bash
composer install
```

3. Create a `.env` file:
```bash
cp .env.example .env
```

4. Configure your environment variables in `.env`:
```bash
OPENWEATHER_API_KEY=your_api_key_here
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=weather_app
DB_USERNAME=root
DB_PASSWORD=
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Run migrations:
```bash
php artisan migrate
```

7. Start the development server:
```bash
php artisan serve
```

The API will be available at http://localhost:8000

## Project Structure

### Frontend
```
frontend/
├── src/
│   ├── app/              # Next.js app directory
│   ├── components/       # React components
│   │   ├── SearchBar.tsx
│   │   └── WeatherCard.tsx
│   └── services/         # API services
│       └── weatherService.ts
├── public/              # Static files
├── tailwind.config.ts   # Tailwind configuration
└── package.json         # Project dependencies
```

### Backend
```
backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── WeatherController.php
│   │   └── Middleware/
│   ├── Services/
│   │   └── WeatherService.php
│   └── Models/
├── config/
├── database/
├── routes/
│   └── api.php
├── tests/
└── storage/
```

## Components

### Frontend Components

#### WeatherCard
Displays weather information including:
- City name
- Temperature
- Weather description
- Humidity
- Weather icon

#### SearchBar
Provides city search functionality with:
- Input field for city name
- Search button
- Loading state
- Error handling

## API Integration

The frontend communicates with the Laravel backend through the following endpoint:

```
GET /api/weather?city={city_name}
```

Example response:
```json
{
  "city": "London",
  "temperature": 15.4,
  "humidity": 70,
  "description": "clear sky",
  "icon": "01d"
}
```

## Development

### Frontend Development
1. Start the development server:
```bash
npm run dev
```

2. Build for production:
```bash
npm run build
```

3. Start production server:
```bash
npm start
```

### Backend Development
1. Start the development server:
```bash
php artisan serve
```

2. Run tests:
```bash
php artisan test
```

3. Clear cache:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request
