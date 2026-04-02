@extends('layouts.app')

@section('title', 'Результат игры')

@section('content')
<div class="card">
    <h1>Результат</h1>

    {{-- Verdict banner --}}
    @if ($isCorrect)
        <div class="result-banner correct">
            <span class="icon">🎉</span>
            Правильно! Отличный ответ, {{ $playerName }}!
        </div>
    @else
        <div class="result-banner wrong">
            <span class="icon">❌</span>
            Неправильно, {{ $playerName }}. Попробуйте в следующий раз!
        </div>
    @endif

    {{-- Number info --}}
    <div class="info-block">
        <div class="key">Число</div>
        <strong style="font-size:1.5rem;color:var(--accent2)">{{ $number }}</strong>
    </div>

    <div class="info-block">
        <div class="key">Правильный ответ</div>
        @if ($isPrime)
            <span class="badge badge-success" style="font-size:.95rem;padding:.3rem .75rem">✅ Простое</span>
            <p style="margin-top:.5rem;color:var(--muted);font-size:.9rem">
                Число {{ $number }} делится только на 1 и на само себя.
            </p>
        @else
            <span class="badge badge-warn" style="font-size:.95rem;padding:.3rem .75rem">🔢 Составное</span>
            @if (!empty($divisors))
                <div class="key" style="margin-top:.75rem">Нетривиальные делители</div>
                <div class="divisors">
                    @foreach ($divisors as $d)
                        <span class="divisor-chip">{{ $d }}</span>
                    @endforeach
                </div>
            @endif
        @endif
    </div>

    <div class="info-block">
        <div class="key">Ваш ответ</div>
        @if ($userAnswer === 'prime')
            <span class="badge {{ $isCorrect ? 'badge-success' : 'badge-error' }}">✅ Простое</span>
        @else
            <span class="badge {{ $isCorrect ? 'badge-success' : 'badge-error' }}">🔢 Составное</span>
        @endif
    </div>

    <div class="actions">
        <a href="{{ route('game.index') }}" class="btn">🔄 Новая игра</a>
        <a href="{{ route('history.index') }}" class="btn btn-outline">📋 История игр</a>
    </div>
</div>
@endsection
