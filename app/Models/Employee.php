<?php

namespace App\Models;

use App\Models\Wish;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'employee_id',
        'name',
        'lastname',
        'dateOfBirth',
        'employmentStartDate',
        'employmentEndDate',
    ];

}
