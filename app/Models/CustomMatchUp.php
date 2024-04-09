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
        $fullScore = 'Prihajajoča igra';

        if (isset($this->t1_first_set) && isset($this->t2_first_set) && isset($this->t1_second_set) && isset($this->t2_second_set)) {
            if (isset($this->t1_third_set) && isset($this->t2_third_set)) {
                $fullScore = "{$this->t1_first_set}:{$this->t2_first_set}  {$this->t1_second_set}:{$this->t2_second_set}  {$this->t1_third_set}:{$this->t2_third_set}";
            } else {
                $fullScore = "{$this->t1_first_set}:{$this->t2_first_set}  {$this->t1_second_set}:{$this->t2_second_set}";
            }
        }

        return $fullScore;
    }
}
