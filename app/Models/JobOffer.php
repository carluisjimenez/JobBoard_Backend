<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class JobOffer extends Model
{
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'job_title',
        'description',
        'location',
        'salary',
        'category',
        'user_id'
    ];

    // Relación con el User (reclutador)
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
