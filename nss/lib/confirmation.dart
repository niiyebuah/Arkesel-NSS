import 'package:flutter/material.dart';

class ConfirmationPage extends StatelessWidget {
  const ConfirmationPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Registration Confirmation'),
        backgroundColor: Colors.green, // Set the app bar to green
      ),
      body: const Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            Icon(
              Icons.check_circle,
              color: Colors.green, // Use a green checkmark icon
              size: 80, // Adjust the icon size
            ),
            SizedBox(height: 20),
            Text(
              'Registration Successful!',
              style: TextStyle(
                fontSize: 24, // Increase the font size
                fontWeight: FontWeight.bold, // Apply bold font weight
              ),
            ),
            SizedBox(height: 8),
            // Text(
            //   'You have been successfully added to the system.',
            //   style: TextStyle(
            //     fontSize: 18, // Adjust the font size
            //   ),
            // ),
          ],
        ),
      ),
    );
  }
}
