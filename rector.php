<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    // Путь к вашему коду
    $rectorConfig->paths([
        __DIR__ . '/classes',
        __DIR__ . '/public/install',
        __DIR__ . '/bcms/classes', // если ты хочешь рефачить и эту папку
    ]);

    // Применяем наборы правил, например, для перехода на PHP 8.4
    $rectorConfig->sets([
        SetList::PHP_84,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::CODING_STYLE,
    ]);
};