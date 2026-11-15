@extends('layouts.master')

@section('pageTitle', $pageTitle)

@section('main')
  <div class="task-list-container" style="max-width: 1200px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 class="task-list-heading" style="margin-bottom: 4px;">Kanban Board</h1>
        <p style="font-size: 13px; color: #6b7280; margin: 0;">Kelola alur kerja tugas dengan transisi status 1-klik.</p>
      </div>

      <div style="display: flex; gap: 12px; align-items: center;">
        <input
          type="text"
          id="kanban-search"
          placeholder="Cari tugas di board..."
          style="padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 13px; width: 220px;"
          oninput="filterKanbanCards(this.value)"
        />
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

    @if (session('success'))
      <div style="background-color: #dcfce7; color: #15803d; padding: 10px 14px; border-radius: 8px; margin-bottom: 16px; font-weight: 500; font-size: 13px;">
        {{ session('success') }}
      </div>
    @endif

    @php
      $columns = [
        [
          'title' => 'Not Started',
          'status' => 'not_started',
          'tasks' => $notStarted,
          'color' => '#6b7280',
          'nextStatus' => 'in_progress',
          'nextLabel' => 'Mulai →',
          'nextColor' => '#2563eb'
        ],
        [
          'title' => 'In Progress',
          'status' => 'in_progress',
          'tasks' => $inProgress,
          'color' => '#2563eb',
          'nextStatus' => 'in_review',
          'nextLabel' => 'Review →',
          'nextColor' => '#d97706'
        ],
        [
          'title' => 'Waiting / In Review',
          'status' => 'in_review',
          'tasks' => $inReview,
          'color' => '#d97706',
          'nextStatus' => 'completed',
          'nextLabel' => 'Selesai ✓',
          'nextColor' => '#16a34a'
        ],
        [
          'title' => 'Completed',
          'status' => 'completed',
          'tasks' => $completed,
          'color' => '#16a34a',
          'nextStatus' => 'in_progress',
          'nextLabel' => 'Buka Lagi ↺',
          'nextColor' => '#6b7280'
        ],
      ];
    @endphp

    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
      @foreach ($columns as $column)
        <div style="background-color: #f3f4f6; border-radius: 10px; padding: 14px; min-height: 480px; display: flex; flex-direction: column;">
          <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid {{ $column['color'] }}; padding-bottom: 8px; margin-bottom: 12px;">
            <h3 style="font-size: 14px; font-weight: 700; color: #1f2937; margin: 0;">{{ $column['title'] }}</h3>
            <span style="background: {{ $column['color'] }}; color: white; border-radius: 9999px; padding: 1px 7px; font-size: 11px; font-weight: bold;">
              {{ $column['tasks']->count() }}
            </span>
          </div>

          <div style="display: flex; flex-direction: column; gap: 10px; flex: 1;">
            @forelse ($column['tasks'] as $task)
              <div class="kanban-card" data-title="{{ strtolower($task->name) }}" data-detail="{{ strtolower($task->detail ?: '') }}" style="background: white; border-radius: 8px; padding: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid {{ $column['color'] }};">
                <h4 style="font-size: 14px; font-weight: 600; margin: 0 0 6px 0; color: #111827;">{{ $task->name }}</h4>
                @if ($task->detail)
                  <p style="font-size: 12px; color: #4b5563; margin: 0 0 10px 0; line-height: 1.4;">{{ Str::limit($task->detail, 80) }}</p>
                @endif
                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 11px; color: #6b7280; border-top: 1px solid #f3f4f6; padding-top: 8px; margin-top: 4px;">
                  <span>📅 {{ $task->due_date }}</span>
                  <div style="display: flex; gap: 6px;">
                    <a href="{{ route('tasks.edit', ['id' => $task->id]) }}" style="color: #2563eb; text-decoration: none; font-weight: 600;">Edit</a>
                    <form method="POST" action="{{ route('tasks.destroy', ['id' => $task->id]) }}" onsubmit="return confirm('Hapus tugas ini?');" style="display: inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" style="background: none; border: none; color: #dc2626; cursor: pointer; font-size: 11px; padding: 0;">✕</button>
                    </form>
                  </div>
                </div>

                <!-- Quick Status Shift Button -->
                <div style="margin-top: 8px; padding-top: 6px; border-top: 1px dashed #e5e7eb;">
                  <form method="POST" action="{{ route('tasks.updateStatus', ['id' => $task->id]) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="{{ $column['nextStatus'] }}">
                    <button type="submit" style="width: 100%; background: {{ $column['nextColor'] }}; color: white; border: none; border-radius: 4px; padding: 5px 8px; font-size: 11px; font-weight: 600; cursor: pointer; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                      {{ $column['nextLabel'] }}
                    </button>
                  </form>
                </div>
              </div>
            @empty
              <div class="empty-column-placeholder" style="text-align: center; color: #9ca3af; font-size: 12px; margin-top: 40px;">
                Belum ada tugas
              </div>
            @endforelse
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <script>
    function filterKanbanCards(keyword) {
      const q = keyword.toLowerCase().trim();
      const cards = document.querySelectorAll('.kanban-card');
      cards.forEach(card => {
        const title = card.getAttribute('data-title') || '';
        const detail = card.getAttribute('data-detail') || '';
        if (!q || title.includes(q) || detail.includes(q)) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    }
  </script>
@endsection
