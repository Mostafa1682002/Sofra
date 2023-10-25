<?php

namespace App\Mostafa;

enum Status: int
{
    case PENDING = 0;
    case ACCEPTED = 1;
    case REJECTED = 2;
    case CANCELED = 3;
    case DELEIVERED = 4;

    public function order()
    {
        return match ($this) {
            self::PENDING => 'قيد الانتظار',
            self::ACCEPTED => 'مقبول',
            self::REJECTED => 'مرفوض',
            self::CANCELED => 'ملغي',
            self::DELEIVERED => 'مكتمل',
        };
    }
}
