<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $table = 'submissions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'point', 'course_id',
    ];

    public function course() {
        return $this->belongsTo(Course::class);
    }
}
