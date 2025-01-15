<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemTask extends Model
{
    use HasFactory;
    protected $fillable = ['task_id', 'name', 'is_completed', 'parent_id'];
}
