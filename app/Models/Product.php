<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table= 'products';
    protected $fillable =['type_id','name','price','time','details','rate','image','priceSale','status'];
   // protected $nullable = ['details','image','priceSale','status'];
    use HasFactory;
    public function rate()
    {
        return $this->hasMany(Rate::class);
    }
    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function type()
    {
    return $this->belongsTo(Type::class,'type_id');
    }
    public function menu()
    {
        return $this->hasMany(Menu::class);
    }

}
