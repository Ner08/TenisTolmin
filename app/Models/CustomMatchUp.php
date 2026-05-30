<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomMatchUp extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team1_id',
        't1_tag',
        'team2_id',
        't2_tag',
        't1_first_set',
        't2_first_set',
        't1_second_set',
        't2_second_set',
        't1_third_set',
        't2_third_set',
        'round',
        'exception',
        'bracket_id',
        'result_status',
        'submitted_by_user_id',
        'result_submitted_at',
    ];

    public function submittedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by_user_id');
    }

    public function hasPendingResult(): bool
    {
        return $this->result_status === 'pending';
    }

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

    public function t1SetsWon()
    {
        $firstSet = (intval($this->t1_first_set) > intval($this->t2_first_set)) ? 1 : 0;
        $secondSet = (intval($this->t1_second_set) > intval($this->t2_second_set)) ? 1 : 0;
        $thirdSet = (intval($this->t1_third_set) > intval($this->t2_third_set)) ? 1 : 0;

        return $firstSet + $secondSet + $thirdSet;
    }

    public function t2SetsWon()
    {
        $firstSet = (intval($this->t2_first_set) > intval($this->t1_first_set)) ? 1 : 0;
        $secondSet = (intval($this->t2_second_set) > intval($this->t1_second_set)) ? 1 : 0;
        $thirdSet = (intval($this->t2_third_set) > intval($this->t1_third_set)) ? 1 : 0;

        return $firstSet + $secondSet + $thirdSet;
    }

    public function winner() //If true p1 won. if false p2 won
    {
        return ($this->t1SetsWon() > $this->t2SetsWon());
    }

    public function game_played() //if score is not 0:0
    {
        return ($this->t1SetsWon() != 0 || $this->t2SetsWon() != 0);
    }
}
