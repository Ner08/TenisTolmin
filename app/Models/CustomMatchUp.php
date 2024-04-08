<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomMatchUp extends Model
{
    use HasFactory;

    protected $fillable = [
     //Here
    ];

    // Accessor mutator to generate end result string
    public function getEndResultAttribute()
    {
        return "{$this->t1_first_set}:{$this->t2_first_set}, {$this->t1_second_set}:{$this->t2_second_set}, {$this->t1_third_set}:{$this->t2_third_set}";
    }
}
