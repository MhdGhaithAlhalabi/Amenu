<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table= 'orders';
    protected $fillable =['product_id','cart_id','qtu'];
    use HasFactory;
    public function cart()
    {
        return $this->hasOne(Cart::class,'cart_id');
    }
    public function product()
    {
        return $this->hasOne(Product::class,'product_id');
    }
}
