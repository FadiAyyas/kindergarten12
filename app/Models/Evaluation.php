<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $table = 'evaluations';

    protected $fillable = [
        'behavioral',
        'social'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'registration_id'
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class,'registration_id');
    }

}
