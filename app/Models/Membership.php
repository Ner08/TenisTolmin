<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = ['year', 'price_adults', 'price_seniors', 'price_students', 'price_kids', 'price_family', 'trr', 'sklic', 'namen', 'prejemnik'];
}
