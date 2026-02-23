# Optimus Prime Game
Консольная PHP игра "Простое ли число?".
Проект разработан в учебных целях.
## Описание
Игроку показывается случайное число. Задача игрока — определить, является ли это число простым (делится только на 1 и на само себя).
Если ответ неверный, игра покажет нетривиальные делители числа.
Ведется история игр с сохранением результатов в локальную базу данных SQLite.
## Требования
* PHP >= 8.4.12
Мб и на пажилых версиях стартанет хз
* Composer
* SQLite3
## Установка

Вы можете установить игру глобально с помощью Composer:

```bash
composer global require Aidar-555/prime -W
```

И запуск

```bash
prime
```

Или локально

```bash
composer require Aidar-555/prime
```

И запуск

```bash
./vendor/bin/prime
```

Или локально 2

```bash
composer create-project Aidar-555/prime
```

И запуск

```bash
php ./bin/prime
```

Ссылка на пакет
https://packagist.org/packages/darkflade/prime