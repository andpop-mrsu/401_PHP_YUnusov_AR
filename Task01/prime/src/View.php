<?php

namespace Aidar555\Prime\View;

use cli\Table;

use function cli\line;
use function cli\prompt;

function showMenu()
{
    line("\n--- MAIN MENU ---");
    line("1. Play Game");
    line("2. View History");
    line("3. Exit");
    return prompt("Choose an option");
}

function askName()
{
    return prompt("Enter your name");
}

function showQuestion($number)
{
    line("\nIs the number %s prime?", $number);
    return prompt("Answer (yes/no)");
}

function showResult($isWin, $divisors = [])
{
    if ($isWin) {
        printGreen("Correct!");
    } else {
        printRed("Wrong!");
        if (!empty($divisors)) {
            printBlue("Non-trivial divisors: " . implode(', ', $divisors));
        } else {
            printBlue("The number IS prime.");
        }
    }
}

function showHistoryTable($data)
{
    if (empty($data)) {
        line("No history yet.");
        return;
    }

    $headers = ['ID', 'Player', 'Date', 'Number', 'Result'];
    $rows = [];

    foreach ($data as $row) {
        $rows[] = [
            $row['id'],
            $row['player_name'],
            $row['date'],
            $row['number'],
            $row['is_correct'] ? 'Win' : 'Loss'
        ];
    }

    $table = new Table();
    $table->setHeaders($headers);
    $table->setRows($rows);
    $table->display();
}

enum Color: string
{
    case Red = "\e[0;30;101m";
    case Green = "\e[0;30;102m";
    case Blue = "\e[0;30;104m";
    case Reset = "\e[0m";
}

function printColored(string $string, Color $color): string
{
    $reset = Color::Reset;
    $coloredString = "$color->value $string $reset->value";

    return $coloredString;
}

function printGreen(string $string): void
{
    line(printColored($string, Color::Green));
}

function printRed(string $string): void
{
    line(printColored($string, Color::Red));
}

function printBlue(string $string): void
{
    line(printColored($string, Color::Blue));
}
