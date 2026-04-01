<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Player;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Главная страница — форма для игры.
     */
    public function index()
    {
        $number = random_int(2, 200);
        session(['current_number' => $number]);

        return view('game.index', compact('number'));
    }

    /**
     * Обработка ответа игрока.
     */
    public function play(Request $request)
    {
        $request->validate([
            'player_name' => 'required|string|max:100|min:1',
            'answer'      => 'required|in:prime,composite',
        ], [
            'player_name.required' => 'Введите ваше имя.',
            'player_name.max'      => 'Имя не должно превышать 100 символов.',
            'answer.required'      => 'Выберите ответ.',
            'answer.in'            => 'Некорректный ответ.',
        ]);

        $number     = session('current_number');
        $playerName = trim($request->input('player_name'));
        $userAnswer = $request->input('answer'); // 'prime' or 'composite'

        if (!$number) {
            return redirect()->route('game.index')
                ->with('error', 'Сессия истекла. Начните игру заново.');
        }

        // Вычислить, простое ли число
        $isPrime   = $this->isPrime($number);
        $divisors  = $isPrime ? [] : $this->getDivisors($number);

        // Правильный ответ
        $correctAnswer = $isPrime ? 'prime' : 'composite';
        $isCorrect     = ($userAnswer === $correctAnswer);

        // Найти или создать игрока
        $player = Player::firstOrCreate(
            ['name' => $playerName],
        );

        // Сохранить игру в БД
        $game = Game::create([
            'player_id'   => $player->id,
            'number'      => $number,
            'is_prime'    => $isPrime,
            'user_answer' => $userAnswer,
            'is_correct'  => $isCorrect,
            'divisors'    => $divisors ? implode(', ', $divisors) : null,
            'played_at'   => now(),
        ]);

        // Очистить сессию
        session()->forget('current_number');

        return view('game.result', [
            'number'      => $number,
            'isPrime'     => $isPrime,
            'divisors'    => $divisors,
            'userAnswer'  => $userAnswer,
            'isCorrect'   => $isCorrect,
            'playerName'  => $playerName,
        ]);
    }

    /**
     * Проверить, является ли число простым.
     */
    private function isPrime(int $n): bool
    {
        if ($n < 2) {
            return false;
        }
        if ($n === 2) {
            return true;
        }
        if ($n % 2 === 0) {
            return false;
        }
        for ($i = 3; $i <= (int) sqrt($n); $i += 2) {
            if ($n % $i === 0) {
                return false;
            }
        }
        return true;
    }

    /**
     * Получить список нетривиальных делителей числа (кроме 1 и самого числа).
     */
    private function getDivisors(int $n): array
    {
        $divisors = [];
        for ($i = 2; $i < $n; $i++) {
            if ($n % $i === 0) {
                $divisors[] = $i;
            }
        }
        return $divisors;
    }
}
