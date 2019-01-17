<?php

namespace App\Tasks;

use App\Http\Traits\HasUserId;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasUserId;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'file',
    ];
}
