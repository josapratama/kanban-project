@extends('layouts.master')

@section('pageTitle', $pageTitle)

@section('main')
  <div class="task-list-container" style="max-width: 1200px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
      <h1 class="task-list-heading" style="margin-bottom: 0;">Kanban Board</h1>
      <div style="display: flex; gap: 12px;">
        <a href="{{ route('tasks.create') }}">
          <button class="task-list-button">
            <span class="material-icons">add</span>Add task
          </button>
        </a>
        <a href="{{ route('tasks.index') }}">
          <button class="task-list-button" style="background-color: #4b5563;">
            <span class="material-icons">list</span>Task List
          </button>
        </a>
      </div>
    </div>

    @php
      $columns = [
        ['title' => 'Not Started', 'status' => 'not_started', 'tasks' => $notStarted, 'color' => '#6b7280'],
        ['title' => 'In Progress', 'status' => 'in_progress', 'tasks' => $inProgress, 'color' => '#2563eb'],
        ['title' => 'Waiting / In Review', 'status' => 'in_review', 'tasks' => $inReview, 'color' => '#d97706'],
        ['title' => 'Completed', 'status' => 'completed', 'tasks' => $completed, 'color' => '#16a34a'],
      ];
    @endphp

    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
      @foreach ($columns as $column)
        <div style="background-color: #f3f4f6; border-radius: 10px; padding: 16px; min-height: 400px; display: flex; flex-direction: column;">
          <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid {{ $column['color'] }}; padding-bottom: 8px; margin-bottom: 12px;">
            <h3 style="font-size: 15px; font-weight: 700; color: #1f2937; margin: 0;">{{ $column['title'] }}</h3>
            <span style="background: {{ $column['color'] }}; color: white; border-radius: 9999px; padding: 2px 8px; font-size: 12px; font-weight: bold;">
              {{ $column['tasks']->count() }}
            </span>
          </div>

          <div style="display: flex; flex-direction: column; gap: 10px; flex: 1;">
            @forelse ($column['tasks'] as $task)
              <div style="background: white; border-radius: 8px; padding: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid {{ $column['color'] }};">
                <h4 style="font-size: 14px; font-weight: 600; margin: 0 0 6px 0; color: #111827;">{{ $task->name }}</h4>
                @if ($task->detail)
                  <p style="font-size: 12px; color: #4b5563; margin: 0 0 8px 0; line-height: 1.4;">{{ Str::limit($task->detail, 80) }}</p>
                @endif
                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 11px; color: #6b7280; border-top: 1px solid #f3f4f6; padding-top: 6px;">
                  <span>📅 {{ $task->due_date }}</span>
                  <a href="{{ route('tasks.edit', ['id' => $task->id]) }}" style="color: #2563eb; text-decoration: none; font-weight: 600;">Edit</a>
                </div>
              </div>
            @empty
              <div style="text-align: center; color: #9ca3af; font-size: 13px; margin-top: 40px;">
                Kosong
              </div>
            @endforelse
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection
