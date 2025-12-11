<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'karada_project',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    // Автоматический расчёт importance_score и установка karada_test_label при создании/обновлении
    public static function booted()
    {
        static::creating(function ($task) {
            $task->karada_test_label = 'KARADA_FULLSTACK_TEST';
            $task->importance_score = (int) $task->priority * 20;
        });

        static::updating(function ($task) {
            // Пересчитаем importance_score при изменении priority
            if ($task->isDirty('priority')) {
                $task->importance_score = (int) $task->priority * 20;
            }
            // Не позволяем менять karada_test_label через массовое присвоение
            $task->karada_test_label = $task->getOriginal('karada_test_label') ?? 'KARADA_FULLSTACK_TEST';
        });

        static::saving(function ($task) {
            // Доп. гарантия: валидируем boundary priority
            if ($task->priority < 1) $task->priority = 1;
            if ($task->priority > 5) $task->priority = 5;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
