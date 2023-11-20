import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:weather_app/client.dart';
import 'package:weather_app/model.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return const MaterialApp(
      debugShowCheckedModeBanner: false,
      home: WeatherApp(),
    );
  }
}

class WeatherApp extends StatefulWidget {
  const WeatherApp({Key? key}) : super(key: key);

  @override
  State<WeatherApp> createState() => _WeatherAppState();
}

class _WeatherAppState extends State<WeatherApp> {
  WeatherModel? weather;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFF212121),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            const Text(
              "Weather Forecast",
              style: TextStyle(
                color: Colors.white,
                fontSize: 40,
                fontWeight: FontWeight.bold,
              ),
            ),
            const SizedBox(height: 16),
            WeatherDisplay(
              temperature: weather?.currentWeather.temperature ?? 0,
              rainfall: null,
              description: getWeatherDescription(weather?.currentWeather.temperature ?? 0),
            ),
            const SizedBox(height: 16),
            ElevatedButton(
              onPressed: () async {
                if (kDebugMode) {
                  print("Fetching weather data...");
                }
                weather = await WeatherApiClient().request();
                if (kDebugMode) {
                  print("Weather data fetched: ${weather?.currentWeather}");
                }
                setState(() {});
              },
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.blue,
                padding: const EdgeInsets.symmetric(horizontal: 50, vertical: 20),
              ),
              child: const Text(
                "Get Data",
                style: TextStyle(
                  fontSize: 20,
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  String getWeatherDescription(double temperature) {
    if (temperature < 0) {
      return "It's freezing! Bundle up.";
    } else if (temperature < 10) {
      return "Cloudy and cold.";
    } else if (temperature < 25) {
      return "Partly cloudy with mild weather.";
    } else {
      return "Sunny and pleasant.";
    }
  }
}

class WeatherDisplay extends StatelessWidget {
  final double temperature;
  final double? rainfall; // Make rainfall nullable
  final String description;

  const WeatherDisplay({
    Key? key,
    required this.temperature,
    required this.rainfall,
    required this.description,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    IconData icon;
    Color iconColor;

    if (temperature < 0) {
      icon = Icons.ac_unit; // Snowflake icon
      iconColor = Colors.blue; // Blue for snow
    } else if (temperature < 10) {
      icon = Icons.cloud; // Cloud icon
      iconColor = Colors.grey; // Grey for clouds
    } else if (temperature < 25) {
      icon = Icons.wb_cloudy; // Cloudy icon
      iconColor = Colors.grey; // Grey for clouds
    } else {
      icon = Icons.wb_sunny; // Sun icon
      iconColor = Colors.yellow; // Yellow for sun
    }

    if (rainfall != null && rainfall! > 0) {
      icon = Icons.water; // Water icon for rainfall
      iconColor = Colors.blue; // Blue for water
    }

    return Column(
      children: [
        Icon(
          icon,
          color: iconColor,
          size: 150,
        ),
        const SizedBox(height: 16),
        Text(
          description,
          style: const TextStyle(
            color: Colors.white,
            fontSize: 25,
          ),
        ),
        Text(
          "$temperature°C",
          style: const TextStyle(
            color: Colors.white,
            fontSize: 45,
            fontWeight: FontWeight.bold,
          ),
        ),
      ],
    );
  }
}
