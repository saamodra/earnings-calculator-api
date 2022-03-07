<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $primaryKey = 'id';

    protected $fillable = [
        'point', 'submission_id', 'user_id',
    ];

    public function submission() {
        return $this->belongsTo(Submission::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
