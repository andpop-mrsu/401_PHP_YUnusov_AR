@extends('layouts.app')

@section('title', 'История игр')

@section('content')
<h1>История игр</h1>

{{-- Stats --}}
<div class="stats-row">
    <div class="stat-card">
        <div class="val">{{ $stats['total'] }}</div>
        <div class="lbl">Всего игр</div>
    </div>
    <div class="stat-card">
        <div class="val">{{ $stats['correct'] }}</div>
        <div class="lbl">Правильных ответов</div>
    </div>
    <div class="stat-card">
        <div class="val">
            {{ $stats['total'] > 0 ? round($stats['correct'] / $stats['total'] * 100) : 0 }}%
        </div>
        <div class="lbl">Точность</div>
    </div>
</div>

<div class="card">
    {{-- Filter --}}
    <form action="{{ route('history.index') }}" method="GET">
        <div class="filter-row">
            <input
                type="text"
                name="player"
                value="{{ request('player') }}"
                placeholder="Поиск по имени игрока..."
            >
            <button type="submit" class="btn btn-sm">Найти</button>
            @if(request('player'))
                <a href="{{ route('history.index') }}" class="btn btn-outline btn-sm">Сбросить</a>
            @endif
        </div>
    </form>

    @if ($games->isEmpty())
        <p style="color:var(--muted);text-align:center;padding:2rem 0">
            @if(request('player'))
                Игры не найдены по запросу «{{ request('player') }}».
            @else
                Игр пока нет. <a href="{{ route('game.index') }}" style="color:var(--accent2)">Сыграйте первым!</a>
            @endif
        </p>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Дата и время</th>
                        <th>Игрок</th>
                        <th>Число</th>
                        <th>Тип числа</th>
                        <th>Ответ</th>
                        <th>Итог</th>
                        <th>Делители</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($games as $game)
                    <tr>
                        <td style="color:var(--muted)">{{ $game->id }}</td>
                        <td style="color:var(--muted);font-size:.82rem;white-space:nowrap">
                            {{ $game->played_at->format('d.m.Y H:i') }}
                        </td>
                        <td>
                            <strong>{{ $game->player->name }}</strong>
                        </td>
                        <td>
                            <span style="font-size:1.1rem;font-weight:700;color:var(--accent2)">
                                {{ $game->number }}
                            </span>
                        </td>
                        <td>
                            @if ($game->is_prime)
                                <span class="badge badge-info">Простое</span>
                            @else
                                <span class="badge badge-warn">Составное</span>
                            @endif
                        </td>
                        <td>
                            {{ $game->user_answer === 'prime' ? 'Простое' : 'Составное' }}
                        </td>
                        <td>
                            @if ($game->is_correct)
                                <span class="badge badge-success">✓ Верно</span>
                            @else
                                <span class="badge badge-error">✗ Нет</span>
                            @endif
                        </td>
                        <td style="font-size:.82rem;color:var(--muted)">
                            {{ $game->divisors ?? '—' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($games->hasPages())
            <div class="pagination">
                {{-- Previous page --}}
                @if ($games->onFirstPage())
                    <span class="disabled"><span>‹</span></span>
                @else
                    <a href="{{ $games->previousPageUrl() }}">‹</a>
                @endif

                {{-- Page numbers --}}
                @foreach ($games->getUrlRange(
                    max(1, $games->currentPage() - 2),
                    min($games->lastPage(), $games->currentPage() + 2)
                ) as $page => $url)
                    @if ($page == $games->currentPage())
                        <span class="active"><span>{{ $page }}</span></span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next page --}}
                @if ($games->hasMorePages())
                    <a href="{{ $games->nextPageUrl() }}">›</a>
                @else
                    <span class="disabled"><span>›</span></span>
                @endif
            </div>
        @endif
    @endif
</div>

<div style="margin-top:1rem">
    <a href="{{ route('game.index') }}" class="btn">🎮 Новая игра</a>
</div>
@endsection
