<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table= 'carts';
    protected $fillable =['customer_id','amount','time'];
    use HasFactory;
    public function customer()
    {
        return $this->hasOne(Customer::class,'customer_id');
    }
    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
