<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'child_age',
        'message',
        'status',
    ];

    public static function statusLabel(string $status): string
    {
        return match($status) {
            'new'       => 'Новая',
            'read'      => 'Прочитана',
            'processed' => 'Обработана',
            default     => $status,
        };
    }

    public static function statusColor(string $status): string
    {
        return match($status) {
            'new'       => 'danger',
            'read'      => 'warning',
            'processed' => 'success',
            default     => 'gray',
        };
    }
}
