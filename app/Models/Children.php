<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    use HasFactory;

    protected $table = 'childrens';
    protected $hidden = [
        'created_at',
        'updated_at',
        'parent_id'
    ];
    protected $fillable = [
        'childName',
        'birthDate',
        'ChildImage',
        'childAddress',
        'medicalNotes',
        'parent_id'
    ];

    public function parent()
    {
        return $this->belongsTo(ParentCh::class);
    }

    public function registration()
    {
        return $this->hasMany(Registration::class,'child_id');
    }
}
