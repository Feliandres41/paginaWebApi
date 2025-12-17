<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task; // ✅ ESTA LÍNEA ES CLAVE

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'is_archived'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
