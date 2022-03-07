<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calculator extends Model
{
    protected $table = 'calculators';

    protected $primaryKey = 'id';

    protected $fillable = [
        'version', 'earnings_per_point', 'tax',
    ];
}
