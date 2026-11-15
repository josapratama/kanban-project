@extends('layouts.master')

@section('pageTitle', $pageTitle)

@section('main')
  <div class="form-container">
    <h1 class="form-title">{{ $pageTitle }}</h1>

    @if ($errors->any())
      <div style="background-color: #fee2e2; color: #dc2626; padding: 12px; border-radius: 8px; margin-bottom: 16px;">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form class="form" method="POST" action="{{ route('tasks.update', ['id' => $task->id]) }}">
      @csrf
      @method('PUT')

      <div class="form-item">
        <label>Name:</label>
        <input
          class="form-input"
          type="text"
          name="name"
          value="{{ old('name', $task->name) }}"
          required
        >
      </div>

      <div class="form-item">
        <label>Detail:</label>
        <textarea class="form-text-area" name="detail">{{ old('detail', $task->detail) }}</textarea>
      </div>

      <div class="form-item">
        <label>Due Date:</label>
        <input
          class="form-input"
          type="date"
          name="due_date"
          value="{{ old('due_date', $task->due_date) }}"
          required
        >
      </div>

      <div class="form-item">
        <label>Progress:</label>
        <select class="form-input" name="status">
          <option {{ old('status', $task->status) == 'not_started' ? 'selected' : '' }} value="not_started">
            Not Started
          </option>
          <option {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }} value="in_progress">
            In Progress
          </option>
          <option {{ old('status', $task->status) == 'in_review' ? 'selected' : '' }} value="in_review">
            Waiting/In Review
          </option>
          <option {{ old('status', $task->status) == 'completed' ? 'selected' : '' }} value="completed">
            Completed
          </option>
        </select>
      </div>

      <div style="display: flex; gap: 12px; margin-top: 16px;">
        <button type="submit" class="form-button">Update Task</button>
        <a href="{{ route('tasks.index') }}" style="padding: 10px 20px; text-decoration: none; background: #e5e7eb; color: #374151; border-radius: 6px; font-weight: bold;">Cancel</a>
      </div>
    </form>
  </div>
@endsection
