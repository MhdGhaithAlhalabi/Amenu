<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table= 'customers';
    protected $fillable =['name','phone','points'];
    use HasFactory;
    public function rate()
    {
        return $this->hasMany(Rate::class);
    }
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }
}
