<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $pageTitle = 'Task List';
        $tasks = Task::orderBy('due_date', 'asc')->get();
        return view('tasks.index', [
            'pageTitle' => $pageTitle,
            'tasks' => $tasks
        ]);
    }

    public function kanban()
    {
        $pageTitle = 'Kanban Board';
        $tasks = Task::all();
        $notStarted = $tasks->where('status', 'not_started');
        $inProgress = $tasks->where('status', 'in_progress');
        $inReview = $tasks->where('status', 'in_review');
        $completed = $tasks->where('status', 'completed');

        return view('tasks.kanban', [
            'pageTitle' => $pageTitle,
            'notStarted' => $notStarted,
            'inProgress' => $inProgress,
            'inReview' => $inReview,
            'completed' => $completed,
        ]);
    }

    public function create()
    {
        $pageTitle = 'Create Task';
        return view('tasks.create', ['pageTitle' => $pageTitle]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|in:not_started,in_progress,in_review,completed',
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task successfully created!');
    }

    public function edit($id)
    {
        $pageTitle = 'Edit Task';
        $task = Task::findOrFail($id);
        return view('tasks.edit', ['pageTitle' => $pageTitle, 'task' => $task]);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|in:not_started,in_progress,in_review,completed',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task successfully updated!');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->back()->with('success', 'Task successfully deleted!');
    }

    public function updateStatus(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:not_started,in_progress,in_review,completed',
        ]);

        $task->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Task status updated!');
    }
}
