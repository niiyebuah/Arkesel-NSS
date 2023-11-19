import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'sql_helper.dart';
// import 'package:get/get.dart';
// import 'package:flutter/foundation.dart';

class Register extends StatefulWidget {
  const Register({super.key});

  @override
  _RegisterState createState() => _RegisterState();
}

class _RegisterState extends State<Register> {
  final TextEditingController _firstNameController = TextEditingController();
  final TextEditingController _lastNameController = TextEditingController();
  final TextEditingController _ageController = TextEditingController();
  final TextEditingController _dateOfBirthController = TextEditingController();
  final TextEditingController _phoneNumberController = TextEditingController();
  final TextEditingController _placeOfPostingController =
  TextEditingController();

  @override
  void initState() {
    super.initState();
    SQLHelper.db(); // Loading the database when the app starts
  }

  void sendSMSv1() async {
    const id = 'ProjectNY';
    const apiKey =
        'OnJxY2k1aEhuRERqSlFXeGE='; // Replace with your Arkesel API key
    final recipientPhoneNumber = _phoneNumberController
        .text; // Replace with the recipient's phone number
    final message =
        'Hello ${_firstNameController.text},\nYou have successfully been Registered into the National Service System';
    final url = Uri.parse(
        'https://sms.arkesel.com/sms/api?action=send-sms&api_key=$apiKey&to=$recipientPhoneNumber&from=$id&sms=${Uri.encodeComponent(message)}');
    final response = await http.get(url);

    if (response.statusCode == 200) {
      print('Confirmation message sent successfully.');
      // Navigate to the ConfirmationPage using a named route
      Navigator.pushNamed(context, '/confirmation');
    } else {
      print('Failed to send the confirmation message.');
    }
  }

  Future<void> sendSMSv2() async {
    const id = 'ProjectNY';
    const apiKey =
        'OnJxY2k1aEhuRERqSlFXeGE='; // Replace with your Arkesel API key
    final recipientPhoneNumber = _phoneNumberController
        .text; // Replace with the recipient's phone number
    final message =
        'Hello ${_firstNameController.text},\nYou have successfully been Registered into the National Service System';

    // Define the API endpoint URL for Arkesel's SMS V2 API
    const String apiUrl = 'https://sms.arkesel.com/api/v2/sms/send';

    // Create a map of the data you want to send in the POST request
    final Map<String, dynamic> data = {
      'sender': id,
      'recipients': [recipientPhoneNumber],
      'message': message,
    };

    // Encode the data as JSON
    final String jsonData = json.encode(data);

    // Create the headers with the API key
    final Map<String, String> headers = {
      'Content-Type': 'application/json', // Set the content type to JSON
      'api-key': apiKey, // Pass the API key in the Authorization header
    };

    // Make the POST request with headers
    final response = await http.post(
      Uri.parse(apiUrl),
      headers: headers,
      body: jsonData, // Send the JSON-encoded data in the request body
    );

    if (response.statusCode == 200) {
      print('Confirmation message sent successfully.');
      // Navigate to the ConfirmationPage using a named route
      Navigator.pushNamed(context, '/confirmation');
    } else {
      print('Failed to send the confirmation message.');
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Registration'),
        backgroundColor: Colors.green,
      ),
      body: SingleChildScrollView(
        child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Card(
            elevation: 5,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(8),
            ),
            child: Padding(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: <Widget>[
                  // Form fields with labels
                  const Text(
                    'FIRST NAME',
                    style: TextStyle(
                      fontWeight: FontWeight.bold,
                      fontSize: 16,
                    ),
                  ),
                  TextFormField(
                    controller: _firstNameController,
                    decoration: const InputDecoration(),
                  ),
                  const SizedBox(height: 16.0),

                  const Text(
                    'LAST NAME',
                    style: TextStyle(
                      fontWeight: FontWeight.bold,
                      fontSize: 16,
                    ),
                  ),
                  TextFormField(
                    controller: _lastNameController,
                    decoration: const InputDecoration(),
                  ),
                  const SizedBox(height: 16.0),

                  const Text(
                    'AGE',
                    style: TextStyle(
                      fontWeight: FontWeight.bold,
                      fontSize: 16,
                    ),
                  ),
                  TextFormField(
                    controller: _ageController,
                    decoration: const InputDecoration(),
                  ),
                  const SizedBox(height: 16.0),

                  const Text(
                    'DATE OF BIRTH',
                    style: TextStyle(
                      fontWeight: FontWeight.bold,
                      fontSize: 16,
                    ),
                  ),
                  TextFormField(
                    controller: _dateOfBirthController,
                    decoration: const InputDecoration(),
                  ),
                  const SizedBox(height: 16.0),

                  const Text(
                    'PHONE NUMBER',
                    style: TextStyle(
                      fontWeight: FontWeight.bold,
                      fontSize: 16,
                    ),
                  ),
                  TextFormField(
                    controller: _phoneNumberController,
                    decoration: const InputDecoration(),
                  ),
                  const SizedBox(height: 16.0),

                  const Text(
                    'PLACE OF POSTING',
                    style: TextStyle(
                      fontWeight: FontWeight.bold,
                      fontSize: 16,
                    ),
                  ),
                  TextFormField(
                    controller: _placeOfPostingController,
                    decoration: const InputDecoration(),
                  ),
                  const SizedBox(height: 16.0),

                  ElevatedButton(
                    onPressed: () {
                      final String firstname = _firstNameController.text;
                      final String lastname = _lastNameController.text;
                      final int age = int.parse(_ageController.text);
                      final String dob = _dateOfBirthController.text;
                      final String phonenumber = _phoneNumberController.text;
                      final String posting = _placeOfPostingController.text;

                      SQLHelper.createUser(
                          firstname, lastname, age, dob, phonenumber, posting);
                      // sendSMSv1();
                      sendSMSv2();
                      // Navigate to the "/Submit Registration" route
                      // Navigator.pushNamed(context, '/confirmation');
                    },
                    style: ElevatedButton.styleFrom(
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(20.0),
                      ),
                      minimumSize: const Size(200, 50),
                      padding: const EdgeInsets.all(16.0),
                      textStyle: const TextStyle(fontSize: 18),
                      primary: Colors.green,
                    ),
                    child: const Text('Submit Registration'),
                  ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }
}
