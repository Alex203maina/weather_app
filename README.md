
# Weather App

This is a weather application built with **Next.js** for the frontend and **Laravel** for the backend, using **OpenWeather API** to fetch weather data. The app is structured in a decoupled architecture, where the frontend and backend are separate. The frontend makes AJAX requests to the Laravel API, which then fetches data from the OpenWeather API.

---

## **Frontend**: Next.js (with TypeScript, Tailwind CSS, RippleUI)

### **Technologies Used**:
- **Next.js** (React Framework)
- **TypeScript**
- **Tailwind CSS** (for styling)
- **RippleUI** (for reusable components)
- **AJAX** (using JavaScript's `fetch` API)
  
### **Frontend Features**:
- Search for weather by city
- Display current weather information: temperature, description, humidity
- Responsive design using **Tailwind CSS**
- Components styled with **RippleUI** for smooth interactions

### **Components**:
- **WeatherCard**: Displays weather details such as temperature, humidity, and description.
- **SearchBar**: Lets the user search for a city to fetch weather data.
- **Button**: A reusable button component styled with **RippleUI**.

---

## **Backend**: Laravel API

### **Technologies Used**:
- **Laravel** (PHP Framework)
- **OpenWeather API** (external weather service)
- **CORS** (for cross-origin requests)

### **Backend Features**:
- A simple API endpoint (`/api/weather`) to fetch weather data from OpenWeather API based on a city name.
- The API returns weather data including temperature, description, and humidity.

### **API Endpoint**:
- **GET** `/api/weather?city={city_name}`
  - Returns weather data in JSON format.
  - Example: `/api/weather?city=London`
 

 Date Due: 01/05/2025
