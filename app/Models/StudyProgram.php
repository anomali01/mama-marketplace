<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    use HasFactory;

    protected $table = 'prodis';

    protected $fillable = [
        'name',
        'code',
        'validator_id',
    ];

    public function validator()
    {
        return $this->belongsTo(User::class, 'validator_id');
    }

    /**
     * Get all validators assigned to this study program.
     */
    public function validators()
    {
        return $this->hasMany(User::class, 'validator_prodi_id')
                    ->where('role', 'validator');
    }

    /**
     * Get all products that belong to this study program.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'prodi_id');
    }
}