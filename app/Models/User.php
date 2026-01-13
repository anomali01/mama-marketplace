<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nim',
        'prodi',
        'phone',
        'verified',
        'shop_name',
        'shop_description',
        'shop_address',
        'shop_image',
        'bank_name',
        'account_number',
        'account_holder_name',
        'seller_bank_name',
        'seller_account_number',
        'seller_account_holder_name',
        'validator_prodi_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'verified' => 'boolean',
    ];

    /**
     * Get the study program that the user belongs to.
     */
    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class, 'prodi_id');
    }

    /**
     * Get the study program that the validator manages.
     */
    public function validatorStudyProgram()
    {
        return $this->belongsTo(StudyProgram::class, 'validator_prodi_id');
    }

    /**
     * Alias for validatorStudyProgram
     */
    public function validatorProdi()
    {
        return $this->belongsTo(StudyProgram::class, 'validator_prodi_id');
    }

    /**
     * Get the products for the user.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    /**
     * Get the study program that the user validates.
     */
    public function validatedStudyProgram()
    {
        return $this->hasOne(StudyProgram::class, 'validator_id');
    }

    /**
     * Get withdrawal requests for this seller
     */
    public function withdrawalRequests()
    {
        return $this->hasMany(WithdrawalRequest::class, 'seller_id');
    }

    /**
     * Get withdrawal requests handled by this validator
     */
    public function handledWithdrawals()
    {
        return $this->hasMany(WithdrawalRequest::class, 'validator_id');
    }
}
