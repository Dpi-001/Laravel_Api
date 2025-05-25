<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = Todo::latest()->get();
        return response([
            'todos' => $todos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'completed' => 'integer',
    ]);

    $todo = Todo::create($validated);

    return response([
        'todo' => $todo,
    ], 201);
}

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        $todo = Todo::findOrFail($todo->id);

        if ($todo->user_id !== auth()->user()->id) {
            return response([
                'message' => 'Unauthorized',
            ], 403);
        }

        return response([
            'todo' => $todo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);

        if ($todo->user_id !== auth()->user()->id) {
            return response([
                'message' => 'Unauthorized',
            ], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'completed' => 'integer',
        ]);

        $todo->update($validated);

        return response([
            'todo' => $todo,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        if ($todo->id !== (int)request()->route('todo')) {
            return response([
                'message' => 'Unauthorized',
            ], 403);
        }

        $todo->delete();

        return response([
            'message' => 'Todo deleted successfully',
        ]);
    }

}
