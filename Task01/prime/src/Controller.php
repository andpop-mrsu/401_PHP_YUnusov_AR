<?php

namespace Aidar555\Prime\Controller;

use function Aidar555\Prime\View\showMenu;
use function Aidar555\Prime\View\askName;
use function Aidar555\Prime\View\showQuestion;
use function Aidar555\Prime\View\showResult;
use function Aidar555\Prime\View\showHistoryTable;
use function Aidar555\Prime\Model\getGameNumber;
use function Aidar555\Prime\Model\isPrime;
use function Aidar555\Prime\Model\getDivisors;
use function Aidar555\Prime\Model\saveGameResult;
use function Aidar555\Prime\Model\getGameHistory;

function startGame()
{
    $name = askName();

    while (true) {
        $choice = showMenu();

        switch ($choice) {
            case '1':
                playRound($name);
                break;
            case '2':
                $history = getGameHistory();
                showHistoryTable($history);
                break;
            case '3':
                break 2;
            default:
                \cli\line("Invalid option.");
                break;
        };
    }
}

function playRound($name)
{
    $number = getGameNumber();
    $numberIsPrime = isPrime($number);

    $userAnswerRaw = showQuestion($number);
    $userSaysYes = in_array(strtolower($userAnswerRaw), ['yes', 'y', 'da', 'aboba']);

    $isCorrect = ($userSaysYes && $numberIsPrime) || (!$userSaysYes && !$numberIsPrime);

    $divisors = [];
    if (!$isCorrect && !$numberIsPrime) {
        $divisors = getDivisors($number);
    }

    showResult($isCorrect, $divisors);

    saveGameResult($name, $number, $isCorrect);
}
