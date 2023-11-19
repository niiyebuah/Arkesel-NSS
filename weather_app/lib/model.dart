class WeatherModel {
  final CurrentWeather currentWeather;

  WeatherModel({required this.currentWeather});

  factory WeatherModel.fromJson(Map<String, dynamic> data) {
    final currentWeatherData = data["current_weather"] as Map<String, dynamic>;
    final currentWeather = CurrentWeather.fromJson(currentWeatherData);
    return WeatherModel(currentWeather: currentWeather);
  }

}
class CurrentWeather {
  final double? temperature;
  final double? windspeed;
  final double? winddirection;
  final int? weathercode;
  final int? isDay;

  CurrentWeather({
    this.temperature,
    this.windspeed,
    this.winddirection,
    this.weathercode,
    this.isDay,
  });

  factory CurrentWeather.fromJson(Map<String, dynamic> data) {
    final temperature = (data["temperature"] as num?)?.toDouble();
    final windspeed = (data["windspeed"] as num?)?.toDouble();
    final winddirection = (data["winddirection"] as num?)?.toDouble();
    final weathercode = (data["weathercode"] as num?)?.toInt();
    final isDay = (data["isDay"] as num?)?.toInt();

    return CurrentWeather(
      temperature: temperature,
      windspeed: windspeed,
      weathercode: weathercode,
      winddirection: winddirection,
      isDay: isDay,
    );
  }
}