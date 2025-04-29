<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
        try {
            $city = $request->query('city');
            
            if (!$city) {
                Log::error('City parameter is missing');
                return response()->json(['error' => 'City parameter is required'], 400);
            }

            // Get API key directly from env for testing
            $apiKey = env('OPENWEATHER_API_KEY');
            
            if (!$apiKey) {
                Log::error('OpenWeather API key is missing from env');
                return response()->json(['error' => 'OpenWeather API key is not configured'], 500);
            }

            // Debug: Log the full API key (temporary)
            Log::info('API Key being used: ' . $apiKey);

            // Get coordinates first using Geocoding API
            Log::info('Fetching coordinates for city: ' . $city);
            try {
                $geoResponse = Http::timeout(15)->get("http://api.openweathermap.org/geo/1.0/direct", [
                    'q' => $city,
                    'limit' => 1,
                    'appid' => $apiKey
                ]);

                if ($geoResponse->failed()) {
                    throw new \Exception('Geocoding request failed: ' . $geoResponse->body());
                }
            } catch (\Exception $e) {
                Log::error('Geocoding API request failed', [
                    'error' => $e->getMessage(),
                    'city' => $city
                ]);
                return response()->json(['error' => 'Failed to find city location: ' . $e->getMessage()], 404);
            }

            $geoData = $geoResponse->json();
            if (empty($geoData)) {
                Log::error('No location data found for city: ' . $city);
                return response()->json(['error' => 'City not found'], 404);
            }

            $location = $geoData[0];
            $lat = $location['lat'];
            $lon = $location['lon'];

            // Get weather forecast using the forecast endpoint
            Log::info('Fetching weather forecast for coordinates', ['lat' => $lat, 'lon' => $lon]);
            try {
                $forecastResponse = Http::timeout(15)->get("https://api.openweathermap.org/data/2.5/forecast", [
                    'lat' => $lat,
                    'lon' => $lon,
                    'units' => 'metric',
                    'appid' => $apiKey
                ]);

                // Debug: Log the full response
                Log::info('Forecast Response:', [
                    'status' => $forecastResponse->status(),
                    'body' => $forecastResponse->body()
                ]);

                if ($forecastResponse->failed()) {
                    throw new \Exception('Forecast request failed: ' . $forecastResponse->body());
                }
            } catch (\Exception $e) {
                Log::error('Forecast API request failed', [
                    'error' => $e->getMessage(),
                    'lat' => $lat,
                    'lon' => $lon
                ]);
                return response()->json(['error' => 'Failed to fetch forecast data: ' . $e->getMessage()], 500);
            }

            $forecastData = $forecastResponse->json();
            
            if (!isset($forecastData['list']) || empty($forecastData['list'])) {
                Log::error('Invalid forecast data format', ['data' => $forecastData]);
                return response()->json(['error' => 'Invalid forecast data received from API'], 500);
            }

            // Get current weather (first item in the list)
            $current = $forecastData['list'][0];
            
            // Get forecast for next 3 days (8 items per day, so we take 24 items)
            $forecastItems = array_slice($forecastData['list'], 1, 24);
            
            // Group forecast items by date
            $forecastByDate = [];
            foreach ($forecastItems as $item) {
                $date = date('Y-m-d', $item['dt']);
                if (!isset($forecastByDate[$date])) {
                    $forecastByDate[$date] = [
                        'date' => $date,
                        'temperature' => $item['main']['temp'],
                        'icon' => $item['weather'][0]['icon']
                    ];
                }
            }
            
            // Convert to array and take first 3 days
            $forecast = array_slice(array_values($forecastByDate), 0, 3);

            $response = [
                'city' => $location['name'],
                'temperature' => $current['main']['temp'],
                'humidity' => $current['main']['humidity'],
                'description' => $current['weather'][0]['description'],
                'icon' => $current['weather'][0]['icon'],
                'windSpeed' => round($current['wind']['speed'] * 3.6, 1), // Convert m/s to km/h
                'forecast' => $forecast
            ];

            Log::info('Successfully fetched weather data', ['city' => $city]);
            return response()->json($response)->header('Content-Type', 'application/json');

        } catch (\Exception $e) {
            Log::error('Exception in WeatherController', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'An error occurred while fetching weather data: ' . $e->getMessage()], 500);
        }
    }
} 