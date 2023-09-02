<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_name',
        'emp_birthdate',
        'emp_salary',
        'dept_id',
        'user_id',
        'status',
    ];


    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id','id');
    }

public function user()
{
    return $this->belongsTo(User::class)->withTrashed();
}

}
