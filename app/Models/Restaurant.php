<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $table= 'restaurants';
    protected $fillable =['name','domain'];
    use HasFactory;
}
