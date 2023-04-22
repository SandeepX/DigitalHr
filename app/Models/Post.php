<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'post_name',
        'is_active',
        'dept_id'
    ];

    const RECORDS_PER_PAGE = 10;


    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id', 'id');
    }

}


