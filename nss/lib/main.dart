import 'package:flutter/material.dart';
import 'package:nss/confirmation.dart';
import 'package:nss/homeScreen.dart';
import 'package:nss/registration.dart';

void main() {
  runApp(
    MaterialApp(
      debugShowCheckedModeBanner: false,
      initialRoute: '/',
      routes: {
        '/': (context) => HomeScreen(),
        '/register': (context) => Register(),
        '/confirmation': (context) => ConfirmationPage(),
      },
    ),
  );
}
