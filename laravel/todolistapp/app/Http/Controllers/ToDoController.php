<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class ToDoController extends Controller
{
    public function index()
    {
        $todos = Todo::latest()->get();
        return view('todo.index', ['todos' => $todos]);
    }

    public function show($id)
    {
        $todo = Todo::findOrFail($id);
        return view('todo.view', ['todo' => $todo]);
    }

    public function create()
    {
        return view('todo.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        Todo::create($validatedData);

        return redirect('/');
    }
    

    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
        return redirect()->route('todo.index', ['id' => $todo->id]);
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'editName' => 'required|max:255',
            'editTitle' => 'required|max:255',
            'editDescription' => 'required',
        ]);

        // Find the todo record by its ID
        $todo = Todo::findOrFail($id);

        // Update the todo record with the new data
        $todo->update([
            'name' => $request->editName,
            'title' => $request->editTitle,
            'description' => $request->editDescription,
        ]);

        // Redirect back to the updated todo page or wherever you want
        return redirect()->route('todo.view', ['id' => $todo->id]);
    }
}