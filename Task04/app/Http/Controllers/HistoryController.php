<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Страница истории игр.
     */
    public function index(Request $request)
    {
        $query = Game::with('player')->orderBy('played_at', 'desc');

        // Фильтр по имени игрока
        if ($request->filled('player')) {
            $query->whereHas('player', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('player') . '%');
            });
        }

        $games = $query->paginate(15)->withQueryString();

        $stats = [
            'total'   => Game::count(),
            'correct' => Game::where('is_correct', true)->count(),
        ];

        return view('history.index', compact('games', 'stats'));
    }
}
