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

    <form class="form" method="POST" action="{{ route('tasks.store') }}">
      @csrf

      <div class="form-item">
        <label>Name:</label>
        <input class="form-input" type="text" name="name" value="{{ old('name') }}" required>
      </div>

      <div class="form-item">
        <label>Detail:</label>
        <textarea class="form-text-area" name="detail">{{ old('detail') }}</textarea>
      </div>

      <div class="form-item">
        <label>Due Date:</label>
        <input class="form-input" type="date" name="due_date" value="{{ old('due_date', date('Y-m-d')) }}" required>
      </div>

      <div class="form-item">
        <label>Progress:</label>
        <select class="form-input" name="status">
          <option value="not_started" {{ old('status') == 'not_started' ? 'selected' : '' }}>Not Started</option>
          <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
          <option value="in_review" {{ old('status') == 'in_review' ? 'selected' : '' }}>Waiting/In Review</option>
          <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
        </select>
      </div>

      <div style="display: flex; gap: 12px; margin-top: 16px;">
        <button type="submit" class="form-button">Submit</button>
        <a href="{{ route('tasks.index') }}" style="padding: 10px 20px; text-decoration: none; background: #e5e7eb; color: #374151; border-radius: 6px; font-weight: bold;">Cancel</a>
      </div>
    </form>
  </div>
@endsection
