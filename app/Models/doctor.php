<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doctor extends Model
{
    use HasFactory;
    protected $fillable = ['doctorid','adminid','name','email','password','department','isinitiator'];
    public $timestamps = false;
    protected $primaryKey = 'doctorid';
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
