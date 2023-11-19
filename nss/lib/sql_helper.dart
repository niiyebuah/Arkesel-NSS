import 'package:sqflite/sqflite.dart' as sql;

class SQLHelper {
  static Future<void> createTable(sql.Database database) async {
    await database.execute('''
      CREATE TABLE users(
        UserID INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
        FirstName TEXT,
        LastName TEXT,
        Age INTEGER,
        DateOfBirth TEXT,
        PhoneNumber TEXT,
        PlaceOfPosting TEXT
      )''');
  }

  static Future<sql.Database> db() async {
    return sql.openDatabase(
      'dbnss.db',
      version: 1,
      onCreate: (sql.Database database, int version) async {
        print('...creating table...');
        await createTable(database);
      },
    );
  }

  static Future<void> createUser(
      String firstname,
      String lastname,
      int age,
      String dob,
      String phonenumber,
      String posting,
      ) async {
    final db = await SQLHelper.db();

    final data = {
      'FirstName': firstname,
      'LastName': lastname,
      'Age': age,
      'DateOfBirth': dob,
      'PhoneNumber': phonenumber,
      'PlaceOfPosting': posting
    };

    await db.insert('users', data, conflictAlgorithm: sql.ConflictAlgorithm.replace);
  }

  static Future<List<Map<String, dynamic>>> getUserDetails(String phonenumber) async {
    final db = await SQLHelper.db();
    return db.query('users', where: "PhoneNumber = ?", whereArgs: [phonenumber], limit: 1);
  }

  static Future<void> deleteUser(int userId) async {
    final db = await SQLHelper.db();
    await db.delete('users', where: 'UserID = ?', whereArgs: [userId]);
  }
}