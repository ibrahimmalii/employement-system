<?php

namespace App\Enums;

enum TaskStatusEnum: string
{
    case TODO = 'todo';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';

    public static function getStatuses(): array
    {
        return [
            self::TODO,
            self::IN_PROGRESS,
            self::DONE
        ];
    }
}
