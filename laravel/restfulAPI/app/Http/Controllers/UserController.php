<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        $account = User::all();
 
        $data = [
            'status' => 200,
            'account' => $account,
        ];
 
        return response()->json($data, 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'api_key' => $this->generateApiKey(),
        ]);

        $user->save();

        return response()->json(['message' => 'User created successfully'], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:users',
            'password' => 'string|min:6',
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->fill([
            'name' => $request->filled('name') ? $request->input('name') : $user->name,
            'email' => $request->filled('email') ? $request->input('email') : $user->email,
            'password' => $request->filled('password') ? Hash::make($request->input('password')) : $user->password,
        ]);

        $user->save();

        return response()->json(['message' => 'User updated successfully']);
    }

    public function delete($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    private function generateApiKey()
    {
        // Generate a unique API key, you can implement your own logic
        return uniqid('api_', true);
    }
}