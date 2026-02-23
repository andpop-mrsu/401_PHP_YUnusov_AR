<?php

namespace Aidar555\Prime\Model;

use PDO;

function getGameNumber()
{
    return rand(2, 100);
}

function isPrime($num)
{
    if ($num < 2) {
        return false;
    }
    for ($i = 2; $i <= sqrt($num); $i++) {
        if ($num % $i === 0) {
            return false;
        }
    }
    return true;
}

function getDivisors($num)
{
    $divisors = [];
    for ($i = 2; $i <= $num / 2; $i++) {
        if ($num % $i === 0) {
            $divisors[] = $i;
        }
    }
    return $divisors;
}

function getDbConnection()
{
    $dbFile = __DIR__ . '/../game.sqlite';
    $pdo = new PDO('sqlite:' . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "CREATE TABLE IF NOT EXISTS games (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        player_name TEXT,
        date TEXT,
        number INTEGER,
        is_correct INTEGER
    )";
    $pdo->exec($query);

    return $pdo;
}

function saveGameResult($name, $number, $isCorrect)
{
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("
        INSERT INTO games (player_name, date, number, is_correct) VALUES (:name, :date, :num, :correct)
    ");
    $stmt->execute([
        ':name' => $name,
        ':date' => date('Y-m-d H:i:s'),
        ':num' => $number,
        ':correct' => $isCorrect ? 1 : 0
    ]);
}

function getGameHistory()
{
    $pdo = getDbConnection();
    return $pdo->query("SELECT * FROM games ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
}
