@extends('layouts.layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">To-Do List</h2>
                </div>
                <div class="card-body">
                    <h4><a href="/create" class="btn btn-success btn-sm mr-2">New To-Do List</a></h4>
                    @forelse ($todos as $todo)
                        <div class="todo-item mt-4 border p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0"><a href="/{{$todo->id}}" class="text-decoration-none text-dark">{{ $todo->name }}</a></h4>
                                <span class="text-muted">Created on: {{ $todo->created_at->format('F j, Y \a\t h:i A') }}</span>
                            </div>
                            <hr class="my-2">
                            <p class="mb-2">{{ $todo->description }}</p>
                            <div class="d-flex justify-content-end">
                                <a href="/{{$todo->id}}" class="btn btn-info btn-sm mr-2">See More</a>
                            </div>
                        </div>
                    @empty
                        <p class="mt-4">All tasks on To-Do list have been completed.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection