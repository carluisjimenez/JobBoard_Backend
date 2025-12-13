<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'role',
    ];

    // Definir los roles
    public const ROLE_CANDIDATE = 1;
    public const ROLE_RECRUITER = 2;

    // Verificar si es candidato
    public function isCandidate()
    {
        return $this->role == self::ROLE_CANDIDATE;
    }

    // Verificar si es reclutador
    public function isRecruiter()
    {
        return $this->role == self::ROLE_RECRUITER;
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
