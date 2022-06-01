<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentCh extends Model
{
    use HasFactory;

    protected $table = 'parents';
    protected $hidden = [
        'created_at',
        'updated_at',
        'password'
    ];
    protected $fillable = [
        'fatherName',
        'motherName',
        'fatherLastName',
        'email',
        'password'
    ];

    public function phone_numbers()
    {
        return $this->hasMany(ParentPhoneNumbers::class, 'parent_id');
    }

    public function childrens()
    {
        return $this->hasMany(Children::class,'parent_id');
    }
}
