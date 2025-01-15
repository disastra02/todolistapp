<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'user_id'];

    public function item()
    {
        return $this->hasMany(ItemTask::class, 'task_id')->whereNull('parent_id');
    }
}
