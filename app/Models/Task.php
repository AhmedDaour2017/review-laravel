<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Task extends Model
{
    use SoftDeletes;
    //

        protected $fillable = [
        'title',
        'description',
        'priority',
        'due_date',
        'status_id',
        'user_id',
    ];

    protected $casts = [
    'due_date' => 'date',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function status(){
    return $this->belongsTo(Status::class);
    }
}
