@extends('layouts.master')

@section('pageTitle', $pageTitle)

@section('main')
  <div class="task-list-container">
    <h1 class="task-list-heading">Task List</h1>

    @if (session('success'))
      <div style="background-color: #dcfce7; color: #15803d; padding: 12px; border-radius: 8px; margin-bottom: 16px; font-weight: 500;">
        {{ session('success') }}
      </div>
    @endif

    <div class="task-list-task-buttons" style="display: flex; gap: 12px; margin-bottom: 20px;">
      <a href="{{ route('tasks.create') }}">
        <button class="task-list-button">
          <span class="material-icons">add</span>Add task
        </button>
      </a>
      <a href="{{ route('tasks.kanban') }}">
        <button class="task-list-button" style="background-color: #4b5563;">
          <span class="material-icons">view_kanban</span>Kanban Board
        </button>
      </a>
    </div>

    <div class="task-list-table-head">
      <div class="task-list-header-task-name">Task Name</div>
      <div class="task-list-header-detail">Detail</div>
      <div class="task-list-header-due-date">Due Date</div>
      <div class="task-list-header-progress">Progress</div>
      <div style="width: 15%;">Actions</div>
    </div>

    @forelse ($tasks as $task)
      <div class="table-body">
        <div class="table-body-task-name">
          <span class="material-icons @if ($task->status == 'completed') check-icon-completed @else check-icon @endif">
            check_circle
          </span>
          {{ $task->name }}
        </div>
        <div class="table-body-detail">{{ $task->detail ?: '-' }}</div>
        <div class="table-body-due-date">{{ $task->due_date }}</div>
        <div class="table-body-progress">
          @switch($task->status)
            @case('in_progress')
              <span style="color: #2563eb; font-weight: 600;">In Progress</span>
              @break
            @case('in_review')
              <span style="color: #d97706; font-weight: 600;">In Review</span>
              @break
            @case('completed')
              <span style="color: #16a34a; font-weight: 600;">Completed</span>
              @break
            @default
              <span style="color: #6b7280; font-weight: 600;">Not Started</span>
          @endswitch
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
          <a href="{{ route('tasks.edit', ['id' => $task->id]) }}" style="color: #2563eb; text-decoration: none; font-weight: 500;">Edit</a>
          <form method="POST" action="{{ route('tasks.destroy', ['id' => $task->id]) }}" onsubmit="return confirm('Hapus task ini?');" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" style="background: none; border: none; color: #dc2626; cursor: pointer; font-weight: 500;">Delete</button>
          </form>
        </div>
      </div>
    @empty
      <div style="text-align: center; padding: 40px; color: #6b7280;">
        Belum ada task. Klik <strong>Add task</strong> untuk memulai.
      </div>
    @endforelse
  </div>
@endsection
