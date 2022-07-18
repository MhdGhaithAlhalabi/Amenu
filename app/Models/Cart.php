<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table= 'carts';
    protected $fillable =['customer_id','amount','time','table_number','status','created_at'];
    use HasFactory;
    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function order()
    {
        return $this->hasMany(Order::class,'cart_id');
    }
//    public function product()
//    {
//        return $this->hasManyThrough(Product::class,Order::class);
//    }
}
