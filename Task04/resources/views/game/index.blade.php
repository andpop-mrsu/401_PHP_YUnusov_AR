@extends('layouts.app')

@section('title', 'Простое ли число?')

@section('content')
<div class="card">
    <h1>Простое ли число?</h1>

    <div class="number-display">
        <div class="label">Ваше число</div>
        <div class="number">{{ $number }}</div>
    </div>

    <form action="{{ route('game.play') }}" method="POST" novalidate>
        @csrf

        <div class="form-group">
            <label for="player_name">Ваше имя</label>
            <input
                type="text"
                id="player_name"
                name="player_name"
                value="{{ old('player_name') }}"
                placeholder="Введите имя..."
                autocomplete="off"
                class="{{ $errors->has('player_name') ? 'is-invalid' : '' }}"
            >
            @error('player_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Ваш ответ</label>
            <div class="radio-group">
                <div class="radio-card">
                    <input
                        type="radio"
                        id="answer_prime"
                        name="answer"
                        value="prime"
                        {{ old('answer') === 'prime' ? 'checked' : '' }}
                    >
                    <label for="answer_prime">✅ Простое</label>
                </div>
                <div class="radio-card">
                    <input
                        type="radio"
                        id="answer_composite"
                        name="answer"
                        value="composite"
                        {{ old('answer') === 'composite' ? 'checked' : '' }}
                    >
                    <label for="answer_composite">🔢 Составное</label>
                </div>
            </div>
            @error('answer')
                <div class="invalid-feedback" style="margin-top:.5rem">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn" style="width:100%;margin-top:.5rem">
            Проверить ответ →
        </button>
    </form>
</div>
@endsection
