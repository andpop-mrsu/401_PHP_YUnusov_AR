@extends('layouts.app')
@section('title', 'Страница не найдена')
@section('content')
<div class="card" style="text-align:center;padding:3rem">
    <div style="font-size:4rem;margin-bottom:1rem">🔍</div>
    <h1 style="margin-bottom:.5rem">404</h1>
    <p style="color:var(--muted);margin-bottom:1.5rem">Страница не найдена.</p>
    <a href="{{ route('game.index') }}" class="btn">На главную</a>
</div>
@endsection
