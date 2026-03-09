<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/game.php';

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->add(function (Request $request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'Content-Type')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
});

$app->options('/{routes:.+}', function (Request $request, Response $response) {
    return $response;
});

function jsonResponse(Response $response, mixed $data, int $status = 200): Response
{
    $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));
    return $response
        ->withStatus($status)
        ->withHeader('Content-Type', 'application/json');
}

$app->get('/', function (Request $request, Response $response) {
    $html = file_get_contents(__DIR__ . '/index.html');
    $response->getBody()->write($html);
    return $response->withHeader('Content-Type', 'text/html; charset=utf-8');
});

$app->get('/games', function (Request $request, Response $response) {
    $rows  = getGames();
    $games = normalizeGames($rows);
    return jsonResponse($response, $games);
});

$app->get('/games/{id}', function (Request $request, Response $response, array $args) {
    $game = getGameById((int) $args['id']);

    if ($game === null) {
        return jsonResponse($response, ['error' => 'Игра не найдена'], 404);
    }

    return jsonResponse($response, $game);
});

$app->post('/games', function (Request $request, Response $response) {
    $data = json_decode((string) $request->getBody(), true) ?? [];

    $playerName = trim((string) ($data['player_name'] ?? 'Аноним'));
    if ($playerName === '') {
        $playerName = 'Аноним';
    }

    $rounds = max(1, min(20, (int) ($data['rounds'] ?? 5)));

    $gameId = createGame($playerName);

    return jsonResponse($response, [
        'id'     => $gameId,
        'number' => generateGameNumber(),
        'rounds' => $rounds,
    ]);
});

$app->post('/step/{id}', function (Request $request, Response $response, array $args) {
    $gameId = (int) $args['id'];
    $game   = getGameById($gameId);

    if ($game === null) {
        return jsonResponse($response, ['error' => 'Игра не найдена'], 404);
    }

    $data = json_decode((string) $request->getBody(), true) ?? [];

    $number = (int) ($data['number'] ?? 0);

    $rawAnswer  = $data['answer'] ?? null;
    $userAnswer = parseUserAnswer(
        is_bool($rawAnswer) ? ($rawAnswer ? 'yes' : 'no') : (string) $rawAnswer
    );

    if ($userAnswer === null) {
        return jsonResponse($response, ['error' => 'Некорректный ответ. Ожидается "yes" или "no"'], 422);
    }

    $step = addStepToGame($gameId, $number, $userAnswer);

    $updatedGame = getGameById($gameId);
    $steps       = $updatedGame['steps'] ?? [];
    $total       = count($steps);
    $score       = count(array_filter($steps, fn(array $s) => $s['is_correct']));
    $rounds      = (int) ($data['rounds'] ?? $total);
    $gameOver    = ($total >= $rounds);

    return jsonResponse($response, [
        'correct'     => $step['is_correct'],
        'is_prime'    => $step['is_prime'],
        'divisors'    => $step['divisors'],
        'score'       => $score,
        'total'       => $total,
        'rounds'      => $rounds,
        'game_over'   => $gameOver,
        'next_number' => $gameOver ? null : generateGameNumber(),
    ]);
});

$app->run();